@extends('admin.include.app')
@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="{{ asset('assets/css/program-redesign.css') }}" rel="stylesheet">
@endsection
@section('main-content')
<div class="pr-page">

    <div class="pr-header">
        <div>
            <h1 class="pr-title">Add Program</h1>
            <ol class="pr-breadcrumb" style="list-style:none;display:flex;gap:0.35rem;padding:0;margin:0.2rem 0 0;">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage-program') }}">Manage Program</a></li>
                <li>/</li>
                <li>Add</li>
            </ol>
        </div>
        <a href="{{ route('manage-program') }}" class="pr-btn pr-btn-outline">&larr; Back to list</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="programForm" action="{{ route('store-program') }}" method="POST">
        @csrf

        {{-- 1. Basic Information --}}
        <div class="pr-card pr-form-card">
            <div class="pr-form-card-header">
                <span class="pr-step-number">1</span>
                <div>
                    <h3 class="pr-form-card-title">Basic Information</h3>
                    <p class="pr-form-card-subtitle">University, program name aur duration</p>
                </div>
            </div>
            <div class="pr-form-grid">
                <div class="pr-form-field pr-col-span-2 @error('school_id') pr-has-error @enderror">
                    <label for="school_id">University / College<span class="pr-required">*</span></label>
                    <select class="pr-select" name="school_id" id="school_id" style="width:100%">
                        @if($selected_university)
                        <option value="{{ $selected_university->id }}" selected>{{ $selected_university->university_name }}</option>
                        @endif
                    </select>
                    @error('school_id')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('programType') pr-has-error @enderror">
                    <label for="lead-programType">Program / Course Type<span class="pr-required">*</span></label>
                    <select class="pr-select" name="programType" id="lead-programType">
                        <option value="">Select program / course type</option>
                        <option value="Full Time" {{ old('programType') == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                        <option value="Part Time" {{ old('programType') == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                        <option value="Correspondence" {{ old('programType') == 'Correspondence' ? 'selected' : '' }}>Correspondence</option>
                    </select>
                    @error('programType')<span class="pr-error">{{ $message }}</span>@enderror
                </div>

                <div class="pr-form-field pr-col-span-2 @error('name') pr-has-error @enderror">
                    <label for="lead-name">Program / Course Name<span class="pr-required">*</span></label>
                    <input class="pr-input" name="name" id="lead-name" type="text" value="{{ old('name') }}" placeholder="e.g. Master of Business Administration (MBA)" autocomplete="off">
                    @error('name')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('length') pr-has-error @enderror">
                    <label for="lead-length">Program Duration<span class="pr-required">*</span></label>
                    <input id="lead-length" name="length" type="text" class="pr-input" value="{{ old('length') }}" placeholder="e.g. 2 Years / 18 Months" autocomplete="off">
                    @error('length')<span class="pr-error">{{ $message }}</span>@enderror
                </div>

                <div class="pr-form-field @error('programCampus') pr-has-error @enderror">
                    <label for="lead-programCampus">Course Campus<span class="pr-required">*</span></label>
                    <select class="pr-select" name="programCampus" id="lead-programCampus">
                        <option value="">Select course campus</option>
                        <option value="Online" {{ old('programCampus') == 'Online' ? 'selected' : '' }}>Online</option>
                        <option value="On Campus" {{ old('programCampus') == 'On Campus' ? 'selected' : '' }}>On Campus</option>
                    </select>
                    @error('programCampus')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('priority') pr-has-error @enderror">
                    <label for="lead-priority">Campus (Address / Notes)</label>
                    <input id="lead-priority" name="priority" type="text" class="pr-input" placeholder="e.g. Berlin, Munich" autocomplete="off" value="{{ old('priority') }}">
                    @error('priority')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('lang_spec_for_program') pr-has-error @enderror">
                    <label for="lead-lang_spec_for_program">Program Language<span class="pr-required">*</span></label>
                    <select class="pr-select" name="lang_spec_for_program" id="lead-lang_spec_for_program">
                        <option value="">Select program language</option>
                        <option value="English" {{ old('lang_spec_for_program') == 'English' ? 'selected' : '' }}>English</option>
                        <option value="Hindi" {{ old('lang_spec_for_program') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                        <option value="Other" {{ old('lang_spec_for_program') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('lang_spec_for_program')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- 2. Classification --}}
        <div class="pr-card pr-form-card">
            <div class="pr-form-card-header">
                <span class="pr-step-number">2</span>
                <div>
                    <h3 class="pr-form-card-title">Classification</h3>
                    <p class="pr-form-card-subtitle">Discipline aur level &ndash; course finder filters isi se chalte hain</p>
                </div>
            </div>
            <div class="pr-form-grid">
                <div class="pr-form-field @error('program_discipline') pr-has-error @enderror">
                    <label for="program-discipline">Program Discipline<span class="pr-required">*</span></label>
                    <select class="pr-select program_discipline_select" name="program_discipline" id="program-discipline">
                        <option value="">Select program discipline</option>
                        @foreach ($program_discipline as $item)
                        <option value="{{ $item->id }}" {{ old('program_discipline') == $item->id ? 'selected' : '' }}>{{ implode(' ', array_slice(explode(' ', $item->name), 0, 3)) }}</option>
                        @endforeach
                    </select>
                    @error('program_discipline')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('program_subdiscipline') pr-has-error @enderror">
                    <label for="lead-program-sub-discipline">Program Sub Discipline</label>
                    <select class="pr-select program_sub_discipline_select" name="program_subdiscipline" id="lead-program-sub-discipline">
                        <option value="">Select program sub discipline</option>
                    </select>
                    @error('program_subdiscipline')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('program_level') pr-has-error @enderror">
                    <label for="program-level">Program Level<span class="pr-required">*</span></label>
                    <select class="pr-select" name="program_level" id="program-level">
                        <option value="">Select program level</option>
                        @foreach ($program_level as $item)
                        <option value="{{ $item->id }}" {{ old('program_level') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('program_level')<span class="pr-error">{{ $message }}</span>@enderror
                </div>

                <div class="pr-form-field @error('program_sub_level') pr-has-error @enderror">
                    <label for="program-sub-level">Program Sub Level<span class="pr-required">*</span></label>
                    <select class="pr-select program-sub-level" name="program_sub_level" id="program-sub-level">
                        <option value="">Select program sub level</option>
                    </select>
                    @error('program_sub_level')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field pr-col-span-2">
                    <label for="lead-tags">Course Tags</label>
                    <input id="lead-tags" name="tags" type="text" class="pr-input" placeholder="e.g. MBA, Management, STEM" autocomplete="off" value="{{ old('tags') }}">
                    <span class="pr-hint">Comma se alag karein</span>
                </div>
            </div>
        </div>

        {{-- 3. Admission Requirements --}}
        <div class="pr-card pr-form-card">
            <div class="pr-form-card-header">
                <span class="pr-step-number">3</span>
                <div>
                    <h3 class="pr-form-card-title">Admission Requirements</h3>
                </div>
            </div>
            <div class="pr-form-grid">
                <div class="pr-form-field @error('education_level') pr-has-error @enderror">
                    <label for="education-level">Min. Education Level<span class="pr-required">*</span></label>
                    <select class="pr-select" name="education_level" id="education-level">
                        <option value="">Select min. education level</option>
                    </select>
                    @error('education_level')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('grading_scheme_id') pr-has-error @enderror">
                    <label for="grading_scheme_id">Grading Scheme<span class="pr-required">*</span></label>
                    <select class="pr-select select-grading-scheme" name="grading_scheme_id" id="grading_scheme_id">
                        <option value="">Select grading scheme</option>
                    </select>
                    @error('grading_scheme_id')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('other_exam') pr-has-error @enderror">
                    <label for="other_exam">Other Exam<span class="pr-required">*</span></label>
                    <select class="pr-select other-exam" name="other_exam" id="other_exam">
                        <option value="">Select other exam</option>
                    </select>
                    @error('other_exam')<span class="pr-error">{{ $message }}</span>@enderror
                </div>

                <div class="pr-form-field" id="grading-number-div" style="display:none;">
                    <label for="lead-grading_number">Grading Number<span class="pr-required">*</span></label>
                    <input type="hidden" name="max_grading_number" id="max_grading_number">
                    <input id="lead-grading_number" name="grading_number" type="text" class="pr-input" placeholder="e.g. 3.5" autocomplete="off" value="{{ old('grading_number') }}">
                    <span id="grading_input_error" class="pr-error" style="display:none;">Invalid grade. Please enter a value within the selected grading scheme.</span>
                    @error('grading_number')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field" id="other-exam-input" style="display:none;">
                    <label for="lead-other-exam-number">Other Exam Total Score<span class="pr-required">*</span></label>
                    <input id="lead-other-exam-number" name="other_exam_number" type="number" class="pr-input" placeholder="0" autocomplete="off" value="{{ old('other_exam_number') }}">
                    <span id="other_exam_input_error" class="pr-error" style="display:none;">Invalid input. Please enter a value within the selected other exam.</span>
                    @error('other_exam_number')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('work_experience') pr-has-error @enderror">
                    <label for="lead-work-experience">Work Experience<span class="pr-required">*</span></label>
                    <select class="pr-select" name="work_experience" id="lead-work-experience">
                        <option value="">Select work experience</option>
                        <option value="1" {{ old('work_experience') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('work_experience') === '0' ? 'selected' : '' }}>No</option>
                    </select>
                    @error('work_experience')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- 4. Fees, Dates & Intake --}}
        <div class="pr-card pr-form-card">
            <div class="pr-form-card-header">
                <span class="pr-step-number">4</span>
                <div>
                    <h3 class="pr-form-card-title">Fees, Dates &amp; Intake</h3>
                </div>
            </div>
            <div class="pr-form-grid">
                <div class="pr-form-field @error('currency') pr-has-error @enderror">
                    <label for="lead-currency">Tuition Currency<span class="pr-required">*</span></label>
                    <select class="pr-select" name="currency" id="lead-currency">
                        <option value="">Select tuition currency</option>
                        @foreach ($currency as $item)
                        <option value="{{ $item->currency }}" {{ old('currency') == $item->currency ? 'selected' : '' }}>{{ $item->currency }}</option>
                        @endforeach
                    </select>
                    @error('currency')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('tution_fee') pr-has-error @enderror">
                    <label for="lead-tution_fee">Tuition Fee<span class="pr-required">*</span></label>
                    <input id="lead-tution_fee" name="tution_fee" type="number" step="0.01" class="pr-input" placeholder="0.00" autocomplete="off" value="{{ old('tution_fee') }}">
                    @error('tution_fee')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('application_fee') pr-has-error @enderror">
                    <label for="lead-application_fee">Application Fee (INR)<span class="pr-required">*</span></label>
                    <div class="pr-input-prefix">
                        <span class="pr-input-prefix-sign">&#8377;</span>
                        <input id="lead-application_fee" name="application_fee" type="number" class="pr-input" placeholder="0" autocomplete="off" value="{{ old('application_fee') }}">
                    </div>
                    @error('application_fee')<span class="pr-error">{{ $message }}</span>@enderror
                </div>

                <div class="pr-form-field @error('application_apply_date') pr-has-error @enderror">
                    <label for="lead-application_apply_date">Application Open Date<span class="pr-required">*</span></label>
                    <input id="lead-application_apply_date" name="application_apply_date" type="date" class="pr-input" value="{{ old('application_apply_date') }}">
                    @error('application_apply_date')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('application_closing_date') pr-has-error @enderror">
                    <label for="lead-application_closing_date_input">Application Closing Date<span class="pr-required">*</span></label>
                    <input id="lead-application_closing_date_input" type="date" class="pr-input date-input" value="">
                    <div class="pr-radio-row">
                        <label><input type="radio" name="application_closing_date_radio" value="ASAP" {{ old('application_closing_date_radio') == 'ASAP' ? 'checked' : '' }}> ASAP</label>
                        <label><input type="radio" name="application_closing_date_radio" value="TBD" {{ old('application_closing_date_radio') == 'TBD' ? 'checked' : '' }}> TBD</label>
                    </div>
                    <input type="hidden" name="application_closing_date" id="final_closing_date" value="{{ old('application_closing_date') }}">
                    @error('application_closing_date')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div></div>

                <div class="pr-form-field @error('intake') pr-has-error @enderror">
                    <label for="lead-intake">Intake<span class="pr-required">*</span></label>
                    <select class="pr-select" name="intake" id="lead-intake">
                        <option value="">Select intake</option>
                        @foreach (range(1, 12) as $month)
                        <option value="{{ date('m', mktime(0, 0, 0, $month, 10)) }}" {{ old('intake') == date('m', mktime(0, 0, 0, $month, 10)) ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 10)) }}</option>
                        @endforeach
                    </select>
                    @error('intake')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
                <div class="pr-form-field @error('year') pr-has-error @enderror">
                    <label for="lead-year">Year<span class="pr-required">*</span></label>
                    <select class="pr-select" name="year" id="lead-year">
                        <option value="">Select year</option>
                        @foreach (range((int) date('Y'), (int) date('Y') + 10) as $year)
                        <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                    @error('year')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- 5. Scholarship --}}
        @include('admin.program.partials.scholarship-fields')

        {{-- 6. Description & Notes --}}
        <div class="pr-card pr-form-card">
            <div class="pr-form-card-header">
                <span class="pr-step-number">6</span>
                <div>
                    <h3 class="pr-form-card-title">Description &amp; Notes</h3>
                </div>
            </div>
            <div class="pr-form-grid">
                <div class="pr-form-field pr-col-span-2" style="grid-column:1 / -1;">
                    <label>Description</label>
                    <textarea name="details" id="summernote1" class="pr-input" cols="30" rows="10">{{ old('details') }}</textarea>
                </div>
                <div class="pr-form-field @error('extra_notes') pr-has-error @enderror" style="grid-column:1 / -1;">
                    <label>Extra Notes</label>
                    <textarea name="extra_notes" id="summernote2" class="pr-input" cols="30" rows="10">{{ old('extra_notes') }}</textarea>
                    @error('extra_notes')<span class="pr-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="pr-sticky-bar">
            <a href="{{ route('manage-program') }}" class="pr-btn pr-btn-outline">Cancel</a>
            <button id="submitBtn" type="submit" class="pr-btn pr-btn-primary">&#10003; Save Program</button>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("programForm");
    const btn = document.getElementById("submitBtn");

    if (form && btn) {
        form.addEventListener("submit", function () {
            btn.disabled = true;
            btn.innerText = "Processing...";
        });
    }

    const firstError = document.querySelector('.pr-has-error');
    if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script>

<script>
$(document).ready(function () {

    const $dateInput = $('#lead-application_closing_date_input');
    const $hidden = $('#final_closing_date');
    const $radios = $('input[name="application_closing_date_radio"]');

    /* ================= PAGE LOAD (EDIT / VALIDATION FAIL) ================= */
    const saved = $hidden.val();

    if (saved) {
        if (saved === 'ASAP' || saved === 'TBD') {
            $radios.filter(`[value="${saved}"]`).prop('checked', true);
            $dateInput.val('').prop('disabled', true);
        } else {
            $dateInput.val(saved);
            $radios.prop('checked', false);
        }
    }

    /* ================= DATE CHANGE ================= */
    $dateInput.on('change', function () {
        $hidden.val($(this).val());
        $radios.prop('checked', false);
    });

    /* ================= RADIO CHANGE ================= */
    $radios.on('change', function () {
        $hidden.val($(this).val());
        $dateInput.val('').prop('disabled', true);
    });

});
</script>

<script>
(function ($) {

    window.addEventListener('load', function () {

        /* ===================== CSRF ===================== */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* ===================== SELECT2 (university, type-to-search) ===================== */
        if ($.fn.select2) {
            $('#school_id').select2({
                placeholder: 'Select university / college',
                allowClear: true,
                width: '100%',
                minimumInputLength: 0,
                ajax: {
                    url: '{{ route('search-university') }}',
                    dataType: 'json',
                    delay: 300,
                    data: function (params) {
                        return { q: params.term || '' };
                    },
                    processResults: function (data) {
                        return { results: data.results };
                    },
                    cache: true
                }
            });
        }

        /* ===================== SUMMERNOTE ===================== */
        if ($.fn.summernote) {
            $('#summernote1, #summernote2').summernote({
                placeholder: 'Write Here',
                height: 120
            });
        }
        let oldSubDiscipline = "{{ old('program_subdiscipline') }}";
        /* ===================== PROGRAM DISCIPLINE ===================== */
        $('.program_discipline_select').on('change', function () {

            $.get("{{ route('get-program-sub-discipline') }}", {
                program_discipline_id: $('#program-discipline').val()
            }, function (res) {

                let $sub = $('.program_sub_discipline_select');
                $sub.empty().append('<option value="">Select program sub discipline</option>');

                if (res && res.length) {
                    $.each(res, function (_, v) {
                        let selected = (v.id == oldSubDiscipline) ? 'selected' : '';
                        $sub.append(`<option value="${v.id}" ${selected}>${v.name}</option>`);
                    });
                }
            });
        });

        $(document).ready(function () {
            if ($('#program-discipline').val()) {
                $('.program_discipline_select').trigger('change');
            }
        });

        /* ===================== PROGRAM LEVEL -> SUB LEVEL ===================== */
        $('#program-level').on('change', function () {

            let program_id = $(this).val();
            if (!program_id) {
                return;
            }

            $.post("{{ route('get-program-sublevel') }}", {
                program_level_id: program_id
            }, function (data) {

                let $sub = $('#program-sub-level').empty();

                if (data && data.length) {
                    $sub.append('<option value="">Select program sub level</option>');
                    $.each(data, function (_, v) {
                        $sub.append(`<option value="${v.id}">${v.name.toUpperCase()}</option>`);
                    });
                } else {
                    $sub.append('<option value="">Not Found</option>');
                }
            });

            $.ajax({
                url: "{{ route('fetch-other-exam') }}",
                type: "POST",
                data: { program_id: program_id },
                success: function (data) {

                    let $other = $('#other_exam').empty();

                    if (data && data.length > 0) {
                        $other.append('<option value="">Select other exam</option>');
                        $.each(data, function (_, exam) {
                            $other.append(`<option value="${exam.id}" other-exam-number="${exam.number}">${exam.name.toUpperCase()}</option>`);
                        });
                    } else {
                        $other.append('<option value="">Not Found</option>');
                    }
                },
                error: function (xhr) {
                    console.error('Other Exam Error:', xhr.responseText);
                }
            });

        });

        /* ===================== SUB LEVEL -> EDUCATION LEVEL ===================== */
        $('#program-sub-level').on('change', function () {

            $.post("{{ route('education-level-fetch') }}", {
                program_level_id: $('#program-level').val(),
                program_sublevel_id: $(this).val()
            }, function (data) {

                let $edu = $('#education-level').empty();

                if (data && data.length) {
                    $edu.append('<option value="">Select min. education level</option>');
                    $.each(data, function (_, v) {
                        $edu.append(`<option value="${v.id}">${v.name.toUpperCase()}</option>`);
                    });
                } else {
                    $edu.append('<option value="">Not Found</option>');
                }
            });
        });

        /* ===================== EDUCATION -> GRADING SCHEME ===================== */
        $('#education-level').on('change', function () {

            let edu = $(this).val();
            let uni = $('#school_id').val();

            if (!edu || !uni) {
                return;
            }

            $.post("{{ route('fetch-scheme-data') }}", {
                education_level_id: edu,
                university_id: uni
            }, function (data) {

                let $grading = $('#grading_scheme_id')
                    .empty()
                    .append('<option value="">Select grading scheme</option>');

                if (data && data.length) {
                    $.each(data, function (_, v) {
                        $grading.append(`<option value="${v.id}" grading-data="${v.name}">${v.name.toUpperCase()}</option>`);
                    });
                }
            });
        });

        /* ===================== VALIDATION ===================== */
        function extractMax(value) {
            let m = value ? value.match(/(\d+)$/) : null;
            return m ? parseInt(m[0]) : null;
        }

        $(document).on('change', '.select-grading-scheme', function () {
            var grading_scheme_id = $(this).val();
            $('#grading-number-div').toggle(grading_scheme_id != '');
        });
        $(document).on('change', '.other-exam', function () {
            var other_exam_id = $(this).val();
            $('#other-exam-input').toggle(other_exam_id != '');
        });

        $('#grading_scheme_id, #lead-grading_number').on('keyup change', function () {

            let scheme = $('#grading_scheme_id option:selected').attr('grading-data');
            let max = extractMax(scheme);
            let val = $('#lead-grading_number').val();

            $('#lead-grading_number').toggleClass('is-invalid', max && val > max);
            $('#grading_input_error').toggle(max && val > max);
        });

        /* ===================== SCHOLARSHIP TOGGLE ===================== */
        function toggleScholarshipBox(animate) {
            var isYes = $('#scholarship_available').val() == '1';
            var $box = $('#scholarship-box');
            if (isYes) {
                animate ? $box.slideDown(200) : $box.show();
                $box.find('.scholarship-required').attr('required', true);
            } else {
                animate ? $box.slideUp(200) : $box.hide();
                $box.find('.scholarship-required').removeAttr('required');
            }
        }
        $('#scholarship_available').on('change', function () {
            toggleScholarshipBox(true);
        });
        toggleScholarshipBox(false);

    });

})(jQuery);
</script>

@endsection
