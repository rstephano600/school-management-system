@extends('layouts.app')

@section('content')
<div class="container">
    <h1>parents List</h1>
    <a href="{{ route('student.parent.index') }}" class="btn btn-primary mb-3">Register New parent</a>
    <form method="GET" action="{{ route('student.parent.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-6">
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Search by name or admission number" 
                value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parents as $parent)
            <tr>
                <td>{{ $parent->user->name }}</td>

                <td><span class="badge bg-success">{{ ucfirst($parent->user->status) }}</span></td>
                <td>
                    <a href="{{ route('student.parent.show', $parent->user_id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('student.parent.edit', $parent->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('student.parent.destroy', $parent->user_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
