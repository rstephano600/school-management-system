{{-- resources/views/in/school/timetables/_form.blade.php --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label>Class</label>
        <select name="class_id" class="form-select" required onchange="autofillTimetableDetails(this.value)">
            <option value="">-- Select Class --</option>
            @foreach($classes as $class)
                <option 
                    value="{{ $class->id }}"
                    data-teacher="{{ $class->teacher_id }}"
                    data-room="{{ $class->room_id }}"
                    data-year="{{ $class->academic_year_id }}"
                    {{ (old('class_id', $timetable->class_id ?? '') == $class->id) ? 'selected' : '' }}>
                    {{ $class->subject->name ?? 'Class '.$class->id }} ({{ $class->section->name ?? '-' }})
                </option>
            @endforeach
        </select>
    </div>

    <input type="hidden" name="teacher_id" id="autofilled_teacher">
    <input type="hidden" name="room_id" id="autofilled_room">
    <input type="hidden" name="academic_year_id" id="autofilled_year">

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

{{-- JS to autofill hidden fields --}}
@push('scripts')
<script>
function autofillTimetableDetails(classId) {
    const selectedOption = document.querySelector(`option[value='${classId}']`);
    if (selectedOption) {
        document.getElementById('autofilled_teacher').value = selectedOption.dataset.teacher || '';
        document.getElementById('autofilled_room').value = selectedOption.dataset.room || '';
        document.getElementById('autofilled_year').value = selectedOption.dataset.year || '';
    }
}
</script>
@endpush
