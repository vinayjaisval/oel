<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Course Update</title>
</head>
<body style="margin:0;background:#f4f6f8;color:#25313c;font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:24px 12px;background:#f4f6f8;">
        <tr><td align="center">
            <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width:600px;background:#fff;border:1px solid #e3e8ec;">
                <tr><td style="padding:24px 28px;background:#123d56;color:#fff;font-size:20px;font-weight:bold;">Overseas Education Lane</td></tr>
                <tr><td style="padding:28px;line-height:1.55;">
                    @if ($event === 'payment' && $audience === 'student')
                        <h1 style="margin:0 0 16px;font-size:22px;color:#123d56;">Payment confirmed</h1>
                        <p style="margin:0 0 16px;">Hello {{ $enquiry->name }}, your IELTS course payment has been verified successfully.</p>
                    @elseif ($event === 'payment')
                        <h1 style="margin:0 0 16px;font-size:22px;color:#123d56;">IELTS course payment confirmed</h1>
                    @elseif ($audience === 'student')
                        <h1 style="margin:0 0 16px;font-size:22px;color:#123d56;">We received your enquiry</h1>
                        <p style="margin:0 0 16px;">Hello {{ $enquiry->name }}, thank you for your IELTS course enquiry. Our team will contact you about the next steps.</p>
                    @else
                        <h1 style="margin:0 0 16px;font-size:22px;color:#123d56;">IELTS course {{ $event === 'payment' ? 'payment' : 'enquiry' }} update</h1>
                    @endif
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="8" style="border-collapse:collapse;font-size:14px;">
                        <tr><td style="border-bottom:1px solid #e8ecef;"><strong>Student</strong></td><td style="border-bottom:1px solid #e8ecef;">{{ $enquiry->name }}</td></tr>
                        <tr><td style="border-bottom:1px solid #e8ecef;"><strong>Email</strong></td><td style="border-bottom:1px solid #e8ecef;">{{ $enquiry->email }}</td></tr>
                        <tr><td style="border-bottom:1px solid #e8ecef;"><strong>Phone</strong></td><td style="border-bottom:1px solid #e8ecef;">{{ $enquiry->phone }}</td></tr>
                        <tr><td style="border-bottom:1px solid #e8ecef;"><strong>City</strong></td><td style="border-bottom:1px solid #e8ecef;">{{ $enquiry->city }}</td></tr>
                        <tr><td style="border-bottom:1px solid #e8ecef;"><strong>Class plan</strong></td><td style="border-bottom:1px solid #e8ecef;">{{ $enquiry->plan_name }}</td></tr>
                        <tr><td style="border-bottom:1px solid #e8ecef;"><strong>Amount</strong></td><td style="border-bottom:1px solid #e8ecef;">{{ $enquiry->currency }} {{ number_format($enquiry->amount) }}</td></tr>
                        <tr><td style="border-bottom:1px solid #e8ecef;"><strong>Enquiry reference</strong></td><td style="border-bottom:1px solid #e8ecef;">{{ $enquiry->enquiry_reference }}</td></tr>
                        <tr><td style="border-bottom:1px solid #e8ecef;"><strong>Payment status</strong></td><td style="border-bottom:1px solid #e8ecef;">{{ ucfirst($enquiry->payment_status) }}</td></tr>
                        @if ($event === 'payment')
                            <tr><td style="border-bottom:1px solid #e8ecef;"><strong>Razorpay order ID</strong></td><td style="border-bottom:1px solid #e8ecef;">{{ $enquiry->razorpay_order_id }}</td></tr>
                            <tr><td style="border-bottom:1px solid #e8ecef;"><strong>Razorpay payment ID</strong></td><td style="border-bottom:1px solid #e8ecef;">{{ $enquiry->razorpay_payment_id }}</td></tr>
                            <tr><td style="border-bottom:1px solid #e8ecef;"><strong>Payment date</strong></td><td style="border-bottom:1px solid #e8ecef;">{{ optional($enquiry->payment_date)->format('d M Y, h:i A T') }}</td></tr>
                        @endif
                    </table>
                    @if ($audience === 'student')
                        <p style="margin:20px 0 0;">@if ($event === 'payment') Our course team will contact you to confirm your class schedule and onboarding details. @else Our team will contact you about the next steps for your IELTS course. @endif For assistance, contact <a href="mailto:info@overseaseducationlane.com" style="color:#116b8b;">info@overseaseducationlane.com</a> or visit <a href="https://overseaseducationlane.com" style="color:#116b8b;">overseaseducationlane.com</a>.</p>
                    @endif
                </td></tr>
                <tr><td style="padding:18px 28px;background:#f8fafb;color:#687681;font-size:12px;">Overseas Education Lane | info@overseaseducationlane.com</td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>