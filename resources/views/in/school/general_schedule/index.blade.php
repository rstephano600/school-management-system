@extends('layouts.app')
@section('title', 'General School Timetable')

@section('content')
<div class="container">
    <h3 class="mb-4">General School Timetable</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('general-schedule.create') }}" class="btn btn-primary mb-3">+ Add Activity</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-info">
                <tr>
                    <th>Day</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Activity</th>
                    <th>Academic Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $day => $entries)
                    @foreach($entries as $entry)
                        <tr>
                            <td>{{ $loop->first ? $day : '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($entry->start_time)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($entry->end_time)->format('H:i') }}</td>
                            <td>{{ $entry->activity }}</td>
                            <td>{{ $entry->academicYear->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('general-schedule.edit', $entry->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('general-schedule.destroy', $entry->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this entry?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr><td colspan="6">No general schedules defined.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
