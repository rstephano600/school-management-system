@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Hostel Details</h3>
    <p><strong>Name:</strong> {{ $hostel->name }}</p>
    <p><strong>Type:</strong> {{ ucfirst($hostel->type) }}</p>
    <p><strong>Address:</strong> {{ $hostel->address }}</p>
    <p><strong>Contact Number:</strong> {{ $hostel->contact_number }}</p>
    <p><strong>Capacity:</strong> {{ $hostel->capacity }}</p>
    <p><strong>Status:</strong>
        <span class="badge bg-{{ $hostel->status ? 'success' : 'secondary' }}">
            {{ $hostel->status ? 'Active' : 'Inactive' }}
        </span>
    </p>
    <p><strong>Warden:</strong> {{ $hostel->warden->user->name ?? 'N/A' }}</p>
    <p><strong>Description:</strong><br>{{ $hostel->description ?? '-' }}</p>
    <a href="{{ route('hostels.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection