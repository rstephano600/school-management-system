@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Hostel List</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('hostels.index') }}" class="row g-3 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name">
        </div>
        <div class="col-md-3">
            <select name="type" class="form-control">
                <option value="">All Types</option>
                @foreach(['boys', 'girls', 'co-ed'] as $type)
                    <option value="{{ $type }}" @if(request('type') === $type) selected @endif>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                <option value="1" @if(request('status') === '1') selected @endif>Active</option>
                <option value="0" @if(request('status') === '0') selected @endif>Inactive</option>
            </select>
        </div>
        <div class="col-md-3 d-flex">
            <button class="btn btn-secondary me-2">Search</button>
            <a href="{{ route('hostels.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <a href="{{ route('hostels.create') }}" class="btn btn-primary mb-3">Add Hostel</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Warden</th>
                <th>Contact</th>
                <th>Capacity</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hostels as $hostel)
            <tr>
                <td>{{ $hostel->name }}</td>
                <td>{{ ucfirst($hostel->type) }}</td>
                <td>{{ $hostel->warden->user->name ?? 'N/A' }}</td>
                <td>{{ $hostel->contact_number }}</td>
                <td>{{ $hostel->capacity }}</td>
                <td><span class="badge bg-{{ $hostel->status ? 'success' : 'secondary' }}">{{ $hostel->status ? 'Active' : 'Inactive' }}</span></td>
                <td>
                    <a href="{{ route('hostels.show', $hostel->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('hostels.edit', $hostel->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('hostels.destroy', $hostel->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this hostel?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7">No hostels found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $hostels->withQueryString()->links() }}
    </div>
</div>
@endsection