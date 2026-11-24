@php
    $testrequiredSelected = old('testrequired_input', optional($university)->testrequired ? explode(',', $university->testrequired) : []);
@endphp
<div class="tab-pane fade" role="tabpanel" id="step2" aria-labelledby="step2-tab">
    <form id="wizard-step2-form">
        <input type="hidden" name="tab2" value="tab2">
        <input type="hidden" name="university_id" class="university_id" value="{{ $university->id ?? '' }}">

        <h3 class="pr-section-heading"><i class="la la-university"></i> University Details</h3>
        <div class="pr-wizard-grid">
            <div class="pr-form-field" style="grid-column: span 2;">
                <label>University Name<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="university_name" maxlength="200" placeholder="e.g. FOM Hochschule" value="{{ old('university_name', optional($university)->university_name) }}">
                <span class="pr-error" data-error="university_name"></span>
            </div>
            <div class="pr-form-field">
                <label>Type of University<span class="pr-required">*</span></label>
                <select class="pr-select" name="type_of_university">
                    <option value="">Select type</option>
                    @foreach ($college_type as $item)
                    <option value="{{ $item->id }}" {{ old('type_of_university', optional($university)->type_of_university) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
                <span class="pr-error" data-error="type_of_university"></span>
            </div>
            <div class="pr-form-field">
                <label>Website<span class="pr-required">*</span></label>
                <input type="url" class="pr-input" name="website" placeholder="https://example.edu" value="{{ old('website', optional($university)->website) }}">
                <span class="pr-error" data-error="website"></span>
            </div>
            <div class="pr-form-field">
                <label>Founded Year<span class="pr-required">*</span></label>
                <input type="number" class="pr-input" name="founded_in" placeholder="e.g. 1991" value="{{ old('founded_in', optional($university)->founded_in) }}">
                <span class="pr-error" data-error="founded_in"></span>
            </div>
            <div class="pr-form-field">
                <label>Campus Size<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="size_of_campus" placeholder="e.g. 12 acres" required value="{{ old('size_of_campus', optional($university)->size_of_campus) }}">
                <span class="pr-error" data-error="size_of_campus"></span>
            </div>
        </div>

        <hr class="pr-section-divider">
        <h3 class="pr-section-heading"><i class="la la-phone"></i> Contact</h3>
        <div class="pr-wizard-grid">
            <div class="pr-form-field">
                <label>Phone No</label>
                <input type="tel" class="pr-input" name="phone_number" placeholder="e.g. +49 30 1234567" value="{{ old('phone_number', optional($university)->phone_number) }}">
                <span class="pr-error" data-error="phone_number"></span>
            </div>
            <div class="pr-form-field">
                <label>Email</label>
                <input type="email" class="pr-input" name="email" placeholder="e.g. info@example.edu" value="{{ old('email', optional($university)->email) }}">
                <span class="pr-error" data-error="email"></span>
            </div>
        </div>

        <hr class="pr-section-divider">
        <h3 class="pr-section-heading"><i class="la la-chart-bar"></i> Student Statistics</h3>
        <div class="pr-wizard-grid">
            <div class="pr-form-field">
                <label>Total Students<span class="pr-required">*</span></label>
                <input type="number" class="pr-input" name="total_students" placeholder="e.g. 5000" value="{{ old('total_students', optional($university)->total_students) }}">
                <span class="pr-error" data-error="total_students"></span>
            </div>
            <div class="pr-form-field">
                <label>International Students<span class="pr-required">*</span></label>
                <input type="number" class="pr-input" name="international_students" placeholder="e.g. 800" value="{{ old('international_students', optional($university)->international_students) }}">
                <span class="pr-error" data-error="international_students"></span>
            </div>
            <div class="pr-form-field">
                <label>Male:Female Ratio<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="male_female_ratio" placeholder="e.g. 55:45" value="{{ old('male_female_ratio', optional($university)->male_female_ratio) }}">
                <span class="pr-error" data-error="male_female_ratio"></span>
            </div>
            <div class="pr-form-field">
                <label>Faculty:Student Ratio<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="faculty_student_ratio" placeholder="e.g. 1:15" value="{{ old('faculty_student_ratio', optional($university)->faculty_student_ratio) }}">
                <span class="pr-error" data-error="faculty_student_ratio"></span>
            </div>
            <div class="pr-form-field">
                <label>Students Receiving Financial Aid (%)<span class="pr-required">*</span></label>
                <input type="number" class="pr-input" name="financial_aid" placeholder="e.g. 30" value="{{ old('financial_aid', optional($university)->financial_aid) }}">
                <span class="pr-error" data-error="financial_aid"></span>
            </div>
        </div>

        <hr class="pr-section-divider">
        <h3 class="pr-section-heading"><i class="la la-coins"></i> Costs &amp; Fees</h3>
        <div class="pr-wizard-grid">
            <div class="pr-form-field">
                <label>Expense Currency<span class="pr-required">*</span></label>
                <select class="pr-select" name="expense_currencies">
                    <option value="">Select currency</option>
                    @foreach ($currency as $item)
                    <option value="{{ $item->id }}" {{ old('expense_currencies', optional($university)->yearly_hostel_expense_currencies) == $item->id ? 'selected' : '' }}>{{ $item->currency }}</option>
                    @endforeach
                </select>
                <span class="pr-error" data-error="expense_currencies"></span>
            </div>
            <div class="pr-form-field">
                <label>Yearly Hostel / Meal Expense<span class="pr-required">*</span></label>
                <input type="number" class="pr-input" name="expense_amount" placeholder="0.00" value="{{ old('expense_amount', optional($university)->yearly_hostel_expense_amount) }}">
                <span class="pr-error" data-error="expense_amount"></span>
            </div>
            <div class="pr-form-field">
                <label>Accommodation<span class="pr-required">*</span></label>
                <select class="pr-select" name="accomodation">
                    <option value="">Select</option>
                    <option value="Yes" {{ old('accomodation', optional($university)->accomodation) == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ old('accomodation', optional($university)->accomodation) == 'No' ? 'selected' : '' }}>No</option>
                </select>
                <span class="pr-error" data-error="accomodation"></span>
            </div>
            <div class="pr-form-field">
                <label>Application Fee Currency<span class="pr-required">*</span></label>
                <select class="pr-select" name="application_cost_currencies">
                    <option value="">Select currency</option>
                    @foreach ($currency as $item)
                    <option value="{{ $item->id }}" {{ old('application_cost_currencies', optional($university)->application_cost_currencies) == $item->id ? 'selected' : '' }}>{{ $item->currency }}</option>
                    @endforeach
                </select>
                <span class="pr-error" data-error="application_cost_currencies"></span>
            </div>
            <div class="pr-form-field">
                <label>Application / Registration Fee<span class="pr-required">*</span></label>
                <input type="number" class="pr-input" name="application_cost" placeholder="0.00" value="{{ old('application_cost', optional($university)->application_cost) }}">
                <span class="pr-error" data-error="application_cost"></span>
            </div>
            <div class="pr-form-field">
                <label>Accommodation Website<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="website2" placeholder="https://example.edu/housing" value="{{ old('website2', optional($university)->website2) }}">
                <span class="pr-error" data-error="website2"></span>
            </div>
            <div class="pr-form-field">
                <label>Tests Required<span class="pr-required">*</span></label>
                <select class="pr-select wizard-tests-select" name="testrequired_input[]" multiple style="width:100%">
                    @foreach ($testrequired as $item)
                    <option value="{{ $item->name }}" {{ in_array($item->name, $testrequiredSelected) ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
                <span class="pr-error" data-error="testrequired_input"></span>
            </div>
            <div class="pr-form-field">
                <label>FAFSA Code<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="fafsa_code" placeholder="e.g. 012345" required value="{{ old('fafsa_code', optional($university)->fafsa_code) }}">
                <span class="pr-error" data-error="fafsa_code"></span>
            </div>
        </div>
        <p class="pr-draft-note" style="margin-top:0.5rem;">Added by &amp; date automatically save hote hain.</p>

        <hr class="pr-section-divider">
        <h3 class="pr-section-heading"><i class="la la-align-left"></i> Content</h3>
        <div class="pr-content-tabs" id="wizard-content-tabs">
            <button type="button" class="pr-content-tab pr-content-tab-active" data-content-tab="details">Details<span class="pr-required">*</span></button>
            <button type="button" class="pr-content-tab" data-content-tab="notes">Notes</button>
            <button type="button" class="pr-content-tab" data-content-tab="placement">Placement</button>
            <button type="button" class="pr-content-tab" data-content-tab="accomodation_details">Accommodation Details</button>
        </div>
        <div class="pr-content-panel pr-content-panel-active" data-content-panel="details">
            <textarea name="details" id="summernote-details" class="pr-input">{{ old('details', optional($university)->details) }}</textarea>
            <span class="pr-error" data-error="details"></span>
        </div>
        <div class="pr-content-panel" data-content-panel="notes">
            <textarea name="notes" id="summernote-notes" class="pr-input">{{ old('notes', optional($university)->notes) }}</textarea>
        </div>
        <div class="pr-content-panel" data-content-panel="placement">
            <textarea name="placement" id="summernote-placement" class="pr-input">{{ old('placement', optional($university)->placement) }}</textarea>
        </div>
        <div class="pr-content-panel" data-content-panel="accomodation_details">
            <textarea name="accomodation_details" id="summernote-accomodation_details" class="pr-input">{{ old('accomodation_details', optional($university)->accomodation_details) }}</textarea>
        </div>
    </form>
</div>
