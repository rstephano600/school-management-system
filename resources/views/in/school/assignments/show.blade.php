@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-3">Assignment Details</h2>
    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Title:</strong> {{ $assignment->title }}</li>
        <li class="list-group-item"><strong>Class:</strong> {{ $assignment->class->name ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Type:</strong> {{ ucfirst($assignment->assignment_type) }}</li>
        <li class="list-group-item"><strong>Due Date:</strong> {{ $assignment->due_date }}</li>
        <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($assignment->status) }}</li>
        <li class="list-group-item"><strong>Description:</strong> {{ $assignment->description }}</li>
        @if($assignment->file)
        <li class="list-group-item"><strong>File:</strong> <a href="{{ asset('storage/' . $assignment->file) }}" target="_blank">Download</a></li>
        @endif
    </ul>
    <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection