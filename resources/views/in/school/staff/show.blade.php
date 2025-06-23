@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Staff Details</h1>

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <td>{{ $staff->user->name }}</td>
        </tr>
        <tr>
            <th>Employee ID</th>
            <td>{{ $staff->employee_id }}</td>
        </tr>
        <tr>
            <th>Designation</th>
            <td>{{ $staff->designation }}</td>
        </tr>
        <tr>
            <th>Department</th>
            <td>{{ $staff->department ?? '-' }}</td>
        </tr>
        <tr>
            <th>Joining Date</th>
            <td>{{ $staff->joining_date->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Qualification</th>
            <td>{{ $staff->qualification ?? '-' }}</td>
        </tr>
        <tr>
            <th>Experience</th>
            <td>{{ $staff->experience ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge bg-{{ $staff->status ? 'success' : 'secondary' }}">
                    {{ $staff->status ? 'Active' : 'Inactive' }}
                </span>
            </td>
        </tr>
    </table>

    <a href="{{ route('schools.staff.index', $school->id) }}" class="btn btn-secondary">Back</a>
</div>
@endsection
