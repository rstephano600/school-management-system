@extends('layouts.app')

@section('content')
<div class="container">
    <h4>{{ $filterRole ? ucfirst($filterRole) : 'All' }} Users at {{ $school->name }}</h4>

    <form method="GET" action="{{ route('superadmin.schools.users', $school->id) }}" class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by name, email or phone"
                value="{{ $searchTerm }}">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-control">
                <option value="">All Roles</option>
                <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                <option value="parent" {{ request('role') == 'parent' ? 'selected' : '' }}>Parent</option>
                <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>

    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->name }} {{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ ucfirst($user->role) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->withQueryString()->links() }}
</div>
@endsection
