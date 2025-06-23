@extends('layouts.app')
@section('title', 'Subjects')

@section('content')
<div class="container">
    <h3 class="mb-4">Subjects</h3>

    <a href="{{ route('subjects.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add New Subject
    </a>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Description</th>
                <th>Core</th>
                <th>Assigned To</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjects as $subject)
            <tr>
    <td>{{ $subject->name }}</td>
    <td>{{ $subject->code }}</td>
    <td>{{ $subject->description ?? '-' }}</td>
    <td>
        <span class="badge {{ $subject->is_core ? 'bg-success' : 'bg-secondary' }}">
            {{ $subject->is_core ? 'Yes' : 'No' }}
        </span>
    </td>
    <td>
        @forelse($subject->teachers as $teacher)
            <span class="badge bg-info">{{ $teacher->name }}</span>
        @empty
            <span class="text-muted">None</span>
        @endforelse
    </td>
    <td class="text-end">
        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-edit"></i>
        </a>
        <a href="{{ route('subjects.show', $subject) }}" class="btn btn-sm btn-info">
            <i class="fas fa-eye"></i>
        </a>
        <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this subject?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
        </form>
    </td>
</tr>

            @empty
            <tr><td colspan="6" class="text-center">No subjects found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $subjects->links() }}
</div>
@endsection
