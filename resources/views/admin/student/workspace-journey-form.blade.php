@php
    $labels = [1 => 'Universities', 2 => 'Courses', 3 => 'Application status', 4 => 'Offer details', 5 => 'Fees', 6 => 'Visa application', 7 => 'Visa status', 8 => 'Flight details', 9 => 'Take off', 10 => 'Boarding', 11 => 'Done'];
    $sbaId = $leadDetails->student_user_id ?? null;
    $applicationMap = $threesixtee && $threesixtee?->application ? (json_decode($threesixtee?->application, true) ?: []) : [];
    $selectedCourseIds = array_filter(explode(',', $threesixtee?->courses ?? ''));
    $courseLookup = $selectedCourseIds ? \Illuminate\Support\Facades\DB::table('program')->whereIn('id', $selectedCourseIds)->get()->keyBy('id') : collect();
    $courseByUniversity = $courseLookup->groupBy('school_id')->map(fn ($rows) => $rows->first());
    $offeredUniversityIds = $courseByUniversity->filter(fn ($course) => ($applicationMap[$course->id . '_application_status'] ?? null) === 'accepted')->keys();
    $feeKey = $step <= 5 ? 'University Application Fee' : 'Visa Processing Fee';
    $feePaid = ($paymentStatusDone[$feeKey] ?? null) === 'Done';
    $progressPct = min(($current ?? 1) - 1, 10) / 10 * 100;
    $visaUploadedDocuments = $step === 6 ? \Illuminate\Support\Facades\DB::table('tbl_three_sixtee_image')
        ->select('tbl_three_sixtee_image.id', 'tbl_three_sixtee_image.image', 'visa_documents.name AS visa_document_name', 'visa_sub_documents.name AS visa_sub_document_name')
        ->join('visa_documents', 'tbl_three_sixtee_image.visa_document_type', '=', 'visa_documents.id')
        ->join('visa_sub_documents', 'tbl_three_sixtee_image.visa_sub_document_type', '=', 'visa_sub_documents.id')
        ->where('tbl_three_sixtee_image.user_id', $sbaId)
        ->where('tbl_three_sixtee_image.image_type', 'visa_application_document')
        ->orderByDesc('tbl_three_sixtee_image.id')
        ->get() : collect();
