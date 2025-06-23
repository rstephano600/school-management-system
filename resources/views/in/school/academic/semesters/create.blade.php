@extends('layouts.app')
@section('title', 'Add Semester')

@section('content')
<div class="container">
    <h3 class="mb-4">Add New Semester</h3>

    <form action="{{ route('semesters.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="academic_year_id" class="form-label">Academic Year</label>
            <select name="academic_year_id" id="academic_year_id" class="form-select" required>
                <option value="">Select Academic Year</option>
                @foreach($academicYears as $year)
                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Semester Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save Semester</button>
        <a href="{{ route('semesters.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
