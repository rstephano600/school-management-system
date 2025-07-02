@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-3">Academic Records</h2>
    <a href="{{ route('academic-records.create') }}" class="btn btn-primary mb-3">Add Record</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Subject</th>
                <th>Year</th>
                <th>Semester</th>
                <th>Final Grade</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td>{{ $record->student->user->first_name ?? 'N/A' }}</td>
                <td>{{ $record->subject->name ?? 'N/A' }}</td>
                <td>{{ $record->year->name ?? 'N/A' }}</td>
                <td>{{ $record->semester->name ?? '-' }}</td>
                <td>{{ $record->final_grade ?? '-' }}</td>
                <td>
                    <a href="{{ route('academic-records.show', $record) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('academic-records.edit', $record) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('academic-records.destroy', $record) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this record?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $records->links() }}
</div>
@endsection