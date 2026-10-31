<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IeltsCoursePaymentAttempt extends Model
{
    protected $guarded = [];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function enquiry()
    {
        return $this->belongsTo(IeltsCourseEnquiry::class, 'ielts_course_enquiry_id');
    }
}