@extends('admin.include.app')
@section('main-content')

<style>
  
  

    .heading {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #1e293b;
    }

    .card {
        background: #fff;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th {
        background: #226cf5;
        color: #fff;
        padding: 15px;
        text-align: left;
        font-size: 14px;
    }

    table td {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
        vertical-align: top;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 30px;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        display: inline-block;
    }

    .scheduled {
        background: #16a34a;
    }

    .rescheduled {
        background: #ea580c;
    }

    .cancelled {
        background: #dc2626;
    }

    .completed {
        background: #4338ca;
    }

    .btn {
        border: none;
        padding: 10px 16px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-block;
        margin: 3px;
    }

    .btn-secondary {
        background: #64748b;
        color: #fff;
    }

    .status-box,
    .reschedule-box {
        background: #f8fafc;
        padding: 15px;
        border-radius: 12px;
        margin-top: 10px;
        border: 1px solid #e2e8f0;
    }

    .actions-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .inline-form {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        margin: 0;
    }

    .inline-form select,
    .inline-form input {
        width: auto;
        min-width: 120px;
        height: 40px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 8px;
        font-size: 14px;
        background: #fff;
    }

    .inline-form button {
        height: 40px;
        padding: 0 14px;
        margin: 0;
    }

    .btn-secondary {
        background: #64748b;
        color: #fff;
    }

    .btn-success {
        background: #16a34a;
        color: #fff;
    }

    .btn-danger {
        background: #dc2626;
        color: #fff;
    }

    .btn-warning {
        background: #f59e0b;
        color: #fff;
    }

    .btn-primary {
        background: #2563eb;
        color: #fff;
    }

    .btn-info {
        background: #0891b2;
        color: #fff;
    }

    .reschedule-box {
        background: #f8fafc;
        padding: 15px;
        border-radius: 12px;
        margin-top: 10px;
        border: 1px solid #e2e8f0;
    }

    .reschedule-box input {
        width: 100%;
        height: 45px;
        margin-bottom: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px;
    }

    .alert {
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    @media(max-width:1100px) {

        table {
            display: block;
            overflow: auto;
        }
    }

    .search-input {
        width: 100%;
        height: 45px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 15px;
        outline: none;
        font-size: 14px;
        background: #fff;
    }

    .search-input:focus {
        border-color: #2563eb;
    }
</style>
<form method="GET" action="{{ url()->current() }}">

    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:15px;
        margin-bottom:20px;
    ">

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

    </div>

    <div style="margin-bottom:20px;">

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


  
<!-- 
    @if(isset($dailyCounts) && $dailyCounts->isNotEmpty())
        <div class="daily-counts-summary" style="margin-bottom:20px;">
            <div class="heading" style="margin-bottom:10px;">Daily Meeting Counts</div>
            <div style="display:flex; flex-wrap:wrap; gap:10px;">
                @foreach($dailyCounts as $count)
                    <span class="" style=" color:#1c7ed6; padding:10px 14px; border-radius:8px; display:inline-block;">
                        {{ $count->date }} : {{ $count->total }} meeting{{ $count->total > 1 ? 's' : '' }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif -->

    <div class="heading">
        Meeting Bookings
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

    @endif

    {{-- ERROR --}}
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

                    <!-- <th>Meeting</th> -->

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                @forelse($bookings as $booking)

                <tr>

                    <td>
                        #{{ $booking->id }}
                    </td>

                    <td>
                        {{ $booking->name }}
                    </td>

                    <td>
                        {{ $booking->email }}
                    </td>

                    <td>
                        {{ $booking->phone }}
                    </td>

                    <td>
                        {{ $booking->date }}
                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}

                    </td>

                    <td>

                        <span class="badge {{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>

                    </td>

                    <td>

                        <div class="actions-row">

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
                                    <option value="scheduled" {{ $booking->status === 'scheduled' ? 'selected' : '' }}>
                                        Scheduled
                                    </option>
                                    <option value="rescheduled" {{ $booking->status === 'rescheduled' ? 'selected' : '' }}>
                                        Rescheduled
                                    </option>
                                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                </select>

                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-check"></i>
                                </button>

                            </form>

                            <form action="{{ route('reschedule.meeting', $booking->id) }}"
                                method="POST"
                                class="inline-form">

                                @csrf

                                <input type="date" name="date" required>

                                <input type="text" name="time" placeholder="02:30 PM" required>

                                <button class="btn btn-warning" type="submit">
                                    <i class="fa fa-calendar"></i>
                                </button>

                            </form>

                            <!-- <form action="{{ route('cancel.booking', $booking->id) }}"
                                  method="POST"
                                  class="inline-form cancel-form">

                                @csrf

                                <button class="btn btn-danger"
                                        onclick="return confirm('Cancel this booking?')">

                                    <i class="fa fa-times"></i>
                                </button> 

                            </form> -->

                        </div>
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="9"
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