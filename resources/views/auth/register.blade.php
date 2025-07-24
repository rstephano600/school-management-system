<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Smart School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* background: linear-gradient(to right, #6a11cb, #2575fc); */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            border: none;
        }
        .card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background: linear-gradient(to right, #007bff, #0056b3);
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
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            transition: border-color 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            background: linear-gradient(to right, #28a745, #218838);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #218838, #1e7e34);
            transform: translateY(-2px);
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
        .login-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .login-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
            border-radius: 50%;
            object-fit: contain;
        }
        /* Adjustments for form-floating labels */
        .form-floating > label {
            padding: 1rem 0.75rem;
        }
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label,
        .form-floating > .form-select ~ label {
            opacity: .65;
            transform: scale(.85) translateY(-.5rem) translateX(.15rem);
        }
    </style>
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg w-100" style="max-width: 420px;">
        <div class="card-header text-center">
            {{-- Assuming you have a logo image in your public directory --}}
            <img src="{{ asset('assets/img/cns.png') }}" alt="School Logo" class="logo">
            <h4>Register New User</h4>
            <p class="mb-0">Create your account to get started.</p>
        </div>
        <div class="card-body p-4">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong> Please check the form for errors.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           placeholder="Full Name"
                           value="{{ old('name') }}"
                           required autofocus>
                    <label for="name">Full Name</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           placeholder="name@example.com"
                           value="{{ old('email') }}"
                           required>
                    <label for="email">Email address</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="school_id" class="form-label">Select School</label>
                    <select class="form-select @error('school_id') is-invalid @enderror"
                            id="school_id"
                            name="school_id"
                            required>
                        <option value="">-- Select School --</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('school_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           placeholder="Password"
                           required autocomplete="new-password">
                    <label for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-4">
                    <input type="password"
                           class="form-control"
                           id="password_confirmation"
                           name="password_confirmation"
                           placeholder="Confirm Password"
                           required autocomplete="new-password">
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg" type="submit">Register</button>
                </div>
                
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}" class="login-link">Already have an account? Login</a>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>