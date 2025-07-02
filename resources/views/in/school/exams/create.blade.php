@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Create New Exam</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('exams.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Exam Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label>Exam Type</label>
            <select name="exam_type_id" class="form-select" required>
                <option value="">-- Select Type --</option>
                @foreach($examTypes as $type)
                    <option value="{{ $type->id }}" {{ old('exam_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" required value="{{ old('start_date') }}">
            </div>
            <div class="col">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" required value="{{ old('end_date') }}">
            </div>
        </div>

        <div class="mb-3">
            <label>Academic Year</label>
            <select name="academic_year_id" class="form-select" required>
                <option value="">-- Select Year --</option>
                @foreach($academicYears as $year)
                    <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Grade Level (optional)</label>
            <select name="grade_id" class="form-select">
                <option value="">-- None --</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Subject (optional)</label>
            <select name="subject_id" class="form-select">
                <option value="">-- None --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Total Marks</label>
                <input type="number" name="total_marks" class="form-control" required value="{{ old('total_marks') }}">
            </div>
            <div class="col">
                <label>Passing Marks</label>
                <input type="number" name="passing_marks" class="form-control" required value="{{ old('passing_marks') }}">
            </div>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="upcoming">Upcoming</option>
                <option value="ongoing">Ongoing</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Description (optional)</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <button class="btn btn-success">Save Exam</button>
        <a href="{{ route('exams.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
