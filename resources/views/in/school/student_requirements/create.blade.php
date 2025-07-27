@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Add Student Requirement</h4>

    <form action="{{ route('student-requirements.store') }}" method="POST" class="mt-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Requirement Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" required value="{{ old('quantity') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Grade Level</label>
            <select name="grade_level_id" class="form-control">
                <option value="">All Grades</option>
                @foreach($gradeLevels as $grade)
                    <option value="{{ $grade->id }}" {{ old('grade_level_id') == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Allow Payment?</label>
            <select name="allow_payment" class="form-control" required>
                <option value="1" {{ old('allow_payment') == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('allow_payment') == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Expected Amount (Optional)</label>
            <input type="number" name="expected_amount" step="0.01" class="form-control" value="{{ old('expected_amount') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <button class="btn btn-success">Save Requirement</button>
        <a href="{{ route('student-requirements.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
