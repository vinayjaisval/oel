<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $shortlist->name }}</title>
    <style>
        @page { margin: 28px 32px; }
        body { font-family: DejaVu Sans, sans-serif; color: #202b38; font-size: 10px; }
        h1 { color: #17365d; font-size: 21px; margin: 0 0 5px; }
        .meta { color: #596777; margin-bottom: 18px; }
        .program { border: 1px solid #d5dce5; margin-bottom: 12px; padding: 11px; page-break-inside: avoid; }
        h2 { color: #17365d; font-size: 14px; margin: 0 0 7px; }
        .university { font-size: 11px; font-weight: bold; margin-bottom: 7px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border-bottom: 1px solid #e4e8ed; padding: 4px 5px; text-align: left; vertical-align: top; }
        th { color: #475569; width: 24%; }
        .description { margin-top: 8px; line-height: 1.4; }
        a { color: #175c9e; text-decoration: none; }
    </style>
</head>
<body>
    <h1>{{ $shortlist->name }}</h1>
    <div class="meta">Exported {{ $exportedAt->format('M j, Y H:i') }} · {{ $shortlist->programs->count() }} available programs</div>

    @forelse($shortlist->programs as $program)
        @php
            $university = $program->school;
            $country = $university?->country?->name;
            $month = (int) $program->intake;
            $intake = $month >= 1 && $month <= 12 ? date('F', mktime(0, 0, 0, $month, 1)) : $program->intake;
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
            $programUrl = $university && $country
                ? url('/study-in-' . Illuminate\Support\Str::slug($country) . '/' . Illuminate\Support\Str::slug($university->university_name) . '-' . $university->id . '/' . Illuminate\Support\Str::slug($program->name) . '-' . $program->id)
                : null;
        @endphp
        <section class="program">
            <h2>{{ $program->name ?? 'Program' }}</h2>
            <div class="university">{{ $university?->university_name ?? 'University not available' }}</div>
            <table>
                <tbody>
                    <tr><th>Country / Location</th><td>{{ $country ?? '' }}{{ $university?->city ? ', ' . $university->city : '' }}{{ $university?->province?->name ? ', ' . $university->province->name : '' }}</td></tr>
                    <tr><th>Study level</th><td>{{ $program->programLevel?->name ?? '' }}</td></tr>
                    <tr><th>Duration</th><td>{{ $program->length ?? '' }}</td></tr>
                    <tr><th>Tuition</th><td>{{ $program->currency ?? '' }} {{ $program->tution_fee ?? '' }}</td></tr>
                    <tr><th>Application fee</th><td>{{ $program->application_fee !== null ? 'INR ' . $program->application_fee : '' }}</td></tr>
                    <tr><th>Intake</th><td>{{ $intake ?? '' }}{{ $program->year ? ' ' . $program->year : '' }}</td></tr>
                    <tr><th>Language requirements</th><td>{{ $languageRequirements }}</td></tr>
                    <tr><th>Academic eligibility</th><td>{{ $program->educationLevelprogram?->name ?? '' }}{{ $program->min_gpa ? ' · Minimum GPA ' . $program->min_gpa : '' }}{{ $program->grading_number ? ' · ' . $program->grading_number . ' ' . ($program->grading_scheme?->name ?? '') : '' }}</td></tr>
                    <tr><th>Additional requirements</th><td>{{ $program->other_requirements ?? '' }}</td></tr>
                    <tr><th>Application deadline</th><td>{{ $program->application_closing_date ?? $program->application_apply_date ?? '' }}</td></tr>
                    <tr><th>Program URL</th><td>@if($programUrl)<a href="{{ $programUrl }}">{{ $programUrl }}</a>@endif</td></tr>
                </tbody>
            </table>
            @if(filled($program->description))
                <div class="description">{{ strip_tags($program->description) }}</div>
            @endif
        </section>
    @empty
        <p>No currently available programs are in this shortlist.</p>
    @endforelse
</body>
</html>
