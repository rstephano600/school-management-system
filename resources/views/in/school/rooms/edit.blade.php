@extends('layouts.app')
@section('title', 'Edit Room')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Room</h3>

    <form action="{{ route('rooms.update', $room->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Room Number</label>
            <input name="number" value="{{ old('number', $room->number) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Room Name</label>
            <input name="name" value="{{ old('name', $room->name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Building</label>
            <input name="building" value="{{ old('building', $room->building) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Floor</label>
            <input name="floor" value="{{ old('floor', $room->floor) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Room Type</label>
            <select name="room_type" class="form-select" required>
                @foreach(['classroom','lab','office','library','other'] as $type)
                    <option value="{{ $type }}" {{ $room->room_type == $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
