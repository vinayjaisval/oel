<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Country;
// use App\Models\Counselor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BOOKING PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $countries = Country::all();

        return view('booking', compact('countries'));
    }

    /*
    |--------------------------------------------------------------------------
    | GET AVAILABLE TIME SLOTS
    |--------------------------------------------------------------------------
    */

    public function getSlots($date)
    {
        $slots = [];

        $timezone = 'Asia/Kolkata';

        $start = Carbon::parse($date . ' 10:00', $timezone);
        $end   = Carbon::parse($date . ' 20:00', $timezone);

        $now = Carbon::now($timezone);

        while ($start < $end) {

            // ONLY FUTURE TIME
            if ($start->timestamp > $now->timestamp) {

                $formattedTime = $start->format('h:i A');

                // CHECK SLOT ALREADY BOOKED OR NOT
                $alreadyBooked = Booking::where('date', $date)
                    ->where('time', $start->format('H:i:s'))
                    ->where('status', '!=', 'cancelled')
                    ->exists();

                if (!$alreadyBooked) {

                    $slots[] = $formattedTime;
                }
            }

            $start->addMinutes(30);
        }

        return response()->json($slots);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE BOOKING
    |--------------------------------------------------------------------------
    */

  public function store(Request $request)
{
  
    $request->validate([

        'name'  => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'date'  => 'required',
        'time'  => 'required',
    ]);

    // CONVERT TIME
    $time = Carbon::createFromFormat('h:i A', $request->time)
                ->format('H:i:s');

    // DEFAULT COUNSELOR
    // $counselor = Counselor::first();

    // if (!$counselor) {

    //     $counselor = Counselor::create([

    //         'name'  => 'Default Counselor',
    //         'email' => 'admin@gmail.com'
    //     ]);
    // }

    // CHECK SLOT ALREADY BOOKED
    $alreadyBooked = Booking::where('date', $request->date)
        ->where('time', $time)
        ->where('status', '!=', 'cancelled')
        ->exists();

    if ($alreadyBooked) {

        return response()->json([
            'success' => false,
            'message' => 'This slot is already booked.'
        ]);
    }

    // GENERATE JITSI ROOM
    $roomName = 'study-abroad-' . time() . '-' . Str::random(5);

    $meetingLink = 'https://meet.jit.si/' . $roomName;

    // SAVE BOOKING
    $booking = Booking::create([

        'name'          => $request->name,
        'email'         => $request->email,
        'phone'         => $request->phone,
         'country_id'    => $request->destination,
        'counselor_id'  => $counselor->id ?? null,
        'date'          => $request->date,
        'time'          => $time,
        'meeting_link'  => $meetingLink,
        'status'        => 'scheduled'
    ]);

    /*
    |--------------------------------------------------------------------------
    | SEND MAIL
    |--------------------------------------------------------------------------
    */

    Mail::raw(

        "Hello {$request->name}\n\n" .

        "Your Study Abroad consultation is confirmed.\n\n" .

        "Date: {$request->date}\n" .
        "Time: {$request->time}\n\n" .

        "Meeting Link:\n{$meetingLink}",

        function ($message) use ($request) {

            $message->to($request->email)
                    ->subject('Study Abroad Consultation Booking');
        }
    );

    /*
    |--------------------------------------------------------------------------
    | WHATSAPP LINK
    |--------------------------------------------------------------------------
    */

    // REMOVE SPACES
    $phone = preg_replace('/[^0-9]/', '', $request->phone);

    // INDIA CODE
    $phone = '91' . $phone;

    // MESSAGE
    $message = urlencode(

        "Hello {$request->name},\n\n" .

        "Your meeting is confirmed.\n\n" .

        "Date: {$request->date}\n" .
        "Time: {$request->time}\n\n" .

        "Meeting Link:\n{$meetingLink}"
    );

    // FINAL URL
    $whatsappLink = "https://wa.me/{$phone}?text={$message}";

    /*
    |--------------------------------------------------------------------------
    | RETURN JSON
    |--------------------------------------------------------------------------
    */

    return response()->json([

        'success' => true,
        'message' => 'Meeting Booked Successfully',

        'meeting_link' => $meetingLink,

        'whatsapp_url' => $whatsappLink
    ]);
}

    /*
    |--------------------------------------------------------------------------
    | ADMIN BOOKINGS PAGE
    |--------------------------------------------------------------------------
    */

public function adminBookings(Request $request)
{
    $query = Booking::query();

    // Name Search
    if ($request->name) {
        $query->where('name', 'LIKE', '%' . $request->name . '%');
    }

    // Email Search
    if ($request->email) {
        $query->where('email', 'LIKE', '%' . $request->email . '%');
    }

    // Mobile Search
    if ($request->phone) {
        $query->where('phone', 'LIKE', '%' . $request->phone . '%');
    }

    // Date Search
    if ($request->date) {
        $query->whereDate('date', $request->date);
    }

    $bookings = $query->latest()->paginate(10);

    $dailyCounts = Booking::dailyMeetingCounts();
    $todayCount = Booking::todayMeetingCount();

    return view(
        'landingpage.admin.onlinemeeting.onlinemeeting',
        compact('bookings', 'dailyCounts', 'todayCount')
    );
}

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:scheduled,rescheduled,cancelled,completed',
        ]);

        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Booking status updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | RESCHEDULE MEETING
    |--------------------------------------------------------------------------
    */

    public function reschedule(Request $request, $id)
    {
      
        $request->validate([

            'date' => 'required',
            'time' => 'required'
        ]);

        $booking = Booking::findOrFail($id);

        // CONVERT TIME
        $time = Carbon::parse($request->time)->format('H:i:s');

        // CHECK SLOT EXISTS
        $alreadyBooked = Booking::where('id', '!=', $booking->id)
            ->where('date', $request->date)
            ->where('time', $time)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($alreadyBooked) {

            return back()->with('error', 'Selected slot already booked.');
        }

        $booking->update([

            'date'   => $request->date,
            'time'   => $time,
            'status' => 'rescheduled'
        ]);

        /*
        |--------------------------------------------------------------------------
        | SEND RESCHEDULE MAIL
        |--------------------------------------------------------------------------
        */

        Mail::raw(

            "Hello {$booking->name}\n\n" .

            "Your meeting has been rescheduled.\n\n" .

            "New Date: {$request->date}\n" .
            "New Time: {$request->time}\n\n" .

            "Meeting Link:\n{$booking->meeting_link}",

            function($message) use ($booking){

                $message->to($booking->email)
                        ->subject('Meeting Rescheduled');
            }
        );

        return back()->with('success', 'Meeting Rescheduled Successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | CANCEL BOOKING
    |--------------------------------------------------------------------------
    */

    public function cancelBooking($id)
    {
       
        $booking = Booking::findOrFail($id);

        $booking->update([

            'status' => 'cancelled'
        ]);

        /*
        |--------------------------------------------------------------------------
        | SEND CANCEL MAIL
        |--------------------------------------------------------------------------
        */

        Mail::raw(

            "Hello {$booking->name}\n\n" .

            "Your meeting has been cancelled.\n\n" .

            "If needed, please book again later.",

            function($message) use ($booking){

                $message->to($booking->email)
                        ->subject('Meeting Cancelled');
            }
        );

        return back()->with('success', 'Booking Cancelled Successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | SEND REMINDER MANUALLY
    |--------------------------------------------------------------------------
    */

    public function sendReminder($id)
    {
        $booking = Booking::findOrFail($id);

        Mail::raw(

            "Hello {$booking->name}\n\n" .

            "Reminder:\n\n" .

            "Your meeting is scheduled soon.\n\n" .

            "Date: {$booking->date}\n" .
            "Time: " . Carbon::parse($booking->time)->format('h:i A') . "\n\n" .

            "Meeting Link:\n{$booking->meeting_link}",

            function($message) use ($booking){

                $message->to($booking->email)
                        ->subject('Meeting Reminder');
            }
        );

        return back()->with('success', 'Reminder Sent Successfully');
    }
}