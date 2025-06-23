@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Assessment</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Form has errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('assessments.update', $assessment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="type">Type</label>
            <select name="type" class="form-control" required>
                @foreach(['exam', 'test', 'assignment', 'exercise'] as $type)
                    <option value="{{ $type }}" {{ $assessment->type == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $assessment->title }}" required>
        </div>

        <div class="mb-3">
            <label>Subject</label>
            <select name="subject_id" class="form-control" required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $assessment->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Class</label>
            <select name="class_id" class="form-control" required>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $assessment->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Teacher</label>
            <select name="teacher_id" class="form-control" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $assessment->teacher_id == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->user->first_name }} {{ $teacher->user->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Issue Date</label>
            <input type="date" name="issue_date" class="form-control" value="{{ $assessment->issue_date }}">
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control" value="{{ $assessment->due_date }}">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4">{{ $assessment->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Assessment</button>
    </form>
</div>
@endsection
