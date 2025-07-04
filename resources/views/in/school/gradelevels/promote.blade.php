@extends('layouts.app')
@section('title', 'Promote Student')

@section('content')
<div class="container">
    <h4>Promote {{ $student->user->name }} to a New Grade</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('student.grades.store', $student->user_id) }}" method="POST" class="mt-3">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Grade Level *</label>
                <select name="grade_level_id" class="form-select" required>
                    <option value="">Select Grade</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Academic Year *</label>
                <select name="academic_year_id" class="form-select" required>
                    <option value="">Select Year</option>
                    @foreach($years as $year)
                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Promote</button>
            <a href="{{ route('student.grades.index', $student->user_id) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
