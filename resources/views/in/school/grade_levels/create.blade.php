@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add New Grade Level</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('grade-levels.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Grade Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" name="code" id="code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <input type="number" name="level" id="level" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <input type="hidden" name="school_id" value="{{ auth()->user()->school_id }}">

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('grade-levels.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
