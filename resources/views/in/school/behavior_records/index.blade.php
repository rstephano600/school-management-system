@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Behavior Records</h3>
    
    <form method="GET" action="{{ route('behavior_records.index') }}" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by student or type">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-secondary" type="submit">Filter</button>
            <a href="{{ route('behavior_records.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <a href="{{ route('behavior_records.create') }}" class="btn btn-primary mb-3">Add Record</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Student</th>
                <th>Type</th>
                <th>Status</th>
                <th>Reported By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
            <tr>
                <td>{{ $record->incident_date }}</td>
                <td>{{ $record->student->user->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($record->incident_type) }}</td>
                <td>{{ ucfirst($record->status) }}</td>
                <td>{{ $record->reporter->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('behavior_records.show', $record->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('behavior_records.edit', $record->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('behavior_records.destroy', $record->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $records->withQueryString()->links() }}
    </div>
</div>
@endsection