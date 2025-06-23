@extends('layouts.app')
@section('title', 'Edit Teacher')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Teacher</h3>

    <form action="{{ route('teachers.update', $teacher->user_id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input name="name" value="{{ old('name', $teacher->user->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $teacher->user->email) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Employee ID</label>
            <input name="employee_id" value="{{ old('employee_id', $teacher->employee_id) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Joining Date</label>
            <input type="date" name="joining_date" value="{{ old('joining_date', $teacher->joining_date) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Qualification</label>
            <input name="qualification" value="{{ old('qualification', $teacher->qualification) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Specialization</label>
            <input name="specialization" value="{{ old('specialization', $teacher->specialization) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Experience (years)</label>
            <input name="experience" value="{{ old('experience', $teacher->experience) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Department</label>
            <input name="department" value="{{ old('department', $teacher->department) }}" class="form-control" required>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="is_class_teacher" id="is_class_teacher"
                {{ old('is_class_teacher', $teacher->is_class_teacher) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_class_teacher">Class Teacher</label>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="status" id="status"
                {{ old('status', $teacher->status) ? 'checked' : '' }}>
            <label class="form-check-label" for="status">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
