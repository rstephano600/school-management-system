@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Grade Levels</h3>
        <a href="{{ route('grade-levels.create') }}" class="btn btn-primary">Add Grade Level</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Code</th>
                <th>Level</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($gradeLevels as $gradeLevel)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $gradeLevel->name }}</td>
                    <td>{{ $gradeLevel->code }}</td>
                    <td>{{ $gradeLevel->level }}</td>
                    <td>{{ $gradeLevel->description }}</td>
                    <td>
                        <a href="{{ route('grade-levels.show', $gradeLevel->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('grade-levels.edit', $gradeLevel->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No grade levels found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
