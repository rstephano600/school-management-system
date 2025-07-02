@extends('layouts.app')
@section('title', 'Scheduled Classes')

@section('content')
<div class="container">
    <h3 class="mb-4">Scheduled Classes</h3>

    <a href="{{ route('classes.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Schedule New Class
    </a>
<a href="{{ route('classes.timetable') }}" class="btn btn-primary mb-3">
    <i class="fas fa-calendar"></i> Timetable Calendar
</a>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<form method="GET" class="row g-3 mb-3">
    <div class="col-md-4">
        <select name="academic_year_id" class="form-select">
            <option value="">Filter by Year</option>
            @foreach($years as $year)
                <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                    {{ $year->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <select name="grade_id" class="form-select">
            <option value="">Filter by Grade</option>
            @foreach($grades as $grade)
                <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                    {{ $grade->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-outline-primary">Filter</button>
        <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Subject</th>
                <th>Grade</th>
                <th>Section</th>
                <th>Teacher</th>
                <th>Room</th>
                <!-- <th>Days</th> -->
                <!-- <th>Time</th> -->
                <!-- <th>Capacity</th> -->
                <th>Status</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
            <tr>
                <td>{{ $class->subject->name ?? '-' }}</td>
                <td>{{ $class->grade->name ?? '-' }}</td>
                <td>{{ $class->section->name ?? '-' }}</td>
                <td>{{ $class->teacher->name ?? '-' }}</td>
                <td>{{ $class->room->name ?? $section->room->number ?? '-' }}</td>
                <!-- <td>{{ is_array($class->class_days) ? implode(', ', $class->class_days) : '-' }}</td> -->
                <!-- <td>{{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}</td> -->
                <!-- <td>{{ $class->current_enrollment }}/{{ $class->max_capacity }}</td> -->
                <td>
                    <span class="badge {{ $class->status ? 'bg-success' : 'bg-danger' }}">
                        {{ $class->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="text-end">
                    <a href="{{ route('classes.show', $class->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i>
                    </a>

                    <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this class?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="10" class="text-center">No classes scheduled.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $classes->links() }}
</div>
@endsection
