@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Hostel Rooms</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('hostel-rooms.index') }}" class="row g-3 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Room number">
        </div>
        <div class="col-md-3">
            <select name="room_type" class="form-control">
                <option value="">All Types</option>
                @foreach(['single', 'double', 'dormitory', 'other'] as $type)
                    <option value="{{ $type }}" @if(request('room_type') === $type) selected @endif>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                @foreach(['available', 'occupied', 'maintenance'] as $status)
                    <option value="{{ $status }}" @if(request('status') === $status) selected @endif>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex">
            <button class="btn btn-secondary me-2">Search</button>
            <a href="{{ route('hostel-rooms.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <a href="{{ route('hostel-rooms.create') }}" class="btn btn-primary mb-3">Add Room</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Room #</th>
                <th>Hostel</th>
                <th>Type</th>
                <th>Capacity</th>
                <th>Occupancy</th>
                <th>Cost/Bed</th>
                <th>Status</th>
                <th>Available Beds</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
            <tr>
                <td>{{ $room->room_number }}</td>
                <td>{{ $room->hostel->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($room->room_type) }}</td>
                <td>{{ $room->capacity }}</td>
                <td>{{ $room->current_occupancy }}</td>
                <td>TSh {{ number_format($room->cost_per_bed, 2) }}</td>
                <td><span class="badge bg-{{ $room->status === 'available' ? 'success' : ($room->status === 'occupied' ? 'warning' : 'secondary') }}">{{ ucfirst($room->status) }}</span></td>
                <td>
    {{ $room->capacity }} 
    <small class="text-muted">({{ $room->current_occupancy }} used)</small>
</td>

                <td>
                    <a href="{{ route('hostel-rooms.show', $room->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('hostel-rooms.edit', $room->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('hostel-rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this room?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8">No rooms found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $rooms->withQueryString()->links() }}
    </div>
</div>
@endsection