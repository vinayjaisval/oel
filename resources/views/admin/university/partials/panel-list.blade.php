@php
    $bulkLabel = $tabKey === 'approved' ? 'Unapprove selected' : 'Approve selected';
    $bulkStatus = $tabKey === 'approved' ? 0 : 1;
    $bulkBtnClass = $tabKey === 'approved' ? 'pr-btn-danger-outline' : 'pr-btn-success';
@endphp
<form class="pr-panel-filter-form" data-tab="{{ $tabKey }}">
    <div class="pr-card pr-filter-card">
        <div class="pr-filter-grid">
            <div class="pr-field">
                <label>University name</label>
                <div class="pr-input-icon">
                    <i class="la la-search pr-icon"></i>
                    <input type="text" class="pr-input" name="university_name" placeholder="e.g. FOM Hochschule" value="{{ request('university_name') }}">
                </div>
            </div>
            <div class="pr-field">
                <label>Country</label>
                <select class="pr-select" name="country">
                    <option value="">All countries</option>
                    @foreach($countries as $c)
                    <option value="{{ $c->id }}" {{ request('country') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="pr-field">
                <label>Active status</label>
                <select class="pr-select" name="status">
                    <option value="">All</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="pr-field">
                <label>University type</label>
                <select class="pr-select" name="type">
                    <option value="">All types</option>
                    @foreach($types as $t)
                    <option value="{{ $t->id }}" {{ request('type') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="pr-field">
                <label>From date</label>
                <input type="date" class="pr-input" name="from_date" value="{{ request('from_date') }}">
            </div>
            <div class="pr-field">
                <label>To date</label>
                <input type="date" class="pr-input" name="to_date" value="{{ request('to_date') }}">
            </div>
            <div class="pr-filter-actions">
                <button type="button" class="pr-btn pr-btn-outline pr-panel-reset">Reset</button>
                <button type="submit" class="pr-btn pr-btn-primary">Apply filters</button>
            </div>
        </div>
    </div>
</form>

<div class="pr-bulk-bar" style="display:none;" data-bulk-bar>
    <span class="pr-bulk-bar-label"><span data-bulk-count>0</span> selected</span>
    <div class="pr-bulk-bar-actions">
        <button type="button" class="pr-btn {{ $bulkBtnClass }} pr-bulk-approve" data-status="{{ $bulkStatus }}">{{ $bulkLabel }}</button>
        <button type="button" class="pr-btn pr-btn-outline pr-bulk-clear">Clear</button>
    </div>
</div>

<div class="pr-card pr-table-card">
    <div class="pr-table-head">
        <h2 class="pr-table-title">{{ ['all' => 'All Universities', 'approved' => 'Approved Universities', 'unapproved' => 'Unapproved Universities'][$tabKey] }}</h2>
        <span class="pr-badge-count">{{ number_format($universities->total()) }}</span>
    </div>
    <div class="pr-table-scroll">
        <table class="pr-table">
            <thead>
                <tr>
                    <th class="pr-checkbox-col"><input type="checkbox" class="pr-checkbox" data-select-all></th>
                    <th>University</th>
                    <th>Location</th>
                    <th>Active</th>
                    <th>Approval</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($universities as $u)
                @php
                    $isEmpty = empty(trim((string) $u->university_name));
                    $initials = $isEmpty ? '?' : strtoupper(substr(trim($u->university_name), 0, 1));
                @endphp
                <tr data-university-row="{{ $u->id }}">
                    <td><input type="checkbox" class="pr-checkbox pr-row-check" value="{{ $u->id }}"></td>
                    <td>
                        <div class="pr-row-flex">
                            <span class="pr-avatar-square">{{ $initials }}</span>
                            <div>
                                @if($isEmpty)
                                <p class="pr-incomplete-name"><i class="la la-exclamation-circle"></i> Name missing</p>
                                <p class="pr-incomplete-sub">Incomplete record &ndash; edit to fix</p>
                                @else
                                <p class="pr-program-name">{{ $u->university_name }}</p>
                                <p class="pr-program-sub">{{ $u->university_type->name ?? '-' }} &middot; {{ $u->city ?? '-' }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        {{ $u->country->name ?? '-' }}
                        @if($u->province->name ?? null)
                        <p class="pr-program-sub">{{ $u->province->name }}</p>
                        @endif
                    </td>
                    <td>
                        @if($u->status == 1)
                        <span class="pr-pill pr-pill-green">&#9679; Active</span>
                        @else
                        <span class="pr-pill pr-pill-gray">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="pr-status-cell">
                            <label class="pr-switch">
                                <input type="checkbox" class="toggle-university-approval" data-id="{{ $u->id }}" {{ $u->is_approved ? 'checked' : '' }}>
                                <span class="pr-switch-slider"></span>
                            </label>
                            <span class="pr-status-text {{ $u->is_approved ? 'pr-approved' : 'pr-pending' }}">{{ $u->is_approved ? 'Approved' : 'Pending' }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="pr-actions">
                            <a href="{{ route('view-university', [\Illuminate\Support\Str::slug($u->university_name ?: 'university') . '-' . $u->id]) }}" class="pr-icon-btn" data-tooltip="View" target="_blank"><i class="la la-eye"></i></a>
                            @can('universities.update')
                            <a href="{{ route('edit-university', $u->id) }}" class="pr-icon-btn" data-tooltip="Edit"><i class="la la-pen"></i></a>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--pr-text-muted);">No universities found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pr-mobile-cards">
        @forelse($universities as $u)
        @php $isEmpty = empty(trim((string) $u->university_name)); @endphp
        <div class="pr-card-row">
            <div class="pr-card-row-top">
                <div class="pr-row-flex">
                    <input type="checkbox" class="pr-checkbox pr-row-check" value="{{ $u->id }}">
                    <span class="pr-avatar-square">{{ $isEmpty ? '?' : strtoupper(substr(trim($u->university_name),0,1)) }}</span>
                    <div>
                        @if($isEmpty)
                        <p class="pr-incomplete-name"><i class="la la-exclamation-circle"></i> Name missing</p>
                        @else
                        <p class="pr-program-name">{{ $u->university_name }}</p>
                        @endif
                    </div>
                </div>
                @can('universities.update')
                <a href="{{ route('edit-university', $u->id) }}" class="pr-icon-btn" data-tooltip="Edit"><i class="la la-pen"></i></a>
                @endcan
            </div>
            <div class="pr-card-row-field"><span class="pr-label">Location</span><span>{{ $u->country->name ?? '-' }}</span></div>
            <div class="pr-card-row-field"><span class="pr-label">Active</span><span>{{ $u->status == 1 ? 'Active' : 'Inactive' }}</span></div>
            <div class="pr-card-row-field">
                <span class="pr-label">Approval</span>
                <label class="pr-switch">
                    <input type="checkbox" class="toggle-university-approval" data-id="{{ $u->id }}" {{ $u->is_approved ? 'checked' : '' }}>
                    <span class="pr-switch-slider"></span>
                </label>
            </div>
        </div>
        @empty
        <p style="text-align:center;color:var(--pr-text-muted);">No universities found.</p>
        @endforelse
    </div>

    <div class="pr-table-footer">
        <span class="pr-showing">Showing {{ $universities->firstItem() ?? 0 }}&ndash;{{ $universities->lastItem() ?? 0 }} of {{ number_format($universities->total()) }}</span>
        <div class="pr-pagination">{{ $universities->withQueryString()->links() }}</div>
    </div>
</div>
