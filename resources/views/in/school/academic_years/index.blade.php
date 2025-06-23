@extends('layouts.app')
@section('title', 'Academic Years')

@section('content')
<div class="container">
    <h3 class="mb-4">Academic Years</h3>

    <a href="{{ route('academic-years.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add New Academic Year
    </a>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Start</th>
                <th>End</th>
                <th>Current</th>
                <th>Description</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($academicYears as $year)
            <tr>
                <td>{{ $year->name }}</td>
                <td>{{ $year->start_date->format('d M Y') }}</td>
                <td>{{ $year->end_date->format('d M Y') }}</td>
                <td>
                    <span class="badge {{ $year->is_current ? 'bg-success' : 'bg-secondary' }}">
                        {{ $year->is_current ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td>{{ $year->description }}</td>
                <td class="text-end">
                    <a href="{{ route('academic-years.edit', $year) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('academic-years.destroy', $year) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this year?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
