@extends('admin.include.app')
@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/oel360-workspace.css') }}">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
@endsection
@section('main-content')

<div class="oel360" data-case-endpoint="{{ route('workspace-case-fragment', ['id' => 'STUDENT']) }}" data-list-endpoint="{{ route('workspace-list-fragment') }}" data-save-endpoint="{{ route('store-lead-360') }}" data-courses-endpoint="{{ route('university.courses') }}" data-offer-courses-endpoint="{{ route('getCourses') }}" data-university-search-endpoint="{{ route('search-university') }}" data-visa-sub-document-endpoint="{{ route('fetch-visa-sub-document') }}" data-delete-visa-document-endpoint="{{ route('delete-visa-document-three') }}" data-asset-base="{{ asset('') }}">
    <div class="toast" data-toast role="status"></div>
    <div class="top"><div><span class="logo">OEL</span><span class="crumb">Admin ? Students &amp; OEL 360</span><span class="who">Counsellor view</span></div></div>
    <div class="wrap {{ $selected ? 'open' : '' }}">
        <section class="card list" aria-label="Students">
            <div class="lh">
            <h1>Students <small data-student-count>{{ $student_profile->total() }}</small></h1>
    <nav class="tabs" aria-label="Student views">
        @foreach(['all' => 'All', 'ready' => 'Ready for 360', 'progress' => 'In progress', 'visa' => 'Visa issues', 'done' => 'Completed', 'incomplete' => 'Profile incomplete'] as $filter => $label)
            @can($filter === 'ready' ? 'oel_360.view' : 'student.view')
                <button type="button" data-view="{{ $filter }}" aria-pressed="{{ $view === $filter ? 'true' : 'false' }}">{{ $label }}</button>
            @endcan
        @endforeach
    </nav>
    <form data-list-filters method="get" action="{{ route('student-list') }}">
        <input type="hidden" name="view" value="{{ $view }}">
        <label class="workspace-search"><span class="sr">Search students</span><input class="inp" type="search" name="q" value="{{ request('q') }}" placeholder="Search name, email or phone"></label>
        <details><summary>More filters</summary><div class="workspace-filter-fields">
            <label>Name <input name="{{ $view === 'ready' ? 'first_name' : 'name' }}" value="{{ request($view === 'ready' ? 'first_name' : 'name') }}"></label>
            <label>Email <input name="email" value="{{ request('email') }}"></label>
            <label>Franchise <select name="agent_id"><option value="">All franchises</option>@foreach($agents as $agent)<option value="{{ $agent->id }}" @selected(request('agent_id') == $agent->id)>{{ $agent->name }}</option>@endforeach</select></label>
            <label>Sub Agent <select name="subagent_id"><option value="">All sub agents</option>@foreach($sub_agents as $agent)<option value="{{ $agent->id }}" @selected(request('subagent_id') == $agent->id)>{{ $agent->name }}</option>@endforeach</select></label>
            <label>Phone <input name="phone_number" value="{{ request('phone_number') }}"></label>
            <label>Pincode <input name="zip" value="{{ request('zip') }}"></label>
            <label>Country <select name="country_id"><option value="">All countries</option>@foreach(\App\Models\Country::orderBy('name')->get() as $country)<option value="{{ $country->id }}" @selected(request('country_id') == $country->id)>{{ $country->name }}</option>@endforeach</select></label>
            <label>From date <input type="date" name="from_date" value="{{ request('from_date') }}"></label>
            <label>To date <input type="date" name="to_date" value="{{ request('to_date') }}"></label>
        </div></details>
        <button type="submit">Search</button><a href="{{ route('student-list', ['view' => $view]) }}">Reset</a>
    </form>
            </div>
            <p class="note n-bad" data-list-error hidden>Unable to load students. Try again.</p>
            @include('admin.student.workspace-list', ['selectedId' => $selected?->user_id])
        </section>
        <section class="case" data-case-panel aria-label="Student profile" aria-live="polite">
            @include('admin.student.workspace-case')
        </section>
    </div>
</div>
@include('admin.student.workspace-payment')
@endsection
@include('admin.student.workspace-scripts')
