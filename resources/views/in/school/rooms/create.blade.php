@extends('layouts.app')
@section('title', 'Add Room')

@section('content')
<div class="container">
    <h3 class="mb-4">Add Room</h3>

    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Form has errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="mb-3">
            <label>Room Number</label>
            <input name="number" value="{{ old('number') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Room Name (optional)</label>
            <input name="name" value="{{ old('name') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Building</label>
            <input name="building" value="{{ old('building') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Floor</label>
            <input name="floor" value="{{ old('floor') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" value="{{ old('capacity') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Room Type</label>
            <select name="room_type" class="form-select" required>
                <option value="">Select Type</option>
                @foreach(['classroom','lab','office','library','other'] as $type)
                    <option value="{{ $type }}" {{ old('room_type') == $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>



        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
