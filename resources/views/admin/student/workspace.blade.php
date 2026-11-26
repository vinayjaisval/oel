@extends('admin.include.app')
@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/oel360-workspace.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
@endsection
@section('main-content')

<div class="oel360" data-case-endpoint="{{ route('workspace-case-fragment', ['id' => 'STUDENT']) }}" data-list-endpoint="{{ route('workspace-list-fragment') }}" data-save-endpoint="{{ route('store-lead-360') }}" data-courses-endpoint="{{ route('university.courses') }}" data-offer-courses-endpoint="{{ route('getCourses') }}" data-university-search-endpoint="{{ route('search-university') }}" data-visa-sub-document-endpoint="{{ route('fetch-visa-sub-document') }}" data-delete-visa-document-endpoint="{{ route('delete-visa-document-three') }}" data-save-payment-endpoint="{{ route('send-payment-link') }}" data-mark-paid-endpoint="{{ route('mark-payment-paid') }}" data-delete-payment-endpoint="{{ route('delete-payment-link') }}" data-asset-base="{{ asset('') }}">
    <div class="toast" data-toast role="status"></div>
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
        <label class="sr" for="q">Search students</label>
        <input class="inp" id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Search name, email or phone">
        <details data-more-filters>
            <summary class="btn">More filters</summary>
            <div class="g" style="margin-top:10px">
                <div class="fld"><label for="f_name">Name</label><input class="inp" id="f_name" name="{{ $view === 'ready' ? 'first_name' : 'name' }}" value="{{ request($view === 'ready' ? 'first_name' : 'name') }}"></div>
                <div class="fld"><label for="f_email">Email</label><input class="inp" id="f_email" name="email" value="{{ request('email') }}"></div>
                <div class="fld"><label for="f_agent">Franchise</label><select class="inp" id="f_agent" name="agent_id"><option value="">All franchises</option>@foreach($agents as $agent)<option value="{{ $agent->id }}" @selected(request('agent_id') == $agent->id)>{{ $agent->name }}</option>@endforeach</select></div>
                <div class="fld"><label for="f_subagent">Sub agent</label><select class="inp" id="f_subagent" name="subagent_id"><option value="">All sub agents</option>@foreach($sub_agents as $agent)<option value="{{ $agent->id }}" @selected(request('subagent_id') == $agent->id)>{{ $agent->name }}</option>@endforeach</select></div>
                <div class="fld"><label for="f_phone">Phone</label><input class="inp" id="f_phone" name="phone_number" value="{{ request('phone_number') }}"></div>
                <div class="fld"><label for="f_zip">Pincode</label><input class="inp" id="f_zip" name="zip" value="{{ request('zip') }}"></div>
                <div class="fld"><label for="f_country">Country</label><select class="inp" id="f_country" name="country_id"><option value="">All countries</option>@foreach(\App\Models\Country::orderBy('name')->get() as $country)<option value="{{ $country->id }}" @selected(request('country_id') == $country->id)>{{ $country->name }}</option>@endforeach</select></div>
                <div class="fld"><label for="f_from">From date</label><input class="inp" id="f_from" type="date" name="from_date" value="{{ request('from_date') }}"></div>
                <div class="fld"><label for="f_to">To date</label><input class="inp" id="f_to" type="date" name="to_date" value="{{ request('to_date') }}"></div>
            </div>
            <div style="display:flex;gap:12px;align-items:center;margin-top:10px">
                <button type="submit" class="btn go">Apply</button>
                <button type="button" class="btn-text" data-clear-filters>Clear</button>
            </div>
        </details>
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
@endsection
@section('scripts')
<script defer src="{{ asset('assets/js/oel360-workspace.js') }}"></script>
@endsection
