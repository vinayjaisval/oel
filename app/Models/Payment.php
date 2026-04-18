<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    // ✅ Safe approach (recommended)
    protected $fillable = [
        'payment_id',
        'payment_method',
        'currency',
        'fallowp_unique_id',
        'customer_name',
        'user_id',
        'customer_email',
        'amount',
        'payment_status',
        'json_response'
    ];

    // ✅ Relation (fixed naming)
    public function paymentLink()
    {
        return $this->belongsTo(PaymentsLink::class, 'fallowp_unique_id', 'fallowp_unique_id');
    }
}