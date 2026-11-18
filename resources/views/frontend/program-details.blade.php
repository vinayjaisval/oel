@extends('frontend.layouts.main')
@section('title', ($program_data->name ?? 'Program') . ' at ' . ($program_data->university_name->university_name ?? '') . ' | Overseas Education Lane')
@section('meta_description', 'Apply for ' . ($program_data->name ?? '') . ' at ' . ($program_data->university_name->university_name ?? '') . ' in ' . ($program_data->university_name->country_name->name ?? '') . '. Duration: ' . ($program_data->length ?? 'N/A') . ' months. Tuition: ' . ($program_data->currency ?? '') . ' ' . ($program_data->tution_fee ?? 'N/A') . '.')
@section('og_title', $program_data->name ?? 'Program')
@section('og_description', Str::limit(strip_tags($program_data->description ?? ''), 160))
@section('og_image', $program_data->university_name->banner ? asset($program_data->university_name->banner) : asset('frontend/img/default-og.jpg'))
@php
    $studyInProgramSlugs = [
        'country' => \Illuminate\Support\Str::slug($program_data->university_name->country_name->name ?? 'unknown'),
        'university' => \Illuminate\Support\Str::slug($program_data->university_name->university_name ?? 'unknown') . '-' . ($program_data->university_name->id ?? 0),
        'program' => \Illuminate\Support\Str::slug($program_data->name) . '-' . $program_data->id,
    ];
    $universityUrl = route('study-in.university', [
        'country' => $studyInProgramSlugs['country'],
        'university' => $studyInProgramSlugs['university'],
    ]);
    $gradingScheme = \App\Models\GradingScheme::where('id', $program_data->grading_scheme_id ?? null)->pluck('name')->first();
    $hasGpa = !empty($program_data->grading_number) || !empty($gradingScheme);
    $examNames = $exam_text->pluck('name')->filter()->implode(', ');
    $intakeLabel = $program_data->intake ? date('F', mktime(0, 0, 0, $program_data->intake, 10)) : null;

    $infoRows = collect([
        ['label' => 'Country', 'value' => $program_data->university_name->country_name->name ?? null],
        ['label' => 'Course duration', 'value' => $program_data->length ? $program_data->length . (stripos($program_data->length, 'month') === false ? ' months' : '') : null],
        ['label' => 'Course type', 'value' => $program_data->programType ?? null],
        ['label' => 'Study mode', 'value' => $program_data->programCampus ?? null],
        ['label' => 'Campus', 'value' => $program_data->priority ?? null],
        ['label' => 'Program level', 'value' => $program_data->programLevel->name ?? null],
        ['label' => 'Education required', 'value' => $program_data->educationLevelprogram->name ?? null],
        ['label' => 'Language tests', 'value' => $examNames ?: null],
        ['label' => 'Admission intake', 'value' => $intakeLabel],
        ['label' => 'Minimum GPA', 'value' => $hasGpa ? trim(($program_data->grading_number ?? '') . ' ' . ($gradingScheme ?? '')) : null],
    ])->filter(fn($row) => !empty($row['value']));

    $applicationFeeFree = empty($program_data->application_fee);
    $applicationFeeText = $applicationFeeFree ? 'Free' : trim(($program_data->currency ?? '') . ' ' . number_format((float) $program_data->application_fee, 0));
    $tuitionText = $program_data->tution_fee !== null && $program_data->tution_fee !== ''
        ? trim(($program_data->currency ?? '') . ' ' . number_format((float) $program_data->tution_fee, 0))
        : null;

    $formatDate = function ($value) {
        if (empty($value)) {
            return null;
        }
        try {
            return \Carbon\Carbon::parse($value)->format('j M Y');
        } catch (\Exception $e) {
            return $value;
        }
    };
    $opensAt = $formatDate($program_data->application_apply_date);
    $closesAt = $formatDate($program_data->application_closing_date);

    $universityInitials = \Illuminate\Support\Str::of($program_data->university_name->university_name ?? '')
        ->explode(' ')->filter()->take(2)->map(fn($w) => strtoupper($w[0]))->implode('');
@endphp
@section('canonical_url', route('study-in.program', $studyInProgramSlugs))
@section('content')

