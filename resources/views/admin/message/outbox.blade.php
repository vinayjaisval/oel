@extends('admin.include.app')

@section('style')
<style>
    .offcanvas.offcanvas-end{
        width: 35vw !important;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .custom-table {
        min-width: 800px;
    }

    .custom-table td {
        vertical-align: top;
    }

    /* Checkbox column */
    .custom-table th:first-child,
    .custom-table td:first-child {
        width: 60px;
        text-align: center;
    }

    /* Message preview */
    .message-box {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        color: #007bff;
    }

    .message-box:hover {
        text-decoration: underline;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css" rel="stylesheet">
@endsection


@section('main-content')

<div class="row">
    <div class="card card-buttons">
        <div class="card-body">
            <ol class="breadcrumb text-muted mb-0">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item text-muted">Outbox</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="col-md-12">
        <div class="table-responsive">

            <table class="table table-striped custom-table mb-0">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="checked_all_lead">
                            <button class="btn btn-warning btn-sm delete-message">
                                <i class="fa fa-trash"></i>
                            </button>
                        </th>
                        <th>S.N</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $i = ($outbox->currentPage()-1)* $outbox->perPage()+1;
                    @endphp

                    @foreach ($outbox as $data)
                    <tr id="row-{{ $data->id }}">
                        <td>
                            <input type="checkbox" class="lead-id" value="{{ $data->id }}">
                        </td>

                        <td>{{ $i }}</td>
                        @php $i++; @endphp

                        <td>{{ $data->email }}</td>
                        <td>{{ $data->subject }}</td>

                        <!-- CLICKABLE MESSAGE -->
                        <td>
                            <div class="message-box view-message"
                                data-email="{{ $data->email }}"
                                data-subject="{{ $data->subject }}"
                                data-id="{{ $data->id }}">

                                {{ \Illuminate\Support\Str::limit(strip_tags($data->body), 10) }}
                            </div>

                            <!-- Hidden full HTML -->
                            <div id="full-message-{{ $data->id }}" style="display:none;">
                                {!! $data->body !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $outbox->links() }}
            </div>

        </div>
    </div>
</div>

<!-- ✅ MODAL -->
<!-- MESSAGE MODAL -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Message Details</h5>

                <!-- ✅ FIXED CLOSE BUTTON -->
                <button type="button" class="close close-modal-btn">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                <p><strong>Subject:</strong> <span id="modalSubject"></span></p>
                <hr>
                <div id="modalMessage"></div>
            </div>

        </div>
    </div>
</div>

@endsection


@section('scripts')

<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function () {

    // ✅ OPEN MODAL
    $(document).on('click', '.view-message', function () {

        let email = $(this).data('email');
        let subject = $(this).data('subject');
        let id = $(this).data('id');

        let message = $('#full-message-' + id).html();

        $('#modalEmail').text(email);
        $('#modalSubject').text(subject);
        $('#modalMessage').html(message);

        $('#messageModal').modal('show');
    });

    // ✅ CLOSE BUTTON FIX
    $(document).on('click', '.close-modal-btn', function () {
        $('#messageModal').modal('hide');
    });

    // ✅ CLICK OUTSIDE CLOSE
    $('#messageModal').on('click', function (e) {
        if ($(e.target).hasClass('modal')) {
            $('#messageModal').modal('hide');
        }
    });

});
</script>
<script>
$(document).ready(function () {

    // ✅ CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ✅ Select All
    $(document).on('change', '.checked_all_lead', function () {
        $('.lead-id').prop('checked', $(this).prop('checked'));
    });

    // ✅ Sync individual
    $(document).on('change', '.lead-id', function () {
        $('.checked_all_lead').prop(
            'checked',
            $('.lead-id:checked').length === $('.lead-id').length
        );
    });

  $(document).on('click', '.view-message', function () {

    let email = $(this).data('email');
    let subject = $(this).data('subject');
    let id = $(this).data('id');

    let message = $('#full-message-' + id).html();

    $('#modalEmail').text(email);
    $('#modalSubject').text(subject);
    $('#modalMessage').html(message);

    $('#messageModal').modal('show');
});
    // ✅ DELETE
    $('.delete-message').click(function () {

        let selected = [];

        $('.lead-id:checked').each(function () {
            selected.push($(this).val());
        });

        if (selected.length === 0) {
            Swal.fire('Warning', 'Please select at least one message', 'warning');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.post("{{ route('delete-sms') }}", { leadIds: selected }, function (res) {

                    if (!res.status) {
                        Swal.fire('Error', res.message, 'error');
                    } else {

                        selected.forEach(id => {
                            $('#row-' + id).remove();
                        });

                        Swal.fire('Deleted!', res.message, 'success');
                    }

                }).fail(function () {
                    Swal.fire('Error', 'Something went wrong', 'error');
                });
            }
        });
    });

});
</script>

@endsection