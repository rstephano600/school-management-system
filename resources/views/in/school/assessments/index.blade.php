@extends('layouts.app')
@section('title', 'Assessments')
@section('content')
<div class="container">
    <h3 class="mb-4">Assessments</h3>
    <a href="{{ route('assessments.create') }}" class="btn btn-primary mb-3">Create New Assessment</a>

    <table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Title</th>
            <th>Grade</th>
            <th>Subject</th>
            <th>Due Date</th>
            <th>Created By</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($assessments as $assessment)
        <tr>
            <td>{{ $assessment->title }}</td>
            <td>{{ $assessment->gradeLevel->name ?? '-' }}</td>
            <td>{{ $assessment->subject->name ?? '-' }}</td>
            <td>{{ $assessment->due_date }}</td>
            <td>{{ $assessment->creator->name ?? 'N/A' }}</td>
            <td>
                <a href="{{ route('assessments.show', $assessment) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('assessments.edit', $assessment) }}" class="btn btn-sm btn-warning">Edit</a>
                <a href="{{ route('assessments.results.index', $assessment) }}" class="btn btn-sm btn-success">Enter Results</a>
                <form action="{{ route('assessments.destroy', $assessment) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


    {{ $assessments->links() }}
</div>
@endsection