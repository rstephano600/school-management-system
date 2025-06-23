@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Staff Members - {{ $school->name }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('schools.staff.create', $school->id) }}" class="btn btn-primary mb-3">Add New Staff</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Joining Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffMembers as $staff)
            <tr>
                <td>{{ $staff->employee_id }}</td>
                <td>{{ $staff->user->name }}</td>
                <td>{{ $staff->designation }}</td>
                <td>{{ $staff->department ?? '-' }}</td>
                <td>{{ $staff->joining_date->format('d M Y') }}</td>
                <td>
                    <span class="badge bg-{{ $staff->status ? 'success' : 'secondary' }}">
                        {{ $staff->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('schools.staff.show', [$school->id, $staff->user_id]) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('schools.staff.edit', [$school->id, $staff->user_id]) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('schools.staff.destroy', [$school->id, $staff->user_id]) }}" method="POST" class="d-inline">
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
