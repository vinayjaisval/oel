<div class="pr-types-grid">
    <div class="pr-card pr-form-card" style="margin-bottom:0;">
        <div class="pr-form-card-header">
            <div>
                <h3 class="pr-form-card-title">Add university type</h3>
            </div>
        </div>
        <form id="type-form" style="padding:1.25rem;">
            <input type="hidden" name="id" id="type-id">
            <div class="pr-form-field" style="margin-bottom:1rem;">
                <label>Type name<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="name" id="type-name" required>
                <span class="pr-error" data-error="name"></span>
            </div>
            <div class="pr-form-field" style="margin-bottom:1rem;">
                <label>Description</label>
                <textarea class="pr-input" name="description" id="type-description" rows="3"></textarea>
            </div>
            <button type="submit" class="pr-btn pr-btn-primary" style="width:100%;" id="type-submit-btn">+ Add type</button>
            <button type="button" class="pr-btn pr-btn-outline" style="width:100%;margin-top:0.5rem;display:none;" id="type-cancel-btn">Cancel edit</button>
        </form>
    </div>

    <div class="pr-card pr-table-card" style="margin-bottom:0;">
        <div class="pr-table-head">
            <h2 class="pr-table-title">All types</h2>
            <span class="pr-badge-count">{{ $types->count() }}</span>
        </div>
        <div id="types-list">
            @foreach($types as $t)
            <div class="pr-card-row pr-type-row" data-id="{{ $t->id }}" style="display:flex;align-items:center;gap:0.75rem;">
                <span class="pr-drag-handle"><i class="la la-grip-vertical"></i></span>
                <div style="flex:1;">
                    <p class="pr-program-name">{{ $t->name }}</p>
                    @if($t->description)
                    <p class="pr-program-sub">{{ $t->description }}</p>
                    @endif
                </div>
                <span class="pr-badge-count">{{ $t->universities_count }} universities</span>
                <label class="pr-switch">
                    <input type="checkbox" class="pr-type-active-toggle" data-id="{{ $t->id }}" {{ $t->active ? 'checked' : '' }}>
                    <span class="pr-switch-slider"></span>
                </label>
                <div class="pr-actions">
                    <button type="button" class="pr-icon-btn pr-type-edit" data-tooltip="Edit"
                        data-id="{{ $t->id }}" data-name="{{ $t->name }}" data-description="{{ $t->description }}">
                        <i class="la la-pen"></i>
                    </button>
                    <button type="button" class="pr-icon-btn pr-type-delete" data-id="{{ $t->id }}" data-tooltip="Delete"><i class="la la-trash"></i></button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
