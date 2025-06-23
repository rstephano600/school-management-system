@extends('layouts.app')
@section('title', 'Sections')

@section('content')
<div class="container">
    <h3 class="mb-4">Sections</h3>

    <a href="{{ route('sections.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add Section
    </a>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<form method="GET" class="row g-3 mb-3">
    <div class="col-md-4">
        <select name="academic_year_id" class="form-select">
            <option value="">All Academic Years</option>
            @foreach($years as $year)
                <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                    {{ $year->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <select name="grade_id" class="form-select">
            <option value="">All Grades</option>
            @foreach($grades as $grade)
                <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                    {{ $grade->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-filter"></i> Filter</button>
        <a href="{{ route('sections.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Grade</th>
                <th>Capacity</th>
                <th>Room</th>
                <th>Class Teacher</th>
                <th>Academic Year</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sections as $section)
            <tr>
                <td>{{ $section->name }}</td>
                <td>{{ $section->code }}</td>
                <td>{{ $section->grade->name ?? '-' }}</td>
                <td>{{ $section->capacity }}</td>
                <td>{{ $section->room->name ?? '-' }}</td>
                <td>{{ $section->teacher->user->name ?? '-' }}</td>
                <td>{{ $section->academicYear->name ?? '-' }}</td>
                <td>
                    <span class="badge {{ $section->status ? 'bg-success' : 'bg-danger' }}">
                        {{ $section->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="text-end">
                    <a href="{{ route('sections.show', $section) }}" class="btn btn-sm btn-information">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('sections.edit', $section) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('sections.destroy', $section) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this section?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center">No sections found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $sections->links() }}
</div>
@endsection
