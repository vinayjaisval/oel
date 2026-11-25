<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class Oel360JourneyAccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'session.driver' => 'array']);
        $this->app['url']->forceRootUrl('http://localhost');
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::purge('sqlite');
        $db = DB::connection();
        if ($db->getDriverName() !== 'sqlite' || $db->getDatabaseName() !== ':memory:') {
            throw new \RuntimeException('The isolated SQLite connection was not selected.');
        }
        $db->statement('CREATE TABLE student (id INTEGER PRIMARY KEY, user_id INTEGER, profile_complete INTEGER, added_by INTEGER, created_at TEXT)');
        $db->statement('CREATE TABLE tbl_three_sixtee (id INTEGER PRIMARY KEY, sba_id INTEGER, user_id INTEGER, college TEXT, courses TEXT, selected_program TEXT, added_by INTEGER, visa_application TEXT, visa_no TEXT, visa_exp_date TEXT, visa_remarks TEXT, remarks TEXT, joining_date TEXT, fee_currency TEXT, fee_amount REAL, cource_details TEXT)');
        $db->statement('CREATE TABLE student_by_agent (id INTEGER PRIMARY KEY, student_user_id INTEGER, email TEXT, name TEXT)');
        $db->statement('CREATE TABLE tbl_three_sixtee_image (id INTEGER PRIMARY KEY, user_id INTEGER, image TEXT, selected_course INTEGER, image_type TEXT)');
        $db->statement('CREATE TABLE university (id INTEGER PRIMARY KEY, university_name TEXT, is_approved INTEGER)');
        $db->statement('CREATE TABLE program (id INTEGER PRIMARY KEY, name TEXT, is_approved INTEGER)');
        $db->table('student')->insert([
            ['id' => 1, 'user_id' => 101, 'profile_complete' => 1, 'added_by' => 10],
            ['id' => 2, 'user_id' => 102, 'profile_complete' => 1, 'added_by' => 20],
        ]);
        $db->table('tbl_three_sixtee_image')->insert(['id' => 1, 'user_id' => 102, 'image' => 'synthetic.pdf', 'selected_course' => 1, 'image_type' => 'offer']);
        $db->table('program')->insert([['id' => 21, 'name' => 'First', 'is_approved' => 1], ['id' => 22, 'name' => 'Second', 'is_approved' => 1]]);
        $db->table('student_by_agent')->insert(['id' => 1, 'student_user_id' => 101, 'email' => 'student@example.test', 'name' => 'Test Student']);
    }

    public function test_authorized_user_cannot_save_or_delete_another_students_case(): void
    {
        $user = new JourneyTestUser(['id' => 10]);
        $this->actingAs($user);
        $this->post('/admin/aply-lead-360', ['sba_id' => 102, 'tab1' => 'tab1', 'collegeValues' => [1]])->assertNotFound();
        $this->get('/admin/delete-lead-360-image?id=1&sba_id=101')->assertNotFound();
        $this->get('/admin/delete-lead-360-image?id=1')->assertNotFound();
        $this->assertSame(1, DB::table('tbl_three_sixtee_image')->count());
        $this->assertSame(0, DB::table('tbl_three_sixtee')->count());
    }

    public function test_authorized_course_insert_and_update_use_the_submitted_values(): void
    {
        $this->actingAs(new JourneyTestUser(['id' => 10]));
        foreach ([21, 22] as $program) {
            $this->post('/admin/aply-lead-360', ['sba_id' => 101, 'tab2' => 'tab2', 'courseValues' => [$program]])
                ->assertOk()->assertJsonPath('program.0.id', $program);
            $this->assertSame((string) $program, DB::table('tbl_three_sixtee')->where('sba_id', 1)->value('courses'));
        }
    }

    public function test_visa_rejection_requires_reason_and_preserves_unsent_fields(): void
    {
        \Illuminate\Support\Facades\Mail::fake();
        DB::table('tbl_three_sixtee')->insert(['sba_id' => 1, 'user_id' => 101, 'visa_application' => 'Accepted', 'visa_no' => 'TEST-123', 'visa_exp_date' => '2030-01-01', 'visa_remarks' => 'Earlier remark']);
        $this->actingAs(new JourneyTestUser(['id' => 10]));
        $this->postJson('/admin/aply-lead-360', ['sba_id' => 101, 'tab' => 'tab6', 'visa_application' => 'Rejected'])
            ->assertStatus(422)->assertJsonValidationErrors(['visa_remarks']);
        $this->assertSame('Accepted', DB::table('tbl_three_sixtee')->where('sba_id', 1)->value('visa_application'));
        $this->postJson('/admin/aply-lead-360', ['sba_id' => 101, 'tab' => 'tab6', 'visa_application' => 'Rejected', 'visa_remarks' => 'Missing document'])
            ->assertOk()->assertJsonPath('success', true);
        $saved = DB::table('tbl_three_sixtee')->where('sba_id', 1)->first();
        $this->assertSame('Rejected', $saved->visa_application);
        $this->assertSame('Missing document', $saved->visa_remarks);
        $this->assertSame('TEST-123', $saved->visa_no);
        $this->assertSame('2030-01-01', $saved->visa_exp_date);
    }
}

class JourneyTestUser extends User
{
    public function can($abilities, $arguments = [])
    {
        return in_array($abilities, ['student.view', 'oel_apply.view', 'universities.create', 'courses.create', 'visa_status.create'], true);
    }

    public function hasRole($roles, string $guard = null): bool
    {
        return false;
    }
}
