@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Announcement Details</h3>
    <p><strong>Title:</strong> {{ $announcement->title }}</p>
    <p><strong>Start Date:</strong> {{ $announcement->start_date }}</p>
    <p><strong>End Date:</strong> {{ $announcement->end_date }}</p>
    <p><strong>Audience:</strong> {{ ucfirst($announcement->audience) }}</p>
    <p><strong>Status:</strong>
        @php
            $badge = $announcement->status === 'published' ? 'success' :
                     ($announcement->status === 'archived' ? 'secondary' : 'warning');
        @endphp
        <span class="badge bg-{{ $badge }}">{{ ucfirst($announcement->status) }}</span>
    </p>
    <p><strong>Content:</strong><br>{{ $announcement->content }}</p>
    <a href="{{ route('announcements.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection