@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-3">Assignments</h2>
    <a href="{{ route('assignments.create') }}" class="btn btn-primary mb-3">Add Assignment</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Class</th>
                <th>Type</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->title }}</td>
                <td>{{ $assignment->class->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($assignment->assignment_type) }}</td>
                <td>{{ $assignment->due_date }}</td>
                <td>{{ ucfirst($assignment->status) }}</td>
                <td>
                    <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('assignments.edit', $assignment) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('assignments.destroy', $assignment) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $assignments->links() }}
</div>
@endsection