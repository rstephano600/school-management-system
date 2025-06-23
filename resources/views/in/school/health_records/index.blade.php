@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Health Records</h3>

<form method="GET" action="{{ route('health_records.index') }}" class="row g-3 mb-3">
    <div class="col-md-6">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by student or blood group">
    </div>
    <div class="col-md-2">
        <button class="btn btn-secondary" type="submit">Search</button>
    </div>
    <div class="col-md-2">
        <a href="{{ route('health_records.index') }}" class="btn btn-light">Reset</a>
    </div>
</form>


    <a href="{{ route('health_records.create') }}" class="btn btn-primary mb-3">Add Health Record</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Student</th>
                <th>Blood Group</th>
                <th>Height (cm)</th>
                <th>Weight (kg)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
            <tr>
                <td>{{ $record->record_date }}</td>
                <td>{{ $record->student->user->name ?? 'N/A' }}</td>
                <td>{{ $record->blood_group }}</td>
                <td>{{ $record->height }}</td>
                <td>{{ $record->weight }}</td>
                <td>
                    <a href="{{ route('health_records.show', $record->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('health_records.edit', $record->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('health_records.destroy', $record->id) }}" method="POST" class="d-inline">
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