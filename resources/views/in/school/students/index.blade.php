@extends('layouts.app')

@section('title', 'Students')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Students List</h5>
            <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-user-plus"></i> Register New Student
            </a>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('students.index') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control" 
                            placeholder="Search by name or admission number" 
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Admission No.</th>
                            <th>
                                <a href="{{ route('students.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => ($sort === 'name' && $direction === 'asc') ? 'desc' : 'asc'])) }}">
                                    Name
                                    @if($sort === 'name')
                                        <i class="bi bi-arrow-{{ $direction === 'asc' ? 'down' : 'up' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Grade</th>
                            <th>Section</th>
                            <th>
                                <a href="{{ route('students.index', array_merge(request()->all(), ['sort' => 'admission_date', 'direction' => ($sort === 'admission_date' && $direction === 'asc') ? 'desc' : 'asc'])) }}">
                                    Admission Date
                                    @if($sort === 'admission_date')
                                        <i class="bi bi-arrow-{{ $direction === 'asc' ? 'down' : 'up' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td>{{ $student->admission_number ?? '-' }}</td>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->grade->name ?? '-' }}</td>
                            <td>{{ $student->section->name ?? '-' }}</td>
                            <td>{{ $student->admission_date->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('students.show', $student->user_id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('students.edit', $student->user_id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student->user_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No students found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $students->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- Load Bootstrap Icons if not already --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
@endpush
@endsection
