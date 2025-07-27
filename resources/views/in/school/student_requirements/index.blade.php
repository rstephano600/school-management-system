@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Student Requirements (Michango / Vitu)</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('student-requirements.index') }}" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search requirement..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="grade_level_id" class="form-control">
                <option value="">All Grade Levels</option>
                @foreach($gradeLevels as $grade)
                    <option value="{{ $grade->id }}" {{ request('grade_level_id') == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary">Filter</button>
            <a href="{{ route('student-requirements.index') }}" class="btn btn-secondary">Reset</a>
            <a href="{{ route('student-requirements.create') }}" class="btn btn-success float-end">+ Add Requirement</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Grade Level</th>
                    <th>Allow Payment</th>
                    <th>Expected Amount</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requirements as $requirement)
                    <tr>
                        <td>{{ $loop->iteration + ($requirements->currentPage() - 1) * $requirements->perPage() }}</td>
                        <td>{{ $requirement->name }}</td>
                        <td>{{ $requirement->gradeLevel?->name ?? 'All' }}</td>
                        <td>{{ $requirement->allow_payment ? 'Yes' : 'No' }}</td>
                        <td>{{ $requirement->expected_amount ? number_format($requirement->expected_amount) . ' TZS' : '-' }}</td>
                        <td>{{ $requirement->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('student-requirements.edit', $requirement) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('student-requirements.destroy', $requirement) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No requirements found.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $requirements->withQueryString()->links() }}
    </div>
</div>
@endsection
