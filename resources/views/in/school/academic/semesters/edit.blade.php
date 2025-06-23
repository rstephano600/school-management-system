@extends('layouts.app')
@section('title', 'Edit Semester')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Semester</h3>

    <form action="{{ route('semesters.update', $semester) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label for="academic_year_id" class="form-label">Academic Year</label>
            <select name="academic_year_id" id="academic_year_id" class="form-select" required>
                <option value="">Select Academic Year</option>
                @foreach($academicYears as $year)
                    <option value="{{ $year->id }}" {{ $semester->academic_year_id == $year->id ? 'selected' : '' }}>
                        {{ $year->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Semester Name</label>
            <input type="text" name="name" class="form-control" value="{{ $semester->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $semester->start_date }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $semester->end_date }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Semester</button>
        <a href="{{ route('semesters.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
