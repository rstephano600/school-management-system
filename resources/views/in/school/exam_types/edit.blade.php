@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Exam Type</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('exam-types.update', $examType) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Exam Type Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $examType->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">Weight (%)</label>
            <input type="number" name="weight" class="form-control" value="{{ old('weight', $examType->weight) }}" step="0.01" min="0" max="100" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (Optional)</label>
            <textarea name="description" class="form-control">{{ old('description', $examType->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('exam-types.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
