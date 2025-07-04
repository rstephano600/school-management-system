@extends('layouts.app')
@section('title', 'Assessment Details')
@section('content')
<div class="container">
    <h3>{{ $assessment->title }}</h3>
    <p><strong>Type:</strong> {{ ucfirst($assessment->type) }}</p>
    <p><strong>Grade:</strong> {{ $assessment->gradeLevel->name }}</p>
    <p><strong>Subject:</strong> {{ $assessment->subject->name }}</p>
    <p><strong>Academic Year:</strong> {{ $assessment->academicYear->name }}</p>
    <p><strong>Semester:</strong> {{ $assessment->semester->name ?? 'N/A' }}</p>
    <p><strong>Due Date:</strong> {{ $assessment->due_date }}</p>
    <p><strong>Description:</strong> {{ $assessment->description }}</p>
    <a href="{{ route('assessments.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection