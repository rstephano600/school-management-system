@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Notices</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('notices.create') }}" class="btn btn-primary mb-3">Upload New Notice</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Topic</th>
                <th>Date</th>
                <th>Audience</th>
                <th>Status</th>
                <th>File</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notices as $notice)
            <tr>
                <td>{{ $notice->title }}</td>
                <td>{{ $notice->topic ?? '-' }}</td>
                <td>{{ $notice->notice_date }}</td>
                <td>{{ ucfirst($notice->audience) }}</td>
                <td>{{ ucfirst($notice->status) }}</td>
                <td>
                    @if($notice->content)
                        <a href="{{ asset('storage/' . $notice->content) }}" target="_blank" class="btn btn-sm btn-info">View</a>
                    @endif
                </td>
                <td>
                    <a href="{{ route('notices.show', $notice->id) }}" class="btn btn-sm btn-secondary">Details</a>
                    <a href="{{ route('notices.edit', $notice->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('notices.destroy', $notice->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this notice?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $notices->withQueryString()->links() }}
    </div>
</div>
@endsection