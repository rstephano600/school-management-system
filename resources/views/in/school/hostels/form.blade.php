<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $hostel->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Type</label>
    <select name="type" class="form-control" required>
        @foreach(['boys', 'girls', 'co-ed'] as $type)
            <option value="{{ $type }}" @if(($hostel->type ?? old('type')) === $type) selected @endif>{{ ucfirst($type) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Address</label>
    <textarea name="address" class="form-control" required>{{ old('address', $hostel->address ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>Contact Number</label>
    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $hostel->contact_number ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Warden</label>
    <select name="warden_id" class="form-control">
        <option value="">-- Select Warden --</option>
        @foreach($wardens as $warden)
            <option value="{{ $warden->user_id }}" @if(($hostel->warden_id ?? old('warden_id')) == $warden->user_id) selected @endif>
                {{ $warden->user->name ?? 'Unnamed' }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Capacity</label>
    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $hostel->capacity ?? 1) }}" required>
</div>
<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $hostel->description ?? '') }}</textarea>
</div>