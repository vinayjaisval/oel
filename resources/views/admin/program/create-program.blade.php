@extends('admin.include.app')
@section('style')
    <style>
        .octicon.octicon-light-bulb {
            position: absolute;
            left: 31px;
            top: 43px;
            font-size: 12px;
            width: 99%;
            text-align: center;
        }
        .dropdown-menu{
        min-width: 150px !important;
    }
    </style>

@endsection
@section('main-content')
<div class="row">
    <!-- Lightbox -->
<div class="col-lg-12">
    <div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0"> Add Program </h4>
    </div>
        <div class="card-body">
          <div class="wizard">
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" role="tabpanel" id="step1" aria-labelledby="step1-tab">
               
                <div class="mb-4">
                  <h3> Add Program</h3>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="programForm" class="row g-4"  action="{{route('store-program')}}" method="POST">
                    @csrf
                    @method('post')
                    <div class="col-4">
                       <div class="form-floating">
                          <select class="form-control " name="school_id" id="school_id" placeholder="University / College Name">
                             <option value="">-- University / College Name --</option>
                             @foreach ($universities as $item)
                                <option  title="{{$item->university_name}}" value="{{$item->id}}" {{ old('school_id') == $item->id ? 'selected' : '' }}>{{ implode(' ', array_slice(explode(' ', $item->university_name), 0, 5)) }}</option>
                             @endforeach
                          </select>

                          <label for="school_id" class="form-label">University / College Name <span class="text-danger">*</span></label>
                          @error('school_id')
                                  <div class="text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                    </div>
                    <div class="col-4">
                       <div class="form-floating">
                          <select class="form-control program_discipline_select" name="program_discipline" id="program-discipline" placeholder="Program Category">
                             <option value="">-- Select Program Discipline --</option>
                             @foreach ($program_discipline as $item)
                                <option value="{{$item->id}}" {{ old('program_discipline') == $item->id ? 'selected' : '' }}>{{ implode(' ', array_slice(explode(' ', $item->name), 0, 3)) }}</option>
                             @endforeach
                          </select>
                          <label for="lead-program-discipline" class="form-label">Program discipline <span class="text-danger">*</span></label>
                        </div>
                        @error('program_discipline')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-control program_sub_discipline_select" name="program_subdiscipline" id="lead-program-sub-discipline" placeholder="Program Sub Discipline">
                                <option value="">-- Select Program Sub Discipline --</option>
                               
                            </select>
                            <label for="lead-program-sub-discipline" class="form-label">Program sub discipline</label>
                        </div>
                        @error('program_subdiscipline')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                   
                    <div class="col-4">
                        <div class="form-floating">
                            <input  name="name" type="text" class="form-control " value="{{ old('name')}}" placeholder="Program / Courses Name" autocomplete="name" >
                            <label for="lead-name" class="form-label">Program / Courses Name <span class="text-danger">*</span></label>
                        </div>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col-4">
                       <div class="form-floating">
                            <input id="lead-length" name="length" type="text" class="form-control "  value="{{ old('length')}}" placeholder="Program / Courses Duration" autocomplete="length" value="">
                            <label for="lead-length" class="form-label">Program / Courses Duration <span class="text-danger">*</span></label>
                        </div>
                        @error('length')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col-4">
                       <div class="form-floating">
                          <select class="form-control " name="programType" id="lead-programType" placeholder="Program / Courses Type">
                             <option value="">-- Select programType --</option>
                             <option value="Full Time"  {{ old('programType') == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                             <option value="Part Time"  {{ old('programType') == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                             <option value="Correspondence"  {{ old('programType') == 'Correspondence' ? 'selected' : '' }}>Correspondence</option>
                          </select>
                          <label for="lead-programType" class="form-label">Program / Courses Type <span class="text-danger">*</span></label>
                        </div>
                        @error('programType')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col-4">
                       <div class="form-floating">
                          <select class="form-control  " name="programCampus" id="lead-programCampus" placeholder="Courses Campus">
                             <option value="">-- Select programCampus --</option>
                             <option value="Online"  {{ old('programCampus') == 'Online' ? 'selected' : '' }}>Online</option>
                             <option value="On Campus" {{ old('programCampus') == 'On Campus' ? 'selected' : '' }}>On Campus</option>
                
                           </select>
                          <label for="lead-programCampus" class="form-label">Courses Campus <span class="text-danger">*</span></label>
                          @error('programCampus')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                       </div>
                    </div>
                    <div class="col-4">
                        <div class="form-floating">
                            <input id="lead-priority" name="priority" type="text" class="form-control " placeholder="Campus" autocomplete="priority" value="{{old('priority')}}">
                            <label for="lead-priority" class="form-label">Campus</label>
                        </div>
                        @error('priority')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col-4">
                       <div class="form-floating">
                          <select class="form-control " name="lang_spec_for_program" id="lead-lang_spec_for_program" placeholder="Language Specification For Program / Courses">
                             <option value="">-- Select Language --</option>
                             <option value="English" {{ old('lang_spec_for_program') == 'English' ? 'selected' : '' }}>English</option>
                             <option value="Hindi" {{ old('lang_spec_for_program') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                             <option value="Other" {{ old('lang_spec_for_program') == 'Other' ? 'selected' : '' }}>Other</option>
                          </select>
                          <label for="lead-lang_spec_for_program" class="form-label">Language Specification For Program <span class="text-danger">*</span></label>
                        </div>
                        @error('lang_spec_for_program')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>


                    <div class="col-4">
                       <div class="form-floating">
                          <select class="form-control " name="program_level" id="program-level" placeholder="Degree">
                             <option value="">-- Program level--</option>
                             @foreach ($program_level as $item)
                                  <option value="{{$item->id}}" {{ old('program_level') == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                             @endforeach
                          </select>
                          <label for="program-level" class="form-label">Program level <span class="text-danger">*</span></label>
                        </div>
                        @error('program_level')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-floating">
                           <select class="form-control program-sub-level" name="program_sub_level" id="program-sub-level" placeholder="" >
                              <option value="">-- Program Sub level --</option>
                           </select>
                           <label for="lead-program-sub-evel" class="form-label">Program Sub level <span class="text-danger">*</span></label>
                         </div>
                         @error('program_sub_level')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                     </div>
                    <div class="col-4" >
                        <div class="form-floating">
                          <select class="form-control " name="education_level" id="education-level" placeholder="Education Level">
                             <option value="">-- Min Education Level Required--</option>
                          </select>
                          <label for="lead-education-level" class="form-label">Education Level <span class="text-danger">*</span></label>
                        </div>
                        @error('education_level')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-control select-grading-scheme" name="grading_scheme_id" id="grading_scheme_id" placeholder="Grading Scheme">
                                <option value="">-- Grading Scheme --</option>
                            </select>
                            <label for="lead-grading_scheme_id" class="form-label">Grading Scheme <span class="text-danger">*</span></label>
                        </div>
                        @error('grading_scheme_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4" id="grading-number-div" style="display: none;">
                        <div class="form-floating">
                            <input type="hidden" name="max_grading_number" id="max_grading_number">
                            <input id="lead-grading_number" name="grading_number" type="text" class="form-control" placeholder="Grading Number" autocomplete="grading_number"
                             value="{{old('grading_number')}}" >
                            <label for="lead-grading_number" class="form-label">Grading Number <span class="text-danger">*</span></label>
                            <div id="grading_input_error" class="text-danger"  style="display: none;">Invalid grade. Please enter a value within the selected grading scheme.</div>
                        </div>
                        @error('grading_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                  
                    <div class="col-4">
                        <div class="form-floating">
                           <select class="form-control other-exam" name="other_exam" id="other_exam" placeholder="" >
                              <option value="">-- Other Exam --</option>
                           </select>
                           <label for="lead-other-exam" class="form-label"> Other Exam <span class="text-danger">*</span></label>
                         </div>
                         @error('other_exam')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="col-4" id="other-exam-input" style="display: none;">
                        <div class="form-floating">
                            <input id="lead-other-exam-number" name="other_exam_number" type="number" class="form-control" placeholder="Other Exam Total Score" autocomplete="other-exam-number"
                             value="{{old('other_exam_number')}}" >
                            <label for="lead-other-exam-number" class="form-label">Other Exam Total Score <span class="text-danger">*</span></label>
                            <div id="other_exam_input_error" class="text-danger"  style="display: none;">Invalid input. Please enter a value within the selected other exam.</div>
                        </div>
                        @error('other_exam_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-floating">
                            <input id="lead-application_fee" name="application_fee" type="number" class="form-control " placeholder="Application Fees in INR" autocomplete="application_fee" value="{{old('application_fee')}}">
                            <label for="lead-application_fee" class="form-label">Application Fees in INR <span class="text-danger">*</span></label>
                        </div>
                        @error('application_fee')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-floating">
                            <input id="lead-application_apply_date"
                                name="application_apply_date"
                                type="date"
                                class="form-control"
                                value="{{ old('application_apply_date') }}">
                            <label>Application Apply Date <span class="text-danger">*</span></label>
                        </div>

                        @error('application_apply_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                        <div class="col-4">

                        <!-- DATE INPUT -->
                        <div class="form-floating">
                            <input id="lead-application_closing_date_input"
                                type="date"
                                class="form-control date-input"
                                value="">
                            <label>
                                Application Closing Date <span class="text-danger">*</span>
                            </label>
                        </div>

                        <!-- RADIO -->
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="application_closing_date_radio"
                                    value="{{ old('application_closing_date_radio') ?? 'ASAP' }}">
                                <label class="form-check-label">ASAP</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="application_closing_date_radio"
                                    value="{{ old('application_closing_date_radio') ?? 'TBD' }}">
                                <label class="form-check-label">TBD</label>
                            </div>
                        </div>

                        
                        <input type="hidden"
                            name="application_closing_date"
                            id="final_closing_date"
                            value="{{ old('application_closing_date') }}">

                        @error('application_closing_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-4">
                        <div class="form-floating">
                            <input id="lead-tution_fee" name="tution_fee" type="number" class="form-control " placeholder="Tution Fee" autocomplete="tution_fee" value="{{old('tution_fee')}}">
                            <label for="lead-tution_fee" class="form-label">Tution Fee <span class="text-danger">*</span></label>
                        </div>
                        @error('tution_fee')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col-4">
                       <div class="form-floating">
                          <select class="form-control " name="currency" id="lead-currency" placeholder="Currency">
                             <option value="EUR">-- Currency --</option>
                             @foreach ($currency as $item)
                                <option value="{{$item->currency}}"  {{ old('currency') == $item->currency ? 'selected' : '' }}>{{$item->currency}}</option>
                             @endforeach
                          </select>
                          <label for="lead-currency" class="form-label">Currency</label>
                        </div>
                        @error('currency')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col-4">
                       <div class="form-floating">
                          <select class="form-control " name="intake" id="lead-intake" placeholder="Intake">
                             <option value="">--Select--</option>
                             @foreach (range(1, 12) as $month)
                                <option value="{{ date('m', mktime(0, 0, 0, $month, 10)) }}" {{ old('intake') == date('m', mktime(0, 0, 0, $month, 10)) ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 10)) }}</option>
                             @endforeach
                          </select>
                          <label for="lead-intake" class="form-label">Intake <span class="text-danger">*</span></label>
                        </div>
                        @error('intake')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col-4">
                            <div class="form-floating">
                            <select class="form-control " name="year" id="lead-year" placeholder="Year">
                                <option value="">-- Select Year --</option>
                                @foreach (range((int)date('Y'), (int)date('Y') + 10) as $year)
                                    <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                            <label for="lead-year" class="form-label">Year <span class="text-danger">*</span></label>
                            </div>
                            @error('year')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="col-4">
                        <div class="form-floating">
                            <select class="form-control" name="work_experience" id="lead-work-experience" placeholder="Work Experience">
                                <option value="">-- Select Work Experience --</option>
                                <option value="1" {{ old('work_experience') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('work_experience') == '1' ? 'selected' : '' }}>No</option>
                            </select>
                            <label for="lead-work-experience" class="form-label">Work Experience <span class="text-danger">*</span></label>
                        </div>
                        @error('work_experience')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                 
                    <div class="col-4">
                        <div class="form-floating">
                            <input id="lead-tags" name="tags" type="text" class="form-control " placeholder="Course Tags" autocomplete="tags" value="{{old('tags')}}">
                            <label for="lead-tags" class="form-label">Course Tags</label>
                        </div>
                        @error('tags')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                 
                    <div class="col-12">
                       <label>Description</label>
                        <textarea name="details" id="summernote1" cols="30" rows="10"> {{ old('details') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label>Extra Notes</label>
                         <textarea name="extra_notes" id="summernote2" cols="30" rows="10"> {{ old('extra_notes') }}</textarea>
                         @error('extra_notes')
                         <div class="text-danger">{{ $message }}</div>
                     @enderror
                    </div>
                    <div class="col-12">
                        <button id="submitBtn" type="submit" class="btn btn-info py-6">Submit</button>
                    </div>
                 </form>
                <br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')

<!-- ===================== CSS ===================== -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<!-- ===================== JS (PLUGINS ONLY) ===================== -->
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
            $dateInput.val('');
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
        $dateInput.val('');
    });

});
</script>

<script>
(function ($) {

    window.addEventListener('load', function () {

        /* ===================== DEBUG ===================== */
        console.log('jQuery:', typeof window.jQuery);
        console.log('Select2:', typeof $.fn.select2);
        console.log('Summernote:', typeof $.fn.summernote);

        /* ===================== CSRF ===================== */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* ===================== SELECT2 ===================== */
        if ($.fn.select2) {
            $('#school_id').select2({
                placeholder: 'University / College Name',
                allowClear: true,
                width: '100%'
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
                    $sub.empty().append('<option value="">--Select Program Sub Discipline--</option>');

                    if (res && res.length) {
                        $.each(res, function (_, v) {

                            // ✅ OLD VALUE MATCH KARE TO SELECT KARO
                            let selected = (v.id == oldSubDiscipline) ? 'selected' : '';

                            $sub.append(
                                `<option value="${v.id}" ${selected}>${v.name}</option>`
                            );
                        });
                    }
                });
            });

        $(document).ready(function () {
            if ($('#program-discipline').val()) {
                $('.program_discipline_select').trigger('change');
            }
        });
        /* ===================== PROGRAM LEVEL → SUB LEVEL ===================== */
        $('#program-level').on('change', function () {

            let program_id = $(this).val();
            if (!program_id) {
                alert('Please Select Program Level');
                return;
            }

            /* -------- SUB LEVEL -------- */
            $.post("{{ route('get-program-sublevel') }}", {
                program_level_id: program_id
            }, function (data) {

                let $sub = $('#program-sub-level').empty();

                if (data && data.length) {
                    $sub.append('<option value="">--- Select Sub level ---</option>');
                    $.each(data, function (_, v) {
                        $sub.append(`<option value="${v.id}">${v.name.toUpperCase()}</option>`);
                    });
                } else {
                    $sub.append('<option value="">Not Found</option>');
                }
            });

            /* -------- OTHER EXAM -------- */
            $.ajax({
                url: "{{ route('fetch-other-exam') }}",
                type: "POST",
                data: {
                    program_id: program_id
                },
                success: function (data) {

                    let $other = $('#other_exam').empty();

                    if (data && data.length > 0) {
                        $other.append('<option value="">--Select Other Exam--</option>');
                        $.each(data, function (_, exam) {
                            $other.append(`
                                <option value="${exam.id}" other-exam-number="${exam.number}">
                                    ${exam.name.toUpperCase()}
                                </option>
                            `);
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

        /* ===================== SUB LEVEL → EDUCATION LEVEL ===================== */
        $('#program-sub-level').on('change', function () {

            $.post("{{ route('education-level-fetch') }}", {
                program_level_id: $('#program-level').val(),
                program_sublevel_id: $(this).val()
            }, function (data) {

                let $edu = $('#education-level').empty();

                if (data && data.length) {
                    $edu.append('<option value="">Select Education Level</option>');
                    $.each(data, function (_, v) {
                        $edu.append(`<option value="${v.id}">${v.name.toUpperCase()}</option>`);
                    });
                } else {
                    $edu.append('<option value="">Not Found</option>');
                }
            });
        });

        /* ===================== EDUCATION → GRADING SCHEME ===================== */
        $('#education-level').on('change', function () {

            let edu = $(this).val();
            let uni = $('#school_id').val();

            if (!edu || !uni) {
                alert('Please Select University & Education Level');
                return;
            }

            $.post("{{ route('fetch-scheme-data') }}", {
                education_level_id: edu,
                university_id: uni
            }, function (data) {

                let $grading = $('#grading_scheme_id')
                    .empty()
                    .append('<option value="">--Select Grading Scheme--</option>');

                if (data && data.length) {
                    $.each(data, function (_, v) {
                        $grading.append(`
                            <option value="${v.id}" grading-data="${v.name}">
                                ${v.name.toUpperCase()}
                            </option>
                        `);
                    });
                }
            });
        });

        /* ===================== VALIDATION ===================== */
        function extractMax(value) {
            let m = value ? value.match(/(\d+)$/) : null;
            return m ? parseInt(m[0]) : null;
        }

        $(document).on('change','.select-grading-scheme',function(){
        var grading_scheme_id = $(this).val();
        if(grading_scheme_id != ''){
            $('#grading-number-div').show();
        }else{
            $('#grading-number-div').hide();
        }
    })
    $(document).on('change','.other-exam',function(){
        var grading_scheme_id = $(this).val();
        if(grading_scheme_id != ''){
            $('#other-exam-input').show();
        }else{
            $('#other-exam-input').hide();
        }
    })

        $('#grading_scheme_id, #lead-grading_number').on('keyup change', function () {

            let scheme = $('#grading_scheme_id option:selected').attr('grading-data');
            let max = extractMax(scheme);
            let val = $('#lead-grading_number').val();

            $('#lead-grading_number').toggleClass('is-invalid', max && val > max);
            $('#grading_input_error').toggle(max && val > max);
        });

    });

})(jQuery);
</script>

@endsection

