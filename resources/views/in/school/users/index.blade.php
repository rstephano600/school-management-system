@extends('layouts.app')

@section('title', 'users')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">users List</h5>
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-user-plus"></i> Register New user
            </a>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('users.index') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control" 
                            placeholder="Search by name or email " 
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>email</th>
                            <th>
                                <a href="{{ route('users.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => ($sort === 'name' && $direction === 'asc') ? 'desc' : 'asc'])) }}">
                                    Name
                                    @if($sort === 'name')
                                        <i class="bi bi-arrow-{{ $direction === 'asc' ? 'down' : 'up' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Role</th>
                            <th>
                                <a href="{{ route('users.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => ($sort === 'created_at' && $direction === 'asc') ? 'desc' : 'asc'])) }}">
                                    Created date
                                    @if($sort === 'created_at')
                                        <i class="bi bi-arrow-{{ $direction === 'asc' ? 'down' : 'up' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- Load Bootstrap Icons if not already --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
@endpush
@endsection
