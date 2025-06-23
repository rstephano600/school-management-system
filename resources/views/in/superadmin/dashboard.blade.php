@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="card">
        <div class="card-header">
            <h5 class="mb-0">dashboard</h5>
        </div>
        <div class="card-body">
            <!-- Your content here -->

    <h2>Welcome, {{ Auth::user()->name }}!</h2>
    <p>You are logged in to your dashboard.</p>



<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h4 class="card-title">Welcome, {{ auth()->user()->name ?? 'Super Admin' }}</h4>
        <p class="text-muted">This is your super admin dashboard for managing the entire school system.</p>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Schools</h5>
                <p class="card-text fs-3">12</p>
                <a href="#" class="btn btn-light btn-sm">View Schools</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text fs-3">210</p>
                <a href="#" class="btn btn-light btn-sm">View Users</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-warning">
            <div class="card-body">
                <h5 class="card-title">Pending Requests</h5>
                <p class="card-text fs-3">3</p>
                <a href="#" class="btn btn-light btn-sm">Review Now</a>
            </div>
        </div>
    </div>
</div>
@endsection
