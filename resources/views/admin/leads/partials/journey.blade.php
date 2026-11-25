    @php
        $workspaceReturn = request()->only(['view', 'name', 'first_name', 'email', 'phone_number', 'zip', 'country_id', 'from_date', 'to_date', 'agent_id', 'subagent_id', 'page']);
        $workspaceReturn['student'] = $studentDetails->user_id;
    @endphp
    <div class="apply360-page">
    @unless($embeddedJourney ?? false)
    <div class="apply360-heading"><h1>Apply for OEL 360</h1><a class="apply360-back" href="{{ route('student-list', $workspaceReturn) }}">&larr; Back to student</a></div>
    @endunless
    <div class="row">
        <!-- Lightbox -->
        <div class="col-lg-12">
            <div class="card">
                @unless($embeddedJourney ?? false)
                <div class="card-header apply360-student-card">
                    <div class="apply360-student-details"><span class="apply360-student-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($studentDetails->first_name ?? '', 0, 1) . mb_substr($studentDetails->last_name ?? '', 0, 1)) }}</span><div>
                    <h2 class="card-title mb-0">{{ $studentDetails->first_name }} {{ $studentDetails->last_name }}</h2>
                    <span>Student · OEL 360 Application</span></div></div>
                    <span class="apply360-payment-status">{{ ($paymentStatusDone['University Application Fee'] ?? null) === 'Done' ? 'Paid' : 'Unpaid' }} <small>University Application Fee</small></span>
                </div>
                @endunless
                @php
                $user = Auth::user();

                // Progress belongs to the selected student, not the signed-in staff member.
                $progress = $threesixtee;

             
                if ($progress && isset($progress->application)) {
                
                    $dataArray = json_decode($progress->application, true);
                
                    $applicationStatus = $dataArray[$progress->cource_details.'_application_status'] ?? '';
                    
                    
                } else {
                
                    $applicationStatus = 'No application status available';
                }
               @endphp
                    @if ($user->hasRole('student'))
                    <div class=" card-timeline px-2 border-none " style="margin-top:100px">
                        <ul class="bs4-order-tracking">
                            <li class="step ">
                                <div class="@if(!empty($progress->college)) bg-success @endif"><i class="fas fa-check"></i></div>
                                Universities
                            </li>
                            <li class="step">
                                <div class="@if(!empty($progress->courses)) bg-success @endif"><i class="fas fa-check"></i></div>
                                Courses
                            </li>
                            <li class="step">
                                <div class="
                                    @if(!empty($progress) && !empty($progress->application))
                                        @if($applicationStatus == 'accepted')
                                            bg-success
                                        @elseif($applicationStatus == 'rejected')
                                            bg-danger
                                        @elseif($applicationStatus == 'inprogress')
                                            bg-warning
                                        @endif
                                    @endif
                                    ">
                                    <i class="fas fa-check"></i>
                                </div>
                                Application Status
                            </li>
                            <li class="step">
                                <div class="@if(!empty($progress->joining_date) && !empty($progress->offer_amount) && !empty($progress->cource_details)) bg-success @else  bg-primary2 @endif"><i class="fas fa-check"></i></div>
                                Offer Detail
                            </li>
                            <li class="step">
                                <div class="
                                @if(!empty($progress->fee_payment_mode) &&
                                !empty($progress->fee_amount) &&
                                !empty($progress->fee_payment_by))
                                bg-success @else  bg-primary2 @endif"
                                ><i class="fas fa-check"></i></div>
                                Fees Details
                            </li>
                            <li class="step">
                                <div class="
                                @if(!empty($progress->visa_document) &&
                                !empty($progress->visa_apply_date))
                                bg-success @else  bg-primary2 @endif"
                                ><i class="fas fa-check"></i></div>
                                Visa Application
                            </li>
                            <li class="step">
                                <div class="
                                @if(!empty($progress->visa_application) && $progress->visa_application == 'Accepted')
                                    bg-success
                                @elseif (!empty($progress->visa_application) && $progress->visa_application == 'Rejected')
                                    bg-danger
                                @elseif (!empty($progress->visa_application) && $progress->visa_application == 'Inprogress')
                                    bg-warning
                                @endif
                                "><i class="fas fa-check"></i></div>
                                Visa Status
                            </li>

                            <li class="step">
                                <div class="
                                @if(!empty($progress->flight_name) &&
                                !empty($progress->flight_no) &&
                                !empty($progress->flight_dep_date))
                                bg-success @else  bg-primary2 @endif"
                                ><i class="fas fa-check"></i></div>
                                Flight Details
                            </li>
                            <li class="step">
                                <div
                                class="
                                @if(!empty($progress->hand_holding) || !empty($progress->agent_name))
                               
                                bg-success @else  bg-primary2 @endif"
                                ><i class="fas fa-check"></i></div>
                                Take Off
                            </li>
                            <li class="step">
                                <div class="
                                @if(!empty($progress->hostel) || !empty($progress->personal))
                                bg-success 
                                @else  bg-primary2 
                                @endif"
                                ><i class="fas fa-check"></i>
                            </div>
                                Boarding
                            </li>
                            <li class="step">
                                <div class="
                                @if(!empty($progress->hostel) || !empty($progress->personal))
                                bg-success 
                                @else  bg-primary2 
                                @endif">
                                    
                                    <i class="fas fa-check"></i></div>
                                Done
                            </li>
                        </ul>

                    </div>
                    <div class="list-group  float-end ms-auto mr-5 mb-0" style="width: 200px">
                        @php
                         $application_status =['In Progress','Completed','Rejected'];
                        @endphp
                        @foreach ($application_status as $key => $value)
                            @php
                                $status_color = '';
                                if ($value == 'In Progress') {
                                    $status_color = 'bg-primary2';
                                } elseif ($value == 'Completed') {
                                    $status_color = 'bg-success';
                                } elseif ($value == 'Rejected') {
                                    $status_color = 'bg-danger';
                                }
                            @endphp
                            <a href="#" class="list-group-item list-group-item-action {{ $status_color }}">
                                <span>{{ $value }}</span>
                                <span class="badge bg-light text-dark float-right rounded-pill">{{ substr($value, 0, 1) }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
                <div class="card-body">
                    <div class="wizard">
                        <details class="apply360-step-menu" open><summary>View steps</summary><ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            @can('universities.create')
                                <li class="nav-item flex-fill " role="presentation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Universities">
                                    <a class="nav-link @can('universities.create') active @endcan rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        href="#step1" id="step1-tab" data-bs-toggle="tab" role="tab" aria-controls="step1"
                                        aria-selected="true">1<span class="octicon octicon-light-bulb">Universities</span></a>
                                </li>
                            @endcan
                            @can('courses.create')
                                <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Courses">
                                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        href="#step2" id="step2-tab" data-bs-toggle="tab" role="tab" aria-controls="step2"
                                        aria-selected="false"
                                        @if (!$user->hasRole('Administrator') || (!$user->hasRole('Administrator') && empty($university_in_three_sixtee))) @disabled(true) @endif> 2 <span class="octicon octicon-light-bulb">Courses</span></a>
                                </li>
                            @endcan
                            @can('application_status.create')
                                <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Application Status">
                                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        href="#step3" id="step3-tab" data-bs-toggle="tab"
                                        @if (!$user->hasRole('Administrator') && empty($course_in_three_sixtee)) @disabled(true) @endif role="tab"
                                        aria-controls="step3" aria-selected="false"> 3 <span class="octicon octicon-light-bulb">Application Status</span></a>
                                </li>
                            @endcan
                            @can('offer_details.create')
                                <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Offer Detail">
                                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        href="#step4" id="step4-tab" data-bs-toggle="tab"
                                        @if (!$user->hasRole('Administrator') && empty($threesixtee->application)) @disabled(true) @endif role="tab"
                                        aria-controls="step4" aria-selected="false"> 4 <span class="octicon octicon-light-bulb">Offer Detail</span></a>
                                </li>
                            @endcan
                            @can('fee_details.create')
                                <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Fees Details">
                                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        href="#step5" id="step5-tab"
                                        @if (
                                            !$user->hasRole('Administrator') &&
                                                (empty($threesixtee->visa_application ?? null) ||
                                                    empty($threesixtee->visa_no ?? null) ||
                                                    empty($threesixtee->visa_exp_date ?? null))) @disabled(true) @endif
                                        data-bs-toggle="tab" role="tab" aria-controls="step5" aria-selected="false"> 5
                                    <span class="octicon octicon-light-bulb"> Fees Details</span></a>
                                </li>
                            @endcan
                            @can('visa_application.create')
                                <li class="nav-item flex-fill " role="presentation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Visa Application">
                                    <a class="nav-link @if ($user->hasRole('visa')) active @endif rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        href="#step6" id="step6-tab" data-bs-toggle="tab"
                                        @if (
                                            !$user->hasRole('Administrator') &&
                                                empty($threesixtee->joining_date ?? (null && $threesixtee->offer_amount ?? null))) @disabled(true) @endif role="tab"
                                        aria-controls="step6" aria-selected="false"> 6
                                    <span class="octicon octicon-light-bulb">Visa Application</span></a>
                                </li>
                            @endcan
                            @can('visa_status.create')
                                <li class="nav-item flex-fill"role="presentation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Visa Status">
                                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        href="#step7" id="step7-tab"
                                        @if (
                                            !$user->hasRole('Administrator') &&
                                                empty($threesixtee->visa_document ?? (null && $threesixtee->visa_agent ?? null))) @disabled(true) @endif
                                        data-bs-toggle="tab" role="tab" aria-controls="step7" aria-selected="false"> 7
                                    <span class="octicon octicon-light-bulb"> Visa Status</span></a>
                                </li>
                            @endcan

                            @can('flight_details.create')
                                <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title=" Flight Details">
                                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        href="#step8" id="step8-tab"
                                        @if ((!$user->hasRole('Administrator') && empty($threesixtee->fee_payment_mode)) &&
                                                empty($threesixtee->fee_amount)) @disabled(true) @endif
                                        data-bs-toggle="tab" role="tab" aria-controls="step8" aria-selected="false"> 8
                                    <span class="octicon octicon-light-bulb"> Flight Details</span></a>
                                </li>
                            @endcan
                            @can('take_off.create')
                                <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Take Off ">
                                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        href="#step9" id="step9-tab" data-bs-toggle="tab" role="tab"
                                        aria-controls="step9" aria-selected="false"
                                        @if (
                                            !$user->hasRole('Administrator') &&
                                                (empty($threesixtee->flight_name) || empty($threesixtee->flight_no) || empty($threesixtee->flight_dep_date))) @disabled(true) @endif> 9
                                    <span class="octicon octicon-light-bulb"> Take Off </span></a>
                                </li>
                            @endcan
                            @can('boarding.create')
                                <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Boarding">
                                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        href="#step10" id="step10-tab" data-bs-toggle="tab" role="tab"
                                        aria-controls="step10" aria-selected="false"
                                        @if (!$user->hasRole('Administrator') && (empty($threesixtee->hand_holding) || empty($threesixtee->agent_name))) @disabled(true) @endif> 10 <span class="octicon octicon-light-bulb"> Boarding</span></a>
                                </li>
                            @endcan
                            @can('done.show')
                                <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Done">
                                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                        href="#step11" id="step11-tab" data-bs-toggle="tab" role="tab"
                                        aria-controls="step11" aria-selected="false"
                                        @if (!$user->hasRole('Administrator') && (empty($threesixtee->hostel) || empty($threesixtee->personal))) @disabled(true) @endif> 11
                                    <span class="octicon octicon-light-bulb"> Done</span></a>
                                </li>
                            @endcan
                        </ul></details>
                        <div class="tab-content" id="myTabContent">
                            <div class="apply360-progress" aria-live="polite"><div class="apply360-step-header"><h2 id="apply360-current-step">OEL 360 application</h2><span id="apply360-step-payment" class="apply360-step-payment" hidden></span></div><div class="apply360-progress-track"><span id="apply360-progress-fill"></span></div></div>
                            @can('universities.create')
                                <div class="tab-pane fade @can('universities.create') show active @endcan"
                                    role="tabpanel" id="step1" aria-labelledby="step1-tab">
                                    <h4>Payment Status</h4>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="paid"
                                            @if(!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done') checked @endif>
                                        <label class="form-check-label" for="paid">@if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done') Paid @else Unpaid @endif</label>
                                    </div>
                                    <hr>
                                    <form class="row g-4" id ="tab1DataForm">
                                        <h4>Selected University</h4>
                                        @if ($university_in_three_sixtee->isNotEmpty())
                                            <div class="row">
                                                @foreach ($university_in_three_sixtee as $item)
                                                    <div class="col-md-4">
                                                        <input class="form-check-input college-checkbox" name="college"
                                                            type="checkbox" checked value="{{ $item->id }}"
                                                            id="college{{ $loop->iteration }}">
                                                        <label class="form-check-label"
                                                            for="college{{ $loop->iteration }}">
                                                            {{  Str::limit($item->university_name,26) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="apply360-empty">No universities selected yet.</p>
                                        @endif
                                        <input type="hidden" name="sba_id" class="sba_id" value="{{$leadDetails->student_user_id ?? null  }}">
                                        <br>

                                        <label class="apply360-university-label" for="universitySelect">Select University</label>
                                        <div class="alert-college"> </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <select id="universitySelect" class="selectpicker college-checkbox"
                                                    name="college" multiple data-live-search="true">
                                                    @foreach ($university as $item)
                                                        <option class="un" value="{{ $item->id }}">
                                                            {{ $item->university_name }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="selectedValues"></div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="d-flex" >
                                            @if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done')
                                            <a class="btn btn btn-primary next "  id="tab1datasubmit">
                                                <span class="spinner-grow spinner-grow-sm d-none" role="status"
                                                    aria-hidden="true"></span>
                                                Next
                                            </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            @endcan
                            @can('courses.create')
                                <div class="tab-pane fade " role="tabpanel" id="step2" aria-labelledby="step2-tab">
                                    <div class="mb-4">
                                        <h5> Select your Cource Details</h5>
                                    </div>
                                    <h4>Payment Status</h4>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="paid"
                                            @if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done') checked @endif>
                                        <label class="form-check-label" for="paid">@if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done') Paid @else Unpaid @endif</label>
                                    </div>
                                    <hr>
                                    <div class="alert-course"> </div>
                                    <h4>Selected Course Details</h4>
                                    <form id ="tab2DataForm">
                                        <div class="row">
                                            @if (!empty($course_in_three_sixtee))
                                                @foreach ($course_in_three_sixtee as $item)
                                                    <div class="col-md-4">
                                                        <input class="form-check-input course-checkbox" name="course"
                                                            type="checkbox" value="{{ $item->id }}" checked
                                                            id="course{{ $loop->iteration }}">
                                                        <label class="form-check-label"
                                                            for="course{{ $loop->iteration }}">  {{  Str::limit($item->name,26) }}</label>
                                                    </div>
                                                @endforeach
                                            @endif        
                                        </div>
                                        <input type="hidden" name="sba_id" class="sba_id" value="{{$leadDetails->student_user_id ?? null  }}">
                                        <h4>Selected University</h4>
                                        <div class="row mb-2 ">
                                            <div class="col-6">
                                                <select id="universitySelected" class="course-checkbox form-control" name="university_show"
                                                     data-live-search="true">
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select id="courses" name="course" class="form-control">
                                                    <option value="">--Select Course--</option>
                                                </select>
                                            </div>
                                            <div id="courseValues"></div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <a class="btn btn btn-warning previous me-2 w-25"> Back</a>
                                        @if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done')
                                        <a class="btn btn-primary next " ><span class="spinner-grow spinner-grow-sm d-none"
                                                role="status" aria-hidden="true"></span> continue</a>
                                        @endif
                                    </div>                                    
                                </div>
                            @endcan
                            @can('application_status.create')
                                <div class="tab-pane fade" role="tabpanel" id="step3" aria-labelledby="step3-tab">
                                    <div class="mb-4">
                                        <h5>Application Status </h5>
                                    </div>
                                    <h4>Payment Status</h4>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="paid"
                                            @if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done') checked @endif>
                                        <label class="form-check-label" for="paid">@if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done') Paid @else Unpaid @endif</label>
                                    </div>
                                    <hr>
                                    <form id ="tab3DataForm">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row select_course">

                                                </div>
                                            </div>
                                            <input type="hidden" name="sba_id" class="sba_id" id="sba_idd" value="{{$leadDetails->student_user_id ?? null  }}">
                                            <input type="hidden" name="tab3" value="tab3">
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <a class="btn btn-warning previous me-2 w-25">Previous</a>
                                        @if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done')
                                        <a class="btn btn-primary next " data-bs-toggle="modal"
                                            data-bs-target="#save_modal"><span class="spinner-grow spinner-grow-sm d-none"
                                                role="status" aria-hidden="true"></span> continue</a>
                                        @endif
                                    </div>
                                </div>
                            @endcan
                            @can('offer_details.create')
                                <div class="tab-pane fade" role="tabpanel" id="step4" aria-labelledby="step4-tab">
                                    <div class="mb-4">
                                        <h5>Offer Details</h5>
                                    </div>
                                    <h4>Payment Status</h4>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="paid"
                                            @if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done') checked @endif>
                                        <label class="form-check-label" for="paid">@if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done') Paid @else Unpaid @endif</label>
                                    </div>
                                    <hr>
                                    <div class="alert-image-error"> </div>
                                    <form id ="tab4DataForm">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <label for="basicpill-namecard-input" class="form-label">Date of Joining
                                                    </label>
                                                    <input type="date" class="form-control" name="joining_date"
                                                        id="joining_date"
                                                        value="{{ $threesixtee->joining_date ?? '' }}">
                                                    <input type="hidden" class="form-control" name="tab" id="tab4"
                                                        value="tab4">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                            <div class="input-block mb-3">
                                                <label for="university_details_status" class="form-label">University</label>
                                                <select class="form-select" name="university_details_status" id="university_details_status">
                                                    <option value="">--Select--</option>
                                                    @if (!empty($university_in_three_sixtee))
                                                    @foreach ($university_in_three_sixtee as $item)
                                                    <option value="{{ $item->id }}" >{{ Str::limit($item->university_name, 26) }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            </div>

                                            <div class="col-lg-6">
                                            <div class="input-block mb-3">
                                                <label for="course_details_status" class="form-label">Course Confirm</label>
                                                <select class="form-select" name="course_details_status" id="course_details_status">
                                                    <option value="">--Select--</option>
                                                   
                                                
                                                </select>
                                            </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <label for="offer_amount" class="form-label">Remarks</label>
                                                    <select class="form-control" name="offer_amount" id="offer_amount">
                                                        <option value="">--Select--</option>
                                                        <option value="case_closed" {{ ($threesixtee->offer_amount ?? null) == 'case_closed' ? 'selected' : '' }}>Case Closed</option>
                                                        <option value="student_rejected" {{ ($threesixtee->offer_amount ?? null) == 'student_rejected' ? 'selected' : '' }}>Student Rejected</option>
                                                        <option value="Accepted" {{ ($threesixtee->offer_amount ?? null) == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                                                        <option value="Rejected" {{ ($threesixtee->offer_amount ?? null) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                       
                                                       
                                                        <!-- Add more options as needed -->
                                                    </select>
                                                    <input type="hidden" name="sba_id" class="sba_id" value="{{$leadDetails->student_user_id ?? null}}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <label for="basicpill-cardno-input" class="form-label">Course
                                                        Offers</label>
                                                    <select class="form-select" name="course_details"
                                                        id="course_details">
                                                        <option value="">--Select--</option>
                                                        @foreach($course_in_three_sixtee as $offerCourse)
                                                            <option value="{{ $offerCourse->id }}" {{ ($threesixtee->cource_details ?? null) == $offerCourse->id ? 'selected' : '' }}>{{ $offerCourse->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <label for="basicpill-cardno-input" class="form-label">Document</label>
                                                    <input type="file" class="form-control" id="document"
                                                        name="document">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="apply360-documents-title"><i class="fa fa-paperclip" aria-hidden="true"></i> Documents</div>
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table">
                                                <thead>
                                                  <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Document Name</th>
                                                    <th scope="col">Document</th>
                                                    <th scope="col">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody class="course_details_document_table">

                                                </tbody>
                                              </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex">
                                                <a class="btn btn-warning previous me-2 w-50">Previous</a>
                                                <a class="btn btn-success upload-image me-2 w-50">
                                                    <span class="spinner-grow spinner-grow-sm d-none" role="status"
                                                        aria-hidden="true"></span>Upload image</a>
                                                @if ((!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done'))
                                                    <a class="btn btn-primary next " data-bs-toggle="modal"
                                                    data-bs-target="#save_modal"><span
                                                        class="spinner-grow spinner-grow-sm d-none" role="status"
                                                        aria-hidden="true"></span>Continue</a>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endcan
                            @can('fee_details.create')
                                <div class="tab-pane fade" role="tabpanel" id="step5" aria-labelledby="step5-tab">
                                    <div class="mb-4">
                                        <h5> Payment Details</h5>
                                    </div>
                                    <h4>Payment Status</h4>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="paid"
                                            @if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done') checked @endif>
                                        <label class="form-check-label" for="paid">@if (!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done') Paid @else Unpaid @endif</label>
                                    </div>
                                    <hr>
                                    <form id ="tab7DataForm">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="fees_details" id="prepaid" value="Prepaid"  {{ (isset($threesixtee->fees_details) && $threesixtee->fees_details == 'Prepaid') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="prepaid">Prepaid</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="fees_details" id="postpaid" value="Postpaid"  {{ (isset($threesixtee->fees_details) && $threesixtee->fees_details == 'Postpaid') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="postpaid">Postpaid</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row prepaid">
                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <input type="hidden" class="form-control" name="tab" id="tab7"
                                                        value="tab7">
                                                    @if($user->hasRole('Application Punching'))
                                                    <input type="hidden" name="application_punching" value="1"
                                                    value="{{$leadDetails->application_punching ?? null  }}">
                                                    @endif
                                                    <input type="hidden" name="sba_id" class="sba_id"
                                                        value="{{$leadDetails->student_user_id ?? null  }}">
                                                    <label for="basicpill-namecard-input" class="form-label">Payment
                                                        Mode</label>
                                                    <input type="text" maxlength ="150"
                                                        value="{{ $threesixtee->fee_payment_mode ?? '' }}"
                                                        placeholder="payment mode" name ="fee_payment_mode"
                                                        id="fee_payment_mode" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-block mb-3">
                                                    <label for="basicpill-namecard-input" class="form-label">Currency</label>
                                                    <!-- <input type="number" maxlength ="150"
                                                        value="{{ $threesixtee->fee_amount ?? '' }}" placeholder="fee amount"
                                                        name ="fee_amount" id="fee_amount" class="form-control"> -->
                                                        <select name="fee_currency" class="form-select">
                                                        <option value="">Select Currency</option>
                                                        <option value="USD">USD - US Dollar</option>
                                                        <option value="EUR">EUR - Euro</option>
                                                        <option value="GBP">GBP - British Pound</option>
                                                        <option value="INR">INR - Indian Rupee</option>
                                                        <option value="JPY">JPY - Japanese Yen</option>
                                                        <option value="CAD">CAD - Canadian Dollar</option>
                                                        <option value="AUD">AUD - Australian Dollar</option>
                                                        <option value="CHF">CHF - Swiss Franc</option>
                                                        <option value="CNY">CNY - Chinese Yuan</option>
                                                        <option value="NZD">NZD - New Zealand Dollar</option>
                                                        <option value="SGD">SGD - Singapore Dollar</option>
                                                        <option value="AED">AED - UAE Dirham</option>
                                                        </select>

                                               
                                                    </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-block mb-3">
                                                    <label for="basicpill-namecard-input" class="form-label">Fee
                                                        Amount</label>
                                                    <input type="number" maxlength ="150"
                                                        value="{{ $threesixtee->fee_amount ?? '' }}" placeholder="fee amount"
                                                        name ="fee_amount" id="fee_amount" class="form-control">
                                                </div>
                                            </div>                                          
                                        </div>
                                        <div class="row prepaid">
                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <label class="form-label">Transferred By</label>
                                                    <select class="form-select" id="fee_payment_by" name="fee_payment_by">
                                                        <option value="">-Select -</option>
                                                        <option value="agent"
                                                            {{ isset($threesixtee) && $threesixtee->fee_payment_by == 'agent' ? 'selected' : '' }}>
                                                            Agent</option>
                                                        <option value="direct"
                                                            {{ isset($threesixtee) && $threesixtee->fee_payment_by == 'direct' ? 'selected' : '' }}>
                                                            Direct</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6" style="display: none" id="feeagent">
                                                <div class="input-block mb-3">
                                                    <label class="form-label">Agent</label>
                                                    <select class="form-select" id="fee_agent" name="fee_agent">
                                                        <option value="">--Select--</option>
                                                        <option value="1"
                                                            {{ isset($threesixtee) && $threesixtee->fee_agent == '1' ? 'selected' : '' }}>
                                                            IDFC</option>
                                                        <option value="2"
                                                            {{ isset($threesixtee) && $threesixtee->fee_agent == '2' ? 'selected' : '' }}>
                                                            HSBC</option>
                                                        <option value="3"
                                                            {{ isset($threesixtee) && $threesixtee->fee_agent == '3' ? 'selected' : '' }}>
                                                            ICICI</option>
                                                        <option value="4"
                                                            {{ isset($threesixtee) && $threesixtee->fee_agent == '4' ? 'selected' : '' }}>
                                                            HDFC</option>
                                                        <option value="5"
                                                            {{ isset($threesixtee) && $threesixtee->fee_agent == '5' ? 'selected' : '' }}>
                                                            Vendor</option>

                                                            <option value="6"
                                                            {{ isset($threesixtee) && $threesixtee->fee_agent == '6' ? 'selected' : '' }}>
                                                            Other</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row prepaid">
                                            <div class="col-lg-12">
                                                <div class="input-block mb-3">
                                                    <label for="basicpill-namecard-input" class="form-label">Remarks</label>
                                                    <input type="text" name ="fee_remarks" id="fee_remarks"
                                                        placeholder="remarks" value="{{ $threesixtee->fee_remarks ?? '' }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <a class="btn btn-warning previous me-2 w-25">Previous</a>
                                        @if ((!empty($paymentStatusDone['University Application Fee']) && $paymentStatusDone['University Application Fee'] == 'Done'))
                                        <a class="btn btn-primary next" data-bs-toggle="modal"
                                            data-bs-target="#save_modal"><span class="spinner-grow spinner-grow-sm d-none"
                                                role="status" aria-hidden="true"></span>Continue</a>
                                        @endif
                                    </div>
                                </div>
                            @endcan
                            @can('visa_application.create')
                                <div class="tab-pane fade @if ($user->hasRole('visa')) show active @endif"
                                    role="tabpanel" id="step6" aria-labelledby="step6-tab">
                                    <div class="mb-4">
                                        <h5> Visa Application Details</h5>
                                    </div>
                                    <h4>Payment Status</h4>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="paid"
                                            @if (!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done') checked @endif>
                                        <label class="form-check-label" for="paid">@if (!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done') Paid @else Unpaid @endif</label>
                                    </div>
                                    <hr>
                                    <form id ="tab5DataForm">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="input-block mb-3">
                                                    <label class="form-label">Agent Type</label>
                                                    <select class="form-select" name="visa_document" id="visa_document">
                                                        <option>Agent Type</option>
                                                        <option value="direct"
                                                            {{ isset($threesixtee) && $threesixtee->visa_document == 'direct' ? 'selected' : '' }}>
                                                            Direct</option>
                                                        <option value="agent"
                                                            {{ isset($threesixtee) && $threesixtee->visa_document == 'agent' ? 'selected' : '' }}>
                                                            Agent</option>
                                                        <option value="manual"
                                                            {{ isset($threesixtee) && $threesixtee->visa_document == 'manual' ? 'selected' : '' }}>
                                                            Manual</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4" style="display:none" id="agent">
                                                <div class="input-block mb-3">
                                                    <label class="form-label">Agent</label>
                                                    <select class="form-select" name="visa_agent" id="visa_agent">
                                                        <option value="">Agent</option>
                                                        @foreach ($agent as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ isset($threesixtee) && $threesixtee->visa_agent == $item->id ? 'selected' : '' }}>
                                                                {{ $item->legal_first_name . ' ' . $item->legal_last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4" style="display:none" id="manual">
                                                <div class="input-block mb-3">
                                                    <label class="form-label">Agent Name</label>
                                                    <input type="text" maxlength ="150" id="visa_manual"
                                                        name="visa_manual" class="visa_manual form-control"
                                                        placeholder="agent name"
                                                        value="{{ $threesixtee->visa_manual ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-block mb-3">
                                                    <label class="form-label">Date of Apply</label>
                                                    <input type="date" name="visa_apply_date" required
                                                        class="form-control"
                                                        value="{{ $threesixtee->visa_apply_date ?? '' }}"
                                                        id="visa_apply_date">
                                                    <input type="hidden" name="sba_id" class="sba_id"
                                                        value="{{$leadDetails->student_user_id ?? null  }}">
                                                </div>
                                            </div>
                                        </div>
                                        <a class="btn btn-primary w-25 my-2">Country Portal Login Details</a>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="input-block mb-3">
                                                    <label for="portal_url" class="form-label">Portal Url</label>
                                                    <input type="url" maxlength ="255" class="form-control"
                                                        name="portal_url" value="{{ $threesixtee->portal_url ?? 'https://www.vfsglobal.com/en/individuals/index.html' }}"
                                                        id="portal_url">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-block mb-3">
                                                    <label for="portal_email" class="form-label">Portal Email</label>
                                                    <input type="email" class="form-control"
                                                        value="{{ $threesixtee->portal_email ?? '' }}" id="portal_email">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-block mb-3">
                                                    <label for="portal_email" class="form-label">Portal User Id</label>
                                                    <input type="text" maxlength ="150" class="form-control"
                                                        value="{{ $threesixtee->portal_userid ?? '' }}"
                                                        id="portal_userid"name="portal_userid">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-block mb-3">
                                                    <label for="portal_email" class="form-label">Portal Password</label>
                                                    @if($user->hasRole('Administrator'))
                                                    <input type="password" class="form-control" id="portal_password"
                                                        value="" autocomplete="new-password" name="portal_password">
                                                    <button type="button" class="btn btn-outline-secondary" id="apply360-password-toggle" aria-controls="portal_password" aria-pressed="false">Show</button>
                                                    <small>Leave blank to keep the existing password.</small>
                                                    @else
                                                    <span>Available to administrators only.</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <a class="btn btn-primary w-25 my-2">Visa Document</a>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="input-block mb-3">
                                                    <label class="form-label">Document Type</label>
                                                    <select class="form-select change-visa-document" name="visa_document_type"
                                                        id="visa_document_type">
                                                        <option value="">--Select--</option>
                                                        @foreach ($visa_document as $item)
                                                             <option value="{{$item->id}}" {{ isset($threesixtee) && $threesixtee->visa_document_type == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-block mb-3">
                                                    <label class="form-label">Sub Document Type</label>
                                                    <select class="form-select" name="visa_sub_document_type"
                                                        id="visa_sub_document_type">
                                                        @isset($visa_sub_document_three)
                                                           <option value="{{$visa_sub_document_three->id}}">{{$visa_sub_document_three->name}}</option>
                                                        @endisset
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="input-block mb-3">
                                                    <label for="basicpill-expiration-input" class="form-label">
                                                         Document </label>
                                                    <input type="file" multiple class="form-control" name="lead_document"
                                                        id="lead_document">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table">
                                                <thead>
                                                  <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Document Type </th>
                                                    <th scope="col">Sub Document</th>
                                                    <th scope="col">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody class="visa_document_table">

                                                </tbody>
                                              </table>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <a class="btn btn-warning previous w-25 me-2">Previous</a>
                                        <a class="btn btn-success upload-visa-document me-2 w-25">
                                            <span class="spinner-grow spinner-grow-sm d-none" role="status"
                                        aria-hidden="true"></span>Upload Document</a>
                                        <span id="apply360-visa-upload-feedback" aria-live="polite"></span>
                                        @if ((!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done'))
                                        <a class="btn btn-primary next w-25" data-bs-toggle="modal"
                                        data-bs-target="#save_modal"><span class="spinner-grow spinner-grow-sm d-none"
                                            role="status" aria-hidden="true"></span>Continue</a>
                                        @endif
                                    </div>
                                </div>
                            @endcan
                            @can('visa_status.create')
                                <div class="tab-pane fade" role="tabpanel" id="step7" aria-labelledby="step7-tab">
                                    <div class="mb-4">
                                        <h5>Visa status</h5>
                                    </div>
                                    <h4>Payment Status</h4>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="paid"
                                            @if (!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done') checked @endif>
                                        <label class="form-check-label" for="paid">@if (!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done') Paid @else Unpaid @endif</label>
                                    </div>
                                    <hr>
                                    <form id ="tab6DataForm">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label class="form-label" for="Accepted">Accepted
                                                </label>
                                                <input type="hidden" name="sba_id" class="sba_id"
                                                    value="{{$leadDetails->student_user_id ?? null  }}">
                                                <input type="radio" name="visa_application"
                                                    {{ isset($threesixtee) && $threesixtee->visa_application == 'Accepted' ? 'checked' : '' }}
                                                    value="Accepted" id="Accepted">
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-block mb-3">
                                                    <label class="form-label" for="Rejected">Rejected</label>
                                                    <input type="radio" name="visa_application"
                                                        {{ isset($threesixtee) && $threesixtee->visa_application == 'Rejected' ? 'checked' : '' }}
                                                        value="Rejected" id="Rejected">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-block mb-3">
                                                    <label for="Inprogress"
                                                        class="form-label">In progress</label>
                                                    <input type="radio" name="visa_application"
                                                        {{ isset($threesixtee) && $threesixtee->visa_application == 'Inprogress' ? 'checked' : '' }}
                                                        value="Inprogress" id="Inprogress">
                                                    <input type="hidden" class="form-control" name="tab" id="tab6"
                                                        value="tab6">
                                                    <input type="hidden" name="sba_id" class="sba_id"
                                                        value="{{$leadDetails->student_user_id ?? null  }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row remarks" style="display: none">
                                            <div class="input-block mb-3">
                                                <label for="remarks" class="form-label">Rejection reason</label>
                                                <input type="text" maxlength ="150" class="form-control"
                                                    value="{{ $threesixtee->visa_remarks ?? '' }}" name="visa_remarks" id="remarks">
                                                <span class="apply360-field-error" id="visa-remarks-error" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="row visa-data" style="display: none">
                                            <div class="col-6">
                                                <div class="input-block mb-3">
                                                    <label for="basicpill-expiration-input" class="form-label">Visa No</label>
                                                    <input type="text" maxlength ="150" class="form-control"
                                                        value="{{ $threesixtee->visa_no ?? '' }}" name="visa_no"
                                                        id="visa_no">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-block mb-3">
                                                    <label for="basicpill-expiration-input" class="form-label">Visa Expire
                                                        Date</label>
                                                    <input type="date" class="form-control" name="visa_exp_date"
                                                        value="{{ $threesixtee->visa_exp_date ?? '' }}" id="visa_exp_date">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <a class="btn btn-warning previous me-2 w-25">Previous</a>
                                        @if ((!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done'))
                                        <a class="btn btn-primary next w-25" data-bs-toggle="modal"
                                        data-bs-target="#save_modal"><span class="spinner-grow spinner-grow-sm d-none"
                                            role="status" aria-hidden="true"></span>Continue</a>
                                        @endif
                                    </div>
                                </div>
                            @endcan
                            @can('flight_details.create')
                                <div class="tab-pane fade" role="tabpanel" id="step8" aria-labelledby="step3-tab">
                                    <div class="mb-4">
                                        <h5> Flight Details</h5>
                                    </div>
                                    <h4>Payment Status</h4>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="paid"
                                            @if (!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done') checked @endif>
                                        <label class="form-check-label" for="paid">@if (!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done') Paid @else Unpaid @endif</label>
                                    </div>
                                    <hr>
                                    <form id ="tab8DataForm">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <input type="hidden" class="form-control" name="tab" id="tab8"
                                                        value="tab8">
                                                    <input type="hidden" name="sba_id" class="sba_id"
                                                        value="{{$leadDetails->student_user_id ?? null  }}">
                                                    <label for="basicpill-namecard-input" class="form-label">Flight
                                                        Name</label>
                                                    <input type="text" maxlength ="250" name="flight_name"
                                                        value="{{ $threesixtee->flight_name ?? '' }}" id="flight_name"
                                                        class="form-control">

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <label for="basicpill-namecard-input" class="form-label">Flight
                                                        Number</label>
                                                    <input type="number" maxlength ="150" name="flight_no" id="flight_no"
                                                        value="{{ $threesixtee->flight_no ?? '' }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <label for="basicpill-namecard-input" class="form-label">Date and Time of
                                                        Departure</label>
                                                    <input type="date" name="flight_dep_date" id="flight_dep_date"
                                                        value="{{ $threesixtee->flight_dep_date ?? '' }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <a class="btn btn-warning previous me-2 w-25">Previous</a>
                                        @if ((!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done'))
                                        <a class="btn btn-primary next w-25" data-bs-toggle="modal"
                                            data-bs-target="#save_modal"><span class="spinner-grow spinner-grow-sm d-none"
                                                role="status" aria-hidden="true"></span>Continue</a>
                                        @endif
                                    </div>
                                </div>
                            @endcan
                            @can('take_off.create')
                                <div class="tab-pane fade" role="tabpanel" id="step9" aria-labelledby="step3-tab">
                                    <div class="mb-4">
                                        <h5> Take Off</h5>
                                    </div>
                                    <h4>Payment Status</h4>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="paid"
                                            @if (!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done') checked @endif>
                                        <label class="form-check-label" for="paid">@if (!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done') Paid @else Unpaid @endif</label>
                                    </div>
                                    <hr>
                                    <form id ="tab9DataForm">
                                        <div class="row">
                                            <div class="col-lg-6 ">
                                                <div class="input-block mb-3">
                                                    <label class="form-label">Hand Holding</label>
                                                    <select class="form-select" name="hand_holding" id="hand_holding">
                                                        <option value=""> --Select-- </option>
                                                        <option value="yes"
                                                            {{ isset($threesixtee) && $threesixtee->hand_holding == 'yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="no"
                                                            {{ isset($threesixtee) && $threesixtee->hand_holding == 'no' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <input type="hidden" class="form-control" name="tab" id="tab9"
                                                        value="tab9">
                                                    <input type="hidden" name="sba_id" class="sba_id"
                                                        value="{{$leadDetails->student_user_id ?? null  }}">
                                                    <label for="basicpill-namecard-input" class="form-label">Agent
                                                        Name</label>
                                                    <input type="text" maxlength ="150" name="agent_name"
                                                        value="{{ $threesixtee->agent_name ?? '' }}" id="agent_name"
                                                        placeholder="agent name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <a class="btn btn-warning previous  w-25 me-2">Previous</a>
                                        @if ((!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done'))
                                        <a class="btn btn-primary next w-25" data-bs-toggle="modal"
                                            data-bs-target="#save_modal"><span class="spinner-grow spinner-grow-sm d-none"
                                                role="status" aria-hidden="true"></span>Continue</a>
                                        @endif
                                    </div>
                                </div>
                            @endcan
                            @can('boarding.create')
                                <div class="tab-pane fade" role="tabpanel" id="step10" aria-labelledby="step3-tab">
                                    <div class="mb-4">
                                        <h5> Boarding</h5>
                                    </div>
                                    <h4>Payment Status</h4>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="paid"
                                            @if (!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done') checked @endif>
                                        <label class="form-check-label" for="paid">@if (!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done') Paid @else Unpaid @endif</label>
                                    </div>
                                    <hr>
                                    <form id="tab10DataForm">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <label class="form-label">Hostel</label>
                                                    <select class="form-select" name="hostel" id="hostel">
                                                        <option value="Personal"
                                                            {{ isset($threesixtee) && $threesixtee->hostel == 'Oel' ? 'selected' : '' }}>
                                                            Oel</option>
                                                        <option value="Address"
                                                            {{ isset($threesixtee) && $threesixtee->hostel == 'Direct' ? 'selected' : '' }}>
                                                            Direct</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="input-block mb-3">
                                                    <input type="hidden" class="form-control" name="tab" id="tab10"
                                                        value="tab10">
                                                    <input type="hidden" name="sba_id" class="sba_id"
                                                        value="{{$leadDetails->student_user_id ?? null  }}">
                                                    <label for="basicpill-expiration-input" class="form-label">
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $threesixtee->personal ?? '' }}" maxlength="200"
                                                        name="personal" id="personal">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <a class="btn btn-warning previous me-2  w-25">Previous</a>
                                      @if ((!empty($paymentStatusDone['Visa Processing Fee']) && $paymentStatusDone['Visa Processing Fee'] == 'Done'))
                                        <a class="btn btn-primary next w-25" data-bs-toggle="modal"
                                            data-bs-target="#save_modal"><span class="spinner-grow spinner-grow-sm d-none"
                                                role="status" aria-hidden="true"></span>Continue</a>
                                        @endif
                                    </div>
                                </div>
                            @endcan
                            @can('done.show')
                                <div class="tab-pane fade" role="tabpanel" id="step11" aria-labelledby="step3-tab">
                                    <div class="mb-4">
                                        <h5> </h5>
                                    </div>
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-12 done-alert">
                                                {{-- <div class="alert alert-warning alert-dismissible fade " role="alert">
                                                <strong>Done!</strong> Success! 🎉
                                                You have Successfully Update the Student 360.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div> --}}
                                            </div>
                                        </div>
                                    </form>
                                    <div class="d-flex">
                                        <a class="btn btn-warning previous me-2 w-25 ">Previous</a>
                                        <a class="btn btn-primary w-25" href="{{ route('oel_360') }}">Back To 360</a>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
