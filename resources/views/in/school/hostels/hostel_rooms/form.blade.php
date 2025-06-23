<div class="mb-3">
    <label>Room Number</label>
    <input type="text" name="room_number" class="form-control" value="{{ old('room_number', $room->room_number ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Hostel</label>
    <select name="hostel_id" id="hostelSelect" class="form-control" required>
        @foreach($hostels as $hostel)
            <option value="{{ $hostel->id }}" @if(($room->hostel_id ?? old('hostel_id')) == $hostel->id) selected @endif>{{ $hostel->name }}</option>
        @endforeach
    </select>
    <small id="hostelCapacityInfo" class="form-text text-muted"></small>
</div>


<div class="mb-3">
    <label>Room Type</label>
    <select name="room_type" class="form-control" required>
        @foreach(['single', 'double', 'dormitory', 'other'] as $type)
            <option value="{{ $type }}" @if(($room->room_type ?? old('room_type')) === $type) selected @endif>{{ ucfirst($type) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Capacity</label>
    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $room->capacity ?? 1) }}" required>
</div>
<div class="mb-3">
    <label>Cost per Bed</label>
    <input type="number" step="0.01" name="cost_per_bed" class="form-control" value="{{ old('cost_per_bed', $room->cost_per_bed ?? 0) }}" required>
</div>
<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control" required>
        @foreach(['available', 'occupied', 'maintenance'] as $status)
            <option value="{{ $status }}" @if(($room->status ?? old('status')) === $status) selected @endif>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const hostelSelect = document.getElementById('hostelSelect');
    const capacityInfo = document.getElementById('hostelCapacityInfo');

    function fetchCapacity(hostelId) {
        if (!hostelId) return;
        fetch(`/school/hostel-capacity/${hostelId}`)
            .then(res => res.json())
            .then(data => {
                capacityInfo.innerText = `Total: ${data.total} | Assigned: ${data.used} | Available: ${data.remaining}`;
            });
    }

    hostelSelect.addEventListener('change', function () {
        fetchCapacity(this.value);
    });

    // fetch on load
    fetchCapacity(hostelSelect.value);
});
</script>
@endsection
