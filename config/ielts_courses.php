<?php

return [
    'plans' => [
        
        'foundation' => [
            'name' => 'FOUNDATION PLAN - 2 Classes Per Week',
            'amount' => 4000,
        ],
        'progress' => [
            'name' => 'PROGRESS PLAN - 3 Classes Per Week',
            'amount' => 5000,
        ],
        'intensive' => [
            'name' => 'INTENSIVE PLAN - 5 Classes Per Week',
            'amount' => 9000,
        ],
    ],

    'razorpay' => [
        'key_id' => env('RAZORPAY_KEY_ID', env('RAZORPAY_API_KEY')),
        'key_secret' => env('RAZORPAY_KEY_SECRET', env('RAZORPAY_API_SECRET')),
    ],

    'admin_email' => 'info@overseaseducationlane.com',
    'pending_expiry_hours' => 24,
];