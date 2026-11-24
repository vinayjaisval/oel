<div class="tab-pane fade" role="tabpanel" id="step3" aria-labelledby="step3-tab">
    <h3 class="pr-section-heading"><i class="la la-trophy"></i> University Ranking</h3>
    <form id="add_ranking">
        <input type="hidden" name="university_id" class="university_id" value="{{ $university->id ?? '' }}">
        <div class="pr-wizard-grid">
            <div class="pr-form-field">
                <label>Ranking<span class="pr-required">*</span></label>
                <input type="number" class="pr-input" name="ranking" placeholder="e.g. 45">
                <span class="pr-error" data-error="ranking"></span>
            </div>
            <div class="pr-form-field">
                <label>Source of Ranking<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="from_place" placeholder="e.g. QS World Rankings">
                <span class="pr-error" data-error="from_place"></span>
            </div>
            <div class="pr-form-field">
                <label>Year<span class="pr-required">*</span></label>
                <input type="number" class="pr-input" name="year" placeholder="e.g. 2026">
                <span class="pr-error" data-error="year"></span>
            </div>
            <div class="pr-form-field">
                <label>Type<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="type" placeholder="e.g. Global">
                <span class="pr-error" data-error="type"></span>
            </div>
        </div>
        <div style="margin-top:0.75rem;">
            <button type="button" class="pr-btn pr-btn-primary add_ranking">+ Add Ranking</button>
            <button type="button" class="pr-btn pr-btn-outline ranking-cancel-edit" style="display:none;">Cancel edit</button>
        </div>
    </form>

    <div class="pr-table-scroll" style="margin-top:1.5rem;">
        <table class="pr-table">
            <thead>
                <tr><th>Ranking</th><th>Source</th><th>Year</th><th>Type</th><th>Actions</th></tr>
            </thead>
            <tbody class="university-ranking">
                <tr><td colspan="5" style="text-align:center;color:var(--pr-text-muted);">Abhi koi ranking add nahi hui</td></tr>
            </tbody>
        </table>
    </div>
</div>
