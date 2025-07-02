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
        @foreach($years as $year)
            <option value="{{ $year->id }}" {{ old('academic_year_id', $test->academic_year_id ?? '') == $year->id ? 'selected' : '' }}>
                {{ $year->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Class</label>
    <select name="class_id" class="form-select" required>
        @foreach($classes as $class)
            <option value="{{ $class->id }}" {{ old('class_id', $test->class_id ?? '') == $class->id ? 'selected' : '' }}>
                {{ $class->class_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Subject</label>
    <select name="subject_id" class="form-select" required>
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}" {{ old('subject_id', $test->subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                {{ $subject->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Teacher</label>
    <select name="teacher_id" class="form-select" required>
        @foreach($teachers as $teacher)
            @if ($teacher->user)
                <option value="{{ $teacher->user_id }}" {{ old('teacher_id', $test->teacher_id ?? '') == $teacher->user_id ? 'selected' : '' }}>
                    {{ $teacher->user->name }}
                </option>
            @endif
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Test Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $test->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Date</label>
    <input type="date" name="test_date" class="form-control" value="{{ old('test_date', $test->test_date ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Start Time</label>
    <input type="time" name="start_time" class="form-control" value="{{ old('start_time', $test->start_time ?? '') }}" required>
</div>

<div class="mb-3">
    <label>End Time</label>
    <input type="time" name="end_time" class="form-control" value="{{ old('end_time', $test->end_time ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $test->description ?? '') }}</textarea>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="status" class="form-check-input" value="1" {{ old('status', $test->status ?? true) ? 'checked' : '' }}>
    <label class="form-check-label">Active</label>
</div>
