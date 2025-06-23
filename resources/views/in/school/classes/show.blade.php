@extends('layouts.app')
@section('title', 'Class Details')

@section('content')
<div class="container">
    <h3 class="mb-4">Class Details</h3>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $class->subject->name ?? 'Unknown Subject' }}</h5>

            <p><strong>Grade:</strong> {{ $class->grade->name ?? '-' }}</p>
            <p><strong>Section:</strong> {{ $class->section->name ?? '-' }}</p>
            <p><strong>Teacher:</strong> {{ $class->teacher->name ?? '-' }}</p>
            <p><strong>Room:</strong> {{ $class->room->name ?? $class->room->number ?? 'N/A' }}</p>
            <p><strong>Academic Year:</strong> {{ $class->academicYear->name ?? '-' }}</p>
            <p><strong>Days:</strong> {{ is_array($class->class_days) ? implode(', ', $class->class_days) : '-' }}</p>
            <p><strong>Time:</strong>
                {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }} -
                {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}
            </p>
            <p><strong>Capacity:</strong>
                {{ $class->current_enrollment }}/{{ $class->max_capacity }}
            </p>
            <p><strong>Status:</strong>
                <span class="badge {{ $class->status ? 'bg-success' : 'bg-danger' }}">
                    {{ $class->status ? 'Active' : 'Inactive' }}
                </span>
            </p>

            <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
