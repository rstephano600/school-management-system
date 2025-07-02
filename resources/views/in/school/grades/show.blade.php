@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Grade Details</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Student:</strong> {{ $grade->student->first_name ?? 'N/A' }}</p>
            <p><strong>Class:</strong> {{ $grade->class->name ?? 'N/A' }}</p>
            <p><strong>Score:</strong> {{ $grade->score }} / {{ $grade->max_score }}</p>
            <p><strong>Grade Value:</strong> {{ $grade->grade_value ?? '-' }}</p>
            <p><strong>Comments:</strong> {{ $grade->comments ?? 'None' }}</p>
            <p><strong>Graded By:</strong> {{ $grade->grader->first_name ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ $grade->grade_date }}</p>

            <a href="{{ route('grades.index') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
@endsection
