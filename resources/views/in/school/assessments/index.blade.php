@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Assessments</h2>

    <form method="GET" class="row mb-3">
        <div class="col-md-3">
            <select name="type" class="form-control">
                <option value="">-- Filter by Type --</option>
                @foreach(['exam', 'test', 'assignment', 'exercise'] as $t)
                    <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="subject_id" class="form-control">
                <option value="">-- Filter by Subject --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </div>
    </form>

    <a href="{{ route('assessments.create') }}" class="btn btn-success mb-3">Add New Assessment</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Type</th>
                <th>Title</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Due Date</th>
                <th>Published</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assessments as $assessment)
            <tr>
                <td>{{ ucfirst($assessment->type) }}</td>
                <td>{{ $assessment->title }}</td>
                <td>{{ $assessment->subject->name ?? '' }}</td>
                <td>{{ $assessment->teacher->user->first_name ?? '' }}</td>
                <td>{{ $assessment->due_date }}</td>
                <td>{{ $assessment->is_published ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('assessments.edit', $assessment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('assessments.destroy', $assessment->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete this assessment?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
