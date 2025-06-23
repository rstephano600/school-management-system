@extends('layouts.auth-app')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <h2 class="mb-4">School Users Register</h2>
     @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="full name.." required>
            <label for="name">full name</label>
        </div>
        <!-- <div class="form-floating mb-3">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number.." required>
            <label for="name">Phone Number</label>
        </div> -->

        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
            <label for="email">Email address</label>
        </div>
        <!-- <div class="form-floating mb-3">
            <select name="gender" id="gender" class="form-select">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <label for="name">Gender</label>
        </div> -->
        <div class="mb-3">
    <label for="school_id" class="form-label">Select School</label>
    <select class="form-select" id="school_id" name="school_id" required>
        <option value="">-- Select School --</option>
        @foreach($schools as $school)
            <option value="{{ $school->id }}">{{ $school->name }}</option>
        @endforeach
    </select>
</div>

        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>
        
        <div class="d-grid gap-2">
            <button class="btn btn-primary btn-lg" type="submit">Register</button>
        </div>
        
        <div class="mt-3 text-center">
            <a href="{{ route('login') }}">You have Account? Login</a>
        </div>

    </form>

</div></div>
@endsection

