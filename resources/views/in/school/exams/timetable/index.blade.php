@extends('layouts.app')
@section('title', 'Tests Timetable')

@section('content')
<div class="container">
    <h3 class="mb-4">Exam Timetable</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('exams.create') }}" class="btn btn-primary mb-3">+ Add Exam</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-info">
                <tr>
                    <th>Title</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exams as $exam)
                    <tr>
                        <td>{{ $exam->title }}</td>
                        <td>{{ $exam->class->class_name ?? '-' }}</td>
                        <td>{{ $exam->subject->name ?? '-' }}</td>
                        <td>{{ $exam->teacher->user->name ?? '-' }}</td>
                        <td>{{ $exam->test_date }}</td>
                        <td>{{ $exam->start_time }} - {{ $exam->end_time }}</td>
                        <td>
                            <a href="{{ route('exams.edit', $exam->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete test?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">No tests scheduled.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
