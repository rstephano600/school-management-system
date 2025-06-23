@extends('layouts.app')
@section('title', 'Add Section')

@section('content')
<div class="container">
    <h3 class="mb-4">Add Section</h3>

    <form action="{{ route('sections.store') }}" method="POST">
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
            <label>Section Name</label>
            <input name="name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Code</label>
            <input name="code" value="{{ old('code') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Grade Level</label>
            <select name="grade_id" class="form-select" required>
                <option value="">Select Grade</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" value="{{ old('capacity') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Room</label>
            <select name="room_id" class="form-select">
                <option value="">Select Room (optional)</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                        {{ $room->name ?? $room->number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Class Teacher</label>
            <select name="class_teacher_id" class="form-select">
                <option value="">Select Teacher (optional)</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->user_id }}" {{ old('class_teacher_id') == $teacher->user_id ? 'selected' : '' }}>
                        {{ $teacher->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Academic Year</label>
            <select name="academic_year_id" class="form-select" required>
                <option value="">Select Year</option>
                @foreach($years as $year)
                    <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>
                        {{ $year->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="status" id="status" value="1" checked>
            <label class="form-check-label" for="status">Active</label>
        </div>

        <button type="submit" class="btn btn-success">Save Section</button>
        <a href="{{ route('sections.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
