@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Student Grades</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('grades.create') }}" class="btn btn-primary mb-3">Add Grade</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Class</th>
                <th>Score</th>
                <th>Grade</th>
                <th>Max Score</th>
                <th>Graded By</th>
                <th>Grade Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
            <tr>
                <td>{{ $grade->student->first_name ?? 'N/A' }}</td>
                <td>{{ $grade->class->name ?? 'N/A' }}</td>
                <td>{{ $grade->score }}</td>
                <td>{{ $grade->grade_value ?? '-' }}</td>
                <td>{{ $grade->max_score }}</td>
                <td>{{ $grade->grader->first_name ?? '-' }}</td>
                <td>{{ $grade->grade_date }}</td>
                <td>
                    <a href="{{ route('grades.show', $grade) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('grades.edit', $grade) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('grades.destroy', $grade) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this grade?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $grades->links() }}
</div>
@endsection
