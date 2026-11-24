<div class="tab-pane fade active show" role="tabpanel" id="step1" aria-labelledby="step1-tab">
    <form id="wizard-step1-form">
        <input type="hidden" name="tab1" value="tab1">
        <input type="hidden" name="university_id" class="university_id" value="{{ $university->id ?? '' }}">

        <h3 class="pr-section-heading"><i class="la la-map-marker-alt"></i> Location</h3>
        <div class="pr-wizard-grid">
            <div class="pr-form-field">
                <label>Country<span class="pr-required">*</span></label>
                <select class="pr-select country" name="country_id">
                    <option value="">Select country</option>
                    @foreach ($countries as $item)
                    <option value="{{ $item->id }}" {{ old('country_id', optional($university)->country_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
                <span class="pr-error" data-error="country_id"></span>
            </div>
            <div class="pr-form-field">
                <label>State / Province<span class="pr-required">*</span></label>
                <select name="province_id" class="pr-select province_id" data-selected="{{ old('province_id', optional($university)->state) }}">
                    <option value="">Select country first</option>
                </select>
                <span class="pr-error" data-error="province_id"></span>
            </div>
            <div class="pr-form-field">
                <label>City<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="city" placeholder="e.g. Berlin" value="{{ old('city', optional($university)->city) }}">
                <span class="pr-error" data-error="city"></span>
            </div>
            <div class="pr-form-field" style="grid-column: span 2;">
                <label>Location / Address<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="university_location" placeholder="e.g. Friedrichstrasse 123" value="{{ old('university_location', optional($university)->university_location) }}">
                <span class="pr-error" data-error="university_location"></span>
            </div>
            <div class="pr-form-field">
                <label>ZIP<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="zip" placeholder="e.g. 10117" value="{{ old('zip', optional($university)->zip) }}">
                <span class="pr-error" data-error="zip"></span>
            </div>
            <div class="pr-form-field" style="grid-column: 1 / -1;">
                <label>Google Maps Embed URL</label>
                <input type="text" class="pr-input google-iframe-url" name="map_location" placeholder="Paste the embed code or link here" value="{{ old('map_location', optional($university)->map_location) }}">
                <span class="pr-hint">Google Maps &rarr; Share &rarr; Embed a map &rarr; copy the src link</span>
                <span class="pr-error" data-error="map_location"></span>
            </div>
            <div class="pr-form-field" style="grid-column: 1 / -1;">
                <label>Map</label>
                <div class="pr-map-preview" id="map-preview">
                    <span id="map-preview-placeholder">Map preview &ndash; URL paste karne par yahan map dikhega</span>
                    <iframe id="map-iframe" style="display:none;" loading="lazy" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </form>
</div>
