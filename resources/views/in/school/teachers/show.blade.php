@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Teacher Details: {{ $teacher->user->name }}</h1>

    <div class="card mb-3">
        <div class="card-header">Personal Information</div>
        <div class="card-body">
            <p><strong>Employee ID:</strong> {{ $teacher->employee_id }}</p>
            <p><strong>Email:</strong> {{ $teacher->user->email }}</p>
            <p><strong>Department:</strong> {{ $teacher->department }}</p>
            <p><strong>Joining Date:</strong> {{ $teacher->joining_date->format('d M Y') }}</p>
            <p><strong>Qualification:</strong> {{ $teacher->qualification }}</p>
            <p><strong>Specialization:</strong> {{ $teacher->specialization }}</p>
            <p><strong>Experience:</strong> {{ $teacher->experience }} years</p>
            <p><strong>Class Teacher:</strong> {{ $teacher->is_class_teacher ? 'Yes' : 'No' }}</p>
            <p><strong>Status:</strong> {{ $teacher->status ? 'Active' : 'Inactive' }}</p>
        </div>
    </div>

    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
