<div class="tab-pane fade" role="tabpanel" id="step4" aria-labelledby="step4-tab">
    <h3 class="pr-section-heading"><i class="la la-certificate"></i> University Accreditation</h3>
    <form id="accerediation">
        <input type="hidden" name="university_id" class="university_id" value="{{ $university->id ?? '' }}">
        <div class="pr-wizard-grid">
            <div class="pr-form-field">
                <label>Name<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="name" placeholder="e.g. AACSB">
                <span class="pr-error" data-error="name"></span>
            </div>
            <div class="pr-form-field">
                <label>Year<span class="pr-required">*</span></label>
                <input type="number" class="pr-input" name="year" placeholder="e.g. 2022">
                <span class="pr-error" data-error="year"></span>
            </div>
            <div class="pr-form-field">
                <label>Logo<span class="pr-required">*</span></label>
                <input type="file" class="pr-input" name="company_logo" accept="image/*">
                <span class="pr-error" data-error="company_logo"></span>
            </div>
        </div>
        <div style="margin-top:0.75rem;">
            <button type="button" class="pr-btn pr-btn-primary accerediation_add">+ Add Accreditation</button>
            <button type="button" class="pr-btn pr-btn-outline accreditation-cancel-edit" style="display:none;">Cancel edit</button>
        </div>
    </form>

    <div class="pr-table-scroll" style="margin-top:1.5rem;">
        <table class="pr-table">
            <thead>
                <tr><th>Logo</th><th>Name</th><th>Year</th><th>Actions</th></tr>
            </thead>
            <tbody class="accerediation_table">
                <tr><td colspan="4" style="text-align:center;color:var(--pr-text-muted);">Abhi koi accreditation add nahi hui</td></tr>
            </tbody>
        </table>
    </div>
</div>
