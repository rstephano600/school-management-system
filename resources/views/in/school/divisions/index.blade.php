@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Division List</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    @if(Auth::user()->role === 'super_admin')
    <form method="GET" class="row mb-3">
    <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by Division...">
        </div>
        
        <div class="col-md-4">
            <select name="school_id" class="form-select">
                <option value="">-- Filter by School --</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                        {{ $school->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" type="submit">Search</button>
            <a href="{{ route('divisions.index') }}" class="btn btn-secondary">Reset</a>
            <a href="{{ route('divisions.create') }}" class="btn btn-success float-end">+ Add Division</a>
        </div>
    </form>
@endif

            <a href="{{ route('divisions.create') }}" class="btn btn-success mb-3">+ Add Division</a>


    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Division</th>
                <th>Min Point</th>
                <th>Max Point</th>
                <th>Remarks</th>
                <!-- <th>School</th> -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($divisions as $division)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $division->division }}</td>
                    <td>{{ $division->min_point }}</td>
                    <td>{{ $division->max_point }}</td>
                    <td>{{ $division->remarks }}</td>
                    <!-- <td>{{ $division->school->name ?? 'N/A' }}</td> -->
                    <td>
                        <a href="{{ route('divisions.edit', $division) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('divisions.destroy', $division) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No divisions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $divisions->withQueryString()->links() }}
</div>
@endsection
