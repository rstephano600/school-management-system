@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Exam Details</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Title:</strong> {{ $exam->title }}</p>
            <p><strong>Type:</strong> {{ $exam->examType->name ?? 'N/A' }}</p>
            <p><strong>Grade:</strong> {{ $exam->grade->name ?? '-' }}</p>
            <p><strong>Subject:</strong> {{ $exam->subject->name ?? '-' }}</p>
            <p><strong>Start Date:</strong> {{ $exam->start_date }}</p>
            <p><strong>End Date:</strong> {{ $exam->end_date }}</p>
            <p><strong>Total Marks:</strong> {{ $exam->total_marks }}</p>
            <p><strong>Passing Marks:</strong> {{ $exam->passing_marks }}</p>
            <p><strong>Status:</strong> {{ ucfirst($exam->status) }}</p>
            <p><strong>Description:</strong> {{ $exam->description }}</p>

            <a href="{{ route('exams.index') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
@endsection
