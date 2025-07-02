@extends('layouts.app')
@section('title', 'Tests Timetable')

@section('content')
<div class="container">
    <h3 class="mb-4">Tests Timetable</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('tests.create') }}" class="btn btn-primary mb-3">+ Add Test</a>

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
                @forelse($tests as $test)
                    <tr>
                        <td>{{ $test->title }}</td>
                        <td>{{ $test->class->class_name ?? '-' }}</td>
                        <td>{{ $test->subject->name ?? '-' }}</td>
                        <td>{{ $test->teacher->user->name ?? '-' }}</td>
                        <td>{{ $test->test_date }}</td>
                        <td>{{ $test->start_time }} - {{ $test->end_time }}</td>
                        <td>
                            <a href="{{ route('tests.edit', $test->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('tests.destroy', $test->id) }}" method="POST" class="d-inline">
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
