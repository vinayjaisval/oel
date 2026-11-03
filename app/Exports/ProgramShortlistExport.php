<?php

namespace App\Exports;

use App\Models\Program;
use App\Models\ProgramShortlist;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProgramShortlistExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(private ProgramShortlist $shortlist)
    {
    }

    public function collection()
    {
        return $this->shortlist->programs;
    }

    public function headings(): array
    {
        return [
            'University',
            'Program',
            'Country',
            'Location',
            'Study level',
            'Duration',
            'Tuition fee',
            'Currency',
            'Application fee',
            'Intake',
            'Language requirements',
            'Academic eligibility',
            'Application deadline',
            'Description',
            'Program URL',
        ];
    }

    public function map($program): array
    {
        $university = $program->school;
        $country = $university?->country?->name;
        $month = (int) $program->intake;
        $intake = $month >= 1 && $month <= 12
            ? date('F', mktime(0, 0, 0, $month, 1))
            : ($program->intake ?? '');
        $academicEligibility = collect([
            $program->educationLevelprogram?->name,
            $program->min_gpa ? 'Minimum GPA ' . $program->min_gpa : null,
            $program->other_requirements,
            collect([$program->grading_number, $program->grading_scheme?->name])
                ->filter(fn ($value) => filled($value))->implode(' '),
        ])->filter(fn ($value) => filled($value))->implode('; ');
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

        return [
            $university?->university_name ?? '',
            $program->name ?? '',
            $country ?? '',
            collect([$university?->city, $university?->province?->name, $university?->zip])
                ->filter(fn ($value) => filled($value))->implode(', '),
            $program->programLevel?->name ?? '',
            $program->length ?? '',
            $program->tution_fee ?? '',
            $program->currency ?? '',
            $program->application_fee !== null ? 'INR ' . $program->application_fee : '',
            $intake,
            $languageRequirements,
            $academicEligibility,
            $program->application_closing_date ?? $program->application_apply_date ?? '',
            strip_tags((string) ($program->description ?? '')),
            $this->programUrl($program, $university, $country),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '17365D']],
                'alignment' => ['vertical' => 'center', 'wrapText' => true],
            ],
        ];
    }

    private function programUrl(Program $program, $university, ?string $country): string
    {
        if (!$university || !$country) {
            return '';
        }

        return url('/study-in-' . Str::slug($country) . '/' .
            Str::slug($university->university_name) . '-' . $university->id . '/' .
            Str::slug($program->name) . '-' . $program->id);
    }
}
