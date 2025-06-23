@extends('layouts.app')
@section('title', 'Edit Section')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Section</h3>
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
    <form action="{{ route('sections.update', $section->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Section Name</label>
            <input name="name" value="{{ old('name', $section->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Code</label>
            <input name="code" value="{{ old('code', $section->code) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Grade Level</label>
            <select name="grade_id" class="form-select" required>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ $section->grade_id == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" value="{{ old('capacity', $section->capacity) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Room</label>
            <select name="room_id" class="form-select">
                <option value="">Select Room (optional)</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ $section->room_id == $room->id ? 'selected' : '' }}>
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
                    <option value="{{ $teacher->user_id }}" {{ $section->class_teacher_id == $teacher->user_id ? 'selected' : '' }}>
                        {{ $teacher->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Academic Year</label>
            <select name="academic_year_id" class="form-select" required>
                @foreach($years as $year)
                    <option value="{{ $year->id }}" {{ $section->academic_year_id == $year->id ? 'selected' : '' }}>
                        {{ $year->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                {{ $section->status ? 'checked' : '' }}>
            <label class="form-check-label" for="status">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('sections.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
