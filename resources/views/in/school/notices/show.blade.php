@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Notice Details</h3>
    <p><strong>Title:</strong> {{ $notice->title }}</p>
    <p><strong>Topic:</strong> {{ $notice->topic ?? '-' }}</p>
    <p><strong>Date:</strong> {{ $notice->notice_date }}</p>
    <p><strong>Audience:</strong> {{ ucfirst($notice->audience) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($notice->status) }}</p>
    <p><strong>Uploaded By:</strong> {{ $notice->creator->name ?? 'N/A' }}</p>
    <p><strong>File:</strong>
        @if($notice->content)
            <a href="{{ asset('storage/' . $notice->content) }}" target="_blank" class="btn btn-sm btn-info">View Document</a>
        @else
            No file attached.
        @endif
    </p>
    <a href="{{ route('notices.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection