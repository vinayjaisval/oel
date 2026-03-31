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
        <h4 class="card-title mb-0">Edit Program </h4>
    </div>
        <div class="card-body">
          <div class="wizard">
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" role="tabpanel" id="step1" aria-labelledby="step1-tab">
                
                <div class="mb-4">
                  <h3> Edit Program</h3>
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
                <form class="row g-4"  action="{{route('update-program',$program->id)}}" method="POST">
                    @csrf
                    @method('post')
                    <div class="col-4">
                       <div class="form-floating">
                          

                           <select class="form-control " name="school_id" id="school_id" placeholder="University / College Name">
                             <option value="">-- University / College Name --</option>
                             @foreach ($universities as $item)
                               <option value="{{$item->id}}" {{ old('school_id') == $item->id ? 'selected' : ($program->school_id == $item->id ? 'selected' : '') }}>{{ implode(' ', array_slice(explode(' ', $item->university_name), 0, 5)) }}</option>
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
                                <option value="{{$item->id}}" {{ old('program_discipline') == $item->id ? 'selected' : ($program->program_discipline == $item->id ? 'selected' : '') }}>{{ implode(' ', array_slice(explode(' ', $item->name), 0, 3)) }}</option>
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
                            <select class="form-control program_sub_discipline_select text-wrap" name="program_subdiscipline" id="program-subdiscipline" placeholder="Program Sub Discipline">
                                <option value="">-- Select Program Sub Discipline --</option>
                                @foreach ($program_subdiscipline as $item)
                             
                                    <option class="text-wrap" value="{{$item->id}}" {{ old('program_subdiscipline') == $item->id ? 'selected' : ($program->program_subdiscipline == $item->id ? 'selected' : '') }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <label for="lead-program-sub-discipline" class="form-label">Program sub discipline</label>
                        </div>
                        @error('program_subdiscipline')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="col-4 ">
                        <div class="form-floating">
                            <select class="form-control  selectpicker" name="subject_id_input"
                                id="subject_id_input" multiple placeholder="Education Level">
                                @foreach ($all_subject as $item)
                                    <option value="{{ $item->id }}" {{ old('subject_id_input') == $item->id ? 'selected' : '' }}>{{ $item->subject_name }}</option>
                                @endforeach
                            </select>
                            <label for="lead-education_level_id" class="form-label">-- Program / Courses Subject --</label>

                        </div>
                        @error('subject_id_input')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div> --}}
                    <div class="col-4">
                        <div class="form-floating">
                            <input  name="name" type="text" class="form-control " value="{{ old('name') ? old('name') : $program->name }}" placeholder="Program / Courses Name" autocomplete="name" >
                            <label for="lead-name" class="form-label">Program / Courses Name <span class="text-danger">*</span></label>
                        </div>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col-4">
                       <div class="form-floating">
                            <input id="lead-length" name="length" type="text" class="form-control "  value="{{ old('length') ? old('length') : $program->length }}" placeholder="Program / Courses Duration" autocomplete="length" value="">
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
                             <option value="Full Time" {{ $program->programType == 'Full Time' ? 'selected' : (old('programType') == 'Full Time' ? 'selected' : '') }}>Full Time</option>
                             <option value="Part Time" {{ $program->programType == 'Part Time' ? 'selected' : (old('programType') == 'Part Time' ? 'selected' : '') }}>Part Time</option>
                             <option value="Correspondence" {{ $program->programType == 'Correspondence' ? 'selected' : (old('programType') == 'Correspondence' ? 'selected' : '') }}>Correspondence</option>
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
                             @foreach(['Online', 'On Campus'] as $option)
                                  <option value="{{ $option }}" {{ ($program->programCampus == $option || old('programCampus') == $option) ? 'selected' : '' }}>{{ $option }}</option>
                             @endforeach
                          </select>
                          <label for="lead-programCampus" class="form-label">Courses Campus <span class="text-danger">*</span></label>
                          @error('programCampus')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                       </div>
                    </div>

                   <div class="col-4">
                        <div class="form-floating">
                            <input id="lead-priority" name="priority" type="text" class="form-control" placeholder="Campus" autocomplete="priority" value="{{old('priority') ?? $program->priority}}">
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
                             <option value="English" {{ (old('lang_spec_for_program') == 'English' || $program->lang_spec_for_program == 'English') ? 'selected' : '' }}>English</option>
                             <option value="Hindi" {{ (old('lang_spec_for_program') == 'Hindi' || $program->lang_spec_for_program == 'Hindi') ? 'selected' : '' }}>Hindi</option>
                             <option value="Other" {{ (old('lang_spec_for_program') == 'Other' || $program->lang_spec_for_program == 'Other') ? 'selected' : '' }}>Other</option>
                          </select>
                          <label for="lead-lang_spec_for_program" class="form-label">Language Specification For Program<span class="text-danger">*</span></label>
                        </div>
                        @error('lang_spec_for_program')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>

                    {{-- <div class="col-4">
                       <div class="form-floating">
                          <select class="form-control " name="fieldsofstudytype" id="lead-fieldsofstudytype" placeholder="Fields Of Study Type (Degree type offered)">
                             <option value="">-- Select Fields Of Study Type --</option>
                             @foreach ($filed_of_study as $item)
                             <option value="{{$item->id}}" {{ old('fieldsofstudytype ') == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                             @endforeach
                            </select>
                          <label for="lead-fieldsofstudytype" class="form-label">Fields Of Study Type (Degree type offered) <span class="text-danger">*</span></label>
                        </div>
                        @error('fieldsofstudytype')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div> --}}

                    <div class="col-4">
                       <div class="form-floating">
                          <select class="form-control " name="program_level" id="program-level" placeholder="Degree">
                             <option value="">-- Program level--</option>
                             @foreach ($program_level as $item)
                                  <option value="{{$item->id}}" {{ (old('program-level') == $item->id || $item->id == $program->program_level_id) ? 'selected' : '' }}>{{$item->name}}</option>
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
                               @foreach ($program_sublevel as $item)
                                    <option value="{{$item->id}}" {{ old('program_sub_level') == $item->id ? 'selected' : ($program->program_sub_level == $item->id ? 'selected' : '') }}>{{$item->name}}</option>
                                @endforeach
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
                             @foreach ($education_level as $item)
                                <option value="{{$item->id}}" {{ old('education_level') == $item->id ? 'selected' : (($program->education_level_id == $item->id) ? 'selected' : ( (isset($program->education_level_id) && $program->education_level_id != $item->id) ? '' : 'selected')) }}>{{$item->name}}</option>
                            @endforeach
                          </select>
                          <label for="lead-education-level" class="form-label">Education Level <span class="text-danger">*</span></label>
                        </div>
                        @error('education-level')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="col-4">
                        <div class="form-floating">
                            <select class="form-control select-grading-scheme" name="grading_scheme_id" id="grading_scheme_id" placeholder="Grading Scheme">
                                <option value="">-- Grading Scheme --</option>
                                @foreach ($grading_scheme as $item)
                                    <option value="{{$item->id}}" {{ old('grading_scheme_id') == $item->id ? 'selected' : ($program->grading_scheme_id == $item->id ? 'selected' : '') }}>{{$item->name}}</option>
                                @endforeach
                            </select>

                            <label for="lead-grading_scheme_id" class="form-label">Grading Scheme <span class="text-danger">*</span></label>
                        </div>
                        @error('grading_scheme_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    {{-- <div class="col-4">
                        <div class="form-floating">
                            <select class="form-control select-grading-scheme" name="grading_scheme_id" id="grading_scheme_id" placeholder="Grading Scheme">
                                <option value="">-- Grading Scheme --</option>
                                @foreach ($grading_scheme as $item)
                                    <option value="{{$item->id}}" {{ old('grading_scheme_id') == $item->id ? 'selected' : ($program->grading_scheme_id == $item->id ? 'selected' : '') }}>{{$item->name}}</option>
                                @endforeach
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
                            value="{{old('grading_number', $program->grading_number ?? '')}}" >
                            <label for="lead-grading_number" class="form-label">Grading Number <span class="text-danger">*</span></label>
                            <div id="grading_input_error" class="text-danger"  style="display: none;">Invalid grade. Please enter a value within the selected grading scheme.</div>
                        </div>
                        @error('grading_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-control select-grading-scheme" name="grading_scheme_id" id="grading_scheme_id" placeholder="Grading Scheme">
                                <option value="">-- Grading Scheme --</option>
                                @foreach ($grading_scheme as $item)
                                    <option value="{{$item->id}}" {{ old('grading_scheme_id') == $item->id ? 'selected' : ($program->grading_scheme_id == $item->id ? 'selected' : '') }}>{{$item->name}}</option>
                                @endforeach
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
                            value="{{old('grading_number', $program->grading_number ?? '')}}" >
                            <label for="lead-grading_number" class="form-label">Grading Number <span class="text-danger">*</span></label>
                            <div id="grading_input_error" class="text-danger"  style="display: none;">Invalid grade. Please enter a value within the selected grading scheme.</div>
                        </div>
                        @error('grading_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="col-4">
                        <div class="form-floating ">
                            <input id="lead-total_credits" name="total_credits" type="number" class="form-control " placeholder="Total Credits" autocomplete="total_credits" value="{{old('total_credits', $program->total_credits ?? '')}}">
                            <label for="lead-total_credits" class="form-label">Total Credits <span class="text-danger">*</span></label>
                        </div>
                        @error('total_credits')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="col-4">
                        <div class="form-floating">
                           <select class="form-control other-exam" name="other_exam" id="other_exam" placeholder="" >
                               <option value="">-- Other Exam --</option>
                                @foreach ($other_exam as $item)
                                    <option value="{{$item->id}}" {{$program->other_exam == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                @endforeach
                           </select>
                           <label for="lead-other-exam" class="form-label"> Other Exam <span class="text-danger">*</span></label>
                         </div>
                         @error('other_exam')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="col-4" id="other-exam-input" style="display: none;">
                        <div class="form-floating">
                            <input id="lead-other-exam-number" name="other_exam_number" value="{{$program->other_exam_number  ?? null}}" type="number" class="form-control" placeholder="Other Exam Total Score" autocomplete="other-exam-number"
                             value="{{old('other-exam-number')}}" >
                            <label for="lead-other-exam-number" class="form-label">Other Exam Total Score <span class="text-danger">*</span></label>
                            <div id="other_exam_input_error" class="text-danger"  style="display: none;">Invalid input. Please enter a value within the selected other exam.</div>
                        </div>
                        @error('other-exam-number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="col-4">
                        <div class="form-floating">
                           <select class="form-control other-exam" name="other_exam" id="other_exam" placeholder="" >
                              <option value="">-- Other Exam --</option>
                              @foreach ($other_exam as $item)
                                <option value="{{$item->id}}" {{$program->other_exam == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                              @endforeach
                           </select>
                           <label for="lead-other-exam" class="form-label"> Other Exam <span class="text-danger">*</span></label>
                         </div>
                         @error('other_exam')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                     </div> --}}
                    <div class="col-4">
                        <div class="form-floating">
                            <input id="lead-application_fee" name="application_fee" type="number" class="form-control " placeholder="Application Fees in INR" autocomplete="application_fee" value="{{old('application_fee', $program->application_fee ?? '')}}">
                            <label for="lead-application_fee" class="form-label">Application Fees  <span class="text-danger">*</span></label>
                        </div>
                        @error('application_fee')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                       <div class="form-floating">
                            <input id="lead-application_apply_date" name="application_apply_date" type="date" class="form-control " placeholder="Application Apply Date" autocomplete="application_apply_date"  value="{{old('application_apply_date', $program->application_apply_date ?? '')}}">
                            <label for="lead-application_apply_date" class="form-label">Application Apply Date <span class="text-danger">*</span></label>
                        </div>
                        @error('application_apply_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                   <div class="col-4">
    <div class="form-floating">
        <input id="lead-application_closing_date_input" 
               name="application_closing_date_input" 
               type="date" 
               class="form-control date-input" 
               placeholder="Application Closing Date"
               value="{{ old('application_closing_date_input') }}">
        <label for="lead-application_closing_date_input">
            Application Closing Date <span class="text-danger">*</span>
        </label>
    </div>

    <div class="mt-2">
        <div class="form-check form-check-inline">
            <input class="form-check-input"
                   type="radio"
                   name="application_closing_date_radio"
                   id="application_closing_date_option1"
                   value="ASAP">
            <label class="form-check-label" for="application_closing_date_option1">ASAP</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input"
                   type="radio"
                   name="application_closing_date_radio"
                   id="application_closing_date_option2"
                   value="TBD">
            <label class="form-check-label" for="application_closing_date_option2">TBD</label>
        </div>
    </div>

    <!-- 🔴 SINGLE SOURCE OF TRUTH -->
    <input type="hidden"
           name="application_closing_date"
           id="application_closing_date_hidden"
           value="{{ old('application_closing_date', $program->application_closing_date ?? '') }}">

    @error('application_closing_date')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>


                    <div class="col-4">
                        <div class="form-floating">
                            <input id="lead-tution_fee" name="tution_fee" type="number" class="form-control " placeholder="Tution Fee" autocomplete="tution_fee" value="{{old('tution_fee', $program->tution_fee ?? '')}}">
                            <label for="lead-tution_fee" class="form-label">Tution Fee <span class="text-danger">*</span></label>
                        </div>
                        @error('tution_fee')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col-4">
                       <div class="form-floating">
                          <select class="form-control " name="currency" id="lead-currency" placeholder="Currency">
                             <option value="">-- Currency --</option>
                             @foreach ($currency as $item)
                                <option value="{{$item->currency}}" {{ (old('currency', $program->currency) == $item->currency) ? 'selected' : '' }}>{{$item->currency}}</option>
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
                                <option value="{{ date('m', mktime(0, 0, 0, $month, 10)) }}" {{ old('intake', $program->intake) == date('m', mktime(0, 0, 0, $month, 10)) ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 10)) }}</option>
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
                                <option value="{{ $year }}" {{ old('year', $program->year) == $year ? 'selected' : '' }}>{{ $year }}</option>
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
                                <option value="1" {{ old('work_experience', $program->work_experience) == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('work_experience', $program->work_experience) == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            <label for="lead-work-experience" class="form-label">Work Experience <span class="text-danger">*</span></label>
                        </div>
                        @error('work_experience')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                  
                    <div class="col-4">
                        <div class="form-floating">
                            <input id="lead-tags" name="tags" type="text" class="form-control " placeholder="Course Tags" autocomplete="tags" value="{{old('tags') ?? $program->tags}}">
                            <label for="lead-tags" class="form-label">Course Tags</label>
                        </div>
                        @error('tags')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
              
                   
                    <div class="col-12">
                       <label>Description</label>
                        <textarea name="details" id="summernote1" cols="30" rows="10">{!! old('details') ?? $program->description !!}</textarea>
                    </div>

                    <div class="col-12">
                        <label>Extra Notes</label>
                         <textarea name="extra_notes" id="summernote2" cols="30" rows="10">{!! old('details') ?? $program->extra_notes !!}</textarea>
                         @error('notes')
                         <div class="text-danger">{{ $message }}</div>
                     @enderror
                    </div>
                    <div class="col-12 w-50"><button type="submit" class="btn btn-info  py-6 ">Submit</button></div>
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
$(document).ready(function () {

    const $dateInput = $('#lead-application_closing_date_input');
    const $hiddenInput = $('#application_closing_date_hidden');
    const $radios = $('input[name="application_closing_date_radio"]');

    /* ================= PAGE LOAD (EDIT / VALIDATION FAIL) ================= */
    const savedValue = $hiddenInput.val();

    if (savedValue) {
        if (savedValue === 'ASAP' || savedValue === 'TBD') {
            $radios.filter(`[value="${savedValue}"]`).prop('checked', true);
            $dateInput.val('');
        } else {
            $dateInput.val(savedValue);
            $radios.prop('checked', false);
        }
    }

    /* ================= DATE CHANGE ================= */
    $dateInput.on('change', function () {
        $hiddenInput.val($(this).val());
        $radios.prop('checked', false);
    });

    /* ================= RADIO CHANGE ================= */
    $radios.on('change', function () {
        $hiddenInput.val($(this).val());
        $dateInput.val('');
    });

});
</script>

<script>
(function ($) {

    $(document).ready(function () {

        /* ================= CSRF ================= */
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        /* ================= SELECT2 ================= */
        $('#school_id').select2({
            placeholder: 'University / College Name',
            allowClear: true,
            width: '100%'
        });

        /* ================= SUMMERNOTE ================= */
        $('#summernote1, #summernote2').summernote({
            placeholder: 'Write Here',
            height: 100
        });

        /* ================= PROGRAM DISCIPLINE ================= */
        $('.program_discipline_select').on('change', function () {
            let id = $('#program-discipline').val();
            if (!id) return;

            $.get("{{ route('get-program-sub-discipline') }}", { program_discipline_id: id }, function (res) {
                let $sub = $('.program_sub_discipline_select').empty()
                    .append('<option value="">--Select Program Sub Discipline--</option>');

                $.each(res || [], function (_, v) {
                    $sub.append(`<option value="${v.id}">${v.name}</option>`);
                });
            });
        });

        /* ================= PROGRAM LEVEL (SUB LEVEL + OTHER EXAM) ================= */
        $('#program-level').on('change', function () {
            let program_id = $(this).val();
            if (!program_id) return;

            fetchSubLevel(program_id);
            fetchOtherExam(program_id);
        });

        function fetchSubLevel(program_id, selected = null) {
            $.post("{{ route('get-program-sublevel') }}", { program_level_id: program_id }, function (data) {
                let $sub = $('#program-sub-level').empty()
                    .append('<option value="">--- Select Sub level ---</option>');

                $.each(data || [], function (_, v) {
                    $sub.append(`<option value="${v.id}">${v.name.toUpperCase()}</option>`);
                });

                if (selected) {
                    $sub.val(selected).trigger('change');
                }
            });
        }

        function fetchOtherExam(program_id, selected = null) {
            $.post("{{ route('fetch-other-exam') }}", { program_id }, function (data) {
                let $other = $('#other_exam').empty()
                    .append('<option value="">--Select Other Exam--</option>');

                $.each(data || [], function (_, v) {
                    $other.append(`
                        <option value="${v.id}" other-exam-number="${v.number}">
                            ${v.name.toUpperCase()}
                        </option>
                    `);
                });

                if (selected) {
                    $other.val(selected).trigger('change');
                }
            });
        }

        /* ================= SUB LEVEL → EDUCATION LEVEL ================= */
        $('#program-sub-level').on('change', function () {
            let program_level = $('#program-level').val();
            let sub = $(this).val();
            if (!program_level || !sub) return;

            $.post("{{ route('education-level-fetch') }}", {
                program_level_id: program_level,
                program_sublevel_id: sub
            }, function (data) {
                let $edu = $('#education-level').empty()
                    .append('<option value="">Select Education Level</option>');

                $.each(data || [], function (_, v) {
                    $edu.append(`<option value="${v.id}">${v.name.toUpperCase()}</option>`);
                });
            });
        });

        /* ================= EDUCATION → GRADING SCHEME ================= */
        $('#education-level').on('change', function () {
            let edu = $(this).val();
            let uni = $('#school_id').val();
            if (!edu || !uni) return;

            $.post("{{ route('fetch-scheme-data') }}", {
                education_level_id: edu,
                university_id: uni
            }, function (data) {
                let $g = $('#grading_scheme_id').empty()
                    .append('<option value="">--Select Grading Scheme--</option>');

                $.each(data || [], function (_, v) {
                    $g.append(`
                        <option value="${v.id}" grading-data="${v.name}">
                            ${v.name.toUpperCase()}
                        </option>
                    `);
                });
            });
        });

        /* ================= VALIDATION ================= */
        function extractMax(v) {
            let m = v ? v.match(/(\d+)$/) : null;
            return m ? parseInt(m[1]) : null;
        }

      
       $('.select-grading-scheme').on('change', function() {
        $('#grading-number-div').toggle(this.value != '');
    }).trigger('change');
    $('.other-exam').on('change', function() {
        $('#other-exam-input').toggle(this.value != '');
    }).trigger('change');
        $('#grading_scheme_id, #lead-grading_number').on('keyup change', function () {
            let scheme = $('#grading_scheme_id option:selected').attr('grading-data');
            let max = extractMax(scheme);
            let val = $('#lead-grading_number').val();

            $('#lead-grading_number').toggleClass('is-invalid', max && val > max);
            $('#grading_input_error').toggle(max && val > max);
        });

        $('#other_exam, #lead-other-exam-number').on('keyup change', function () {
            let scheme = $('#other_exam option:selected').attr('other-exam-number');
            let max = extractMax(scheme);
            let val = $('#lead-other-exam-number').val();

            $('#lead-other-exam-number').toggleClass('is-invalid', max && val > max);
            $('#other_exam_input_error').toggle(max && val > max);
        });

        /* ================= EDIT MODE AUTO LOAD ================= */
        let programLevel = $('#program-level').data('selected');
        let subLevel = $('#program-sub-level').data('selected');
        let otherExam = $('#other_exam').data('selected');

        if (programLevel) {
            $('#program-level').val(programLevel);
            fetchSubLevel(programLevel, subLevel);
            fetchOtherExam(programLevel, otherExam);
        }

    });

})(jQuery);
</script>
@endsection