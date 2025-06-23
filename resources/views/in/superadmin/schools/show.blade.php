@extends('layouts.app')

@section('content')
<div class="container ">
    <h2>{{ $school->name }} - Details</h2>
    <hr>

    <div class="row mb-4">
        <div class="col-md-3">
            <strong>School Code:</strong> {{ $school->code }}
        </div>
        <div class="col-md-3">
            <strong>City:</strong> {{ $school->city }}
        </div>
        <div class="col-md-3">
            <strong>Phone:</strong> {{ $school->phone }}
        </div>
        <div class="col-md-3">
            <strong>Email:</strong> {{ $school->email }}
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <strong>Established:</strong> {{ $school->established_date }}
        </div>
        <div class="col-md-3">
            <strong>Status:</strong>
            @if($school->status)
                <span class="badge bg-success">Active</span>
            @else
                <span class="badge bg-danger">Inactive</span>
            @endif
        </div>
    </div>
<a href="{{ route('superadmin.schools.users.create', $school) }}" class="btn btn-sm btn-success mb-3">
    Register User
</a>
<div class="container p-5 my-5 border">
    <h4>User Statistics</h4>

<ul class="list-group">
    <li class="list-group-item">
        <a href="{{ route('superadmin.schools.users', ['school' => $school->id]) }}">
            Total Users: {{ $totalUsers }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('superadmin.schools.users', ['school' => $school->id, 'role' => 'student']) }}">
            Total Students: {{ $totalStudents }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('superadmin.schools.users', ['school' => $school->id, 'role' => 'parent']) }}">
            Total Parents: {{ $totalParents }}
        </a>
    </li>
</ul>


        
</div>

    <h4>Library Information</h4>
    

    <h4>Health Information</h4>
 

    <h4>Activities</h4>


    <a href="{{ route('superadmin.schools') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