@push('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Course",
    "name": @json($program_data->name),
    "description": @json(strip_tags($program_data->description ?? '')),
    "provider": {
        "@type": "CollegeOrUniversity",
        "name": @json($program_data->university_name->university_name ?? ''),
        "sameAs": @json($program_data->university_name->website ?? '')
    }
}
</script>
@endpush

<style>
    .pd {
        --navy: #111A66;
        --orange: #C2410C;
        --bg: #F4F6FB;
        --border: #E3E7F0;
        --green: #166534;
        background: var(--bg);
    }

    .pd-title-band {
        background: #fff;
        border-bottom: 1px solid var(--border);
        padding: 20px 0 24px;
    }

    .pd-title-head {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        margin-top: 10px;
    }

    .pd-logo {
        width: 56px;
        height: 56px;
        border-radius: 10px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        background: #fff;
        font-weight: 700;
        color: var(--navy);
        font-size: 15px;
    }

    .pd-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .pd-title-head h1 {
        font-weight: 700;
        font-size: clamp(22px, 3vw, 30px);
        color: var(--navy);
        margin: 0 0 4px;
    }

    .pd-subline a {
        color: var(--navy);
        font-weight: 600;
        text-decoration: none;
    }

    .pd-subline a:hover {
        text-decoration: underline;
    }

    .pd-subline .muted {
        color: #6b7280;
    }

    .pd-body {
        padding: 28px 0 48px;
    }

    .pd-grid {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 991px) {
        .pd-grid {
            grid-template-columns: 1fr;
        }
    }

    .pd-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px;
    }

    .pd-card h2 {
        font-weight: 700;
        font-size: 18px;
        color: #1f2430;
        margin-bottom: 10px;
    }

    .pd-info-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 11px 0;
        border-bottom: 1px solid var(--border);
    }

    .pd-info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .pd-info-row .l {
        color: #6b7280;
        font-size: 14px;
    }

    .pd-info-row .v {
        font-weight: 700;
        color: #1f2430;
        text-align: right;
        font-size: 14px;
    }

    .pd-btn-primary,
    .pd-btn-secondary {
        display: block;
        width: 100%;
        min-height: 48px;
        border-radius: 8px;
        font-weight: 600;
        text-align: center;
        padding: 12px;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .pd-btn-primary {
        background: var(--orange);
        color: #fff;
        margin-top: 16px;
    }

    .pd-btn-primary:hover {
        background: #a8380a;
        color: #fff;
    }

    .pd-btn-primary:disabled,
    .pd-btn-primary[aria-disabled="true"] {
        opacity: .5;
        pointer-events: none;
    }

    .pd-btn-secondary {
        background: #fff;
        color: var(--navy);
        border: 1px solid var(--border);
        margin-top: 10px;
    }

    .pd-btn-secondary:hover {
        background: var(--bg);
        color: var(--navy);
    }

    .pd-intake-select {
        width: 100%;
        min-height: 44px;
        border-radius: 8px;
        border: 1px solid var(--border);
        padding: 0 12px;
        margin-top: 10px;
        font-size: 14px;
    }

    .pd-tabs {
        display: flex;
        gap: 4px;
        border-bottom: 1px solid var(--border);
        padding: 0 20px;
        overflow-x: auto;
    }

    .pd-tabs button {
        background: none;
        border: none;
        padding: 16px 10px;
        font-weight: 600;
        color: #6b7280;
        border-bottom: 2px solid transparent;
        white-space: nowrap;
        cursor: pointer;
    }

    .pd-tabs button.active {
        color: var(--navy);
        border-bottom-color: var(--navy);
    }

    .pd-tab-panel {
        padding: 22px 20px 24px;
        display: none;
    }

    .pd-tab-panel.active {
        display: block;
    }

    .pd-tab-panel h3 {
        font-weight: 700;
        font-size: 16px;
        color: #1f2430;
        margin: 22px 0 10px;
    }

    .pd-tab-panel h3:first-child {
        margin-top: 0;
    }

    .pd-charge-row,
    .pd-date-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 480px) {
        .pd-charge-row,
        .pd-date-row {
            grid-template-columns: 1fr;
        }
    }

    .pd-box {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 14px 16px;
    }

    .pd-box .l {
        display: block;
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .pd-box .v {
        font-weight: 700;
        font-size: 18px;
        color: #1f2430;
    }

    .pd-box .v.free {
        color: var(--green);
    }

    .pd-fees-note {
        color: #6b7280;
        font-size: 13px;
        margin-top: 10px;
    }

    .pd-exam-card {
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 14px;
    }

    .pd-exam-head {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        background: var(--bg);
        padding: 10px 16px;
        font-weight: 700;
        color: #1f2430;
    }

    .pd-exam-head .overall {
        font-weight: 400;
        color: #6b7280;
        font-size: 14px;
    }

    .pd-exam-head .overall b {
        color: #1f2430;
        font-weight: 700;
    }

    .pd-exam-scores {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        text-align: center;
    }

    @media (max-width: 480px) {
        .pd-exam-scores {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .pd-exam-scores .score {
        padding: 12px 8px;
        border-top: 1px solid var(--border);
    }

    .pd-exam-scores .score .l {
        display: block;
        color: #6b7280;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .pd-exam-scores .score .v {
        font-weight: 700;
        color: #1f2430;
    }

    .pd-exam-remarks {
        padding: 10px 16px;
        border-top: 1px solid var(--border);
        color: #6b7280;
        font-size: 13px;
    }

    .pd-prose {
        line-height: 1.7;
        color: #374151;
    }

    a.pd-btn-primary:focus-visible,
    a.pd-btn-secondary:focus-visible,
    .pd-btn-primary:focus-visible,
    .pd-tabs button:focus-visible {
        outline: 3px solid #90a4ff;
        outline-offset: 2px;
    }
</style>

<div class="pd">
    <section class="pd-title-band">
        <div class="container">
            @include('frontend.partials.breadcrumb', ['items' => [
                ['label' => 'Home', 'url' => url('/')],
                ['label' => $program_data->university_name->country_name->name ?? ''],
                ['label' => $program_data->university_name->university_name ?? '', 'url' => $universityUrl],
                ['label' => $program_data->name ?? ''],
            ]])

            <div class="pd-title-head">
                <div class="pd-logo">
                    @if($program_data->university_name->logo ?? null)
                        <img src="{{ asset($program_data->university_name->logo) }}" alt="{{ $program_data->university_name->university_name }} logo" width="56" height="56" loading="eager" decoding="async" onerror="this.parentElement.textContent='{{ $universityInitials }}'">
                    @else
                        {{ $universityInitials }}
                    @endif
                </div>
                <div>
                    <h1>{{ $program_data->name ?? '' }}</h1>
                    <div class="pd-subline">
                        <a href="{{ $universityUrl }}">{{ $program_data->university_name->university_name ?? '' }}</a>
                        @php
                            $cityCountry = collect([$program_data->priority ?? null, $program_data->university_name->country_name->name ?? null])->filter()->implode(', ');
                        @endphp
                        @if($cityCountry)
                            <span class="muted">&middot; {{ $cityCountry }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pd-body">
        <div class="container">
            <div class="pd-grid">
                <div>
                    <div class="pd-card">
                        <h2>Course information</h2>
                        @foreach($infoRows as $row)
                            <div class="pd-info-row">
                                <span class="l">{{ $row['label'] }}</span>
                                <span class="v">{{ $row['value'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    @if(Auth::check())
                        @php $user = Auth::user(); @endphp
                        @if($user->hasRole('student'))
                            @php
                                $student_id = App\Models\Student::where('user_id', $user->id)->select('id')->first();
                                $student_program_applied = App\Models\PaymentsLink::with('program:name,id,school_id')->where('user_id', $user->id)->get();
                                $university_id = $student_program_applied->pluck('program.school_id')->toArray();
                            @endphp
                            @if(in_array($program_data->school_id, $university_id))
                                <button type="button" class="pd-btn-primary" disabled>You Can Select One University One Program</button>
                            @else
                                @php
                                    $student_data = DB::table('student')->where('user_id', $user->id)->first();
                                    $program_id = DB::table('education_history')->select('education_level_id')
                                        ->where('student_id', $student_data->id ?? null)
                                        ->pluck('education_level_id')->toArray();
                                    $program_level_name = App\Models\ProgramLevel::where('id', $program_id)->pluck('name')->first();
                                    $documents_id = App\Models\Documents::where('name', 'like', '%' . $program_level_name . '%')->pluck('id')->first();
                                    $last_school_attended = App\Models\SchoolAttended::where('student_id', $student_data->id)->where('documents', $documents_id)
                                        ->select('grading_scheme_id', 'max_score', 'grading_average')
                                        ->first();

                                    $studentGradingSchemeId = explode('-', $last_school_attended->grading_scheme_id ?? null);
                                    $studentGradingSchemeValue = end($studentGradingSchemeId);
                                    $studentGradingSchemeId = App\Models\GradingScheme::where('name', 'like', '%Out of ' . $studentGradingSchemeValue . '%')->pluck('id')->toArray();

                                    $Additional_qualification = App\Models\AdditionalQualification::where('student_id', $student_data->id)
                                        ->whereIn('type', ['GRE', 'GMAT'])
                                        ->select('type', 'total_score')
                                        ->get();
                                    $test_score = App\Models\TestScore::where('student_id', $student_data->id)
                                        ->select('type', 'total_score')
                                        ->get();
                                    $test_score_additional_qualification = [];
                                    foreach ($test_score as $key => $value) {
                                        $test_score_additional_qualification[$value->type] = $value->total_score;
                                    }
                                    foreach ($Additional_qualification as $key => $value) {
                                        $test_score_additional_qualification[$value->type] = $value->total_score;
                                    }
                                    $exam_data = $exam_text->mapWithKeys(function ($exam) {
                                        if (is_numeric($exam->type)) {
                                            $type = App\Models\EngProficiencyLevel::where('id', $exam->type)->value('name') ?? null;
                                        } else {
                                            $type = $exam->type;
                                        }
                                        return [$type => $exam->overall_score ?? 0.0];
                                    });
                                    $matching_scores = collect($exam_data)->filter(function ($value, $key) use ($test_score_additional_qualification) {
                                        return isset($test_score_additional_qualification[$key]) && $test_score_additional_qualification[$key] == $value;
                                    });
                                @endphp

                                @if(isset($matching_scores) && count($matching_scores) > 0 && ($program_data->grading_number <= (isset($last_school_attended) ? $last_school_attended->grading_average : 0)) && in_array($program_data->grading_scheme_id, $studentGradingSchemeId))
                                    <a href="{{ route('apply-program-payment', ['student_id' => $student_id->id, 'program_id' => $program_data->id]) }}" class="pd-btn-primary">Apply</a>
                                @else
                                    <select class="pd-intake-select" name="intake_month" id="intakeMonth">
                                        <option value="">Select intake month</option>
                                        <option value="jan">January</option>
                                        <option value="feb">February</option>
                                        <option value="mar">March</option>
                                        <option value="apr">April</option>
                                        <option value="may">May</option>
                                        <option value="jun">June</option>
                                        <option value="jul">July</option>
                                        <option value="aug">August</option>
                                        <option value="sep">September</option>
                                        <option value="oct">October</option>
                                        <option value="nov">November</option>
                                        <option value="dec">December</option>
                                    </select>

                                    <select class="pd-intake-select" name="intake_year" id="intakeYear">
                                        <option value="">Select intake year</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                    </select>

                                    <a href="{{ route('apply-program-payment', ['student_id' => $student_id->id, 'program_id' => $program_data->id]) }}"
                                        id="applyBtn"
                                        class="pd-btn-primary"
                                        aria-disabled="true">
                                        Apply
                                    </a>

                                    <script>
                                        const intakeMonth = document.getElementById('intakeMonth');
                                        const intakeYear = document.getElementById('intakeYear');
                                        const applyBtn = document.getElementById('applyBtn');

                                        const monthMap = { jan: 0, feb: 1, mar: 2, apr: 3, may: 4, jun: 5, jul: 6, aug: 7, sep: 8, oct: 9, nov: 10, dec: 11 };

                                        function checkIfFieldsAreSelected() {
                                            if (intakeMonth.value && intakeYear.value) {
                                                applyBtn.removeAttribute('aria-disabled');
                                            } else {
                                                applyBtn.setAttribute('aria-disabled', 'true');
                                            }
                                        }

                                        intakeMonth.addEventListener('change', checkIfFieldsAreSelected);
                                        intakeYear.addEventListener('change', checkIfFieldsAreSelected);

                                        applyBtn.addEventListener('click', function (event) {
                                            event.preventDefault();
                                            if (applyBtn.getAttribute('aria-disabled') === 'true') return;

                                            const selectedMonth = monthMap[intakeMonth.value];
                                            const selectedYear = parseInt(intakeYear.value);
                                            const today = new Date();
                                            const currentMonth = today.getMonth();
                                            const currentYear = today.getFullYear();

                                            if (selectedYear < currentYear || (selectedYear === currentYear && selectedMonth < currentMonth)) {
                                                alert("This intake is no longer available. Please select the current or a future intake.");
                                                return;
                                            }

                                            let url = "{{ route('apply-program-payment', ['student_id' => $student_id->id, 'program_id' => $program_data->id]) }}";
                                            url += "?intake_month=" + intakeMonth.value + "&intake_year=" + intakeYear.value;
                                            window.location.href = url;
                                        });
                                    </script>
                                @endif
                            @endif
                        @endif
                    @else
                        <a href="{{ route('user-login') }}" class="pd-btn-primary">Login to apply</a>
                    @endif
                    <button type="button" class="pd-btn-secondary" onclick="openWizard()">Talk to a counsellor</button>
                </div>

                <div class="pd-card" style="padding: 0;">
                    <div class="pd-tabs" role="tablist">
                        <button type="button" class="active" data-pd-tab="overview" role="tab" aria-selected="true">Overview</button>
                        <button type="button" data-pd-tab="description" role="tab" aria-selected="false">Description</button>
                        <button type="button" data-pd-tab="notes" role="tab" aria-selected="false">Extra notes</button>
                    </div>

                    <div class="pd-tab-panel active" id="pd-panel-overview" role="tabpanel">
                        <h3>Application charges</h3>
                        <div class="pd-charge-row">
                            <div class="pd-box">
                                <span class="l">Application fee</span>
                                <span class="v{{ $applicationFeeFree ? ' free' : '' }}">{{ $applicationFeeText }}</span>
                            </div>
                            @if($tuitionText)
                                <div class="pd-box">
                                    <span class="l">Tuition fee (1st year)</span>
                                    <span class="v">{{ $tuitionText }}</span>
                                </div>
                            @endif
                        </div>
                        <p class="pd-fees-note">Fees may vary according to university structure and policy.</p>

                        @if($opensAt || $closesAt)
                            <h3>Application dates</h3>
                            <div class="pd-date-row">
                                @if($opensAt)
                                    <div class="pd-box">
                                        <span class="l">Opens</span>
                                        <span class="v">{{ $opensAt }}</span>
                                    </div>
                                @endif
                                @if($closesAt)
                                    <div class="pd-box">
                                        <span class="l">Closes</span>
                                        <span class="v">{{ $closesAt }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($exam_text->isNotEmpty())
                            <h3>Accepted language tests</h3>
                            @foreach($exam_text as $exam)
                                <div class="pd-exam-card">
                                    <div class="pd-exam-head">
                                        <span>{{ $exam->name ?? '' }}</span>
                                        @if($exam->overall_score ?? null)
                                            <span class="overall">Overall <b>{{ $exam->overall_score }}</b></span>
                                        @endif
                                    </div>
                                    <div class="pd-exam-scores">
                                        <div class="score"><span class="l">Speaking</span><span class="v">{{ $exam->speaking_score ?? '–' }}</span></div>
                                        <div class="score"><span class="l">Listening</span><span class="v">{{ $exam->listening_score ?? '–' }}</span></div>
                                        <div class="score"><span class="l">Writing</span><span class="v">{{ $exam->writing_score ?? '–' }}</span></div>
                                        <div class="score"><span class="l">Reading</span><span class="v">{{ $exam->reading_score ?? '–' }}</span></div>
                                    </div>
                                    @if($exam->remarks ?? null)
                                        <div class="pd-exam-remarks">Remarks: {{ $exam->remarks }}</div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="pd-tab-panel" id="pd-panel-description" role="tabpanel">
                        <div class="pd-prose">{!! $program_data->description !!}</div>
                    </div>

                    <div class="pd-tab-panel" id="pd-panel-notes" role="tabpanel">
                        <div class="pd-prose">{!! $program_data->extra_notes !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('javascript_section')
<script>
    document.querySelectorAll('.pd-tabs button').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.pd-tabs button').forEach(b => { b.classList.remove('active'); b.setAttribute('aria-selected', 'false'); });
            document.querySelectorAll('.pd-tab-panel').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');
            document.getElementById('pd-panel-' + btn.dataset.pdTab).classList.add('active');
        });
    });
</script>
@endsection
