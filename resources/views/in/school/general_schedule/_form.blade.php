<div class="mb-3">
    <label>Academic Year</label>
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
    <select name="academic_year_id" class="form-select" required>
        @foreach($academicYears as $year)
            <option value="{{ $year->id }}"
                {{ old('academic_year_id', $schedule->academic_year_id ?? '') == $year->id ? 'selected' : '' }}>
                {{ $year->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Day of the Week</label>
    <select name="day_of_week" class="form-select" required>
        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
            <option value="{{ $day }}"
                {{ old('day_of_week', $schedule->day_of_week ?? '') == $day ? 'selected' : '' }}>
                {{ $day }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Activity</label>
    <input type="text" name="activity" class="form-control" value="{{ old('activity', $schedule->activity ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Start Time</label>
    <input type="time" name="start_time" class="form-control" value="{{ old('start_time', $schedule->start_time ?? '') }}" required>
</div>

<div class="mb-3">
    <label>End Time</label>
    <input type="time" name="end_time" class="form-control" value="{{ old('end_time', $schedule->end_time ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $schedule->description ?? '') }}</textarea>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="status" class="form-check-input" value="1" {{ old('status', $schedule->status ?? true) ? 'checked' : '' }}>
    <label class="form-check-label">Active</label>
</div>
