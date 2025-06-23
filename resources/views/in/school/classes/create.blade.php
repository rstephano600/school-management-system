@extends('layouts.app')
@section('title', 'Schedule Class')

@section('content')
<div class="container">
    <h3 class="mb-4">Schedule New Class</h3>
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
    <form action="{{ route('classes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Subject</label>
            <select name="subject_id" class="form-select" required>
                <option value="">Select Subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Grade Level</label>
            <select name="grade_id" class="form-select" required>
                <option value="">Select Grade</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Section</label>
            <select name="section_id" class="form-select" required>
                <option value="">Select Section</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }} ({{ $section->code }})</option>
                @endforeach
            </select>
        </div>

<div class="mb-3">
    <label>Teacher</label>
    <select name="teacher_id" class="form-select" required>
        @foreach($teachers as $teacher)
            @if ($teacher->user)
                <option value="{{ $teacher->user_id }}">
                    {{ $teacher->user->name }}
                </option>
            @endif
        @endforeach
    </select>
</div>


        <div class="mb-3">
            <label>Room</label>
            <select name="room_id" class="form-select">
                <option value="">Select Room (optional)</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name ?? $room->number }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Class Days</label>
            <select name="class_days[]" multiple class="form-select">
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple days</small>
        </div>

        <div class="mb-3">
            <label>Start Time</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>End Time</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Max Capacity</label>
            <input type="number" name="max_capacity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Academic Year</label>
            <select name="academic_year_id" class="form-select" required>
                @foreach($years as $year)
                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Schedule</button>
        <a href="{{ route('classes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
