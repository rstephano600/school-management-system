@extends('layouts.app')
@section('title', 'Rooms')

@section('content')
<div class="container">
    <h3 class="mb-4">Rooms</h3>

    <a href="{{ route('rooms.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add Room
    </a>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Room Number</th>
                <th>Name</th>
                <th>Building</th>
                <th>Floor</th>
                <th>Type</th>
                <th>Capacity</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
            <tr>
                <td>{{ $room->number }}</td>
                <td>{{ $room->name ?? '-' }}</td>
                <td>{{ $room->building }}</td>
                <td>{{ $room->floor }}</td>
                <td>{{ ucfirst($room->room_type) }}</td>
                <td>{{ $room->capacity }}</td>
                <td>
                    <span class="badge {{ $room->status ? 'bg-success' : 'bg-danger' }}">
                        {{ $room->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="text-end">
                    <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this room?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center">No rooms found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $rooms->links() }}
</div>
@endsection
