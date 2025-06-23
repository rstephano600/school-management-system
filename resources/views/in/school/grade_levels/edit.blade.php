@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Grade Level</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('grade-levels.update', $gradeLevel->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Grade Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $gradeLevel->name }}" required>
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" name="code" id="code" class="form-control" value="{{ $gradeLevel->code }}" required>
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <input type="number" name="level" id="level" class="form-control" value="{{ $gradeLevel->level }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $gradeLevel->description }}</textarea>
        </div>

        <input type="hidden" name="school_id" value="{{ $gradeLevel->school_id }}">

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('grade-levels.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
