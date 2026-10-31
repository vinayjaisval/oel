<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IeltsCourseEnquiry extends Model
{
    protected $guarded = [];

    protected $casts = [
        'payment_verified' => 'boolean',
        'payment_date' => 'datetime',
        'initial_admin_email_sent_at' => 'datetime',
        'initial_student_email_sent_at' => 'datetime',
        'payment_admin_email_sent_at' => 'datetime',
        'payment_student_email_sent_at' => 'datetime',
    ];

}