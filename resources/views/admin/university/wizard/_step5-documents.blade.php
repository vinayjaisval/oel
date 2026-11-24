<div class="tab-pane fade" role="tabpanel" id="step5" aria-labelledby="step5-tab">
    <h3 class="pr-section-heading"><i class="la la-images"></i> University Documents</h3>
    <input type="hidden" class="university_id" value="{{ $university->id ?? '' }}">

    <div class="pr-wizard-grid">
        <div class="pr-form-field">
            <label>Logo <small class="pr-hint">(Max 100KB, JPG/PNG)</small></label>
            <div class="pr-dropzone" data-field="logo" data-accept="image/jpeg,image/png">
                <i class="la la-cloud-upload-alt"></i>
                <span>Click or drop a file</span>
                <input type="file" name="logo" accept="image/jpeg,image/png" hidden>
            </div>
            <div class="pr-upload-preview" data-preview="logo"></div>
        </div>
        <div class="pr-form-field">
            <label>Thumbnail <small class="pr-hint">(Max 100KB, JPG/PNG)</small></label>
            <div class="pr-dropzone" data-field="thumbnail" data-accept="image/jpeg,image/png">
                <i class="la la-cloud-upload-alt"></i>
                <span>Click or drop a file</span>
                <input type="file" name="thumbnail" accept="image/jpeg,image/png" hidden>
            </div>
            <div class="pr-upload-preview" data-preview="thumbnail"></div>
        </div>
        <div class="pr-form-field">
            <label>Banner <small class="pr-hint">(Max 100KB, JPG/PNG)</small></label>
            <div class="pr-dropzone" data-field="banner" data-accept="image/jpeg,image/png">
                <i class="la la-cloud-upload-alt"></i>
                <span>Click or drop a file</span>
                <input type="file" name="banner" accept="image/jpeg,image/png" hidden>
            </div>
            <div class="pr-upload-preview" data-preview="banner"></div>
        </div>
    </div>

    <hr class="pr-section-divider">
    <h3 class="pr-section-heading"><i class="la la-images"></i> Gallery</h3>
    <div class="pr-form-field">
        <label>Images <small class="pr-hint">(Max 100KB each, JPG/PNG)</small></label>
        <div class="pr-dropzone" data-field="images" data-multiple="1" data-accept="image/jpeg,image/png">
            <i class="la la-cloud-upload-alt"></i>
            <span>Click or drop images</span>
            <input type="file" name="images[]" accept="image/jpeg,image/png" multiple hidden>
        </div>
        <div class="pr-upload-preview pr-row-flex" style="flex-wrap:wrap;gap:0.75rem;" data-preview="images"></div>
    </div>
</div>
