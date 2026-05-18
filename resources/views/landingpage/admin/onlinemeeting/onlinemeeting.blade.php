@extends('admin.include.app')
@section('main-content')

<style>

    *{
        box-sizing:border-box;
    }

    .heading{
        font-size:30px;
        font-weight:700;
        margin-bottom:25px;
        color:#1e293b;
    }

    .card{
        background:#fff;
        border-radius:18px;
        padding:20px;
        box-shadow:0 5px 20px rgba(0,0,0,.05);
        overflow-x:auto;
    }

    .top-filter{
        display:flex;
        flex-wrap:wrap;
        gap:15px;
        margin-bottom:20px;
        align-items:center;
    }

    .search-input{
        flex:1;
        min-width:220px;
        height:45px;
        border:1px solid #dbe2ea;
        border-radius:10px;
        padding:0 15px;
        font-size:14px;
        outline:none;
    }

    .search-input:focus{
        border-color:#2563eb;
    }

    .btn{
        border:none;
        padding:10px 16px;
        border-radius:10px;
        cursor:pointer;
        font-size:13px;
        font-weight:600;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        gap:6px;
        color:#fff;
        white-space:nowrap;
    }

    .btn-primary{
        background:#2563eb;
    }

    .btn-danger{
        background:#dc2626;
    }

    .btn-success{
        background:#16a34a;
    }

    .btn-warning{
        background:#f59e0b;
    }

    .btn-secondary{
        background:#64748b;
    }

    table{
        width:100%;
        border-collapse:collapse;
        min-width:1400px;
    }

    table thead th{
        background:#2563eb;
        color:#fff;
        padding:14px;
        text-align:left;
        font-size:13px;
        font-weight:700;
        white-space:nowrap;
    }

    table tbody td{
        padding:14px;
        border-bottom:1px solid #edf2f7;
        font-size:14px;
        vertical-align:middle;
        white-space:nowrap;
    }

    table tbody tr:hover{
        background:#f8fafc;
    }

    .badge{
        padding:6px 12px;
        border-radius:50px;
        color:#fff;
        font-size:12px;
        font-weight:700;
    }

    .scheduled{
        background:#16a34a;
    }

    .rescheduled{
        background:#ea580c;
    }

    .completed{
        background:#4338ca;
    }

    .cancelled{
        background:#dc2626;
    }

    .action-group{
        display:flex;
        align-items:center;
        gap:10px;
        flex-wrap:nowrap;
    }

    .inline-form{
        display:flex;
        align-items:center;
        gap:8px;
        margin:0;
        flex-wrap:nowrap;
    }

    .inline-form select,
    .inline-form input{
        height:38px;
        border:1px solid #dbe2ea;
        border-radius:8px;
        padding:0 10px;
        font-size:13px;
        outline:none;
    }

    .inline-form select{
        width:130px;
    }

    .inline-form input[type="date"]{
        width:140px;
    }

    .inline-form input[type="text"]{
        width:120px;
    }

    .inline-form button{
        height:38px;
        padding:0 12px;
    }

    .alert{
        padding:14px 18px;
        border-radius:10px;
        margin-bottom:20px;
        font-weight:600;
    }

    .alert-success{
        background:#dcfce7;
        color:#166534;
    }

    .alert-danger{
        background:#fee2e2;
        color:#991b1b;
    }

    @media(max-width:1200px){

        .card{
            overflow-x:auto;
        }

        table{
            min-width:1400px;
        }

    }

</style>

<form method="GET" action="{{ url()->current() }}">

    <div class="top-filter">

        <input type="text"
               name="name"
               value="{{ request('name') }}"
               placeholder="Search Name"
               class="search-input">

        <input type="text"
               name="email"
               value="{{ request('email') }}"
               placeholder="Search Email"
               class="search-input">

        <input type="text"
               name="phone"
               value="{{ request('phone') }}"
               placeholder="Search Mobile"
               class="search-input">

        <input type="date"
               name="date"
               value="{{ request('date') }}"
               class="search-input">

        <button class="btn btn-primary">
            <i class="fa fa-search"></i>
            Search
        </button>

        <a href="{{ url()->current() }}"
           class="btn btn-danger">

            Reset

        </a>

    </div>

</form>

<div class="heading">
    Meeting Bookings
</div>

@if(session('success'))

<div class="alert alert-success">
    {{ session('success') }}
</div>

@endif

@if(session('error'))

<div class="alert alert-danger">
    {{ session('error') }}
</div>

@endif

<div class="card">

    <table>

        <thead>

            <tr>

                <th>ID</th>

                <th>Student</th>

                <th>Email</th>

                <th>Phone</th>

                <th>Date</th>

                <th>Time</th>

                <th>Status</th>

                <th>Actions</th>

            </tr>

        </thead>

        <tbody>

            @forelse($bookings as $booking)

            <tr>

                <td>#{{ $booking->id }}</td>

                <td>{{ $booking->name }}</td>

                <td>{{ $booking->email }}</td>

                <td>{{ $booking->phone }}</td>

                <td>{{ $booking->date }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}
                </td>

                <td>

                    <span class="badge {{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </span>

                </td>

                <td>

                    <div class="action-group">

                        @if($booking->meeting_link)

                        <a href="{{ route('join.meeting', $booking->id) }}"
                           target="_blank"
                           class="btn btn-success">

                            <i class="fa fa-video"></i>
                            Join

                        </a>

                        @endif

                        <a href="{{ route('send.reminder', $booking->id) }}"
                           class="btn btn-primary">

                            <i class="fa fa-bell"></i>
                            Reminder

                        </a>

                        <form action="{{ route('update.booking.status', $booking->id) }}"
                              method="POST"
                              class="inline-form">

                            @csrf

                            <select name="status" required>

                                <option value="scheduled"
                                    {{ $booking->status == 'scheduled' ? 'selected' : '' }}>
                                    Scheduled
                                </option>

                                <option value="rescheduled"
                                    {{ $booking->status == 'rescheduled' ? 'selected' : '' }}>
                                    Rescheduled
                                </option>

                                <option value="completed"
                                    {{ $booking->status == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>

                                <option value="cancelled"
                                    {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>

                            </select>

                            <button type="submit"
                                    class="btn btn-secondary">

                                <i class="fa fa-check"></i>

                            </button>

                        </form>

                        <form action="{{ route('reschedule.meeting', $booking->id) }}"
                              method="POST"
                              class="inline-form">

                            @csrf

                            <input type="date"
                                   name="date"
                                   required>

                            <input type="text"
                                   name="time"
                                   placeholder="02:30 PM"
                                   required>

                            <button type="submit"
                                    class="btn btn-warning">

                                <i class="fa fa-calendar"></i>

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8"
                    style="text-align:center;padding:40px;">

                    No Bookings Found

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

    <div style="margin-top:20px;">

        {{ $bookings->appends(request()->query())->links() }}

    </div>

</div>

@endsection