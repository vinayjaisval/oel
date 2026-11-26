@php
    $base = request()->except(['student', 'tab', 'step']);
    $base['view'] = $view;
    $backUrl = route('student-list', $base);
$progress = $summary;
    $saved = [
        filled($progress->college ?? null), filled($progress->courses ?? null),
        filled($progress->application ?? null), filled($progress->cource_details ?? null),
        filled($progress->fee_amount ?? null), filled($progress->visa_apply_date ?? null),
        ($progress->visa_application ?? null) === 'Accepted', filled($progress->flight_no ?? null),
        filled($progress->hand_holding ?? null), filled($progress->hostel ?? null),
    ];
    $current = array_search(false, $saved, true);
    $current = $current === false ? 11 : $current + 1;
    $permissions = ['universities.create', 'courses.create', 'application_status.create', 'offer_details.create', 'fee_details.create', 'visa_application.create', 'visa_status.create', 'flight_details.create', 'take_off.create', 'boarding.create', 'boarding.create'];
    $activeStep = auth()->user()->hasRole('visa') ? 6 : $current;
    if ($step && auth()->user()->can($permissions[$step - 1]) && ($step <= $current || ($saved[$step - 1] ?? false))) {
        $activeStep = $step;
    }
    $number = 0;
@endphp
            @if($selected)
            <div class="card">
            <div class="ch"><a class="btn back" data-case-close href="{{ $backUrl }}">&larr; Students</a><span class="av large">{{ mb_strtoupper(mb_substr($selected->first_name ?? '?', 0, 1)) }}{{ mb_strtoupper(mb_substr($selected->last_name ?? '', 0, 1)) }}</span><div><h2>{{ $selected->first_name }} {{ $selected->last_name }}</h2><p class="sub">{{ $selected->email }} @if($selected->phone_number) · {{ $selected->phone_number }} @endif</p><span class="pill p-new">{{ $selected->profile_complete ? 'Profile Completed' : 'Profile incomplete' }}</span></div><div class="acts">
                @if($selected->phone_number)<a class="btn" href="tel:{{ $selected->phone_number }}">Call</a>@endif
                @if($account && $account->email && $account->password && !session()->has('admin_user') && auth()->user()->hasAnyRole(['Administrator','visa','agent','sub_agent','Application Punching']))<a class="btn" href="{{ route('impersonate', $account) }}">Login as student</a>@endif
                @can('application.view')<button type="button" class="btn" data-case-tab="payments">Payment Link</button>@endcan
            </div></div>
            <div class="kpis" aria-label="Case summary">
                <div class="kpi"><span>Progress</span><b>{{ $current - 1 }} / 10 steps</b></div>
                <div class="kpi"><span>Universities</span><b>{{ $universities->count() }}</b></div>
                <div class="kpi"><span>Paid to OEL</span><b>&#8377;{{ number_format($totals->paid ?? 0, 2) }}</b></div>
                <div class="kpi"><span>Due</span><b>&#8377;{{ number_format($totals->due ?? 0, 2) }}</b></div>
            </div>
            <nav class="ctabs" role="tablist" aria-label="Profile sections">
                @can('oel_360.view')
                    @if($selected->profile_complete && $selected->status_threesixty && auth()->user()->can('oel_apply.view'))<button type="button" role="tab" aria-selected="{{ $tab === 'journey' ? 'true' : 'false' }}" data-case-tab="journey">OEL 360 journey</button>@else<span class="workspace-tab-disabled" aria-disabled="true">OEL 360 journey</span>@endif
                @endcan
                @can('application.view')<button type="button" role="tab" aria-selected="{{ $tab === 'payments' ? 'true' : 'false' }}" data-case-tab="payments">Payments</button>@endcan
                @can('oel_360.view')<button type="button" role="tab" aria-selected="{{ $tab === 'documents' ? 'true' : 'false' }}" data-case-tab="documents">Documents</button>@endcan
                @can('application.view')<button type="button" role="tab" aria-selected="{{ $tab === 'applications' ? 'true' : 'false' }}" data-case-tab="applications">Applications &amp; Visa</button>@endcan
                <button type="button" role="tab" aria-selected="{{ $tab === 'overview' ? 'true' : 'false' }}" data-case-tab="overview">Overview</button>
            </nav>
            <div class="body">
            @unless($selected->profile_complete)<p class="note n-warn">Profile incomplete. Complete the student profile before starting OEL 360.</p>@endunless
            @if($tab === 'journey' && $journeyData)

            @include('admin.student.workspace-rail')
            @include('admin.student.workspace-journey-form', array_merge($journeyData, ['step' => $activeStep, 'current' => $current]))
            </div>
            @elseif($tab === 'overview')
            <div class="ov">
                <div class="card"><h4>Contact</h4>
                    <div class="kv"><span>Email</span><span>{{ $selected->email ?: '—' }}</span></div>
                    <div class="kv"><span>Phone</span><span>{{ $selected->phone_number ?: '—' }}</span></div>
                    <div class="kv"><span>Pincode</span><span>{{ $selected->zip ?: '—' }}</span></div>
                    <div class="kv"><span>Counsellor</span><span>{{ $owner?->name ?? '—' }}</span></div>
                </div>
                <div class="card"><h4>Admission</h4>
                    <div class="kv"><span>Universities</span><span>{{ $universities->join(', ') ?: '—' }}</span></div>
                    <div class="kv"><span>Offer</span><span>{{ $latestApplication?->status ?? '—' }}</span></div>
                    <div class="kv"><span>Joining</span><span>{{ $summary?->joining_date ?: '—' }}</span></div>
                </div>
                <div class="card"><h4>Visa &amp; travel</h4>
                    <div class="kv"><span>Visa</span><span>{{ $summary?->visa_application ?: '—' }}</span></div>
                    <div class="kv"><span>Flight</span><span>{{ trim(($summary?->flight_name ?? '').' '.($summary?->flight_no ?? '')) ?: '—' }}</span></div>
                    <div class="kv"><span>Stay</span><span>{{ $summary?->hostel ?: '—' }}</span></div>
                </div>
            </div>
            @elseif($tab === 'documents')
            <div class="tw"><table class="stack">
                <thead><tr><th>Document</th><th>File</th></tr></thead>
                <tbody>@forelse($details as $entry)
                <tr><td data-l="Document">{{ $entry->name ?: 'Student document' }}</td><td data-l="File">{!! $entry->image_url ? '<a href="' . asset($entry->image_url) . '" target="_blank">View</a>' : '—' !!}</td></tr>
                @empty <tr><td colspan="2" class="empty">No documents available.</td></tr> @endforelse</tbody>
            </table></div>
            @elseif($tab === 'applications')
            <div class="tw"><table class="stack">
                <thead><tr><th>Program</th><th>University</th><th>Application</th><th>Visa</th></tr></thead>
                <tbody>@forelse($details as $entry)
                <tr>
                    <td data-l="Program">{{ optional($entry->program)->name ?: 'Program unavailable' }}</td>
                    <td data-l="University">{{ optional(optional($entry->program)->university_name)->university_name ?: 'University unavailable' }}</td>
                    <td data-l="Application">{{ optional($courseStatuses->get($entry->program_id))->course_remarks ?: 'N/A' }}</td>
                    <td data-l="Visa">{{ optional($visaStatuses->get($entry->program_id))->visa_application ?: 'N/A' }}</td>
                </tr>
                @empty <tr><td colspan="4" class="empty">No applications available.</td></tr> @endforelse</tbody>
            </table></div>
            @elseif($tab === 'payments')
            @php
                $statusLabels = ['success' => ['Paid', 'p-ok'], 'free' => ['Free', 'p-grey'], 'pending' => ['Pay later', 'p-warn'], 'failed' => ['Failed', 'p-bad']];
                $sbaIdForPay = $selected->user_id;
            @endphp
            <div class="g" style="grid-template-columns:repeat(auto-fit,minmax(150px,1fr))">
                <div class="kpi"><span>Received</span><b>&#8377;{{ number_format($totals->paid ?? 0, 2) }}</b></div>
                <div class="kpi"><span>Due</span><b>&#8377;{{ number_format($totals->due ?? 0, 2) }}</b></div>
                <div class="kpi"><span>Entries</span><b>{{ $details->count() }}</b></div>
            </div>
            @if(count($duplicatePaymentIds))
            <div class="note n-warn" style="margin-top:12px">Same service is marked paid twice &mdash; check for a duplicate entry.</div>
            @endif
            <div class="tw" style="margin-top:14px"><table class="stack" data-payment-table>
                <thead><tr><th>Service</th><th class="n">Amount</th><th>Mode</th><th>Date</th><th>Status</th><th></th></tr></thead>
                <tbody>@forelse($details as $entry)
                @php [$statusLabel, $statusClass] = $statusLabels[$entry->payment_status] ?? [ucfirst($entry->payment_status ?: 'Unknown'), 'p-new']; @endphp
                <tr data-payment-row="{{ $entry->id }}">
                    <td data-l="Service">{{ $entry->service_name ?: 'Unknown service' }}</td>
                    <td data-l="Amount" class="n">&#8377;{{ number_format((float) $entry->amount, 2) }}</td>
                    <td data-l="Mode">{{ $entry->payment_method ?: '—' }}</td>
                    <td data-l="Date">{{ $entry->created_at ?: '—' }}</td>
                    <td data-l="Status"><span class="pill {{ $statusClass }}">{{ $statusLabel }}</span>@if(in_array($entry->id, $duplicatePaymentIds)) <span class="pill p-warn">Possible duplicate</span>@endif</td>
                    <td data-l="">
                        @if($entry->payment_status === 'pending')<button type="button" class="btn" data-mark-paid="{{ $entry->id }}">Mark paid</button>@endif
                        <button type="button" class="btn" data-view-payment="{{ $entry->id }}">View</button>
                        <button type="button" class="btn" data-delete-payment="{{ $entry->id }}" aria-label="Delete entry">Delete</button>
                    </td>
                </tr>
                <tr data-payment-detail="{{ $entry->id }}" hidden><td colspan="6"><div class="note n-info">Remark: {{ $entry->remarks ?: '—' }} &middot; Discount: &#8377;{{ number_format((float) ($entry->discount ?? 0), 2) }} &middot; Entry #{{ $entry->id }}</div></td></tr>
                @empty <tr><td colspan="6" class="empty">No payments yet.</td></tr> @endforelse</tbody>
            </table></div>
            <form data-add-payment-form class="card" style="margin-top:16px;padding:14px;display:flex;flex-direction:column;gap:12px" data-sba-id="{{ $sbaIdForPay }}" novalidate>
                <h4 style="margin:0">Add payment</h4>
                <div class="g">
                    <div class="fld"><label for="psvc" class="req">Service</label>
                        <select class="inp" id="psvc" name="master_service" data-pay-service>
                            <option value="">Select</option>
                            @foreach($masterServices as $service)
                                <option value="{{ $service->id }}" data-amount="{{ $service->amount }}" data-name="{{ $service->name }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fld"><label for="pamt" class="req">Amount (&#8377;)</label><input class="inp" id="pamt" name="amount" type="number" min="0" step="0.01"></div>
                    <div class="fld"><label for="pmode" class="req">Payment mode</label>
                        <select class="inp" id="pmode" name="paymentMode">
                            <option value="">Select</option>
                            <option value="UPI">UPI</option>
                            <option value="Card">Card</option>
                            <option value="Bank transfer">Bank transfer</option>
                            <option value="Cash">Cash</option>
                            <option value="Pay later">Pay later</option>
                        </select>
                    </div>
                    <div class="fld"><label for="pdisc">Discount (&#8377;)</label><input class="inp" id="pdisc" name="discount" type="number" min="0" step="0.01" placeholder="0"></div>
                    <div class="fld" data-pay-university-field hidden><label for="psvcuni" class="req">University</label>
                        <select class="inp" id="psvcuni" name="selected_university" data-pay-university>
                            <option value="">Select</option>
                            @foreach($paymentUniversities as $uni)
                                <option value="{{ $uni->id }}" data-program="{{ $uni->program_id }}" data-program-name="{{ $uni->program_name }}">{{ $uni->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fld" data-pay-program-field hidden><label for="psvcprog" class="req">Program</label>
                        <input class="inp" id="psvcprog" type="text" readonly>
                        <input type="hidden" name="selected_program" data-pay-program>
                    </div>
                </div>
                <div class="fld"><label for="prem">Remark</label><input class="inp" id="prem" name="remarks"></div>
                <div class="note n-bad" data-pay-error hidden></div>
                <input type="hidden" name="student_id" value="{{ $sbaIdForPay }}">
                <div><button class="btn go" type="submit">Add payment</button></div>
            </form>
            @endif
            </div></div>
            @else <div class="card empty" style="padding:48px">Select a student to open their OEL 360 case.</div> @endif
