@extends('admin.include.app')
@section('main-content')
<div class="row">
    <div class="card card-buttons">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb text-muted mb-0">
                        <li class="breadcrumb-item">
                            <a href=""> Home</a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            IELTS Course Enquiries
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Reference</th>
                        <th>Name</th>
                        <th>Email Id</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Course Plan</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Payment Date</th>
                        <th>Submitted At</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                     @php
                        $i = ($courseEnquiries->currentPage()-1)* $courseEnquiries->perPage()+1;
                    @endphp
                    @if ($courseEnquiries->count() > 0)
                    @foreach ($courseEnquiries as $item)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $item->enquiry_reference }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->city }}</td>
                            <td>{{ $item->plan_name }}</td>
                            <td>{{ $item->currency }} {{ number_format($item->amount, 2) }}</td>
                            <td>{{ ucfirst($item->payment_status) }}{{ $item->payment_verified ? ' (Verified)' : '' }}</td>
                            <td>{{ $item->payment_date ?? '-' }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td class="text-nowrap">
                                <a title="Delete" href="{{ route('ielts-course.delete', [$item->id]) }}" class="btn btn-warning btn-sm content-icon">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    @else
                        <tr>
                            <td colspan="11">Data Not Found!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="dataTables_paginate paging_simple_numbers" id="pagination">
                        {{$courseEnquiries->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

