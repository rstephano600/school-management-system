@extends('layouts.app')
@section('title', 'Semesters')

@section('content')
<div class="container">
    <h3 class="mb-4">Semesters</h3>

    <a href="{{ route('semesters.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add New Semester
    </a>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<form method="GET" action="{{ route('semesters.index') }}" class="row g-3 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search semesters...">
    </div>
    <div class="col-md-3">
        <select name="sort_by" class="form-select">
            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Sort by Name</option>
            <option value="start_date" {{ request('sort_by') == 'start_date' ? 'selected' : '' }}>Sort by Start Date</option>
            <option value="end_date" {{ request('sort_by') == 'end_date' ? 'selected' : '' }}>Sort by End Date</option>
        </select>
    </div>
    <div class="col-md-3">
        <select name="order" class="form-select">
            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-secondary w-100" type="submit"><i class="fas fa-search"></i> Search</button>
    </div>
</form>

    <table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Academic Year</th>
            <th>Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Current</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($semesters as $semester)
        <tr>
            <td>{{ $semester->academicYear->name ?? '-' }}</td>
            <td>{{ $semester->name }}</td>
            <td>{{ \Carbon\Carbon::parse($semester->start_date)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($semester->end_date)->format('d M Y') }}</td>
            <td>
                <span class="badge {{ $semester->is_current ? 'bg-success' : 'bg-secondary' }}">
                    {{ $semester->is_current ? 'Yes' : 'No' }}
                </span>
            </td>
            <td class="text-end">
                <a href="{{ route('semesters.edit', $semester) }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('semesters.destroy', $semester) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this semester?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No semesters found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $semesters->links() }} {{-- Laravel pagination links --}}

</div>
@endsection
