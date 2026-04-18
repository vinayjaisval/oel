<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Failed</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff6a6a, #ff0000);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .failure-card {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 450px;
            width: 100%;
            animation: fadeIn 0.8s ease-in-out;
        }

        .crossmark {
            font-size: 70px;
            color: red;
            animation: shake 0.4s ease;
        }

        h1 {
            font-weight: 600;
            margin-top: 15px;
        }

        p {
            color: #555;
            margin-top: 10px;
        }

        .btn-retry {
            margin-top: 20px;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 500;
        }

        @keyframes shake {
            0% { transform: translateX(-10px); }
            50% { transform: translateX(10px); }
            100% { transform: translateX(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>

<body>

<div class="failure-card">

    <div class="crossmark">✖</div>

    <h1>Payment Failed</h1>

    <p>
        Oops! Something went wrong while processing your payment.  
        Please try again.
    </p>

    <a href="{{ url('/') }}" class="btn btn-danger btn-retry">
        Try Again
    </a>

</div>

</body>
</html>