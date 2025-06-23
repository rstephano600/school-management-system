{{-- resources/views/in/school/timetables/_form.blade.php --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label>Class</label>
        <select name="class_id" class="form-select" required>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ (old('class_id', $timetable->class_id ?? '') == $class->id) ? 'selected' : '' }}>
                    {{ $class->subject->name ?? 'Class '.$class->id }} ({{ $class->section->name ?? '-' }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>Teacher</label>
        <select name="teacher_id" class="form-select" required>
            @foreach($teachers as $teacher)
                @if ($teacher->user)
                    <option value="{{ $teacher->user_id }}" {{ (old('teacher_id', $timetable->teacher_id ?? '') == $teacher->user_id) ? 'selected' : '' }}>
                        {{ $teacher->user->name }} ({{ $teacher->specialization }})
                    </option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>Room</label>
        <select name="room_id" class="form-select">
            <option value="">-- Optional --</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" {{ (old('room_id', $timetable->room_id ?? '') == $room->id) ? 'selected' : '' }}>
                    {{ $room->name ?? 'Room '.$room->number }} - {{ $room->building }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>Day of Week</label>
        <select name="day_of_week" class="form-select" required>
            @foreach([1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday',7=>'Sunday'] as $num => $day)
                <option value="{{ $num }}" {{ (old('day_of_week', $timetable->day_of_week ?? '') == $num) ? 'selected' : '' }}>{{ $day }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label>Period</label>
        <input type="number" name="period_number" class="form-control" value="{{ old('period_number', $timetable->period_number ?? '') }}" required>
    </div>
    <div class="col-md-3 mb-3">
        <label>Start Time</label>
        <input type="time" name="start_time" class="form-control" value="{{ old('start_time', $timetable->start_time ?? '') }}" required>
    </div>
    <div class="col-md-3 mb-3">
        <label>End Time</label>
        <input type="time" name="end_time" class="form-control" value="{{ old('end_time', $timetable->end_time ?? '') }}" required>
    </div>
    <div class="col-md-3 mb-3">
        <label>Academic Year</label>
        <select name="academic_year_id" class="form-select" required>
            @foreach($years as $year)
                <option value="{{ $year->id }}" {{ (old('academic_year_id', $timetable->academic_year_id ?? '') == $year->id) ? 'selected' : '' }}>
                    {{ $year->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>Effective From</label>
        <input type="date" name="effective_from" class="form-control" value="{{ old('effective_from', optional($timetable->effective_from ?? null)->format('Y-m-d')) }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label>Effective To</label>
        <input type="date" name="effective_to" class="form-control" value="{{ old('effective_to', optional($timetable->effective_to ?? null)->format('Y-m-d')) }}" required>
    </div>
    <div class="col-md-12 mb-3">
        <div class="form-check">
            <input type="checkbox" name="status" value="1" class="form-check-input" {{ old('status', $timetable->status ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>
    </div>
</div>
