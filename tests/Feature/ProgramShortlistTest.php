<?php

namespace Tests\Feature;

use App\Exports\ProgramShortlistExport;
use App\Models\Program;
use App\Models\ProgramShortlist;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ProgramShortlistTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'database.connections.sqlite.foreign_key_constraints' => true,
            'permission.cache.store' => 'array',
        ]);
        DB::purge();
        DB::setDefaultConnection('sqlite');
        $this->createSchema();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_agent_can_save_reopen_rename_and_export_a_persistent_shortlist(): void
    {
        $agent = $this->makeUser('agent@example.test', 'agent');
        $program = $this->makeProgram();
        $this->actingAs($agent);

        $response = $this->postJson(route('program-shortlists.store'), [
            'name' => 'UK Masters',
            'program_ids' => [$program->id],
        ])->assertCreated();
        $shortlistId = $response->json('shortlist_id');
        $this->assertDatabaseHas('program_shortlists', ['id' => $shortlistId, 'user_id' => $agent->id]);
        $this->assertDatabaseHas('program_shortlist_program', ['shortlist_id' => $shortlistId, 'program_id' => $program->id]);
        $this->postJson(route('program-shortlists.store'), [
            'name' => 'Second shortlist',
            'program_ids' => [$program->id],
        ])->assertCreated();
        $this->assertSame(2, ProgramShortlist::where('user_id', $agent->id)->count());

        auth()->logout();
        $this->actingAs(User::findOrFail($agent->id));
        $this->get(route('program-shortlists.show', $shortlistId))
            ->assertOk()
            ->assertSee('Agent')
            ->assertSee('Applied Computing');

        $this->patchJson(route('program-shortlists.rename', $shortlistId), ['name' => 'Canada Fall 2027'])
            ->assertOk()
            ->assertJsonPath('name', 'Canada Fall 2027');

        $pdfResponse = $this->get(route('program-shortlists.export', [$shortlistId, 'pdf']))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $pdfResponse->getContent());
        $excelResponse = $this->get(route('program-shortlists.export', [$shortlistId, 'xlsx']))
            ->assertOk()
            ->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $export = new ProgramShortlistExport(ProgramShortlist::with('programs.school.country', 'programs.programLevel', 'programs.educationLevelprogram', 'programs.grading_scheme', 'programs.programEnglishRequired.proficiency')->findOrFail($shortlistId));
        $workbookBytes = Excel::raw($export, ExcelWriter::XLSX);
        $this->assertStringStartsWith('PK', $workbookBytes);
        $mappedProgram = $export->map($program->fresh(['school.country', 'programLevel', 'educationLevelprogram', 'grading_scheme', 'programEnglishRequired.proficiency']));
        $this->assertSame('Example University', $mappedProgram[0]);
        $this->assertSame('Applied Computing', $mappedProgram[1]);
        $this->assertSame('Canada', $mappedProgram[2]);
        $this->assertSame('Toronto, Ontario', $mappedProgram[3]);
        $this->assertStringContainsString('IELTS', $mappedProgram[10]);
        $this->assertStringContainsString('Overall 6.5', $mappedProgram[10]);
        $this->assertStringContainsString('Minimum GPA 3.0', $mappedProgram[11]);
    }

    public function test_sub_agent_can_save_and_manage_a_separate_owned_shortlist(): void
    {
        $agent = $this->makeUser('parent-agent@example.test', 'agent');
        $subAgent = $this->makeUser('sub-agent@example.test', 'sub_agent', $agent->id);
        $program = $this->makeProgram();
        $this->actingAs($subAgent);

        $shortlistId = $this->postJson(route('program-shortlists.store'), [
            'name' => 'Australia Undergraduate',
            'program_ids' => [$program->id],
        ])->assertCreated()->json('shortlist_id');

        $this->assertDatabaseHas('users', ['id' => $subAgent->id, 'added_by' => $agent->id]);
        $this->get(route('program-shortlists.show', $shortlistId))->assertOk()->assertSee('Sub-Agent');
        $this->postJson(route('program-shortlists.programs.add', $shortlistId), ['program_ids' => [$program->id]])
            ->assertOk();
        $this->assertSame(1, DB::table('program_shortlist_program')->where('shortlist_id', $shortlistId)->count());
    }

    public function test_shortlist_ownership_blocks_other_agents_and_parent_agents(): void
    {
        $parentAgent = $this->makeUser('owner-agent@example.test', 'agent');
        $subAgent = $this->makeUser('child-sub-agent@example.test', 'sub_agent', $parentAgent->id);
        $program = $this->makeProgram();
        $this->actingAs($subAgent);
        $shortlistId = $this->postJson(route('program-shortlists.store'), [
            'name' => 'Private shortlist',
            'program_ids' => [$program->id],
        ])->assertCreated()->json('shortlist_id');

        $otherAgent = $this->makeUser('other-agent@example.test', 'agent');
        $this->actingAs($otherAgent);
        $this->get(route('program-shortlists.show', $shortlistId))->assertNotFound();
        $this->patchJson(route('program-shortlists.rename', $shortlistId), ['name' => 'Hijacked'])->assertNotFound();
        $this->get(route('program-shortlists.export', [$shortlistId, 'pdf']))->assertNotFound();
        $this->postJson(route('program-shortlists.programs.add', $shortlistId), ['program_ids' => [$program->id]])->assertNotFound();
        $this->deleteJson(route('program-shortlists.programs.remove', [$shortlistId, $program->id]))->assertNotFound();
        $this->deleteJson(route('program-shortlists.destroy', $shortlistId))->assertNotFound();

        $this->actingAs($parentAgent);
        $this->get(route('program-shortlists.show', $shortlistId))->assertNotFound();
    }

    public function test_guests_and_unrelated_roles_cannot_manage_shortlists(): void
    {
        $this->get(route('program-shortlists.index'))->assertRedirect();
        $this->postJson(route('program-shortlists.store'), [])->assertUnauthorized();

        $student = $this->makeUser('student@example.test', 'student');
        $this->actingAs($student);
        $this->get(route('program-shortlists.index'))->assertForbidden();
    }

    public function test_duplicate_ids_are_rejected_and_programs_can_be_removed(): void
    {
        $agent = $this->makeUser('manage-agent@example.test', 'agent');
        $program = $this->makeProgram();
        $this->actingAs($agent);

        $this->postJson(route('program-shortlists.store'), [
            'name' => 'Duplicate test',
            'program_ids' => [$program->id, $program->id],
        ])->assertUnprocessable();

        $shortlistId = $this->postJson(route('program-shortlists.store'), [
            'name' => 'Manage test',
            'program_ids' => [$program->id],
        ])->assertCreated()->json('shortlist_id');
        $this->deleteJson(route('program-shortlists.programs.remove', [$shortlistId, $program->id]))->assertOk();
        $this->assertDatabaseMissing('program_shortlist_program', ['shortlist_id' => $shortlistId, 'program_id' => $program->id]);

        $this->deleteJson(route('program-shortlists.destroy', $shortlistId))->assertOk();
        $this->assertDatabaseMissing('program_shortlists', ['id' => $shortlistId]);
    }

    public function test_program_search_matches_program_and_university_but_excludes_unapproved_programs(): void
    {
        $agent = $this->makeUser('search-agent@example.test', 'agent');
        $program = $this->makeProgram();
        $this->actingAs($agent);

        $this->getJson(route('program-shortlists.programs.search', ['q' => 'Example University']))
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.id', $program->id);

        $this->getJson(route('program-shortlists.programs.search', ['q' => 'Applied Computing']))
            ->assertOk()
            ->assertJsonCount(1);

        DB::table('program')->where('id', $program->id)->update(['is_approved' => 0]);
        $this->getJson(route('program-shortlists.programs.search', ['q' => 'Applied Computing']))
            ->assertOk()
            ->assertJsonCount(0);
    }

    public function test_unavailable_programs_are_hidden_and_empty_shortlists_export_safely(): void
    {
        $agent = $this->makeUser('unavailable-agent@example.test', 'agent');
        $program = $this->makeProgram();
        $this->actingAs($agent);
        $shortlistId = $this->postJson(route('program-shortlists.store'), [
            'name' => 'Unavailable program',
            'program_ids' => [$program->id],
        ])->assertCreated()->json('shortlist_id');
        DB::table('program')->where('id', $program->id)->update(['is_approved' => 0]);

        $this->get(route('program-shortlists.show', $shortlistId))
            ->assertOk()
            ->assertSee('No available programs in this shortlist');
        $this->get(route('program-shortlists.export', [$shortlistId, 'pdf']))->assertOk();
        $this->get(route('program-shortlists.export', [$shortlistId, 'xlsx']))->assertOk();
    }

    private function makeUser(string $email, string $roleName, ?int $addedBy = null): User
    {
        DB::table('users')->insert([
            'name' => $roleName,
            'email' => $email,
            'admin_type' => $roleName,
            'password' => bcrypt('password'),
            'added_by' => $addedBy,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user = User::where('email', $email)->firstOrFail();
        $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        $user->assignRole($role);

        return $user;
    }

    private function makeProgram(): Program
    {
        $countryId = DB::table('country')->insertGetId(['name' => 'Canada']);
        $provinceId = DB::table('province')->insertGetId(['name' => 'Ontario', 'country_id' => $countryId]);
        $universityId = DB::table('universities')->insertGetId([
            'university_name' => 'Example University',
            'country_id' => $countryId,
            'state' => $provinceId,
            'city' => 'Toronto',
            'is_approved' => 1,
        ]);
        $ieltsId = DB::table('eng_proficiency_levels')->insertGetId(['name' => 'IELTS']);
        $programId = DB::table('program')->insertGetId([
            'school_id' => $universityId,
            'name' => 'Applied Computing',
            'is_approved' => 1,
            'length' => '2 years',
            'tution_fee' => 19000,
            'currency' => 'CAD',
            'application_fee' => 100,
            'intake' => '09',
            'min_gpa' => '3.0',
        ]);
        DB::table('program_english_required')->insert([
            'program_id' => $programId,
            'type' => $ieltsId,
            'overall_score' => '6.5',
        ]);

        return Program::findOrFail($programId);
    }

    private function createSchema(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('admin_type')->nullable();
            $table->string('status')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type']);
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
            $table->primary(['role_id', 'model_id', 'model_type']);
        });
        Schema::create('country', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
        });
        Schema::create('province', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
        });
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('university_name')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_approved')->default(true);
        });
        Schema::create('program_level', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
        });
        Schema::create('education_level', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
        });
        Schema::create('grading_scheme', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
        });
        Schema::create('eng_proficiency_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
        });
        Schema::create('program', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->string('name')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->string('length')->nullable();
            $table->string('programType')->nullable();
            $table->string('programCampus')->nullable();
            $table->string('grading_number')->nullable();
            $table->text('description')->nullable();
            $table->decimal('application_fee', 12, 2)->nullable();
            $table->date('application_apply_date')->nullable();
            $table->date('application_closing_date')->nullable();
            $table->unsignedBigInteger('program_level_id')->nullable();
            $table->unsignedBigInteger('education_level_id')->nullable();
            $table->unsignedBigInteger('grading_scheme_id')->nullable();
            $table->decimal('tution_fee', 12, 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('intake')->nullable();
            $table->string('year')->nullable();
            $table->string('other_exam')->nullable();
            $table->string('other_exam_number')->nullable();
            $table->string('min_gpa')->nullable();
            $table->text('other_requirements')->nullable();
            $table->timestamps();
        });
        Schema::create('program_english_required', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('type')->nullable();
            $table->string('listening_score')->nullable();
            $table->string('writing_score')->nullable();
            $table->string('reading_score')->nullable();
            $table->string('speaking_score')->nullable();
            $table->string('overall_score')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        $shortlistMigration = require base_path('database/migrations/2026_10_31_000000_create_program_shortlists_tables.php');
        $shortlistMigration->up();
    }
}
