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

<section>
    <div class="container mt-3">
        @include('frontend.partials.breadcrumb', ['items' => [
            ['label' => 'Home', 'url' => url('/')],
            ['label' => $program_data->university_name->country_name->name ?? ''],
            ['label' => $program_data->university_name->university_name ?? '', 'url' => route('study-in.university', [
                'country' => $studyInProgramSlugs['country'],
                'university' => $studyInProgramSlugs['university'],
            ])],
            ['label' => $program_data->name ?? ''],
        ]])
    </div>
</section>

<section>
    <div class="coursedetail_title">
        <div class="one-image_com">
            <img src="{{asset($program_data->university_name->banner ?? null)}}" alt="17">
        </div>
          <!-- <div class="courses_heading_k text-white">
            <h1 class="fw-semibold">{{$program_data->name ?? null}}
            </h1>
            <p class="text-center fw-bold">{{$program_data->university_name->university_name ?? null}}</p>

        </div> -->
    </div>
</section>

<!-- first-section background-imgae course end -->

<section>
    <div class="detail_hr_edu">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="left_article bg-white">
                        <div class="left_heading_h">
                            <h2 class="fw-bold">{{$program_data->name ?? null}}</h2>
                        </div>

                        <div class="all_list_h">
                            <ul>
                                <li class="lectures-feature">
                                    <i class="fa fa-flag"></i>
                                    <span class="label mx-2">Country</span>
                                    <span class="value">{{$program_data->university_name->country_name->name ?? null}}</span>
                                </li>
                                <li class="lectures-feature">
                                    <i class="fa fa-flag"></i>
                                    <span class="label mx-2">University </span>
                                    <span class="value">{{$program_data->university_name->university_name ?? null}}</span>
                                </li>
                                <li class="quizzes-feature">
                                    <i class="fa fa-building"></i>
                                    <span class="label mx-2">Course Duration</span>
                                    <span class="value">{{$program_data->length ?? null}}-Months</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-tag"></i>
                                    <span class="label mx-2">Course Type</span>
                                    <span class="value">{{$program_data->programType ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-building"></i>
                                    <span class="label mx-2">Courses Campus</span>
                                    <span class="value">{{$program_data->programCampus ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-building"></i>
                                    <span class="label mx-2">Campus</span>
                                    <span class="value">{{$program_data->priority ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-language"></i>
                                    <span class="label mx-2">Language Specification</span>
                                    @php
                                    $exam_name =implode(',', $exam_text->pluck('name')->toArray());
                                    @endphp
                                    <span class="value">{{$exam_name ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-graduation-cap"></i>
                                    <span class="label mx-2">Program Level</span>
                                    <span class="value">{{$program_data->programLevel->name ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-graduation-cap"></i>
                                    <span class="label mx-2">Education Required</span>
                                    <span class="value">{{$program_data->educationLevelprogram->name ?? null}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-calendar"></i>
                                    <span class="label mx-2">Admission intake</span>
                                    <span class="value">{{date('F', mktime(0, 0, 0, $program_data->intake ?? null, 10))}}</span>
                                </li>
                                <li class="duration-feature">
                                    <i class="fa fa-trophy"></i>
                                    <span class="label mx-2">Minimum GPA</span>
                                    @php
                                    $grading_scheme = App\Models\GradingScheme::where('id', $program_data->grading_scheme_id ?? null)->pluck('name')->first();
                                    @endphp
                                    <span class="value">({{$program_data->grading_number ?? null}} {{$grading_scheme ?? null}})</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="btn-part mb-20">
                        @if(Auth::check())
                        @php
                        $user=Auth::user();

                        @endphp
                        @if($user->hasRole('student'))
                        @php
                        $student_id=App\Models\Student::where('user_id',$user->id)->select('id')->first();

                        $student_program_applied = App\Models\PaymentsLink::with('program:name,id,school_id')->where('user_id', $user->id)->get();
                        $university_id = $student_program_applied->pluck('program.school_id')->toArray();

                        @endphp
                        @if(in_array($program_data->school_id,$university_id))
                        <button class="btn btn-primary">You Can Select One University One Program</button>
                        @else
                        @php
                        $student_data = DB::table('student')->where('user_id', $user->id)->first();
                        $program_id = DB::table('education_history')->select('education_level_id')
                        ->where('student_id', $student_data->id ?? null)
                        ->pluck('education_level_id')->toArray();
                        $program_level_name=App\Models\ProgramLevel::where('id',$program_id)->pluck('name')->first();
                        $documents_id=App\Models\Documents::where('name', 'like', '%' . $program_level_name . '%')->pluck('id')->first();
                        $last_school_attended =App\Models\SchoolAttended::where('student_id', $student_data->id)->where('documents', $documents_id)
                        ->select('grading_scheme_id','max_score','grading_average')
                        ->first();

                        $grading_scheme_id = explode('-', $last_school_attended->grading_scheme_id ?? null);

                        $grading_scheme_value = end($grading_scheme_id);

                        $grading_scheme_id = App\Models\GradingScheme::where('name','like', '%Out of ' . $grading_scheme_value .'%')->pluck('id')->toArray();

                        $Additional_qualification = App\Models\AdditionalQualification::where('student_id', $student_data->id)
                        ->whereIn('type', ['GRE', 'GMAT'])
                        ->select('type', 'total_score')
                        ->get();

                        $test_score=App\Models\TestScore::where('student_id', $student_data->id)
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
                        $type = App\Models\EngProficiencyLevel::where('id',$exam->type)->value('name') ?? null;
                        } else {
                        $type = $exam->type;
                        }
                        return [
                        $type => $exam->overall_score ?? 0.0,
                        ];
                        });
                        $matching_scores = collect($exam_data)->filter(function ($value, $key) use ($test_score_additional_qualification) {
                        return isset($test_score_additional_qualification[$key]) && $test_score_additional_qualification[$key] == $value;
                        });


                        @endphp

                        @if(isset($matching_scores) && count($matching_scores) > 0 && ($program_data->grading_number <= (isset($last_school_attended) ? $last_school_attended->grading_average : 0)) && in_array($program_data->grading_scheme_id, $grading_scheme_id))

    <a href="{{ route('apply-program-payment', ['student_id' => $student_id->id, 'program_id' => $program_data->id]) }}"
        class="d-flex justify-content-start btn btn-primary">
        Apply
    </a>

@else

    <select class="form-select" name="intake_month" id="intakeMonth">
        <option value="">Select Intake Month</option>
        <option value="jan">January</option>
        <option value="feb">February</option>
        <option value="mar">March</option>
        <option value="apr">April</option>
        <option value="may">May</option>
        <option value="jun">June</option>
        <option value="jul">July</option>
        <option value="aug">August</option>
        <option value="sep">September</option>
    </select>

    <br>

    <select class="form-select" name="intake_year" id="intakeYear">
        <option value="">Select Intake Year</option>
        <option value="2026">2026</option>
        <option value="2027">2027</option>
        <option value="2028">2028</option>
        <option value="2029">2029</option>
        <option value="2030">2030</option>
    </select>

    <br>

    <a href="{{ route('apply-program-payment', ['student_id' => $student_id->id, 'program_id' => $program_data->id]) }}"
        id="applyBtn"
        class="btn btn-primary btn-lg"
        style="pointer-events:none;opacity:0.5;">
        Apply
    </a>

    <script>
        const intakeMonth = document.getElementById('intakeMonth');
        const intakeYear = document.getElementById('intakeYear');
        const applyBtn = document.getElementById('applyBtn');

        const monthMap = {
            jan: 0,
            feb: 1,
            mar: 2,
            apr: 3,
            may: 4,
            jun: 5,
            jul: 6,
            aug: 7,
            sep: 8
        };

        // Enable/Disable Apply button
        function checkIfFieldsAreSelected() {
            if (intakeMonth.value && intakeYear.value) {
                applyBtn.style.pointerEvents = 'auto';
                applyBtn.style.opacity = '1';
            } else {
                applyBtn.style.pointerEvents = 'none';
                applyBtn.style.opacity = '0.5';
            }
        }

        intakeMonth.addEventListener('change', checkIfFieldsAreSelected);
        intakeYear.addEventListener('change', checkIfFieldsAreSelected);

        applyBtn.addEventListener('click', function(event) {

            event.preventDefault();

            const selectedMonth = monthMap[intakeMonth.value];
            const selectedYear = parseInt(intakeYear.value);

            const today = new Date();
            const currentMonth = today.getMonth(); // 0 = Jan
            const currentYear = today.getFullYear();

            // Past intake check
            if (
                selectedYear < currentYear ||
                (selectedYear === currentYear && selectedMonth < currentMonth)
            ) {
                alert("This intake is no longer available. Please select the current or a future intake.");
                return;
            }

            // Redirect
            let url = "{{ route('apply-program-payment', ['student_id' => $student_id->id, 'program_id' => $program_data->id]) }}";
            url += "?intake_month=" + intakeMonth.value + "&intake_year=" + intakeYear.value;

            window.location.href = url;
        });
    </script>

@endif
                            @endif
                            @endif
                            @else
                            <a href="{{route('user-login')}}" class="btn btn-primary w-100">Login</a>
                            @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="tabing-tab">
                        <div class="nav-int-clock">
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-home" type="button" role="tab"
                                        aria-controls="nav-home" aria-selected="true">Home</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-profile" type="button" role="tab"
                                        aria-controls="nav-profile" aria-selected="false">Description</button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-contact" type="button" role="tab"
                                        aria-controls="nav-contact" aria-selected="false">Extra Notes</button>
                                </div>
                            </nav>
                            <div class="card shadow">
                              
                                <div class="tab-content  bg-white" id="nav-tabContent">
                                    <div class="tab-pane fade active show" id="nav-home" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        <div class="tab-f">
                                            <div class="head-4 mb-3">
                                                <h3 class="">Application Charges</h3>
                                            </div>
                                            <div class="table-cl">

                                                <table class="mb-5">
                                                    <tr>
                                                        <th scope="col">Application Fee</th>
                                                        <th scope="col">Tuition Fee</th>
                                                    </tr>
                                                    <tr>
                                                        <td> @if (empty($program_data->application_fee))
                                                            {{'Free'}}
                                                            @else
                                                            {{$program_data->currency ?? null}} {{$program_data->application_fee ?? null}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{$program_data->currency ?? null}}
                                                            {{$program_data->tution_fee ?? null}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="head-4 mb-3">
                                                <h3 class="">Application Date</h3>
                                            </div>
                                            <div class="table-cl">

                                                <table class="mb-5">
                                                    <tr>
                                                        <th scope="col">Application Start Date</th>
                                                        <th scope="col">Application Closing Date</th>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$program_data->application_apply_date ?? null}}</td>
                                                        <td>
                                                            {{$program_data->application_closing_date ?? null}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="head-4 mb-3">
                                                <h3 class="">Accepted Language Test</h3>
                                            </div>
                                            @forelse ($exam_text as $exam)
                                            <div class="exam_heading">{{$exam->name ?? null}}</div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Speaking Score</th>
                                                            <th scope="col">Listening Score</th>
                                                            <th scope="col">Writing Score</th>
                                                            <th scope="col">Reading Score</th>
                                                            <th scope="col">Overall Score</th>
                                                            <th scope="col">Remarks </th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{$exam->speaking_score ?? null}}</td>
                                                            <td>{{$exam->listening_score ?? null}}</td>
                                                            <td>{{$exam->writing_score ?? null}}</td>
                                                            <td>{{$exam->reading_score ?? null}}</td>
                                                            <td>{{$exam->overall_score ?? null}}</td>
                                                            <td> {{ Str::limit($exam->remarks ?? '', 4) }}</td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                        aria-labelledby="nav-profile-tab">
                                        <div class="sub-left">
                                            {!! $program_data->description !!}
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                        aria-labelledby="nav-contact-tab">
                                        <div class="strong-ex">
                                            <h4 class="mb-5">Extra Notes</h4>
                                            <div>{!! $program_data->extra_notes !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection