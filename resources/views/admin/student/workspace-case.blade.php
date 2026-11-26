@php
    $base = request()->except(['student', 'tab', 'step']);
    $base['view'] = $view;
    $backUrl = route('student-list', $base);
    $tabUrl = fn ($target) => route('student-list', array_merge($base, ['student' => $selected->user_id, 'tab' => $target]));
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
                @if($selected->email)<button type="button" class="btn payment_model" student-id="{{ $selected->user_id }}" data-bs-toggle="offcanvas" data-bs-target="#gmat">Payment Link</button>@endif
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
                <button type="button" role="tab" aria-selected="{{ $tab === 'overview' ? 'true' : 'false' }}" data-case-tab="overview">Overview</button>
            </nav>
            <div class="body">
            @unless($selected->profile_complete)<p class="note n-warn">Profile incomplete. Complete the student profile before starting OEL 360.</p>@endunless
            @if($tab === 'journey' && $journeyData)

            @include('admin.student.workspace-rail')
            @include('admin.student.workspace-journey-form', array_merge($journeyData, ['step' => $activeStep, 'current' => $current]))
            </div>
            @elseif($tab === 'overview')
            <div class="acts">@can('oel_360.view')<a class="btn" href="{{ $tabUrl('documents') }}">Documents</a>@endcan @can('application.view')<a class="btn" href="{{ $tabUrl('applications') }}">Applications &amp; Visa</a>@endcan</div>
            <div class="ov">
                <div class="card"><h4>Contact</h4>
                    <div class="kv"><span>Email</span><span>{{ $selected->email ?: '?' }}</span></div>
                    <div class="kv"><span>Phone</span><span>{{ $selected->phone_number ?: '?' }}</span></div>
                    <div class="kv"><span>Pincode</span><span>{{ $selected->zip ?: '?' }}</span></div>
                    <div class="kv"><span>Counsellor</span><span>{{ $owner?->name ?? '?' }}</span></div>
                </div>
                <div class="card"><h4>Admission</h4>
                    <div class="kv"><span>Universities</span><span>{{ $universities->join(', ') ?: '?' }}</span></div>
                    <div class="kv"><span>Offer</span><span>{{ $latestApplication?->status ?? '?' }}</span></div>
                    <div class="kv"><span>Joining</span><span>{{ $summary?->joining_date ?: '?' }}</span></div>
                </div>
                <div class="card"><h4>Visa &amp; travel</h4>
                    <div class="kv"><span>Visa</span><span>{{ $summary?->visa_application ?: '?' }}</span></div>
                    <div class="kv"><span>Flight</span><span>{{ trim(($summary?->flight_name ?? '').' '.($summary?->flight_no ?? '')) ?: '?' }}</span></div>
                    <div class="kv"><span>Stay</span><span>{{ $summary?->hostel ?: '?' }}</span></div>
                </div>
            </div>
            @else
            @if($tab === 'payments')
            <div class="workspace-payment-summary" aria-label="Payment summary">
                <div><span>Received</span><strong>&#8377;{{ number_format($totals->paid ?? 0, 2) }}</strong></div>
                <div class="kpi"><span>Due</span><b>&#8377;{{ number_format($totals->due ?? 0, 2) }}</b></div>
                <div><span>Entries</span><strong>{{ $details->count() }}</strong></div>
            </div>
            @if(count($duplicatePaymentIds))
            <div class="note n-warn" style="margin-top:12px">Same service is marked paid twice &mdash; check for a duplicate entry.</div>
            @endif
            <div class="tw"><table class="stack">
                <thead><tr><th>Service</th><th>Amount</th><th>Mode</th><th>Date</th><th>Status</th></tr></thead>
                <tbody>@forelse($details as $entry)
                <tr><td data-l="Service">{{ $entry->service_name ?: '—' }}</td><td data-l="Amount">₹{{ number_format((float) $entry->amount, 2) }}</td><td data-l="Mode">{{ $entry->payment_method ?: '—' }}</td><td data-l="Date">{{ $entry->created_at ?: '—' }}</td><td data-l="Status"><span class="pill p-new">{{ $entry->payment_status ?: 'Unknown' }}</span>@if(in_array($entry->id, $duplicatePaymentIds)) <span class="pill p-warn">Possible duplicate</span>@endif</td></tr>
                @empty <tr><td colspan="5">No payment records available.</td></tr> @endforelse</tbody>
            </table></div>
            @if($selected->email)<div class="workspace-add-payment"><h3>Add payment</h3><button type="button" class="payment_model" student-id="{{ $selected->user_id }}" data-bs-toggle="offcanvas" data-bs-target="#gmat">Add payment</button></div>@endif
            @else
            <article class="workspace-detail"><h3>{{ ['documents'=>'Documents','applications'=>'Applications & Visa'][$tab] }}</h3>
                @forelse($details as $entry)
                @if($tab === 'documents')<p>{{ $entry->name ?: 'Student document' }}</p>
                @elseif($tab === 'applications')<p><strong>{{ optional($entry->program)->name ?: 'Program unavailable' }}</strong> · {{ optional(optional($entry->program)->university_name)->university_name ?: 'University unavailable' }}<br>Application: {{ optional($courseStatuses->get($entry->program_id))->course_remarks ?: 'N/A' }} · Visa: {{ optional($visaStatuses->get($entry->program_id))->visa_application ?: 'N/A' }}</p>
                @else<p>{{ $entry->created_at ?? '' }} · {{ $entry->amount ?? '' }} · {{ $entry->payment_status ?? 'Status unavailable' }}</p>@endif
                @empty<p>No records available.</p>@endforelse
            </article>
            @endif
            @endif
            </div></div>
            @else <div class="card empty" style="padding:48px">Select a student to open their OEL 360 case.</div> @endif
