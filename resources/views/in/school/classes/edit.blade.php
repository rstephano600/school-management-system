@extends('layouts.app')
@section('title', 'Edit Scheduled Class')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Class</h3>
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
    <form action="{{ route('classes.update', $class->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Subject</label>
            <select name="subject_id" class="form-select" required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $class->subject_id == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Grade Level</label>
            <select name="grade_id" class="form-select" required>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ $class->grade_id == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Section</label>
            <select name="section_id" class="form-select" required>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" {{ $class->section_id == $section->id ? 'selected' : '' }}>
                        {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Teacher</label>
            <select name="teacher_id" class="form-select" required>
@foreach($teachers as $teacher)
    <option value="{{ $teacher->user_id }}">
        {{ $teacher->user->name }}
    </option>
@endforeach

            </select>
        </div>

        <div class="mb-3">
            <label>Room</label>
            <select name="room_id" class="form-select">
                <option value="">Select Room (optional)</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ $class->room_id == $room->id ? 'selected' : '' }}>
                        {{ $room->name ?? $room->number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Class Days</label>
            <select name="class_days[]" multiple class="form-select">
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                    <option value="{{ $day }}" {{ in_array($day, $class->class_days ?? []) ? 'selected' : '' }}>
                        {{ $day }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Start Time</label>
            <input type="time" name="start_time" class="form-control" value="{{ $class->start_time }}" required>
        </div>

        <div class="mb-3">
            <label>End Time</label>
            <input type="time" name="end_time" class="form-control" value="{{ $class->end_time }}" required>
        </div>

        <div class="mb-3">
            <label>Max Capacity</label>
            <input type="number" name="max_capacity" class="form-control" value="{{ $class->max_capacity }}" required>
        </div>

        <div class="mb-3">
            <label>Academic Year</label>
            <select name="academic_year_id" class="form-select" required>
                @foreach($years as $year)
                    <option value="{{ $year->id }}" {{ $class->academic_year_id == $year->id ? 'selected' : '' }}>
                        {{ $year->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('classes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
