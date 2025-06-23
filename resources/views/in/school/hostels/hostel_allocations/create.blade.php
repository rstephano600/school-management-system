@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Allocate Hostel Bed</h3>
    <form action="{{ route('hostel-allocations.store') }}" method="POST">
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
            <label>Student</label>
  <select name="student_id" class="form-control" required>
    <option value="">-- Select Student --</option>
    @foreach($students as $student)
        <option value="{{ $student->user_id }}"
            @if((old('student_id') ?? $selectedStudent ?? '') == $student->user_id) selected @endif>
            {{ $student->user->name ?? 'Unnamed' }}
        </option>
    @endforeach
</select>

        </div>

        <div class="mb-3">
            <label>Hostel</label>
            <select name="hostel_id" id="hostelSelect" class="form-control" required>
                <option value="">-- Select Hostel --</option>
                @foreach($hostels as $hostel)
                    <option value="{{ $hostel->id }}">{{ $hostel->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Room</label>
            <select name="room_id" id="roomSelect" class="form-control" required>
                <option value="">-- Select Room --</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" data-hostel="{{ $room->hostel_id }}">
                        {{ $room->room_number }} ({{ $room->current_occupancy }}/{{ $room->capacity }})
                    </option>
                @endforeach
            </select>
            <small id="roomAvailability" class="form-text text-muted"></small>
        </div>

        <div class="mb-3">
            <label>Bed Number</label>
            <input type="text" name="bed_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Allocation Date</label>
            <input type="date" name="allocation_date" class="form-control" required>
        </div>

        <button class="btn btn-primary">Allocate</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hostelSelect = document.getElementById('hostelSelect');
        const roomSelect = document.getElementById('roomSelect');
        const roomAvailability = document.getElementById('roomAvailability');

        function filterRooms() {
            const hostelId = hostelSelect.value;
            Array.from(roomSelect.options).forEach(option => {
                const matches = option.dataset.hostel == hostelId || option.value === "";
                option.style.display = matches ? 'block' : 'none';
            });
            roomSelect.value = "";
            roomAvailability.innerText = "";
        }

        function showAvailability() {
            const selected = roomSelect.selectedOptions[0];
            if (selected && selected.textContent.includes('(')) {
                const match = selected.textContent.match(/\\((\\d+)/(\\d+)\\)/);
                if (match) {
                    const used = match[1];
                    const total = match[2];
                    roomAvailability.innerText = `Occupied: ${used} / ${total}`;
                }
            }
        }

        hostelSelect.addEventListener('change', filterRooms);
        roomSelect.addEventListener('change', showAvailability);

        filterRooms();
    });
</script>
@endsection