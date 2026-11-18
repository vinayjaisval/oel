@php
    $uni = $item->university_name;
    $programUrl = route('study-in.program', [
        'country' => \Illuminate\Support\Str::slug($uni->country_name->name ?? 'unknown'),
        'university' => \Illuminate\Support\Str::slug($uni->university_name ?? 'unknown') . '-' . ($uni->id ?? 0),
        'program' => \Illuminate\Support\Str::slug($item->name) . '-' . $item->id,
    ]);
    $duration = $item->length
        ? $item->length . (stripos($item->length, 'month') === false ? ' month' . ($item->length == 1 ? '' : 's') : '')
        : null;
    $tuition = ($item->tution_fee !== null && $item->tution_fee !== '')
        ? trim(($item->currency ?? '') . ' ' . number_format((float) $item->tution_fee))
        : null;
    $appFeeFree = $item->application_fee === null || $item->application_fee === '' || (float) $item->application_fee === 0.0;
    $appFeeText = $item->application_fee === null || $item->application_fee === ''
        ? null
        : ($appFeeFree ? 'Free' : trim(($item->currency ?? '') . ' ' . number_format((float) $item->application_fee)));
@endphp
<div class="vpd-card">
    <div class="title"><a href="{{ $programUrl }}">{{ $item->name }}</a></div>
    @if($showUniversity)
        <div class="uni">{{ $uni->university_name ?? '' }}</div>
    @endif
    <div class="vpd-facts">
        @if($item->programLevel->name ?? null)
            <div class="vpd-fact"><span class="l">Level</span><span class="v">{{ $item->programLevel->name }}</span></div>
        @endif
        @if($duration)
            <div class="vpd-fact"><span class="l">Duration</span><span class="v">{{ $duration }}</span></div>
        @endif
        @if($tuition)
            <div class="vpd-fact"><span class="l">Tuition fee</span><span class="v">{{ $tuition }}</span></div>
        @endif
        @if($appFeeText)
            <div class="vpd-fact"><span class="l">Application fee</span><span class="v{{ $appFeeFree ? ' free' : '' }}">{{ $appFeeText }}</span></div>
        @endif
    </div>
    <a href="{{ $programUrl }}" class="vpd-view-btn">Course details</a>
</div>
