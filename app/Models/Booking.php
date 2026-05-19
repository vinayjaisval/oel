<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'country_id',
        'counselor_id',
        'date',
        'time',
        'meeting_link'
    ];

    /**
     * Get daily meeting totals grouped by date.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
 public static function dailyMeetingCounts()
{
    $query = self::selectRaw('date, COUNT(*) as total')
        ->where('status', '!=', 'cancelled');

    // Non-admin only own counts
    if (auth()->check() && auth()->user()->role != 'Administrator') {
        $query->where('counselor_id', auth()->id());
    }

    return $query->groupBy('date')
        ->orderBy('date', 'desc')
        ->get();
}

public static function todayMeetingCount($timezone = 'Asia/Kolkata')
{
    $query = self::whereDate('date', Carbon::today($timezone))
        ->where('status', '!=', 'cancelled');

    // Non-admin only own counts
    if (auth()->check() && auth()->user()->role != 'Administrator') {
        $query->where('counselor_id', auth()->id());
    }

    return $query->count();
}
}
