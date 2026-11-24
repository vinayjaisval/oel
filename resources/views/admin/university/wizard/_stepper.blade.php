@php
    $wizardSteps = [
        1 => ['label' => 'Location', 'sub' => 'Address & map'],
        2 => ['label' => 'Basic Info', 'sub' => 'Details & costs'],
        3 => ['label' => 'Ranking', 'sub' => 'Rankings &amp; sources'],
        4 => ['label' => 'Accreditation', 'sub' => 'Accrediting bodies'],
        5 => ['label' => 'Documents', 'sub' => 'Logo, banner &amp; gallery'],
    ];
@endphp
<div class="pr-stepper" id="wizard-stepper">
    @foreach ($wizardSteps as $num => $step)
    <div class="pr-step" data-step="{{ $num }}">
        <div class="pr-step-circle">{{ $num }}</div>
        <div>
            <div class="pr-step-label">{{ $step['label'] }}</div>
        </div>
    </div>
    @if (!$loop->last)
    <div class="pr-step-line"></div>
    @endif
    @endforeach
</div>

<div class="pr-mobile-progress">
    <div style="display:flex;justify-content:space-between;font-size:0.85rem;font-weight:600;">
        <span id="wizard-mobile-step-label">Step 1 of 5 &middot; Location</span>
        <span id="wizard-mobile-step-percent">20%</span>
    </div>
    <div class="pr-progress-track">
        <div class="pr-progress-fill" id="wizard-mobile-progress-fill" style="width:20%;"></div>
    </div>
</div>
