@extends('layouts.app')
@section('title', 'Subject Details')

@section('content')
<div class="container">
    <h3 class="mb-4">Subject Details</h3>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $subject->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">Code: {{ $subject->code }}</h6>

            <p class="card-text"><strong>Description:</strong><br>
                {{ $subject->description ?? 'N/A' }}
            </p>

            <p class="card-text">
                <strong>Is Core:</strong>
                <span class="badge {{ $subject->is_core ? 'bg-success' : 'bg-secondary' }}">
                    {{ $subject->is_core ? 'Yes' : 'No' }}
                </span>
            </p>

<p><strong>Assigned Teachers:</strong><br>
    @forelse($subject->teachers as $teacher)
        <span class="badge bg-info">{{ $teacher->name }}</span>
    @empty
        <span class="text-muted">No teachers assigned.</span>
    @endforelse
</p>


            <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
