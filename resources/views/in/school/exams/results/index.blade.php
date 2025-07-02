@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Exam Results</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('exam-results.create') }}" class="btn btn-primary mb-3">Add Result</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Exam</th>
                <th>Student</th>
                <th>Marks</th>
                <th>Grade</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr>
                <td>{{ $result->exam->title ?? 'N/A' }}</td>
                <td>{{ $result->student->first_name ?? '' }} {{ $result->student->last_name ?? '' }}</td>
                <td>{{ $result->marks_obtained }}</td>
                <td>{{ $result->grade }}</td>
                <td>
                    @if($result->published)
                        <span class="badge bg-success">Published</span>
                    @else
                        <span class="badge bg-secondary">Draft</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('exam-results.show', $result) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('exam-results.edit', $result) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('exam-results.destroy', $result) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this result?')">Delete</button>
                    </form>
                    @if(!$result->published)
                    <form action="{{ route('exam-results.publish', $result) }}" method="POST" style="display:inline-block">
                        @csrf
                        <button class="btn btn-success btn-sm" onclick="return confirm('Publish result?')">Publish</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $results->links() }}
</div>
@endsection
