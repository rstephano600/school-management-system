@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Exam Types</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('exam-types.create') }}" class="btn btn-primary mb-3">Add Exam Type</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Weight (%)</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($examTypes as $type)
                <tr>
                    <td>{{ $type->name }}</td>
                    <td>{{ $type->weight }}</td>
                    <td>{{ $type->description ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('exam-types.show', $type) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('exam-types.edit', $type) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('exam-types.destroy', $type) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this exam type?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">No exam types found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $examTypes->links() }}
</div>
@endsection
