@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Hostel Allocations</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('hostel-allocations.create') }}" class="btn btn-primary mb-3">Allocate Student</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Hostel</th>
                <th>Room</th>
                <th>Bed</th>
                <th>Start Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($allocations as $allocation)
            <tr>
                <td>{{ $allocation->student->user->name ?? 'N/A' }}</td>
                <td>{{ $allocation->hostel->name ?? '-' }}</td>
                <td>{{ $allocation->room->room_number ?? '-' }}</td>
                <td>{{ $allocation->bed_number }}</td>
                <td>{{ $allocation->allocation_date }}</td>
                <td><span class="badge bg-{{ $allocation->status ? 'success' : 'secondary' }}">{{ $allocation->status ? 'Active' : 'Inactive' }}</span></td>
                <td>
                    <a href="{{ route('hostel-allocations.show', $allocation->id) }}" class="btn btn-sm btn-info">View</a>
                    <form action="{{ route('hostel-allocations.destroy', $allocation->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this allocation?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7">No allocations found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $allocations->links() }}
    </div>
</div>
@endsection