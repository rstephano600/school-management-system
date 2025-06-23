@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Registered Schools</h4>
    <a href="{{ route('superadmin.schools.create') }}" class="btn btn-primary">+ Register New School</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>Name</th>
            <th>Code</th>
            <th>City</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Established</th>
            <th>Status</th>
            <th width="140">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($schools as $school)
        <tr>
            <td>{{ $school->name }}</td>
            <td>{{ $school->code }}</td>
            <td>{{ $school->city }}</td>
            <td>{{ $school->phone }}</td>
            <td>{{ $school->email }}</td>
            <td>{{ $school->established_date }}</td>
            <td>
                @if($school->status)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </td>
            <td>
                <a href="{{ route('superadmin.schools.show', $school) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('superadmin.schools.edit', $school) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('superadmin.schools.destroy', $school) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center text-muted">No schools registered yet.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
