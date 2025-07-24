<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Smart School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            border-radius: 15px; /* Softer rounded corners */
            overflow: hidden; /* Ensures content respects border-radius */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); /* More pronounced shadow */
            transition: all 0.3s ease; /* Smooth transition for hover effects */
            border: none;
        }
        .card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background: linear-gradient(to right, #007bff, #0056b3); /* Primary color gradient */
            color: white;
            padding: 20px;
            border-bottom: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .card-header h4 {
            margin-top: 10px;
            font-weight: 600;
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            background: linear-gradient(to right, #28a745, #218838); /* Green gradient for the button */
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #218838, #1e7e34);
            transform: translateY(-2px); /* Slight lift on hover */
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        .back-to-login {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .back-to-login:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .logo {
            width: 80px; /* Adjust logo size as needed */
            height: 80px;
            margin-bottom: 10px;
            border-radius: 50%; /* If your logo is circular */
            object-fit: contain; /* Ensures the image fits without distortion */
        }
    </style>
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg w-100" style="max-width: 420px;">
        <div class="card-header text-center">
            <img src="{{ asset('assets/img/cns.png') }}" class="logo">
            <h4>Forgot Your Password?</h4>
            <p class="mb-0">Enter your email to receive a password reset link.</p>
        </div>
        <div class="card-body p-4">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required autocomplete="email" autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                </div>

                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}" class="back-to-login">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>