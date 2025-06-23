@extends('layouts.app')
@section('title', 'Teachers')

@section('content')
<div class="container">
    <h3 class="mb-4">Teachers</h3>

    <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add Teacher
    </a>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Employee ID</th>
                <th>Specialization</th>
                <th>Department</th>
                <th>Joined</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $teacher)
            <tr>
                <td>{{ $teacher->user->name }}</td>
                <td>{{ $teacher->user->email }}</td>
                <td>{{ $teacher->employee_id }}</td>
                <td>{{ $teacher->specialization }}</td>
                <td>{{ $teacher->department }}</td>
                <td>{{ \Carbon\Carbon::parse($teacher->joining_date)->format('d M Y') }}</td>
                <td>
                    <span class="badge {{ $teacher->status ? 'bg-success' : 'bg-danger' }}">
                        {{ $teacher->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="text-end">
                    <a href="{{ route('teachers.edit', $teacher->user_id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('teachers.destroy', $teacher->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this teacher?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center">No teachers found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $teachers->links() }}
</div>
@endsection
