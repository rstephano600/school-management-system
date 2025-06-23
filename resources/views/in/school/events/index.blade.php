@extends('layouts.app')
@section('content')
<div class="container">
    <h3>School Events</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('events.index') }}" class="row g-3 mb-3">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title or type">
        </div>
        <div class="col-md-2">
            <button class="btn btn-secondary">Search</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('events.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Add Event</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Start</th>
                <th>End</th>
                <th>Audience</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ ucfirst($event->event_type) }}</td>
                <td>{{ $event->start_datetime }}</td>
                <td>{{ $event->end_datetime }}</td>
                <td>{{ ucfirst($event->audience) }}</td>
                <td>
                    @php
                        $badge = $event->status === 'completed' ? 'success' :
                                 ($event->status === 'cancelled' ? 'danger' : 'warning');
                    @endphp
                    <span class="badge bg-{{ $badge }}">{{ ucfirst($event->status) }}</span>
                </td>
                <td>
                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-secondary">View</a>
                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this event?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7">No events found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $events->withQueryString()->links() }}
    </div>
</div>
@endsection