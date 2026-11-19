@php
$rowLevel = $item->programLevel->name ?? null;
$lengthDigits = preg_replace('/[^0-9]/', '', (string) $item->length);
$rowDuration = $lengthDigits !== '' ? $lengthDigits . ' month' . ($lengthDigits === '1' ? '' : 's') : null;
$rowIsFree = empty($item->application_fee);
$rowTuition = $item->tution_fee !== null && $item->tution_fee !== ''
    ? trim(($item->currency ?? '') . ' ' . number_format((float) $item->tution_fee))
    : null;
$rowUrl = route('study-in.program', [
    'country' => $studyInUniversitySlugs['country'],
    'university' => $studyInUniversitySlugs['university'],
    'program' => \Illuminate\Support\Str::slug($item->name) . '-' . $item->id,
]);
@endphp
<div class="ud-course-card">
    <div class="ud-course-top">
        <a href="{{ $rowUrl }}">{{ $item->name }}</a>
        @if($rowIsFree)
            <span class="ud-free-badge">Free to apply</span>
        @endif
    </div>
    <div class="ud-course-facts">
        @if($rowLevel)
            <div class="f"><svg width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="5" y="5" width="10" height="10" rx="2" transform="rotate(45 10 10)"/></svg><span>{{ $rowLevel }}</span></div>
        @endif
        @if($rowDuration)
            <div class="f"><svg width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="10" cy="10" r="7"/><path stroke-linecap="round" d="M10 6v4l3 2"/></svg><span>{{ $rowDuration }}</span></div>
        @endif
        @if($item->programType ?? null)
            <div class="f"><svg width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="4" width="14" height="13" rx="2"/><path d="M3 8h14M7 2v4M13 2v4"/></svg><span>{{ $item->programType }}</span></div>
        @endif
        @if($rowTuition)
            <div class="f"><svg width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="10" cy="10" r="7.5"/><path stroke-linecap="round" d="M10 5.5v9M12.3 7.6c0-1-1-1.6-2.3-1.6s-2.4.6-2.4 1.6c0 2.1 4.9 1 4.9 3.1 0 1-1 1.7-2.5 1.7s-2.4-.6-2.4-1.7"/></svg><span><b>{{ $rowTuition }}</b> /yr</span></div>
        @endif
    </div>
    <a href="{{ $rowUrl }}" class="ud-view-btn">View course &rarr;</a>
</div>
