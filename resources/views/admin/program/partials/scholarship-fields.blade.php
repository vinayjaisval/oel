@php
    $scholarshipAvailable = old('scholarship_available', $program->scholarship_available ?? 0);
@endphp
<div class="pr-card pr-form-card">
    <div class="pr-form-card-header">
        <span class="pr-step-number">5</span>
        <div>
            <h3 class="pr-form-card-title">Scholarship</h3>
            <p class="pr-form-card-subtitle">Agar is program par scholarship available hai to Yes select karein</p>
        </div>
    </div>
    <div class="pr-form-grid">
        <div class="pr-form-field @error('scholarship_available') pr-has-error @enderror">
            <label for="scholarship_available">Scholarship Available?<span class="pr-required">*</span></label>
            <select class="pr-select" name="scholarship_available" id="scholarship_available">
                <option value="0" {{ (string) $scholarshipAvailable === '0' ? 'selected' : '' }}>No</option>
                <option value="1" {{ (string) $scholarshipAvailable === '1' ? 'selected' : '' }}>Yes</option>
            </select>
            @error('scholarship_available')<span class="pr-error">{{ $message }}</span>@enderror
        </div>
        <div></div>
        <div></div>

        <div id="scholarship-box" class="pr-scholarship-box" @if((string) $scholarshipAvailable !== '1') style="display:none;" @endif>
            <div class="pr-form-field">
                <label for="scholarship_name">Scholarship Name</label>
                <input type="text" class="pr-input" name="scholarship_name" id="scholarship_name" placeholder="e.g. Merit Scholarship" value="{{ old('scholarship_name', $program->scholarship_name ?? '') }}">
            </div>
            <div class="pr-form-field @error('scholarship_amount') pr-has-error @enderror">
                <label for="scholarship_amount">Scholarship Amount<span class="pr-required">*</span></label>
                <input type="number" step="0.01" min="0" class="pr-input scholarship-required" name="scholarship_amount" id="scholarship_amount" placeholder="0.00" value="{{ old('scholarship_amount', $program->scholarship_amount ?? '') }}">
                @error('scholarship_amount')<span class="pr-error">{{ $message }}</span>@enderror
            </div>
            <div class="pr-form-field @error('scholarship_currency') pr-has-error @enderror">
                <label for="scholarship_currency">Scholarship Currency<span class="pr-required">*</span></label>
                <select class="pr-select scholarship-required" name="scholarship_currency" id="scholarship_currency">
                    <option value="">Select scholarship currency</option>
                    @foreach ($currency as $item)
                    <option value="{{ $item->currency }}" {{ old('scholarship_currency', $program->scholarship_currency ?? '') == $item->currency ? 'selected' : '' }}>{{ $item->currency }}</option>
                    @endforeach
                </select>
                @error('scholarship_currency')<span class="pr-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
</div>
