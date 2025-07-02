@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Academic Record Details</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Student:</strong> {{ $academicRecord->student->user->full_name ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Subject:</strong> {{ $academicRecord->subject->name ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Class:</strong> {{ $academicRecord->class->name ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Academic Year:</strong> {{ $academicRecord->year->name ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Semester:</strong> {{ $academicRecord->semester->name ?? '-' }}</li>
        <li class="list-group-item"><strong>Final Grade:</strong> {{ $academicRecord->final_grade }}</li>
        <li class="list-group-item"><strong>Remarks:</strong> {{ $academicRecord->remarks }}</li>
    </ul>
    <a href="{{ route('academic-records.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
