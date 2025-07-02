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


</div>


@endsection
