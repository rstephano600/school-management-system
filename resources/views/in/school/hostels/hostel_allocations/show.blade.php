@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Allocation Details</h3>
    <p><strong>Student:</strong> {{ $hostel_allocation->student->user->name ?? 'N/A' }}</p>
    <p><strong>Hostel:</strong> {{ $hostel_allocation->hostel->name ?? '-' }}</p>
    <p><strong>Room:</strong> {{ $hostel_allocation->room->room_number ?? '-' }}</p>
    <p><strong>Bed Number:</strong> {{ $hostel_allocation->bed_number }}</p>
    <p><strong>Allocation Date:</strong> {{ $hostel_allocation->allocation_date }}</p>
    <p><strong>Status:</strong>
        <span class="badge bg-{{ $hostel_allocation->status ? 'success' : 'secondary' }}">
            {{ $hostel_allocation->status ? 'Active' : 'Inactive' }}
        </span>
    </p>
    <a href="{{ route('hostel-allocations.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection