@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Student Requirement</h4>

    <form action="{{ route('student-requirements.update', $studentRequirement) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Requirement Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $studentRequirement->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Requirement Name</label>
            <input type="text" name="quantity" class="form-control" >
        </div>

        <div class="mb-3">
            <label class="form-label">Grade Level</label>
            <select name="grade_level_id" class="form-control">
                <option value="">All Grades</option>
                @foreach($gradeLevels as $grade)
                    <option value="{{ $grade->id }}" {{ $studentRequirement->grade_level_id == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Allow Payment?</label>
            <select name="allow_payment" class="form-control" required>
                <option value="1" {{ $studentRequirement->allow_payment ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$studentRequirement->allow_payment ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Expected Amount</label>
            <input type="number" name="expected_amount" step="0.01" class="form-control" value="{{ $studentRequirement->expected_amount }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $studentRequirement->description }}</textarea>
        </div>

        <button class="btn btn-primary">Update Requirement</button>
        <a href="{{ route('student-requirements.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
