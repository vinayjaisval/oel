
<div class="journey">
    <nav class="rail" aria-label="Journey steps">
        @foreach(['Admission' => ['Universities', 'Courses', 'Application status', 'Offer details', 'Fees'], 'Visa' => ['Visa application', 'Visa status'], 'Travel' => ['Flight details', 'Take off', 'Boarding', 'Done']] as $group => $labels)
            <h4>{{ $group }}</h4>
            @foreach($labels as $label)
                @php
                    $number++;
                    $rejected = $number === 7 && ($progress->visa_application ?? null) === 'Rejected';
                    $locked = !auth()->user()->can($permissions[$number - 1]) || ($number > $current && !($saved[$number - 1] ?? false));
                @endphp
                <button type="button" class="rs {{ $number === $activeStep ? 'on' : '' }}" data-case-step="{{ $number }}" @disabled($locked) aria-current="{{ $number === $activeStep ? 'step' : 'false' }}">
                    <span class="dot {{ $rejected ? 'd-bad' : (($saved[$number - 1] ?? false) ? 'd-done' : ($number === $activeStep ? 'd-cur' : '')) }}">{{ $rejected ? '!' : (($saved[$number - 1] ?? false) ? '✓' : $number) }}</span>{{ $label }}
                </button>
            @endforeach
        @endforeach
    </nav>
