<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-card {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 450px;
            width: 100%;
            animation: fadeIn 0.8s ease-in-out;
        }

        .checkmark {
            font-size: 70px;
            color: #28a745;
            animation: pop 0.5s ease;
        }

        h1 {
            font-weight: 600;
            margin-top: 15px;
        }

        p {
            color: #555;
            margin-top: 10px;
        }

        .btn-home {
            margin-top: 20px;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 500;
        }

        @keyframes pop {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>

<body>

<div class="success-card">

    <div class="checkmark">✔</div>

    <h1>Payment Successful</h1>

    <p>
        Thank you! Your payment has been successfully processed.  
        We have received your request.
    </p>

    <a href="{{ url('/') }}" class="btn btn-success btn-home">
        Go to Home
    </a>

</div>

</body>
</html>