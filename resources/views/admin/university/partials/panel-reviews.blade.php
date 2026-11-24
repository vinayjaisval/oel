<form class="pr-panel-filter-form" data-tab="reviews">
    <div class="pr-card pr-filter-card">
        <div class="pr-filter-grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="pr-field">
                <label>Status</label>
                <select class="pr-select" name="status">
                    <option value="">All</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Published</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="pr-field">
                <label>University</label>
                <select class="pr-select pr-review-university-filter" name="university_id" style="width:100%">
                    @if(request('university_id') && request('university_name_label'))
                    <option value="{{ request('university_id') }}" selected>{{ request('university_name_label') }}</option>
                    @endif
                </select>
            </div>
            <div class="pr-filter-actions">
                <button type="button" class="pr-btn pr-btn-outline pr-panel-reset">Reset</button>
                <button type="submit" class="pr-btn pr-btn-primary">Apply filters</button>
            </div>
        </div>
    </div>
</form>

<div class="pr-card pr-table-card">
    <div class="pr-table-head">
        <h2 class="pr-table-title">OEL Reviews</h2>
        <span class="pr-badge-count">{{ number_format($reviews->total()) }}</span>
        <a href="javascript:void(0)" class="pr-btn pr-btn-primary pr-add-review" style="margin-left:auto;">+ Add review</a>
    </div>
    <div class="pr-table-scroll">
        <table class="pr-table">
            <thead>
                <tr>
                    <th>Review</th>
                    <th>Rating</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $r)
                <tr>
                    <td>
                        <p class="pr-program-name">{{ $r->heading }}</p>
                        <p class="pr-program-sub">{{ $r->university->university_name ?? ('School #' . $r->school_id) }}</p>
                        @if($r->reviewer_name)
                        <p class="pr-program-sub">{{ $r->reviewer_name }}</p>
                        @endif
                    </td>
                    <td>
                        @if($r->rating)
                        <span class="pr-star-rating">
                            @for($i = 1; $i <= 5; $i++)
                            <span class="la la-star pr-star {{ $i <= $r->rating ? 'pr-star-filled' : '' }}"></span>
                            @endfor
                        </span>
                        @else
                        <span class="pr-no-rating">No rating</span>
                        @endif
                    </td>
                    <td><p class="pr-clamp-2" style="max-width:320px;">{{ $r->details }}</p></td>
                    <td>
                        @if($r->status == 1)
                        <span class="pr-pill pr-pill-green">Published</span>
                        @else
                        <span class="pr-pill pr-pill-amber">Pending</span>
                        @endif
                    </td>
                    <td>
                        <div class="pr-actions">
                            @if($r->status != 1)
                            <button type="button" class="pr-icon-btn pr-approve-review" data-id="{{ $r->id }}" data-tooltip="Approve"><i class="la la-check"></i></button>
                            @endif
                            <button type="button" class="pr-icon-btn pr-edit-review" data-tooltip="Edit"
                                data-id="{{ $r->id }}"
                                data-school_id="{{ $r->school_id }}"
                                data-university_name="{{ $r->university->university_name ?? '' }}"
                                data-student_id="{{ $r->student_id }}"
                                data-reviewer_name="{{ $r->reviewer_name }}"
                                data-rating="{{ $r->rating }}"
                                data-heading="{{ $r->heading }}"
                                data-details="{{ $r->details }}"
                                data-status="{{ $r->status }}">
                                <i class="la la-pen"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--pr-text-muted);">No reviews yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pr-table-footer">
        <span class="pr-showing">Showing {{ $reviews->firstItem() ?? 0 }}&ndash;{{ $reviews->lastItem() ?? 0 }} of {{ number_format($reviews->total()) }}</span>
        <div class="pr-pagination">{{ $reviews->withQueryString()->links() }}</div>
    </div>
</div>

{{-- Add/Edit review offcanvas --}}
<div class="offcanvas offcanvas-end border-0" tabindex="-1" id="review-offcanvas">
    <div class="sidebar-headerset" style="box-shadow: 0 1.6rem 3rem rgba(0,0,0,.1);">
        <div class="sidebar-headersets"><h5 id="review-offcanvas-title">Add Review</h5></div>
        <div class="sidebar-headerclose">
            <a data-bs-dismiss="offcanvas" aria-label="Close"><img src="{{ url('assets/img/close.png') }}" alt="Close"></a>
        </div>
    </div>
    <div class="offcanvas-body">
        <form id="review-form">
            <input type="hidden" name="id" id="review-id">
            <div class="pr-form-field" style="margin-bottom:1rem;">
                <label>University<span class="pr-required">*</span></label>
                <select class="pr-select" name="school_id" id="review-school-id" style="width:100%" required></select>
                <span class="pr-error" data-error="school_id"></span>
            </div>
            <div class="pr-form-field" style="margin-bottom:1rem;">
                <label>Student (optional)</label>
                <select class="pr-select" name="student_id" id="review-student-id" style="width:100%"></select>
            </div>
            <div class="pr-form-field" style="margin-bottom:1rem;">
                <label>Reviewer name</label>
                <input type="text" class="pr-input" name="reviewer_name" id="review-reviewer-name" placeholder="e.g. Jane D.">
            </div>
            <div class="pr-form-field" style="margin-bottom:1rem;">
                <label>Rating (optional)</label>
                <div class="pr-star-input" id="review-star-input">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="la la-star pr-star" data-value="{{ $i }}"></span>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="review-rating" value="">
            </div>
            <div class="pr-form-field" style="margin-bottom:1rem;">
                <label>Heading<span class="pr-required">*</span></label>
                <input type="text" class="pr-input" name="heading" id="review-heading" required>
                <span class="pr-error" data-error="heading"></span>
            </div>
            <div class="pr-form-field" style="margin-bottom:1rem;">
                <label>Details<span class="pr-required">*</span></label>
                <textarea class="pr-input" name="details" id="review-details" rows="4" required></textarea>
                <span class="pr-error" data-error="details"></span>
            </div>
            <div class="pr-form-field" style="margin-bottom:1rem;">
                <label>Status<span class="pr-required">*</span></label>
                <select class="pr-select" name="status" id="review-status" required>
                    <option value="1">Published</option>
                    <option value="0">Pending</option>
                </select>
            </div>
            <button type="submit" class="pr-btn pr-btn-primary" style="width:100%;">Save Review</button>
        </form>
    </div>
</div>
