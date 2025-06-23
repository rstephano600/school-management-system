@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Event Details</h3>
    <p><strong>Title:</strong> {{ $event->title }}</p>
    <p><strong>Type:</strong> {{ ucfirst($event->event_type) }}</p>
    <p><strong>Start:</strong> {{ $event->start_datetime }}</p>
    <p><strong>End:</strong> {{ $event->end_datetime }}</p>
    <p><strong>Location:</strong> {{ $event->location ?? 'N/A' }}</p>
    <p><strong>Audience:</strong> {{ ucfirst($event->audience) }}</p>
    <p><strong>Description:</strong><br>{{ $event->description ?? '-' }}</p>
    <p><strong>Status:</strong>
        @php
            $badge = $event->status === 'completed' ? 'success' :
                     ($event->status === 'cancelled' ? 'danger' : 'warning');
        @endphp
        <span class="badge bg-{{ $badge }}">{{ ucfirst($event->status) }}</span>
    </p>
    <a href="{{ route('events.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection