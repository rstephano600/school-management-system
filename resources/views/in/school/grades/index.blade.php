@extends('layouts.app')

@section('title', 'Grade List')

@section('content')
<div class="container">
    <h3 class="mb-3">Grade List</h3>
    <a href="{{ route('grades.create') }}" class="btn btn-success mb-3">Add Grade</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Min %</th>
                <th>Max %</th>
                <th>Letter</th>
                <th>Point</th>
                <th>Remarks</th>
                <th>Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
            <tr>
                <td>{{ $grade->min_score }}</td>
                <td>{{ $grade->max_score }}</td>
                <td>{{ $grade->grade_letter }}</td>
                <td>{{ $grade->grade_point }}</td>
                <td>{{ $grade->remarks }}</td>
                <td>{{ $grade->level }}</td>
                <td>
                    <a href="{{ route('grades.edit', $grade) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete this grade?')" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $grades->links() }}
</div>
@endsection