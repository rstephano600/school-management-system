@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Grade</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('grades.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Student</label>
            <select name="student_id" class="form-select" required>
                <option value="">Select student</option>
                @foreach($students as $student)
                    <option value="{{ $student->user_id }}" {{ old('student_id') == $student->user_id ? 'selected' : '' }}>
                        {{ $student->first_name }} {{ $student->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Class</label>
            <select name="class_id" class="form-select" required>
                <option value="">Select class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Submission (optional)</label>
            <select name="submission_id" class="form-select">
                <option value="">-- None --</option>
                @foreach($submissions as $submission)
                    <option value="{{ $submission->id }}" {{ old('submission_id') == $submission->id ? 'selected' : '' }}>
                        {{ $submission->assignment->title ?? 'Assignment #' . $submission->id }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Score</label>
                <input type="number" name="score" class="form-control" step="0.01" required value="{{ old('score') }}">
            </div>
            <div class="col">
                <label class="form-label">Max Score</label>
                <input type="number" name="max_score" class="form-control" step="0.01" required value="{{ old('max_score') }}">
            </div>
            <div class="col">
                <label class="form-label">Grade Value</label>
                <input type="text" name="grade_value" class="form-control" maxlength="5" value="{{ old('grade_value') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Comments (optional)</label>
            <textarea name="comments" class="form-control">{{ old('comments') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Grade Date</label>
            <input type="date" name="grade_date" class="form-control" value="{{ old('grade_date', date('Y-m-d')) }}" required>
        </div>

        <button class="btn btn-success">Save Grade</button>
        <a href="{{ route('grades.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
