<?php

namespace App\Http\Controllers;

use App\Exports\ProgramShortlistExport;
use App\Models\Program;
use App\Models\ProgramShortlist;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProgramShortlistController extends Controller
{
    public function index(Request $request)
    {
        $shortlists = ProgramShortlist::query()
            ->where('user_id', $request->user()->id)
            ->withCount('programs')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->string('search') . '%');
            })
            ->latest('updated_at')
            ->paginate(15)
            ->appends($request->query());

        return view('frontend.program-shortlists.index', compact('shortlists'));
    }

    public function show(Request $request, int $shortlistId)
    {
        $shortlist = $this->ownedShortlist($request, $shortlistId);
        $shortlist->load($this->programRelations());

        return view('frontend.program-shortlists.show', compact('shortlist'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'program_ids' => ['required', 'array', 'min:1', 'max:5'],
            'program_ids.*' => ['required', 'integer', 'distinct', 'exists:program,id'],
        ]);
        $programIds = $this->approvedProgramIds($validated['program_ids']);
        $this->rejectUnavailablePrograms($validated['program_ids'], $programIds);

        $shortlist = DB::transaction(function () use ($request, $validated, $programIds) {
            $shortlist = ProgramShortlist::create([
                'user_id' => $request->user()->id,
                'name' => trim($validated['name']),
            ]);
            $shortlist->programs()->attach($programIds);

            return $shortlist;
        });

        return response()->json([
            'message' => 'Shortlist saved.',
            'shortlist_id' => $shortlist->id,
            'url' => route('program-shortlists.show', $shortlist->id),
        ], 201);
    }

    public function searchPrograms(Request $request)
    {
        $validated = $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:100'],
        ]);
        $search = trim($validated['q']);
        $programs = Program::query()
            ->with(['school.country', 'programLevel'])
            ->where('is_approved', 1)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhereIn('school_id', \App\Models\University::query()
                        ->select('id')
                        ->where('university_name', 'like', '%' . $search . '%'));
            })
            ->limit(20)
            ->get();

        return response()->json($programs->map(function (Program $program) {
            return [
                'id' => $program->id,
                'name' => $program->name,
                'university' => $program->school?->university_name,
                'country' => $program->school?->country?->name,
                'level' => $program->programLevel?->name,
                'duration' => $program->length,
            ];
        }));
    }

    public function rename(Request $request, int $shortlistId)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:120'],
        ]);
        $shortlist = $this->ownedShortlist($request, $shortlistId);
        $shortlist->name = trim($validated['name']);
        $shortlist->save();

        return response()->json(['message' => 'Shortlist renamed.', 'name' => $shortlist->name]);
    }

    public function addPrograms(Request $request, int $shortlistId)
    {
        $validated = $request->validate([
            'program_ids' => ['required', 'array', 'min:1', 'max:250'],
            'program_ids.*' => ['required', 'integer', 'distinct', 'exists:program,id'],
        ]);
        $shortlist = $this->ownedShortlist($request, $shortlistId);
        $programIds = $this->approvedProgramIds($validated['program_ids']);
        $this->rejectUnavailablePrograms($validated['program_ids'], $programIds);
        $programCount = DB::transaction(function () use ($shortlist, $programIds) {
            $shortlist = ProgramShortlist::query()->lockForUpdate()->findOrFail($shortlist->id);
            $savedProgramIds = $shortlist->programs()->pluck('program.id')->all();
            $newProgramIds = array_values(array_diff($programIds, $savedProgramIds));

            if (count($savedProgramIds) + count($newProgramIds) > 5) {
                throw ValidationException::withMessages([
                    'program_ids' => ['A shortlist can contain a maximum of 5 programs.'],
                ]);
            }

            $shortlist->programs()->syncWithoutDetaching($newProgramIds);

            return $shortlist->programs()->count();
        });

        return response()->json([
            'message' => 'Programs added to shortlist.',
            'program_count' => $programCount,
        ]);
    }

    public function removeProgram(Request $request, int $shortlistId, int $programId)
    {
        $shortlist = $this->ownedShortlist($request, $shortlistId);
        $shortlist->programs()->detach($programId);

        return response()->json(['message' => 'Program removed from shortlist.']);
    }

    public function destroy(Request $request, int $shortlistId)
    {
        $this->ownedShortlist($request, $shortlistId)->delete();

        return response()->json(['message' => 'Shortlist deleted.']);
    }

    public function exportExcel(Request $request, int $shortlistId)
    {
        $shortlist = $this->ownedShortlist($request, $shortlistId);
        $shortlist->load($this->programRelations());

        return Excel::download(
            new ProgramShortlistExport($shortlist),
            $this->filename($shortlist, 'xlsx')
        );
    }

    public function exportPdf(Request $request, int $shortlistId)
    {
        $shortlist = $this->ownedShortlist($request, $shortlistId);
        $shortlist->load($this->programRelations());

        return Pdf::loadView('frontend.program-shortlists.pdf', [
            'shortlist' => $shortlist,
            'exportedAt' => now(),
        ])->setPaper('a4')->download($this->filename($shortlist, 'pdf'));
    }

    public function export(Request $request, int $shortlistId, string $format)
    {
        if ($format === 'pdf') {
            return $this->exportPdf($request, $shortlistId);
        }
        if ($format === 'xlsx') {
            return $this->exportExcel($request, $shortlistId);
        }

        abort(404);
    }

    private function ownedShortlist(Request $request, int $shortlistId): ProgramShortlist
    {
        return ProgramShortlist::query()
            ->where('user_id', $request->user()->id)
            ->findOrFail($shortlistId);
    }

    private function approvedProgramIds(array $programIds): array
    {
        return Program::query()
            ->where('is_approved', 1)
            ->whereIn('id', $programIds)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    private function rejectUnavailablePrograms(array $requestedIds, array $approvedIds): void
    {
        if (count($approvedIds) !== count($requestedIds)) {
            throw ValidationException::withMessages([
                'program_ids' => ['One or more selected programs are no longer available. Refresh the program list and try again.'],
            ]);
        }
    }

    private function filename(ProgramShortlist $shortlist, string $extension): string
    {
        return (Str::slug($shortlist->name) ?: 'program-shortlist') . '.' . $extension;
    }

    private function programRelations(): array
    {
        return [
            'programs.school.country',
            'programs.school.province',
            'programs.programLevel',
            'programs.educationLevelprogram',
            'programs.grading_scheme',
            'programs.programEnglishRequired.proficiency',
        ];
    }
}
