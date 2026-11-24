@php
    $staleDays6 = $staleDays * 2;
@endphp
<form class="pr-panel-filter-form" data-tab="needs-update">
    <div class="pr-card pr-filter-card">
        <div class="pr-filter-grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="pr-field">
                <label>Age</label>
                <select class="pr-select" name="age">
                    <option value="3" {{ request('age', '3') == '3' ? 'selected' : '' }}>{{ $staleDays }}+ days</option>
                    <option value="6" {{ request('age') == '6' ? 'selected' : '' }}>{{ $staleDays6 }}+ days</option>
                    <option value="12" {{ request('age') == '12' ? 'selected' : '' }}>1+ year</option>
                </select>
            </div>
            <div class="pr-filter-actions" style="grid-column: span 2;">
                <button type="button" class="pr-btn pr-btn-outline pr-panel-reset">Reset</button>
                <button type="submit" class="pr-btn pr-btn-primary">Apply filters</button>
            </div>
        </div>
    </div>
</form>

<div class="pr-bulk-bar" style="display:none;" data-bulk-bar>
    <span class="pr-bulk-bar-label"><span data-bulk-count>0</span> selected</span>
    <div class="pr-bulk-bar-actions">
        <button type="button" class="pr-btn pr-btn-success pr-bulk-verify">Mark selected as verified</button>
        <button type="button" class="pr-btn pr-btn-outline pr-bulk-clear">Clear</button>
    </div>
</div>

<div class="pr-card pr-table-card">
    <div class="pr-table-head">
        <h2 class="pr-table-title">Needs Update</h2>
        <span class="pr-badge-count">{{ number_format($universities->total()) }}</span>
    </div>
    <div class="pr-table-scroll">
        <table class="pr-table">
            <thead>
                <tr>
                    <th class="pr-checkbox-col"><input type="checkbox" class="pr-checkbox" data-select-all></th>
                    <th>University</th>
                    <th>Last Updated</th>
                    <th>Last Updated By</th>
                    <th>Missing Info</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($universities as $u)
                @php
                    $effective = $u->last_verified_at && $u->last_verified_at->gt($u->updated_at) ? $u->last_verified_at : $u->updated_at;
                    $daysAgo = $effective->diffInDays(now());
                    $ageClass = $daysAgo >= $staleDays6 ? 'pr-pill-red' : 'pr-pill-amber';
                    $missing = array_filter([
                        'Name' => empty(trim((string) $u->university_name)),
                        'Email' => empty($u->email),
                        'Phone' => empty($u->phone_number),
                        'Logo' => empty($u->logo),
                        'Website' => empty($u->website),
                        'Type' => empty($u->type_of_university),
                    ]);
                @endphp
                <tr>
                    <td><input type="checkbox" class="pr-checkbox pr-row-check" value="{{ $u->id }}"></td>
                    <td>
                        <p class="pr-program-name">{{ $u->university_name ?: 'Name missing' }}</p>
                    </td>
                    <td><span class="pr-pill {{ $ageClass }}">{{ $daysAgo }} days ago</span></td>
                    <td>{{ $u->lastUpdatedBy->name ?? '-' }}</td>
                    <td>
                        @forelse($missing as $label => $isMissing)
                        <span class="pr-pill pr-pill-amber" style="margin:1px;">{{ $label }}</span>
                        @empty
                        <span class="pr-pill pr-pill-gray">Complete</span>
                        @endforelse
                    </td>
                    <td>
                        <div class="pr-actions">
                            <a href="{{ route('edit-university', $u->id) }}" class="pr-icon-btn" data-tooltip="Update"><i class="la la-pen"></i></a>
                            <button type="button" class="pr-icon-btn pr-mark-verified" data-id="{{ $u->id }}" data-tooltip="Mark as verified"><i class="la la-check"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--pr-text-muted);">Nothing needs updating right now.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pr-mobile-cards">
        @forelse($universities as $u)
        @php
            $effective = $u->last_verified_at && $u->last_verified_at->gt($u->updated_at) ? $u->last_verified_at : $u->updated_at;
            $daysAgo = $effective->diffInDays(now());
            $ageClass = $daysAgo >= $staleDays6 ? 'pr-pill-red' : 'pr-pill-amber';
        @endphp
        <div class="pr-card-row">
            <div class="pr-card-row-top">
                <div class="pr-row-flex">
                    <input type="checkbox" class="pr-checkbox pr-row-check" value="{{ $u->id }}">
                    <p class="pr-program-name">{{ $u->university_name ?: 'Name missing' }}</p>
                </div>
                <div class="pr-actions">
                    <a href="{{ route('edit-university', $u->id) }}" class="pr-icon-btn" data-tooltip="Update"><i class="la la-pen"></i></a>
                    <button type="button" class="pr-icon-btn pr-mark-verified" data-id="{{ $u->id }}" data-tooltip="Mark as verified"><i class="la la-check"></i></button>
                </div>
            </div>
            <div class="pr-card-row-field"><span class="pr-label">Last updated</span><span class="pr-pill {{ $ageClass }}">{{ $daysAgo }} days ago</span></div>
            <div class="pr-card-row-field"><span class="pr-label">By</span><span>{{ $u->lastUpdatedBy->name ?? '-' }}</span></div>
        </div>
        @empty
        <p style="text-align:center;color:var(--pr-text-muted);">Nothing needs updating right now.</p>
        @endforelse
    </div>

    <div class="pr-table-footer">
        <span class="pr-showing">Showing {{ $universities->firstItem() ?? 0 }}&ndash;{{ $universities->lastItem() ?? 0 }} of {{ number_format($universities->total()) }}</span>
        <div class="pr-pagination">{{ $universities->withQueryString()->links() }}</div>
    </div>
</div>
