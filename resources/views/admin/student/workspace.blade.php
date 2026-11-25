@extends('admin.include.app')
@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/oel360-workspace.css') }}">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
@endsection
@section('main-content')
@php
    $base = request()->except(['student', 'tab']);
    $base['view'] = $view;
    $backUrl = route('student-list', $base);
    $tabUrl = fn ($target) => route('student-list', array_merge($base, ['student' => $selected->user_id, 'tab' => $target]));
@endphp
<div class="oel360">
    <div class="top"><div><span class="logo">OEL</span><span class="crumb">Admin ? Students &amp; OEL 360</span><span class="who">Counsellor view</span></div></div>
    <div class="wrap {{ $selected ? 'open' : '' }}">
        <section class="card list" aria-label="Students">
            <div class="lh">
            <h1>Students <small>{{ $student_profile->total() }}</small></h1>
    <nav class="tabs" aria-label="Student views">
        @can('student.view')<a class="{{ $view === 'all' ? 'active' : '' }}" href="{{ route('student-list', ['view' => 'all']) }}" {{ $view === 'all' ? 'aria-current=page' : '' }}>All Students</a>@endcan
        @can('oel_360.view')<a class="{{ $view === 'ready' ? 'active' : '' }}" href="{{ route('student-list', ['view' => 'ready']) }}" {{ $view === 'ready' ? 'aria-current=page' : '' }}>OEL 360 Ready</a>@endcan
    </nav>
    <form class="workspace-filters" method="get" action="{{ route('student-list') }}">
        <input type="hidden" name="view" value="{{ $view }}">
        <label class="workspace-search"><span class="sr">Search students</span><input class="inp" type="search" name="q" value="{{ request('q') }}" placeholder="Search name, email or phone"></label>
        <details><summary>More filters</summary><div class="workspace-filter-fields">
            <label>Name <input name="{{ $view === 'ready' ? 'first_name' : 'name' }}" value="{{ request($view === 'ready' ? 'first_name' : 'name') }}"></label>
            <label>Email <input name="email" value="{{ request('email') }}"></label>
            @if($view === 'ready')
            <label>Franchise <select name="agent_id"><option value="">All franchises</option>@foreach($agents as $agent)<option value="{{ $agent->id }}" @selected(request('agent_id') == $agent->id)>{{ $agent->name }}</option>@endforeach</select></label>
            <label>Sub Agent <select name="subagent_id"><option value="">All sub agents</option>@foreach($sub_agents as $agent)<option value="{{ $agent->id }}" @selected(request('subagent_id') == $agent->id)>{{ $agent->name }}</option>@endforeach</select></label>
            @else
            <label>Phone <input name="phone_number" value="{{ request('phone_number') }}"></label>
            <label>Pincode <input name="zip" value="{{ request('zip') }}"></label>
            <label>Country <select name="country_id"><option value="">All countries</option>@foreach(\App\Models\Country::orderBy('name')->get() as $country)<option value="{{ $country->id }}" @selected(request('country_id') == $country->id)>{{ $country->name }}</option>@endforeach</select></label>
            <label>From date <input type="date" name="from_date" value="{{ request('from_date') }}"></label>
            <label>To date <input type="date" name="to_date" value="{{ request('to_date') }}"></label>
            @endif
        </div></details>
        <button type="submit">Search</button><a href="{{ route('student-list', ['view' => $view]) }}">Reset</a>
    </form>
            </div>
            <div class="items">
            @forelse($student_profile as $item)
            <a class="it {{ $selected && $selected->user_id == $item->user_id ? 'selected' : '' }}" href="{{ route('student-list', array_merge($base, ['student' => $item->user_id])) }}">
                <span class="av">{{ mb_strtoupper(mb_substr($item->first_name ?? '?', 0, 1)) }}{{ mb_strtoupper(mb_substr($item->last_name ?? '', 0, 1)) }}</span><span><strong>{{ $item->first_name }} {{ $item->last_name }}</strong><small>{{ $item->email }}</small></span>
                @if($view === 'ready')<span class="pill p-new">360 Ready</span>@endif
            </a>
            @empty<p>No students match these filters.</p>@endforelse
            {{ $student_profile->links() }}
            </div>
        </section>
        <section class="case" aria-label="Student profile" aria-live="polite">
            @if($selected)
            <div class="card">
            <a class="btn back" href="{{ $backUrl }}">&larr; Students</a>
            <div class="ch"><span class="av large">{{ mb_strtoupper(mb_substr($selected->first_name ?? '?', 0, 1)) }}{{ mb_strtoupper(mb_substr($selected->last_name ?? '', 0, 1)) }}</span><div><h2>{{ $selected->first_name }} {{ $selected->last_name }}</h2><p>{{ $selected->email }} @if($selected->phone_number) · {{ $selected->phone_number }} @endif</p><span class="pill p-new">{{ $selected->profile_complete ? 'Profile Completed' : 'Profile incomplete' }}</span></div><div class="acts">
                @if($selected->phone_number)<a href="tel:{{ $selected->phone_number }}">Call</a>@endif
                @if($account && $account->email && $account->password && !session()->has('admin_user') && auth()->user()->hasAnyRole(['Administrator','visa','agent','sub_agent','Application Punching']))<a href="{{ route('impersonate', $account) }}">Login as student</a>@endif
                @if($selected->email)<button type="button" class="payment_model" student-id="{{ $selected->user_id }}" data-bs-toggle="offcanvas" data-bs-target="#gmat">Payment Link</button>@endif
            </div></div>
            <div class="kpis" aria-label="Case summary">
                <div><span>Progress</span><strong>{{ $selected->status_threesixty ? 'Started' : 'Not started' }}</strong></div>
                <div><span>Universities</span><strong>—</strong></div>
                <div><span>Paid to OEL</span><strong>—</strong></div>
                <div><span>Due</span><strong>—</strong></div>
            </div>
            <nav class="ctabs" aria-label="Profile sections">
                @can('oel_360.view')
                    @if($selected->profile_complete && $selected->status_threesixty && auth()->user()->can('oel_apply.view'))<a class="{{ $tab === 'journey' ? 'active' : '' }}" href="{{ $tabUrl('journey') }}">OEL 360 journey</a>@else<span class="workspace-tab-disabled" aria-disabled="true">OEL 360 journey</span>@endif
                @endcan
                @can('application.view')<a class="{{ $tab === 'payments' ? 'active' : '' }}" href="{{ $tabUrl('payments') }}">Payments</a>@endcan
                <a class="{{ $tab === 'overview' ? 'active' : '' }}" href="{{ $tabUrl('overview') }}">Overview</a>
                @can('oel_360.view')<a class="{{ $tab === 'documents' ? 'active' : '' }}" href="{{ $tabUrl('documents') }}">Documents</a>@endcan
                @can('application.view')<a class="{{ $tab === 'applications' ? 'active' : '' }}" href="{{ $tabUrl('applications') }}">Applications &amp; Visa</a>@endcan
            </nav>
            <div class="body">
            @unless($selected->profile_complete)<p class="note n-warn">Profile incomplete. Complete the student profile before starting OEL 360.</p>@endunless
            @if($tab === 'journey' && $journeyData)
            @include('admin.leads.partials.journey', array_merge($journeyData, ['embeddedJourney' => true]))
            @elseif($tab === 'overview')
            <div class="ov"><div><article><h3>Contact &amp; Ownership</h3><dl><dt>Email</dt><dd>{{ $selected->email ?: 'Not available' }}</dd><dt>Phone</dt><dd>{{ $selected->phone_number ?: 'Not available' }}</dd><dt>Location</dt><dd>{{ $selected->city ?: 'Not available' }}{{ optional($selected->country)->name ? ', '.optional($selected->country)->name : '' }}</dd><dt>Account Owner</dt><dd>{{ optional($owner)->name ?: 'Not available' }}</dd></dl></article><article><h3>Education &amp; Preferences</h3>@if($details)<dl><dt>Highest Education</dt><dd>{{ optional($details->educationLevel)->name ?: 'Not available' }}</dd><dt>Grade</dt><dd>{{ $details->grading_average ?: 'Not available' }}</dd></dl>@else<p>No education history available.</p>@endif</article></div><article><h3>Latest Application</h3>@if($latestApplication)<p><strong>{{ optional($latestApplication->program)->name ?: 'Program unavailable' }}</strong><br>{{ optional(optional($latestApplication->program)->university_name)->university_name ?: 'University unavailable' }}</p><p>{{ $latestApplication->status ?: 'Status unavailable' }}</p>@else<p>No authorized applications available.</p>@endif</article></div>
            @else
            @if($tab === 'payments')
            <div class="workspace-payment-summary" aria-label="Payment summary">
                <div><span>Received</span><strong>₹{{ number_format($details->where('payment_status', 'success')->sum('amount'), 2) }}</strong></div>
                <div><span>Due</span><strong>—</strong></div>
                <div><span>Entries</span><strong>{{ $details->count() }}</strong></div>
            </div>
            <div class="tw"><table class="stack">
                <thead><tr><th>Service</th><th>Amount</th><th>Mode</th><th>Date</th><th>Status</th></tr></thead>
                <tbody>@forelse($details as $entry)
                <tr><td data-l="Service">{{ $entry->service_name ?: '—' }}</td><td data-l="Amount">₹{{ number_format((float) $entry->amount, 2) }}</td><td data-l="Mode">{{ $entry->payment_method ?: '—' }}</td><td data-l="Date">{{ $entry->created_at ?: '—' }}</td><td data-l="Status"><span class="pill p-new">{{ $entry->payment_status ?: 'Unknown' }}</span></td></tr>
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
        </section>
    </div>
</div>
@include('admin.student.workspace-payment')
@endsection
@include('admin.student.workspace-scripts')
