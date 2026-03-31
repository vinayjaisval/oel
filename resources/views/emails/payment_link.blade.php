<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overseas Education Lane</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        body {
            margin: 0;
            padding: 0;
            background-color: #F4F6FA;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 620px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: linear-gradient(135deg, #1f4fd8, #3a6ff7);
            padding: 25px;
            text-align: center;
            color: #ffffff;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }

        .content {
            padding: 35px 40px;
            color: #333333;
        }

        .content p {
            font-size: 14px;
            line-height: 22px;
            margin-bottom: 15px;
        }

        .highlight-box {
            background-color: #F7F9FF;
            border-left: 4px solid #1f4fd8;
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
        }

        .highlight-box p {
            margin: 6px 0;
            font-size: 14px;
        }

        .payment-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 28px;
            background-color: #1f4fd8;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .payment-btn:hover {
            background-color: #173db3;
        }

        .note {
            font-size: 12px;
            color: #666666;
            margin-top: 20px;
        }

        .footer {
            background-color: #F0F2F8;
            text-align: center;
            padding: 18px;
            font-size: 12px;
            color: #666666;
        }

        .footer strong {
            color: #1f4fd8;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- Header -->
    <div class="header">
        <h1>Overseas Education Lane</h1>
    </div>

    <!-- Content -->
    <div class="content">

        <p><strong>Dear {{ $paymentData['name'] }},</strong></p>

        <p>
            Thank you for choosing <strong>Overseas Education Lane</strong>.
            To proceed further with your study abroad process, kindly confirm your registration
            by completing the payment using the link provided below.
        </p>

        @php
            $amountInRupees = $paymentData['amount'];
        @endphp

        <div class="highlight-box">
            <p><strong>Registration Amount:</strong> ₹{{ number_format($amountInRupees, 2) }} INR</p>
            <p><strong>Platform Charges:</strong> Razorpay charges applicable (2.5%)</p>
        </div>

        <a href="{{ $paymentData['payment_link'] }}" class="payment-btn">
            Confirm Registration & Pay
        </a>

        <p class="note">
            Once the payment is completed, your profile will be activated and assigned to a dedicated counselor.
        </p>

        <p class="note">
            For any assistance, feel free to contact us. We are happy to help you at every step of your overseas education journey.
        </p>

        <p>
            <strong>Best regards,</strong><br>
            Overseas Education Lane Team
        </p>

    </div>

    <!-- Footer -->
    <div class="footer">
        © {{ date('Y') }} <strong>Overseas Education Lane</strong>. All rights reserved.
    </div>

</div>

</body>
</html>
