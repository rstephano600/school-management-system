@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Grade Level Details</h3>

    <div class="mb-3">
        <strong>Name:</strong> {{ $gradeLevel->name }}
    </div>
    <div class="mb-3">
        <strong>Code:</strong> {{ $gradeLevel->code }}
    </div>
    <div class="mb-3">
        <strong>Level:</strong> {{ $gradeLevel->level }}
    </div>
    <div class="mb-3">
        <strong>Description:</strong> {{ $gradeLevel->description }}
    </div>

    <a href="{{ route('grade-levels.edit', $gradeLevel->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('grade-levels.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
