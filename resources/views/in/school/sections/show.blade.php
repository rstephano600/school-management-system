@extends('layouts.app')
@section('title', 'Section Details')

@section('content')
<div class="container">
    <h3 class="mb-4">Section Details</h3>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $section->name }} ({{ $section->code }})</h5>

            <p><strong>Grade Level:</strong> {{ $section->grade->name ?? '-' }}</p>
            <p><strong>Capacity:</strong> {{ $section->capacity }}</p>
            <p><strong>Room:</strong> {{ $section->room->name ?? $section->room->number ?? 'N/A' }}</p>
            <p><strong>Class Teacher:</strong> {{ $section->teacher->user->name ?? 'Not Assigned' }}</p>
            <p><strong>Academic Year:</strong> {{ $section->academicYear->name ?? '-' }}</p>
            <p><strong>Status:</strong>
                <span class="badge {{ $section->status ? 'bg-success' : 'bg-secondary' }}">
                    {{ $section->status ? 'Active' : 'Inactive' }}
                </span>
            </p>

            <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('sections.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
