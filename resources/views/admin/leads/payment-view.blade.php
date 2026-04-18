<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oel Overseas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F7F8FA;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 40px;
            margin: 40px auto;
            max-width: 600px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .payment-btn {
            font-size: 16px;
            font-weight: 500;
            color: #007bff;
            border: 1px solid #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            background: #fff;
            cursor: pointer;
        }
        .payment-btn:hover {
            background: #007bff;
            color: #fff;
        }
    </style>
</head>

<body>

<div class="container text-center">

    <p style="font-size:18px;">⚠️ Please do not refresh the page until payment is done</p>

    <h3>Dear {{ $data['name'] }}</h3>

    <p>Please proceed with your payment</p>
    <span>Note: GST 18% and 3% Markup fee is added for international payment.</span>
    <p><b>Amount: {{ $data['amount'] }} INR</b></p>

    <!-- Hidden fields -->
    <input type="hidden" id="user_id" value="{{ $data['user_id'] }}">
    <input type="hidden" id="fallowp_unique_id" value="{{ $data['fallowp_unique_id'] }}">
    <input type="hidden" id="name" value="{{ $data['name'] }}">

    <!-- Payment Button -->
    <button type="button" id="payBtn" class="payment-btn">
        Pay {{ $data['amount'] }} INR
    </button>

</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    var options = {
        key: "{{ env('RAZORPAY_API_KEY') }}",
        amount: "{{ $data['amount'] * 100 }}",
        currency: "INR",
        name: "Oel Overseas",
        description: "Payment",
        image: "{{ asset('assets/img/logo2.png') }}",

        prefill: {
            name: "{{ $data['name'] }}",
            email: "{{ $data['email'] ?? '' }}"
        },

        theme: {
            color: "#0F408F"
        },

        handler: function (response) {

            $.ajax({
                url: "{{ url('payment/create') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    response: {
                        razorpay_payment_id: response.razorpay_payment_id,
                        user_id: $('#user_id').val(),
                        fallowp_unique_id: $('#fallowp_unique_id').val(),
                        name: $('#name').val()
                    }
                },
                success: function (res) {

                    if (res.success === true) {
                        window.location.href = "{{ url('payment/success') }}";
                    } else {
                        window.location.href = "{{ url('payment/failure') }}";
                    }
                },
                error: function (err) {
                    console.log('AJAX ERROR:', err);
                }
            });
        }
    };

    var rzp = new Razorpay(options);

    // Button Click
    document.getElementById('payBtn').onclick = function (e) {
        e.preventDefault();
        rzp.open();
    };

    // Payment Failed
    rzp.on('payment.failed', function (response) {

        $.ajax({
            url: "{{ url('payment/create') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                response: {
                    razorpay_payment_id: response.error.metadata.payment_id,
                    user_id: $('#user_id').val(),
                    fallowp_unique_id: $('#fallowp_unique_id').val(),
                    name: $('#name').val()
                }
            },
            success: function () {
                window.location.href = "{{ url('payment/failure') }}";
            }
        });
    });
</script>

</body>
</html>