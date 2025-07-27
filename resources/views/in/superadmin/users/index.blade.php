@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Users Management</h2>
        <span class="badge bg-info float-end">{{ $userCount }}</span>
    <form method="GET" action="{{ route('superadmin.users.index') }}" class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Search</button>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('superadmin.users.create') }}" class="btn btn-success">Add New User</a>
        </div>
    </form>

    @if($users->count())
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>School</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->status ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $user->school->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('superadmin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->withQueryString()->links() }}
    @else
        <p>No users found.</p>
    @endif
</div>
@endsection
