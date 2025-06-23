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


    
    <div class="container">
    <h2 class="mb-4">School Admin Dashboard</h2>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('students.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Students</h5>
                        <p class="card-text display-4">{{ $studentCount }}</p>
                        <button class="btn btn-primary">View Students</button>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('teachers.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Teachers</h5>
                        <p class="card-text display-4">{{ $teacherCount }}</p>
                        <button class="btn btn-primary">View Teacherss</button>
                    </div>
                </div>
            </a>
        </div>
        <!-- You can add similar cards for Teachers, Classes, etc. -->
    </div>
</div>



<ul>
    @foreach($students as $student)
        <li>{{ $student->name }}</li>
    @endforeach
</ul>

    

   


</div>


@endsection
