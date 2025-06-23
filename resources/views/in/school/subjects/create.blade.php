@extends('layouts.app')
@section('title', 'Add Subject')

@section('content')
<div class="container">
    <h3 class="mb-4">Add New Subject</h3>

    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Code</label>
            <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_core" value="1" class="form-check-input" id="is_core">
            <label class="form-check-label" for="is_core">Is Core Subject?</label>
        </div>
        <div class="mb-3">
    <label class="form-label">Assign Teachers</label>
    <select name="teacher_ids[]" multiple class="form-select">
    @foreach($teachers as $teacher)
        <option value="{{ $teacher->user_id }}">
            {{ $teacher->user->name }} - {{ $teacher->specialization }}
        </option>
    @endforeach
</select>

    <small class="form-text text-muted">Hold Ctrl or Cmd to select multiple.</small>
</div>


        <button type="submit" class="btn btn-success">Save Subject</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
