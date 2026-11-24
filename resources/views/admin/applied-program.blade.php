@extends('admin.include.app')
@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/applied-program-list.css') }}">
@endsection
@section('main-content')
<div class="applied-page">
    <div class="applied-heading"><h1>Applied Program List</h1></div>
    <section class="applied-filters" aria-label="Filter applications">
        <form action="{{ route('total-applied-program') }}" method="get" class="applied-filter-form">
            <div><label for="applied-name">Student Name</label><input id="applied-name" type="search" name="first_name" value="{{ request('first_name') }}" placeholder="Search by student name"></div>
            <div><label for="applied-email">Email</label><input id="applied-email" type="search" name="email" value="{{ request('email') }}" placeholder="Search by email"></div>
            <div class="applied-filter-actions"><button type="submit" class="applied-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button><a class="applied-reset" href="{{ route('total-applied-program') }}"><i class="fa fa-rotate-right" aria-hidden="true"></i> Reset</a></div>
        </form>
    </section>
    <section class="applied-table-card" aria-label="Applied programs">
        <div class="applied-scroll" tabindex="0" aria-label="Scroll applied programs table horizontally">
            <table class="applied-table">
                <thead><tr><th scope="col">Application ID</th><th scope="col">Applied On</th><th scope="col">Created By</th><th scope="col">Student</th><th scope="col">University &amp; Program</th><th scope="col">Payment</th><th scope="col">Application / Visa</th><th scope="col">Actions</th></tr></thead>
                <tbody>
                @forelse($program_applied as $item)
                    @php
                        $key = $item->user_id . ':' . $item->program_id;
                        $courseStatus = optional(optional($courseStatuses->get($key))->first())->course_remarks ?? 'N/A';
                        $visaStatus = optional(optional($visaStatuses->get($key))->first())->visa_application ?? 'N/A';
                        $paymentStatus = strtolower(trim((string) ($item->payments->payment_status ?? $item->payment_status ?? '')));
                        $paymentLabel = $paymentStatus === 'success' ? 'Success' : ($paymentStatus === 'free' ? 'Free' : ($paymentStatus === 'failed' ? 'Failed' : ($item->payment_type_remarks === 'applied_program_pay_later' ? 'Pending' : ($paymentStatus ?: 'N/A'))));
                        $badgeClass = function ($value) {
                            $value = strtolower(trim((string) $value));
                            if (in_array($value, ['success', 'free', 'accepted', 'approved'], true)) return 'is-success';
                            if (in_array($value, ['pending', 'processing', 'in progress'], true)) return 'is-pending';
                            if (in_array($value, ['failed', 'rejected', 'student_rejected'], true)) return 'is-failed';
                            return 'is-neutral';
                        };
                    @endphp
                    <tr>
                        <td><strong>{{ $item->app_id ?: 'N/A' }}</strong></td>
                        <td>{{ $item->created_at ?: 'N/A' }}</td>
                        <td>@if(auth()->user()->hasRole('Administrator') || auth()->user()->hasRole('agent'))<span class="applied-line"><small>Franchise</small> {{ $creatorEmails[$item->added_by_agent_id] ?? 'N/A' }}</span><span class="applied-line"><small>Sub Agent</small> {{ $creatorEmails[$item->assigned_to] ?? 'N/A' }}</span>@else N/A @endif</td>
                        <td><strong>{{ $item->name ?: 'N/A' }}</strong><span class="applied-muted">{{ $item->user_email }}</span></td>
                        <td><strong>{{ $item->program->university_name->university_name ?? 'N/A' }}</strong>@if($item->program)<a class="applied-program-link" href="{{ route('course-details', [str_replace(' ', '-', $item->program->name) . '-' . $item->program->id]) }}">{{ $item->program->name }}</a>@else<span class="applied-muted">N/A</span>@endif</td>
                        <td><span class="applied-badge {{ $badgeClass($paymentLabel) }}">{{ ucfirst($paymentLabel) }}</span></td>
                        <td><span class="applied-status-line"><small>Application</small> <span class="applied-badge {{ $badgeClass($courseStatus) }}">{{ $courseStatus ?: 'N/A' }}</span></span><span class="applied-status-line"><small>Visa</small> <span class="applied-badge {{ $badgeClass($visaStatus) }}">{{ $visaStatus ?: 'N/A' }}</span></span></td>
                        <td>@if((int) $item->user_id === (int) auth()->id())<details class="applied-menu"><summary aria-label="Actions for application {{ $item->app_id ?: $item->id }}">&#8943;</summary><div><a href="{{ route('delete-program', [$item->id]) }}" onclick="return confirm('Delete this applied program?')">Delete</a></div></details>@else<span class="applied-muted">—</span>@endif</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="applied-empty">No applications match your search.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="applied-pagination"><span>@if($program_applied->total()) Showing {{ $program_applied->firstItem() }}–{{ $program_applied->lastItem() }} of {{ $program_applied->total() }} applications @else No applications found @endif</span>{{ $program_applied->links() }}</div>
    </section>
</div>
@endsection
