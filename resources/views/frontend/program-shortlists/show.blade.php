@extends('frontend.layouts.main')
@section('title', $shortlist->name . ' | Program Shortlists')
@section('content')
<div class="container py-4">
    <nav aria-label="Breadcrumb" class="mb-3">
        <a href="{{ route('program-shortlists.index') }}">My Shortlists</a>
        <span class="text-muted"> / {{ $shortlist->name }}</span>
    </nav>
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <p class="text-muted mb-1">{{ auth()->user()->hasRole('agent') ? 'Agent' : 'Sub-Agent' }}</p>
            <h1 class="h2" id="shortlist-title">{{ $shortlist->name }}</h1>
            <p class="text-muted mb-0">{{ $shortlist->programs->count() }} / 5 available programs · Updated {{ $shortlist->updated_at->format('M j, Y') }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-outline-secondary" id="shortlist-rename">Rename</button>
            <a class="btn btn-outline-secondary" href="{{ route('program-shortlists.export', [$shortlist->id, 'pdf']) }}">Download PDF</a>
            <a class="btn btn-outline-success" href="{{ route('program-shortlists.export', [$shortlist->id, 'xlsx']) }}">Export Excel</a>
        </div>
    </div>
    <div id="shortlist-feedback" class="small mb-3" role="status" aria-live="polite"></div>

    <section class="border rounded p-3 mb-4" aria-labelledby="add-programs-heading">
        <h2 class="h5" id="add-programs-heading">Add Programs</h2>
        <label for="shortlist-program-search" class="form-label">Search approved programs or universities</label>
        <input id="shortlist-program-search" class="form-control" type="search" autocomplete="off" placeholder="Type at least 2 characters">
        <div id="shortlist-search-state" class="small text-muted mt-2" role="status" aria-live="polite"></div>
        <div id="shortlist-search-results" class="list-group mt-2"></div>
        <button type="button" class="btn btn-primary mt-3" id="shortlist-add-programs" disabled>Add selected programs</button>
    </section>

    @if($shortlist->programs->isEmpty())
        <div class="border rounded p-4 text-center" id="shortlist-empty-state">
            <h2 class="h5">No available programs in this shortlist</h2>
            <p class="text-muted mb-0">Programs that are no longer approved are excluded. Search above to add available programs.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>University</th>
                        <th>Country</th>
                        <th>Study level</th>
                        <th>Duration</th>
                        <th>Tuition</th>
                        <th>Application fee</th>
                        <th>Intake</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="shortlist-program-rows">
                    @foreach($shortlist->programs as $program)
                        @php
                            $intakeMonth = (int) $program->intake;
                            $intakeLabel = $intakeMonth >= 1 && $intakeMonth <= 12 ? date('F', mktime(0, 0, 0, $intakeMonth, 1)) : $program->intake;
                            $languageRequirements = collect([$program->lang_spec_for_program])->merge($program->programEnglishRequired->map(function ($requirement) {
                                $scores = collect([
                                    'Listening ' . ($requirement->listening_score ?? ''),
                                    'Writing ' . ($requirement->writing_score ?? ''),
                                    'Reading ' . ($requirement->reading_score ?? ''),
                                    'Speaking ' . ($requirement->speaking_score ?? ''),
                                    'Overall ' . ($requirement->overall_score ?? ''),
                                ])->filter(fn ($value) => !str_ends_with($value, ' '))->implode(', ');

                                return collect([$requirement->proficiency?->name, $scores, $requirement->remarks])
                                    ->filter(fn ($value) => filled($value))->implode(': ');
                            }))->filter()->implode('; ');
                            $programUrl = $program->school && $program->school->country
                                ? route('study-in.program', [
                                    'country' => Illuminate\Support\Str::slug($program->school->country->name),
                                    'university' => Illuminate\Support\Str::slug($program->school->university_name) . '-' . $program->school->id,
                                    'program' => Illuminate\Support\Str::slug($program->name) . '-' . $program->id,
                                ])
                                : null;
                        @endphp
                        <tr data-program-row="{{ $program->id }}">
                            <th scope="row">
                                <a href="{{ $programUrl ?? '#' }}">{{ $program->name }}</a>
                                <details class="small mt-1">
                                    <summary>Program details</summary>
                                    <p class="mb-1"><strong>Language requirements:</strong> {{ $languageRequirements }}</p>
                                    <p class="mb-1"><strong>Academic eligibility:</strong> {{ $program->educationLevelprogram?->name ?? '' }}{{ $program->min_gpa ? ' · Minimum GPA ' . $program->min_gpa : '' }}{{ $program->grading_number ? ' · ' . $program->grading_number . ' ' . ($program->grading_scheme?->name ?? '') : '' }}</p>
                                    @if(filled($program->other_requirements))
                                        <p class="mb-1"><strong>Additional requirements:</strong> {{ $program->other_requirements }}</p>
                                    @endif
                                    <p class="mb-1"><strong>Application deadline:</strong> {{ $program->application_closing_date ?? $program->application_apply_date ?? '' }}</p>
                                    @if(filled($program->description))
                                        <p class="mb-1"><strong>Description:</strong> {{ strip_tags($program->description) }}</p>
                                    @endif
                                    @if($programUrl)<p class="mb-1"><a href="{{ $programUrl }}">Program URL</a></p>@endif
                                </details>
                            </th>
                            <td>{{ $program->school?->university_name ?? 'Not available' }}</td>
                            <td>{{ $program->school?->country?->name ?? 'Not available' }}{{ $program->school?->province?->name ? ', ' . $program->school->province->name : '' }}{{ $program->school?->city ? ', ' . $program->school->city : '' }}</td>
                            <td>{{ $program->programLevel?->name ?? '' }}</td>
                            <td>{{ $program->length ?? '' }}</td>
                            <td>{{ $program->currency ?? '' }} {{ $program->tution_fee ?? '' }}</td>
                            <td>{{ $program->application_fee !== null ? 'INR ' . $program->application_fee : '' }}</td>
                            <td>{{ $intakeLabel ?? '' }}</td>
                            <td><button type="button" class="btn btn-sm btn-outline-danger shortlist-remove-program" data-program-id="{{ $program->id }}">Remove Program</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
@section('javascript_section')
<script>
(function () {
    const searchUrl = @json(route('program-shortlists.programs.search'));
    const addUrl = @json(route('program-shortlists.programs.add', $shortlist->id));
    const renameUrl = @json(route('program-shortlists.rename', $shortlist->id));
    const removeUrlBase = @json(url('/program-shortlists/' . $shortlist->id . '/programs'));
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const alreadySaved = new Set(@json($shortlist->programs->pluck('id')->map(fn ($id) => (string) $id)->values()));
    const selectedToAdd = new Set();
    let searchVersion = 0;
    const searchInput = document.getElementById('shortlist-program-search');
    const results = document.getElementById('shortlist-search-results');
    const state = document.getElementById('shortlist-search-state');
    const feedback = document.getElementById('shortlist-feedback');
    const addButton = document.getElementById('shortlist-add-programs');
    let searchTimer;

    function updateAddButton() {
        const remainingSlots = Math.max(0, 5 - alreadySaved.size);
        document.querySelectorAll('.shortlist-add-checkbox').forEach(function (checkbox) {
            checkbox.disabled = alreadySaved.has(String(checkbox.value)) ||
                (!selectedToAdd.has(String(checkbox.value)) && selectedToAdd.size >= remainingSlots);
        });
        addButton.disabled = selectedToAdd.size === 0 || remainingSlots === 0;
        addButton.textContent = selectedToAdd.size ? 'Add selected programs (' + selectedToAdd.size + ')' : 'Add selected programs';
    }

    function showSearchResults(programs) {
        results.replaceChildren();
        if (!programs.length) {
            state.textContent = 'No approved programs found.';
            return;
        }
        state.textContent = programs.length + ' programs found.';
        programs.forEach(function (program) {
            const label = document.createElement('label');
            label.className = 'list-group-item d-flex gap-2 align-items-start';
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'form-check-input mt-1 shortlist-add-checkbox';
            checkbox.value = program.id;
            checkbox.disabled = alreadySaved.has(String(program.id)) || alreadySaved.size + selectedToAdd.size >= 5;
            checkbox.checked = selectedToAdd.has(String(program.id));
            checkbox.addEventListener('change', function () {
                if (checkbox.checked) selectedToAdd.add(String(program.id));
                else selectedToAdd.delete(String(program.id));
                updateAddButton();
            });
            const text = document.createElement('span');
            text.textContent = [program.name, program.university, program.country, program.level].filter(Boolean).join(' · ');
            label.append(checkbox, text);
            results.append(label);
        });
    }

    searchInput.addEventListener('input', function () {
        window.clearTimeout(searchTimer);
        const requestVersion = ++searchVersion;
        const term = searchInput.value.trim();
        updateAddButton();
        results.replaceChildren();
        if (term.length < 2) {
            state.textContent = 'Type at least 2 characters.';
            return;
        }
        state.textContent = 'Searching...';
        searchTimer = window.setTimeout(function () {
            fetch(searchUrl + '?q=' + encodeURIComponent(term), { headers: { 'Accept': 'application/json' } })
                .then(function (response) {
                    if (!response.ok) throw new Error('Program search failed.');
                    return response.json();
                })
                .then(function (programs) {
                    if (requestVersion === searchVersion) showSearchResults(programs);
                })
                .catch(function (error) {
                    if (requestVersion === searchVersion) state.textContent = error.message;
                });
        }, 250);
    });

    addButton.addEventListener('click', function () {
        addButton.disabled = true;
        state.textContent = 'Saving selected programs...';
        fetch(addUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ program_ids: Array.from(selectedToAdd) })
        }).then(function (response) {
            return response.json().then(function (data) {
                if (!response.ok) throw new Error(data.errors?.program_ids?.[0] || data.message || 'Programs could not be added.');
                return data;
            });
        }).then(function (data) {
            feedback.className = 'small mb-3 text-success';
            feedback.textContent = data.message;
            window.location.reload();
        }).catch(function (error) {
            feedback.className = 'small mb-3 text-danger';
            feedback.textContent = error.message;
            updateAddButton();
        });
    });

    document.querySelectorAll('.shortlist-remove-program').forEach(function (button) {
        button.addEventListener('click', function () {
            button.disabled = true;
            fetch(removeUrlBase + '/' + encodeURIComponent(button.dataset.programId), {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
            }).then(function (response) {
                if (!response.ok) throw new Error('Program could not be removed.');
                const row = button.closest('tr');
                row.remove();
                alreadySaved.delete(String(button.dataset.programId));
                updateAddButton();
                feedback.className = 'small mb-3 text-success';
                feedback.textContent = 'Program removed from shortlist.';
                if (!document.querySelector('[data-program-row]')) window.location.reload();
            }).catch(function (error) {
                button.disabled = false;
                feedback.className = 'small mb-3 text-danger';
                feedback.textContent = error.message;
            });
        });
    });

    document.getElementById('shortlist-rename').addEventListener('click', function () {
        const currentName = document.getElementById('shortlist-title').textContent.trim();
        const nextName = window.prompt('Rename shortlist', currentName);
        if (nextName === null || !nextName.trim() || nextName.trim() === currentName) return;
        fetch(renameUrl, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ name: nextName.trim() })
        }).then(function (response) {
            return response.json().then(function (data) {
                if (!response.ok) throw new Error(data.errors?.name?.[0] || data.message || 'Shortlist could not be renamed.');
                document.getElementById('shortlist-title').textContent = data.name;
                feedback.className = 'small mb-3 text-success';
                feedback.textContent = data.message;
                document.title = data.name + ' | Program Shortlists';
            });
        }).catch(function (error) {
            feedback.className = 'small mb-3 text-danger';
            feedback.textContent = error.message;
        });
    });
})();
</script>
@endsection
