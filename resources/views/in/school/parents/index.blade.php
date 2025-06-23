@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Students List</h1>
    <a href="{{ route('students.index') }}" class="btn btn-primary mb-3">Register New Student</a>
    <form method="GET" action="{{ route('student.parent.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-6">
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Search by name or admission number" 
                value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Admission Number</th>
                <th>Name</th>
                <th>Grade</th>
                <th>Section</th>
                <th>Admission Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parents as $parent)
            <tr>
                <td>{{ parent->admission_number ?? '-' }}</td>
                <td>{{ parent->user->name }}</td>
                <td>{{ parent->grade->name ?? '-' }}</td>
                <td>{{ parent->section->name ?? '-' }}</td>
                <td>{{ parent->admission_date->format('d M Y') }}</td>
                <td><span class="badge bg-success">{{ ucfirst($parent->status) }}</span></td>
                <td>
                    <a href="{{ route('parent.show', $parent->user_id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('parent.edit', $parent->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('parent.destroy', $parent->user_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
