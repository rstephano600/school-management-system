@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Room Details</h3>
    <p><strong>Room Number:</strong> {{ $hostel_room->room_number }}</p>
    <p><strong>Hostel:</strong> {{ $hostel_room->hostel->name ?? 'N/A' }}</p>
    <p><strong>Type:</strong> {{ ucfirst($hostel_room->room_type) }}</p>
    <p><strong>Capacity:</strong> {{ $hostel_room->capacity }}</p>
    <p><strong>Current Occupancy:</strong> {{ $hostel_room->current_occupancy }}</p>
    <p><strong>Cost per Bed:</strong> TSh {{ number_format($hostel_room->cost_per_bed, 2) }}</p>
    <p><strong>Status:</strong>
        <span class="badge bg-{{ $hostel_room->status === 'available' ? 'success' : ($hostel_room->status === 'occupied' ? 'warning' : 'secondary') }}">{{ ucfirst($hostel_room->status) }}</span>
    </p>
    <a href="{{ route('hostel-rooms.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection