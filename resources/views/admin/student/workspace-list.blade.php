<div class="items" data-student-rows data-total="{{ $student_profile->total() }}">
    @forelse($student_profile as $item)
        @php
            [$stage, $color] = match (true) {
                !$item->profile_complete => ['Profile incomplete', 'p-warn'],
                $item->visa_application === 'Rejected' => ['Visa rejected', 'p-bad'],
                filled($item->hostel) => ['Completed', 'p-ok'],
                filled($item->flight_no) => ['Step 9/11 · Take off', 'p-ok'],
                filled($item->visa_apply_date) => ['Step 7/11 · Visa status', 'p-ok'],
                filled($item->fee_amount) => ['Step 6/11 · Visa application', 'p-ok'],
                filled($item->courses) => ['Step 3/11 · Application status', 'p-ok'],
                filled($item->college) => ['Step 2/11 · Courses', 'p-ok'],
                default => ['Ready for OEL 360', 'p-new'],
            };
            $studentUrl = route('student-list', array_merge(request()->except(['student','tab','step','page']), ['student' => $item->user_id, 'tab' => $item->profile_complete && $item->status_threesixty && auth()->user()->can('oel_360.view') && auth()->user()->can('oel_apply.view') ? 'journey' : 'overview']));
        @endphp
        <a class="it" aria-current="{{ $selectedId == $item->user_id ? 'true' : 'false' }}" href="{{ $studentUrl }}" data-student="{{ $item->user_id }}">
            <span class="av">{{ mb_strtoupper(mb_substr($item->first_name ?? '?', 0, 1).mb_substr($item->last_name ?? '', 0, 1)) }}</span>
            <span class="meta"><b class="nm">{{ $item->first_name }} {{ $item->last_name }}</b><small class="em">{{ $item->email }}</small></span>
            <span class="r"><span class="pill {{ $color }}">{{ $stage }}</span><span class="pill {{ $item->workspace_payment === 'Paid' ? 'p-ok' : 'p-warn' }}">{{ $item->workspace_payment }}</span></span>
        </a>
    @empty
        <p class="empty">No students match these filters.</p>
    @endforelse
    @if($student_profile->hasMorePages())
        <button class="btn" type="button" data-load-more="{{ $student_profile->currentPage() + 1 }}">Load more</button>
    @endif
</div>
