@extends('admin.include.app')
@section('main-content')

<div class="row">
    <div class="card card-buttons">
        <div class="card-body">
            <ol class="breadcrumb text-muted mb-0">
                <li class="breadcrumb-item"><a href="">Student Invoice</a></li>
            </ol>
        </div>
    </div>
</div>
<br>

{{-- ======================== SEARCH FILTER ======================== --}}
<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('student-review') }}" method="GET">
                <div class="row">

                    <div class="col-md-3">
                        <input type="text" name="first_name" class="form-control"
                               placeholder="Student Name" value="{{ request()->first_name }}">
                    </div>

                    <div class="col-md-3">
                        <input type="email" name="email" class="form-control"
                               placeholder="Student Email" value="{{ request()->email }}">
                    </div>

                    <div class="col-md-3">
                        <input type="text" name="phone_number" class="form-control"
                               placeholder="Phone" value="{{ request()->phone_number }}">
                    </div>

                    <div class="col-md-3">
                        <input type="date" name="day" class="form-control"
                               value="{{ request()->day }}">
                    </div>

                    <div class="col-md-3 mt-2">
                        <input type="month" name="month" class="form-control"
                               value="{{ request()->month }}">
                    </div>

                    <div class="col-md-3 mt-2">
                        <input type="number" name="year" class="form-control"
                               placeholder="Year"
                               value="{{ request()->year }}">
                    </div>

                    <div class="col-md-1 mt-2">
                        <button class="btn btn-info w-100">
                            Filter
                        </button>
                    </div>

                    <div class="col-md-1 mt-2">
                        <a href="{{ route('student-review') }}" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<br>

@if(request()->day || request()->month || request()->year)
<div class="row">

    {{-- MONTHLY --}}
    @if($monthlyTotal->count())
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">Monthly</div>
            <div class="card-body">
                @foreach($monthlyTotal as $m)
                    <p>{{ \Carbon\Carbon::parse($m->month.'-01')->format('F Y') }} :
                        ₹ {{ number_format($m->total,2) }}</p>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- DAILY --}}
    @if($dailyTotal->count())
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">Daily</div>
            <div class="card-body">
                @foreach($dailyTotal as $d)
                    <p>{{ \Carbon\Carbon::parse($d->day)->format('d M Y') }} :
                        ₹ {{ number_format($d->total,2) }}</p>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- YEARLY --}}
    @if($yearlyTotal->count())
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-dark text-white">Yearly</div>
            <div class="card-body">
                @foreach($yearlyTotal as $y)
                    <p>{{ $y->year }} :
                        ₹ {{ number_format($y->total,2) }}</p>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>
@endif


<br>

{{-- ======================== STUDENT TABLE ======================== --}}
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>P Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                       
                        @can('student_amount.view')
                        <th>View</th>
                        {{--<th>Invoice</th>--}}
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($students->currentPage()-1)*$students->perPage() }}</td>
                        <td>{{ $item->payment_date }}</td>
                         <td><a href="{{ route('view-student-reviews',$item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone_number }}</td>
                        
                        @can('student_amount.view')
                        {{--<td><a href="{{ route('view-student-reviews',$item->id) }}" class="btn btn-info"><i class="fa-solid fa-eye"></i></a></td>--}}
                        <td><a href="{{ route('view-student-invoice',$item->id) }}" class="btn "><i class="fa-solid fa-eye"></i></a></td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    {{ $students->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
