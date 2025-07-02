@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Submissions</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('submissions.create') }}" class="btn btn-primary mb-3">Submit Assignment</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Assignment</th>
                <th>Student</th>
                <th>Submitted At</th>
                <th>Status</th>
                <th>File</th>
                <th>Graded By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($submissions as $submission)
            <tr>
                <td>{{ $submission->assignment->title ?? '-' }}</td>
                <td>{{ $submission->student->first_name ?? 'N/A' }}</td>
                <td>{{ $submission->submission_date }}</td>
                <td>
                    <span class="badge bg-{{ $submission->status === 'late' ? 'warning' : ($submission->status === 'missing' ? 'danger' : 'success') }}">
                        {{ ucfirst($submission->status) }}
                    </span>
                </td>
                <td>
                    @if($submission->file)
                        <a href="{{ asset('storage/' . $submission->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $submission->grader->first_name ?? '-' }}</td>
                <td>
                    <a href="{{ route('submissions.show', $submission) }}" class="btn btn-info btn-sm">View</a>
                    <form action="{{ route('submissions.destroy', $submission) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this submission?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $submissions->links() }}
</div>
@endsection
