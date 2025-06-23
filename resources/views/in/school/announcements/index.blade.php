"@extends('layouts.app')
@section('content')
<div class="container">
    <h3>School Announcements</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('announcements.index') }}" class="row g-3 mb-3">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title or audience">
        </div>
        <div class="col-md-2">
            <button class="btn btn-secondary">Search</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('announcements.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <a href="{{ route('announcements.create') }}" class="btn btn-primary mb-3">Add Announcement</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Start</th>
                <th>End</th>
                <th>Audience</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($announcements as $announcement)
            <tr>
                <td>{{ $announcement->title }}</td>
                <td>{{ $announcement->start_date }}</td>
                <td>{{ $announcement->end_date }}</td>
                <td>{{ ucfirst($announcement->audience) }}</td>
                @php
                    $badge = $announcement->status === 'published' ? 'success' :
                             ($announcement->status === 'archived' ? 'secondary' : 'warning');
                @endphp
                <td><span class="badge bg-{{ $badge }}">{{ ucfirst($announcement->status) }}</span></td>
                <td>
                    <a href="{{ route('announcements.show', $announcement->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this announcement?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6">No announcements found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $announcements->withQueryString()->links() }}
    </div>
</div>
@endsection