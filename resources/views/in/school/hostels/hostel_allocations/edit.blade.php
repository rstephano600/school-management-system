@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Edit Allocation</h3>
    <form action="{{ route('hostel-allocations.update', $hostel_allocation->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Student</label>
            <select name="student_id" class="form-control" required>
                @foreach($students as $student)
                    <option value="{{ $student->user_id }}" @if($hostel_allocation->student_id == $student->user_id) selected @endif>
                        {{ $student->user->name ?? 'Unnamed' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Hostel</label>
            <select name="hostel_id" class="form-control" required>
                @foreach($hostels as $hostel)
                    <option value="{{ $hostel->id }}" @if($hostel_allocation->hostel_id == $hostel->id) selected @endif>
                        {{ $hostel->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Room</label>
            <select name="room_id" class="form-control" required>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" @if($hostel_allocation->room_id == $room->id) selected @endif>
                        {{ $room->room_number }} ({{ $room->current_occupancy }}/{{ $room->capacity }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Bed Number</label>
            <input type="text" name="bed_number" class="form-control" value="{{ $hostel_allocation->bed_number }}" required>
        </div>

        <div class="mb-3">
            <label>Allocation Date</label>
            <input type="date" name="allocation_date" class="form-control" value="{{ $hostel_allocation->allocation_date }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" @if($hostel_allocation->status) selected @endif>Active</option>
                <option value="0" @if(!$hostel_allocation->status) selected @endif>Inactive</option>
            </select>
        </div>

        <button class="btn btn-success">Update Allocation</button>
    </form>
</div>
@endsection