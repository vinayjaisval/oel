@extends('admin.include.app')
@section('style')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css" rel="stylesheet">
<link href="{{ asset('assets/css/program-redesign.css') }}" rel="stylesheet">
@endsection
@section('main-content')
<div class="pr-page">

    <div class="pr-header">
        <div>
            <h1 class="pr-title">Programs / Courses</h1>
            <ol class="pr-breadcrumb" style="list-style:none;display:flex;gap:0.35rem;padding:0;margin:0.2rem 0 0;">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li>/</li>
                <li>Manage Program</li>
            </ol>
        </div>
        @can('programs.create')
        <a href="{{ route('add-program') }}" class="pr-btn pr-btn-primary">+ Add Program</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="pr-stats">
        <div class="pr-card pr-stat-card">
            <p class="pr-stat-label">Total Programs</p>
            <p class="pr-stat-value">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="pr-card pr-stat-card">
            <p class="pr-stat-label">Approved</p>
            <p class="pr-stat-value pr-green">{{ number_format($stats['approved']) }}</p>
        </div>
        <div class="pr-card pr-stat-card">
            <p class="pr-stat-label">Pending Approval</p>
            <p class="pr-stat-value pr-amber">{{ number_format($stats['pending']) }}</p>
        </div>
        <div class="pr-card pr-stat-card">
            <p class="pr-stat-label">With Scholarship</p>
            <p class="pr-stat-value pr-blue">{{ number_format($stats['with_scholarship']) }}</p>
        </div>
    </div>

    <div class="pr-card pr-filter-card">
        <form id="program_filter" action="{{ route('program-filter') }}" method="get">
            <div class="pr-filter-grid">
                <div class="pr-field">
                    <label for="program_name">Program name</label>
                    <div class="pr-input-icon">
                        <i class="la la-search pr-icon"></i>
                        <input type="text" class="pr-input" name="program_name" id="program_name" placeholder="e.g. MBA" value="{{ request('program_name') }}">
                    </div>
                </div>
                <div class="pr-field">
                    <label for="university_name">University name</label>
                    <div class="pr-input-icon">
                        <i class="la la-search pr-icon"></i>
                        <input type="text" class="pr-input" name="univerisity_name" id="university_name" placeholder="e.g. FOM Hochschule" value="{{ request('univerisity_name') }}">
                    </div>
                </div>
                <div class="pr-field">
                    <label for="approve">Approval</label>
                    <select name="approve_status" class="pr-select" id="approve">
                        <option value="" {{ request('approve_status') ? '' : 'selected' }}>All</option>
                        <option value="approve" {{ request('approve_status') == 'approve' ? 'selected' : '' }}>Approve</option>
                        <option value="unapprove" {{ request('approve_status') == 'unapprove' ? 'selected' : '' }}>UnApprove</option>
                        <option value="unapprove_including_null" {{ request('approve_status') == 'unapprove_including_null' ? 'selected' : '' }}>Unapproved (including unset)</option>
                    </select>
                </div>
                <div class="pr-field">
                    <label for="user_id">Added by</label>
                    <select name="user_id" class="pr-select" id="user_id">
                        <option value="">All users</option>
                        @if(request('user_id') && !$users->contains('id', request('user_id')) && (string) request('user_id') === (string) auth()->id())
                        <option value="{{ auth()->id() }}" selected>Me</option>
                        @endif
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pr-field">
                    <label for="from_date">From date</label>
                    <input type="date" class="pr-input" name="from_date" id="from_date" value="{{ request('from_date') }}">
                </div>
                <div class="pr-field">
                    <label for="to_date">To date</label>
                    <input type="date" class="pr-input" name="to_date" id="to_date" value="{{ request('to_date') }}">
                </div>
                <div class="pr-filter-actions">
                    <a href="{{ route('manage-program') }}" class="pr-btn pr-btn-outline">Reset</a>
                    <button type="submit" class="pr-btn pr-btn-primary">Apply filters</button>
                </div>
            </div>
        </form>
    </div>

    <div class="pr-card pr-table-card">
        <div class="pr-table-head">
            <h2 class="pr-table-title">All Programs</h2>
            <span class="pr-badge-count">{{ number_format($program->total()) }}</span>
        </div>
        <div class="pr-table-scroll">
            <table class="pr-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Program</th>
                        <th>University</th>
                        <th>Level</th>
                        <th>Scholarship</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse ($program as $item)
                    @php
                        $levelName = $item->programLevel->name ?? null;
                        $levelClass = $levelName === 'Postgraduate' ? 'pr-pill-purple' : ($levelName === 'Undergraduate' ? 'pr-pill-blue' : 'pr-pill-gray');
                        $intakeLabel = $item->intake ? date('M', mktime(0, 0, 0, (int) $item->intake, 1)) : null;
                    @endphp
                    <tr>
                        <td>{{ $loop->index + (($program->currentPage() - 1) * $program->perPage()) + 1 }}</td>
                        <td>
                            <p class="pr-program-name">{{ implode(' ', array_slice(explode(' ', $item->name), 0, 8)) }}</p>
                            @if($item->length || $intakeLabel)
                            <p class="pr-program-sub">{{ $item->length }}@if($item->length && $intakeLabel) &middot; @endif{{ $intakeLabel }}{{ $intakeLabel && $item->year ? ' '.$item->year : '' }}</p>
                            @endif
                        </td>
                        <td>{{ $item->school->university_name ?? '-' }}</td>
                        <td><span class="pr-pill {{ $levelClass }}">{{ $levelName ?? '-' }}</span></td>
                        <td>
                            @if($item->scholarship_available && $item->scholarship_amount)
                                <span class="pr-pill pr-pill-green">{{ $item->scholarship_currency }} {{ number_format($item->scholarship_amount) }}</span>
                            @else
                                <span class="pr-pill pr-pill-gray">No</span>
                            @endif
                        </td>
                        <td>
                            <div class="pr-status-cell">
                                <label class="pr-switch">
                                    <input type="checkbox" class="toggle-status" data-id="{{ $item->id }}" {{ $item->is_approved ? 'checked' : '' }}>
                                    <span class="pr-switch-slider"></span>
                                </label>
                                <span class="pr-status-text {{ $item->is_approved ? 'pr-approved' : 'pr-pending' }}">{{ $item->is_approved ? 'Approved' : 'Pending' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="pr-actions">
                                <a href="{{ route('edit-score-program', $item->id) }}" class="pr-icon-btn" data-tooltip="Score"><i class="la la-star"></i></a>
                                <a href="javascript:void(0)" class="pr-icon-btn commission_modal" data-tooltip="Commission" program-id="{{ $item->id }}" data-bs-toggle="offcanvas" data-bs-target="#testscrores" aria-controls="testscrores"><i class="la la-dollar-sign"></i></a>
                                @can('programs.update')
                                <a href="{{ route('edit-program', $item->id) }}" class="pr-icon-btn" data-tooltip="Edit"><i class="la la-pen"></i></a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--pr-text-muted);">No programs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pr-table-footer">
            <span class="pr-showing">Showing {{ $program->firstItem() ?? 0 }}&ndash;{{ $program->lastItem() ?? 0 }} of {{ number_format($program->total()) }}</span>
            <div class="pr-pagination">{{ $program->withQueryString()->links() }}</div>
        </div>
    </div>

    {{-- commission offcanvas (unchanged behaviour) --}}
    <div class="offcanvas offcanvas-end border-0 " tabindex="-1" id="testscrores">
        <div class="sidebar-headerset" style="  box-shadow: 0 1.6rem 3rem rgba(0,0,0,.1);">
            <div class="sidebar-headersets">
                <h5>Program Commission</h5>
            </div>
            <div class="sidebar-headerclose">
                <a data-bs-dismiss="offcanvas" aria-label="Close">
                    <img src="{{ url('assets/img/close.png') }}" alt="Close Icon">
                </a>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="responseMessage"></div>
            <div class="row">
                <div class="card-stretch-full">
                    <div class="row g-4">
                        <form class="row g-4" id="commission-data">
                            <input type="hidden" name="program_commission_id">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="usr-commission" name="commission" type="number" class="form-control commission" placeholder="Program Commission (In Percentage)" autocomplete="commission">
                                    <label for="usr-commission" class="form-label">Program Commission (In Percentage)</label>
                                    <span class="text-danger error-commission"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="usr-commission_for_program_payment_to_franchise" name="commission_for_program_payment_to_franchise" type="number" class="form-control commission_for_program_payment_to_franchise" placeholder="Commission to Franchise when student pays (In Percentage)" autocomplete="commission_for_program_payment_to_franchise"><label for="usr-commission_for_program_payment_to_franchise" class="form-label">Commission to Franchise when student pays (In Percentage)</label>
                                    <span class="text-danger error-commission_for_program_payment_to_franchise"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="usr-commission_for_added_program_payment_to_franchise" name="commission_for_added_program_payment_to_franchise" type="number" class="form-control commission_for_added_program_payment_to_franchise" placeholder="Commission to Franchise for Program/University added (In Percentage)" autocomplete="commission_for_added_program_payment_to_franchise"><label for="usr-commission_for_added_program_payment_to_franchise" class="form-label">Commission to Franchise for Program/University added (In Percentage)</label>
                                    <span class="text-danger error-commission_for_added_program_payment_to_franchise"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="usr-commission_for_program_payment_to_counselor" name="commission_for_program_payment_to_counselor" type="number" class="form-control commission_for_program_payment_to_counselor" placeholder="Commission to Counselor for Program/University added (In Percentage)" autocomplete="commission_for_program_payment_to_counselor"><label for="usr-commission_for_program_payment_to_counselor" class="form-label">Commission to Counselor for Program/University added (In Percentage)</label>
                                    <span class="text-danger error-commission_for_program_payment_to_counselor"></span>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12"><button type="button" class="btn btn-info py-6 commission">Submit</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {
    function setupCSRF() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    }
    setupCSRF();

    $('.commission_modal').on('click', function(event) {
        $('#commission-data')[0].reset();
        var program_id = $(this).attr('program-id');
        $('input[name="program_commission_id"]').val(program_id);
        $.ajax({
            url: '{{ route('get-program-commission') }}',
            type: 'post',
            data: { program_id: program_id },
            success: function(response) {
                $('.commission').val(response.data.commission);
                $('.commission_for_program_payment_to_franchise').val(response.data.commission_for_program_payment_to_franchise);
                $('.commission_for_added_program_payment_to_franchise').val(response.data.commission_for_added_program_payment_to_franchise);
                $('.commission_for_program_payment_to_counselor').val(response.data.commission_for_program_payment_to_counselor);
            },
        });
    });

    $('.commission').on('click', function(event) {
        event.preventDefault();
        $('.commission').addClass('disabled');
        var program_id = $('input[name="program_commission_id"]').val();
        var formData = $('#commission-data').serialize();
        formData += '&program_id=' + program_id;
        $.ajax({
            url: '{{ route('update-program-commission') }}',
            type: 'post',
            data: formData,
            success: function(response) {
                if (response.status) {
                    Swal.fire({ icon: 'success', title: 'Success...', text: response.success }).then((result) => {
                        if (result.value) { setTimeout(function() { location.reload(); }, 100); }
                    });
                }
                $('.commission').removeClass('disabled');
                $('#commission-data')[0].reset();
            },
            error: function(xhr) {
                var response = JSON.parse(xhr.responseText);
                $('.error-commission').html(response.errors && response.errors.type ? response.errors.type : '');
                $('.error-commission_for_program_payment_to_franchise').html(response.errors && response.errors.listening_score ? response.errors.listening_score : '');
                $('.error-commission_for_added_program_payment_to_franchise').html(response.errors && response.errors.writing_score ? response.errors.writing_score : '');
                $('.error-commission_for_program_payment_to_counselor').html(response.errors && response.errors.reading_score ? response.errors.reading_score : '');
            }
        });
    });

    // Approve toggle: optimistic UI, reverts without reload if the save fails
    $(document).on('change', '.toggle-status', function() {
        var $checkbox = $(this);
        var $row = $checkbox.closest('tr');
        var $label = $row.find('.pr-status-text');
        var id = $checkbox.data('id');
        var status = $checkbox.is(':checked') ? 1 : 0;
        var previous = status ? 0 : 1;

        $checkbox.prop('disabled', true);

        $.ajax({
            url: "{{ route('toggle.approval') }}",
            type: "POST",
            data: { id: id, status: status },
            success: function(response) {
                $label.text(status ? 'Approved' : 'Pending').toggleClass('pr-approved', !!status).toggleClass('pr-pending', !status);
            },
            error: function() {
                $checkbox.prop('checked', previous === 1);
                Swal.fire({ icon: 'error', title: 'Could not update status', text: 'Please try again.' });
            },
            complete: function() {
                $checkbox.prop('disabled', false);
            }
        });
    });

    // Debounce free-text filters so they don't fire a request per keystroke
    var debounceTimer;
    $('#program_name, #university_name').on('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function() {
            $('#program_filter').trigger('submit');
        }, 500);
    });
});
</script>
@endsection
