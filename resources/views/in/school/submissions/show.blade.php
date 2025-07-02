@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Submission Details</h3>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $submission->assignment->title ?? 'Assignment' }}</h5>
            <p><strong>Student:</strong> {{ $submission->student->first_name ?? '-' }}</p>
            <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($submission->status) }}</span></p>
            <p><strong>Submitted At:</strong> {{ $submission->submission_date }}</p>
            <p><strong>Notes:</strong><br>{{ $submission->notes ?? 'None' }}</p>

            @if($submission->file)
                <p><strong>Submitted File:</strong></p>
                <a href="{{ asset('storage/' . $submission->file) }}" target="_blank" class="btn btn-sm btn-primary">
                    Download File
                </a>
            @else
                <p><strong>File:</strong> None</p>
            @endif

            <a href="{{ route('submissions.index') }}" class="btn btn-secondary mt-3">Back to Submissions</a>
        </div>
    </div>
</div>
@endsection
