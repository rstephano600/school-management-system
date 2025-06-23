<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $event->title ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Start Date & Time</label>
    <input type="datetime-local" name="start_datetime" class="form-control" value="{{ old('start_datetime', isset($event) ? $event->start_datetime->format('Y-m-d\\TH:i') : '') }}" required>
</div>
<div class="mb-3">
    <label>End Date & Time</label>
    <input type="datetime-local" name="end_datetime" class="form-control" value="{{ old('end_datetime', isset($event) ? $event->end_datetime->format('Y-m-d\\TH:i') : '') }}" required>
</div>
<div class="mb-3">
    <label>Location</label>
    <input type="text" name="location" class="form-control" value="{{ old('location', $event->location ?? '') }}">
</div>
<div class="mb-3">
    <label>Event Type</label>
    <select name="event_type" class="form-control" required>
        @foreach(['academic', 'holiday', 'meeting', 'sports', 'cultural', 'other'] as $type)
            <option value="{{ $type }}" @if(($event->event_type ?? old('event_type')) === $type) selected @endif>{{ ucfirst($type) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Audience</label>
    <select name="audience" class="form-control" required>
        @foreach(['all', 'teachers', 'students', 'parents', 'staff'] as $aud)
            <option value="{{ $aud }}" @if(($event->audience ?? old('audience')) === $aud) selected @endif>{{ ucfirst($aud) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $event->description ?? '') }}</textarea>
</div>