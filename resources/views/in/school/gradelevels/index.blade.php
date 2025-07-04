@extends('layouts.app')
@section('title', 'Grade History')

@section('content')
<div class="container">
    <h4>Grade Level History for {{ $student->user->name }}</h4>

    <!-- Filter/Search -->
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by grade/year"
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-primary">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Grade</th>
                <th>Academic Year</th>
                <th>Start</th>
                <th>End</th>
                <th>Current</th>
                <th>Changed By</th>
            </tr>
        </thead>
        <tbody>
            @forelse($grades as $level)
                <tr>
                    <td>{{ $level->grade->name }}</td>
                    <td>{{ $level->academicYear->name }}</td>
                    <td>{{ $level->start_date->format('d M Y') }}</td>
                    <td>{{ $level->end_date ? $level->end_date->format('d M Y') : '-' }}</td>
                    <td>
                        @if($level->is_current)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td>{{ optional($level->changer)->name ?? '-' }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-muted">No grade records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $grades->withQueryString()->links() }}
    </div>

    <a href="{{ route('student.grades.promote', $student->user_id) }}" class="btn btn-primary mt-3">Promote to Next Grade</a>
</div>
@endsection
