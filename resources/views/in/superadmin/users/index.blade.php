@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Registered User</h4>
    <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary">+ Register New User</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>Name</th>
            <th>Email Address</th>
            <th>Role</th>
            <!-- <th>Phone</th> -->
            <th>School Belonged</th>
            <th>Status</th>
            <th width="140">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <!-- <td>{{ $user->phone }}</td> -->
            <td>{{ $user->school->name ?? 'N/A' }}</td>
            <td>
                @if($user->status)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </td>
            <td>
                <a href="{{ route('superadmin.users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center text-muted">No Users registered yet.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