@endphp
<form class="form" data-journey-form data-step="{{ $step }}" data-sba-id="{{ $sbaId }}" id="sf" novalidate>
    <div class="fh"><h3>Step {{ $step }} of 11 &middot; {{ $labels[$step] }}</h3><span class="pill {{ $feePaid ? 'p-ok' : 'p-warn' }}">Payments: {{ $feePaid ? 'Paid' : 'Unpaid' }}</span></div>
    <div class="prog" aria-hidden="true"><i style="width:{{ $progressPct }}%"></i></div>
    <div class="note n-bad" data-ferr hidden></div>

    @if($step === 1)
        <p class="help" style="margin:0;color:var(--muted)">Add every university the student is applying to. Later steps use this list &mdash; no need to pick again.</p>
        <div class="chips" data-uni-chips>
            @forelse($university_in_three_sixtee as $item)
                <span class="chip" data-chip-uni="{{ $item->id }}">{{ Str::limit($item->university_name, 40) }}<button type="button" data-rmuni="{{ $item->id }}" aria-label="Remove {{ $item->university_name }}">&#10005;</button><input type="hidden" name="collegeValues[]" value="{{ $item->id }}"></span>
            @empty
                <div class="note n-info" data-uni-empty>No university selected yet.</div>
            @endforelse
        </div>
        <div class="g">
            <div class="fld" style="position:relative"><label for="adduni">Add university</label>
                <input class="inp" id="adduni" type="text" autocomplete="off" placeholder="Search or select university" data-uni-search>
                <div data-uni-results role="listbox" aria-label="University results" hidden style="position:absolute;left:0;right:0;z-index:5;background:var(--card);border:1px solid var(--line2);border-radius:10px;margin-top:4px;max-height:240px;overflow:auto;box-shadow:0 8px 24px rgba(0,0,0,.12)"></div>
            </div>
        </div>
        <input type="hidden" name="sba_id" value="{{ $sbaId }}">
        <input type="hidden" name="tab1" value="tab1">

    @elseif($step === 2)
        @forelse($university_in_three_sixtee as $k => $uni)
            @php $selectedCourse = optional($courseByUniversity->get($uni->id))->id; @endphp
            <div class="fld"><label for="c{{ $k }}" class="req">{{ Str::limit($uni->university_name, 40) }}</label>
                <select class="inp" id="c{{ $k }}" name="courseValues[]" data-course-select data-university="{{ $uni->id }}" data-selected="{{ $selectedCourse }}">
                    <option value="">Select course</option>
                </select>
            </div>
        @empty
            <div class="note n-warn">Add a university in step 1 first.</div>
        @endforelse
        <input type="hidden" name="sba_id" value="{{ $sbaId }}">
        <input type="hidden" name="tab2" value="tab2">

    @elseif($step === 3)
        <div class="tw"><table class="stack">
            <thead><tr><th>University</th><th>Course</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($university_in_three_sixtee as $uni)
                @php
                    $course = $courseByUniversity->get($uni->id);
                    $status = $course ? ($applicationMap[$course->id . '_application_status'] ?? '') : '';
                    $remarks = $course ? ($applicationMap['remarks_' . $course->id] ?? '') : '';
                    $showRemarks = in_array($status, ['rejected', 'in_progress'], true);
                @endphp
                <tr>
                    <td data-l="University">{{ Str::limit($uni->university_name, 40) }}</td>
                    <td data-l="Course">{{ $course->name ?? '—' }}</td>
                    <td data-l="Status">
                        @if($course)
                            <input type="hidden" name="program_ids[]" value="{{ $course->id }}">
                            <select class="inp" name="{{ $course->id }}_application_status" data-status-select data-course="{{ $course->id }}">
                                <option value="" @selected($status === '')>Not applied</option>
                                <option value="accepted" @selected($status === 'accepted')>Offer received</option>
                                <option value="in_progress" @selected($status === 'in_progress')>In review</option>
                                <option value="rejected" @selected($status === 'rejected')>Rejected</option>
                            </select>
                            <div class="fld" data-remarks-wrap="{{ $course->id }}" style="margin-top:8px{{ $showRemarks ? '' : ';display:none' }}">
                                <label for="remarksdata_{{ $course->id }}">Remarks</label>
                                <input class="inp" id="remarksdata_{{ $course->id }}" name="remarks_{{ $course->id }}" maxlength="150" value="{{ $remarks }}">
                            </div>
                        @else
                            <span class="note n-warn">Pick a course in step 2 first.</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="empty">No universities selected yet.</td></tr>
            @endforelse
            </tbody>
        </table></div>
        <input type="hidden" name="sba_id" value="{{ $sbaId }}">
        <input type="hidden" name="tab3" value="tab3">

    @elseif($step === 4)
        @php $offeredUnis = $university_in_three_sixtee->filter(fn ($u) => $offeredUniversityIds->contains($u->id)); @endphp
        @if($offeredUnis->isEmpty())
            <div class="note n-warn">No university has an accepted offer yet &mdash; mark one "Offer received" in step 3.</div>
        @endif
        <div class="g">
            <div class="fld"><label for="university_details_status" class="req">University</label>
                <select class="inp" id="university_details_status" name="university_details_status" data-offer-university>
                    <option value="">Select</option>
                    @foreach($offeredUnis as $item)
                        <option value="{{ $item->id }}" @selected(($threesixtee?->university_details_status ?? null) == $item->id)>{{ Str::limit($item->university_name, 40) }}</option>
                    @endforeach
                </select>
                <div class="hint">Only universities with an accepted offer are listed.</div>
            </div>
            <div class="fld"><label for="course_details_status">Confirmed course</label>
                <select class="inp" id="course_details_status" name="course_details_status" data-offer-course data-selected="{{ $threesixtee?->course_details_status ?? '' }}">
                    <option value="">Select</option>
                </select>
            </div>
            <div class="fld"><label for="joining_date" class="req">Date of joining</label>
                <input class="inp" id="joining_date" name="joining_date" type="date" value="{{ $threesixtee?->joining_date ?? '' }}">
                <div class="hint">Left empty until known &mdash; never defaulted to today.</div>
            </div>
            <div class="fld"><label for="offer_amount">Remarks</label>
                <select class="inp" id="offer_amount" name="offer_amount">
                    <option value="">Select</option>
                    <option value="case_closed" @selected(($threesixtee?->offer_amount ?? null) === 'case_closed')>Case Closed</option>
                    <option value="student_rejected" @selected(($threesixtee?->offer_amount ?? null) === 'student_rejected')>Student Rejected</option>
                    <option value="Accepted" @selected(($threesixtee?->offer_amount ?? null) === 'Accepted')>Accepted</option>
                    <option value="Rejected" @selected(($threesixtee?->offer_amount ?? null) === 'Rejected')>Rejected</option>
                </select>
            </div>
            <div class="fld"><label for="course_details">Course offers</label>
                <select class="inp" id="course_details" name="course_details">
                    <option value="">Select</option>
                    @foreach($course_in_three_sixtee as $offerCourse)
                        <option value="{{ $offerCourse->id }}" @selected(($threesixtee?->cource_details ?? null) == $offerCourse->id)>{{ $offerCourse->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="hidden" name="sba_id" value="{{ $sbaId }}">
        <input type="hidden" name="tab" id="tab4" value="tab4">
        <div class="fld"><label for="document">Offer letter</label>
            <input class="inp" id="document" name="document" type="file" style="padding:8px">
            <div class="hint">PDF or image, up to 5&nbsp;MB.</div>
        </div>
        <div class="note n-bad" data-offer-upload-error hidden></div>
        <div><button type="button" class="btn" data-upload-offer>Upload document</button></div>
        <div class="tw"><table class="stack">
            <thead><tr><th>#</th><th>Document</th><th>File</th></tr></thead>
            <tbody data-offer-doc-rows>
            @forelse(($table_three_sixtee_image ?? collect()) as $row)
                <tr><td data-l="#">{{ $row->id }}</td><td data-l="Document">{{ $row->program_name }}</td><td data-l="File"><a href="{{ asset($row->image) }}" target="_blank">View</a></td></tr>
            @empty
                <tr><td colspan="3" class="empty">No documents uploaded yet.</td></tr>
            @endforelse
            </tbody>
        </table></div>

    @elseif($step === 5)
        @php $plan = $threesixtee?->fees_details ?? ''; $isPrepaid = $plan !== 'Postpaid'; @endphp
        <div class="fld"><span style="display:block;font-size:13px;font-weight:600;margin-bottom:5px">Payment plan</span>
            <div class="seg" role="radiogroup">
                <label><input type="radio" name="fees_details" value="Prepaid" @checked($plan === 'Prepaid' || $plan === '')>Prepaid</label>
                <label><input type="radio" name="fees_details" value="Postpaid" @checked($plan === 'Postpaid')>Postpaid</label>
            </div>
        </div>
        <div class="g" data-fee-prepaid-fields style="{{ $isPrepaid ? '' : 'display:none' }}">
            <div class="fld"><label for="fee_payment_mode" class="req">Payment mode</label>
                <input class="inp" id="fee_payment_mode" name="fee_payment_mode" maxlength="150" value="{{ $threesixtee?->fee_payment_mode ?? '' }}" placeholder="Payment mode"></div>
            <div class="fld"><label for="fee_currency" class="req">Currency</label>
                <select class="inp" id="fee_currency" name="fee_currency">
                    <option value="">Select Currency</option>
                    @foreach(['USD' => 'US Dollar', 'EUR' => 'Euro', 'GBP' => 'British Pound', 'INR' => 'Indian Rupee', 'JPY' => 'Japanese Yen', 'CAD' => 'Canadian Dollar', 'AUD' => 'Australian Dollar', 'CHF' => 'Swiss Franc', 'CNY' => 'Chinese Yuan', 'NZD' => 'New Zealand Dollar', 'SGD' => 'Singapore Dollar', 'AED' => 'UAE Dirham'] as $code => $name)
                        <option value="{{ $code }}" @selected(($threesixtee?->fee_currency ?? null) === $code)>{{ $code }} - {{ $name }}</option>
                    @endforeach
                </select></div>
            <div class="fld"><label for="fee_amount" class="req">Fee amount</label>
                <input class="inp" id="fee_amount" name="fee_amount" type="number" maxlength="150" value="{{ $threesixtee?->fee_amount ?? '' }}" placeholder="Fee amount"></div>
            <div class="fld"><label for="fee_payment_by">Transferred by</label>
                <select class="inp" id="fee_payment_by" name="fee_payment_by">
                    <option value="">Select</option>
                    <option value="agent" @selected(($threesixtee?->fee_payment_by ?? null) === 'agent')>Agent</option>
                    <option value="direct" @selected(($threesixtee?->fee_payment_by ?? null) === 'direct')>Direct</option>
                </select></div>
            <div class="fld" data-fee-agent-field style="{{ ($threesixtee?->fee_payment_by ?? null) === 'agent' ? '' : 'display:none' }}"><label for="fee_agent">Agent</label>
                <select class="inp" id="fee_agent" name="fee_agent">
                    <option value="">Select</option>
                    @foreach(['1' => 'IDFC', '2' => 'HSBC', '3' => 'ICICI', '4' => 'HDFC', '5' => 'Vendor', '6' => 'Other'] as $code => $name)
                        <option value="{{ $code }}" @selected(($threesixtee?->fee_agent ?? null) === $code)>{{ $name }}</option>
                    @endforeach
                </select></div>
        </div>
        <div class="fld" data-fee-prepaid-fields style="{{ $isPrepaid ? '' : 'display:none' }}"><label for="fee_remarks">Remarks</label>
            <input class="inp" id="fee_remarks" name="fee_remarks" value="{{ $threesixtee?->fee_remarks ?? '' }}" placeholder="Remarks"></div>
        <input type="hidden" name="tab" id="tab7" value="tab7">
        <input type="hidden" name="sba_id" value="{{ $sbaId }}">
        @if(auth()->user()->hasRole('Application Punching'))
            <input type="hidden" name="application_punching" value="1">
        @endif

    @elseif($step === 6)
        <div class="g">
            <div class="fld"><label for="visa_document" class="req">Agent type</label>
                <select class="inp" id="visa_document" name="visa_document" data-visa-agent-type>
                    <option value="">Select</option>
                    <option value="direct" @selected(($threesixtee?->visa_document ?? null) === 'direct')>Direct</option>
                    <option value="agent" @selected(($threesixtee?->visa_document ?? null) === 'agent')>Agent</option>
                    <option value="manual" @selected(($threesixtee?->visa_document ?? null) === 'manual')>Manual</option>
                </select>
            </div>
            <div class="fld" data-visa-agent-field style="{{ ($threesixtee?->visa_document ?? null) === 'agent' ? '' : 'display:none' }}"><label for="visa_agent">Agent</label>
                <select class="inp" id="visa_agent" name="visa_agent">
                    <option value="">Select</option>
                    @foreach($agent as $item)
                        <option value="{{ $item->id }}" @selected(($threesixtee?->visa_agent ?? null) == $item->id)>{{ $item->legal_first_name }} {{ $item->legal_last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fld" data-visa-manual-field style="{{ ($threesixtee?->visa_document ?? null) === 'manual' ? '' : 'display:none' }}"><label for="visa_manual">Agent name</label>
                <input class="inp" id="visa_manual" name="visa_manual" maxlength="150" value="{{ $threesixtee?->visa_manual ?? '' }}">
            </div>
            <div class="fld"><label for="visa_apply_date" class="req">Date of apply</label>
                <input class="inp" id="visa_apply_date" name="visa_apply_date" type="date" value="{{ $threesixtee?->visa_apply_date ?? '' }}">
            </div>
        </div>
        <h4 style="margin:4px 0 0;font-size:15px">Country portal login</h4>
        <div class="g">
            <div class="fld"><label for="portal_url">Portal URL</label>
                <input class="inp" id="portal_url" name="portal_url" type="url" value="{{ $threesixtee?->portal_url ?? '' }}" placeholder="https://"></div>
            <div class="fld"><label for="portal_email">Portal email</label>
                <input class="inp" id="portal_email" name="portal_email" type="email" value="{{ $threesixtee?->portal_email ?? '' }}"></div>
            <div class="fld"><label for="portal_userid">Portal user ID</label>
                <input class="inp" id="portal_userid" name="portal_userid" value="{{ $threesixtee?->portal_userid ?? '' }}"></div>
            @if(auth()->user()->hasRole('Administrator'))
            <div class="fld"><label for="portal_password">Portal password</label>
                <div class="pw"><input class="inp" id="portal_password" name="portal_password" type="password" autocomplete="new-password" value=""><button type="button" class="btn" data-pw-toggle="portal_password">Show</button></div>
                <div class="hint">Leave blank to keep the existing password.</div>
            </div>
            @else
            <div class="fld"><label>Portal password</label><div class="hint">Available to administrators only.</div></div>
            @endif
        </div>
        <h4 style="margin:4px 0 0;font-size:15px">Visa documents</h4>
        <div class="g">
            <div class="fld"><label for="visa_document_type">Document type</label>
                <select class="inp" id="visa_document_type" name="visa_document_type" data-visa-document-type>
                    <option value="">Select</option>
                    @foreach($visa_document as $item)
                        <option value="{{ $item->id }}" @selected(($threesixtee?->visa_document_type ?? null) == $item->id)>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fld"><label for="visa_sub_document_type">Sub type</label>
                <select class="inp" id="visa_sub_document_type" name="visa_sub_document_type">
                    <option value="">Select</option>
                    @isset($visa_sub_document_three)
                        <option value="{{ $visa_sub_document_three->id }}" selected>{{ $visa_sub_document_three->name }}</option>
                    @endisset
                </select>
            </div>
            <div class="fld"><label for="lead_document">Files</label>
                <input class="inp" id="lead_document" name="lead_document" type="file" style="padding:8px"></div>
        </div>
        <div class="tw"><table class="stack">
            <thead><tr><th>Document type</th><th>Sub type</th><th>File</th><th></th></tr></thead>
            <tbody data-visa-doc-rows>
            @forelse($visaUploadedDocuments as $row)
                <tr data-doc-row="{{ $row->id }}"><td data-l="Document type">{{ $row->visa_document_name }}</td><td data-l="Sub type">{{ $row->visa_sub_document_name }}</td><td data-l="File"><a href="{{ asset($row->image) }}" target="_blank">View</a></td><td data-l=""><button type="button" class="btn" data-del-visa-doc="{{ $row->id }}">Delete</button></td></tr>
            @empty
                <tr><td colspan="4" class="empty">No documents uploaded yet.</td></tr>
            @endforelse
            </tbody>
        </table></div>
        <input type="hidden" name="tab5" value="tab5">
        <input type="hidden" name="sba_id" value="{{ $sbaId }}">

    @elseif($step === 7)
        @php $visaStatus = $threesixtee?->visa_application ?? null; @endphp
        <div class="seg" role="radiogroup">
            <label><input type="radio" name="visa_application" value="Inprogress" @checked($visaStatus === 'Inprogress')>In progress</label>
            <label><input type="radio" name="visa_application" value="Accepted" @checked($visaStatus === 'Accepted')>Accepted</label>
            <label><input type="radio" name="visa_application" value="Rejected" @checked($visaStatus === 'Rejected')>Rejected</label>
        </div>
        <div class="note n-bad" data-visa-rejected-note style="{{ $visaStatus === 'Rejected' ? '' : 'display:none' }}"><b>Visa rejected.</b> Travel steps are locked. Record the reason and re-apply from step 6, or close the case.</div>
        <div class="fld" data-visa-rejected-reason style="{{ $visaStatus === 'Rejected' ? '' : 'display:none' }}"><label for="visa_remarks" class="req">Rejection reason</label>
            <textarea class="inp" id="visa_remarks" name="visa_remarks">{{ $threesixtee?->visa_remarks ?? '' }}</textarea></div>
        <div class="note n-ok" data-visa-accepted-note style="{{ $visaStatus === 'Accepted' ? '' : 'display:none' }}">Visa accepted &mdash; travel steps are unlocked.</div>
        <input type="hidden" name="tab" value="tab6">
        <input type="hidden" name="sba_id" value="{{ $sbaId }}">

    @elseif($step === 8)
        <div class="g">
            <div class="fld"><label for="flight_name" class="req">Airline</label>
                <input class="inp" id="flight_name" name="flight_name" maxlength="250" value="{{ $threesixtee?->flight_name ?? '' }}"></div>
            <div class="fld"><label for="flight_no" class="req">Flight number</label>
                <input class="inp" id="flight_no" name="flight_no" value="{{ $threesixtee?->flight_no ?? '' }}" placeholder="e.g. LH 761"></div>
            <div class="fld"><label for="flight_dep_date" class="req">Departure date</label>
                <input class="inp" id="flight_dep_date" name="flight_dep_date" type="date" value="{{ $threesixtee?->flight_dep_date ?? '' }}"></div>
        </div>
        <input type="hidden" name="tab" value="tab8">
        <input type="hidden" name="sba_id" value="{{ $sbaId }}">

    @elseif($step === 9)
        @php $handHolding = $threesixtee?->hand_holding ?? null; @endphp
        <div class="fld"><span style="display:block;font-size:13px;font-weight:600;margin-bottom:5px">Airport hand-holding</span>
            <div class="seg" role="radiogroup">
                <label><input type="radio" name="hand_holding" value="yes" @checked($handHolding === 'yes')>Yes</label>
                <label><input type="radio" name="hand_holding" value="no" @checked($handHolding === 'no')>No</label>
            </div>
        </div>
        <div class="g" data-handholding-agent style="{{ $handHolding === 'yes' ? '' : 'display:none' }}">
            <div class="fld"><label for="agent_name" class="req">Agent name</label>
                <input class="inp" id="agent_name" name="agent_name" maxlength="150" value="{{ $threesixtee?->agent_name ?? '' }}"></div>
        </div>
        <input type="hidden" name="tab" value="tab9">
        <input type="hidden" name="sba_id" value="{{ $sbaId }}">

    @elseif($step === 10)
        <div class="g">
            <div class="fld"><label for="hostel" class="req">Accommodation</label>
                <select class="inp" id="hostel" name="hostel">
                    <option value="">Select</option>
                    @foreach(['OEL partner hostel', 'University halls', 'Private housing', 'Arranged by student'] as $option)
                        <option value="{{ $option }}" @selected(($threesixtee?->hostel ?? null) === $option)>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fld"><label for="personal">Address / room details</label>
                <input class="inp" id="personal" name="personal" maxlength="200" value="{{ $threesixtee?->personal ?? '' }}"></div>
        </div>
        <input type="hidden" name="tab" value="tab10">
        <input type="hidden" name="sba_id" value="{{ $sbaId }}">

    @elseif($step === 11)
        <div class="note n-ok"><b>{{ $studentDetails->first_name }} {{ $studentDetails->last_name }}</b> has completed the OEL 360 journey.</div>
    @endif

    <div class="fnav"><button type="button" class="btn" data-case-step="{{ $step - 1 }}" @disabled($step <= 1)>&larr; Previous</button>
    @if($step < 11)
    <div class="r"><button type="submit" class="btn go">{!! $step === 7 && ($threesixtee?->visa_application ?? null) === 'Rejected' ? 'Save' : 'Save &amp; continue &rarr;' !!}</button></div>
    @endif
    </div>
</form>
