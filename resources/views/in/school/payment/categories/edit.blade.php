@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Payment Category</h4>

    <form action="{{ route('payment.categories.update', $paymentCategory) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $paymentCategory->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Code</label>
            <input type="text" name="code" value="{{ old('code', $paymentCategory->code) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control" required>
                @foreach (['mandatory', 'optional', 'conditional'] as $type)
                    <option value="{{ $type }}" {{ $paymentCategory->type === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category" class="form-control" required>
                @foreach (['fees', 'bills', 'michango', 'other'] as $category)
                    <option value="{{ $category }}" {{ $paymentCategory->category === $category ? 'selected' : '' }}>{{ ucfirst($category) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Frequency</label>
            <select name="payment_frequency" class="form-control" required>
                @foreach (['once', 'monthly', 'termly', 'annually'] as $freq)
                    <option value="{{ $freq }}" {{ $paymentCategory->payment_frequency === $freq ? 'selected' : '' }}>{{ ucfirst($freq) }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="required_at_registration" value="1"
                {{ $paymentCategory->required_at_registration ? 'checked' : '' }}>
            <label class="form-check-label">Required at Registration</label>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="required_at_grade_entry" value="1"
                {{ $paymentCategory->required_at_grade_entry ? 'checked' : '' }}>
            <label class="form-check-label">Required at Grade Entry</label>
        </div>

        <div class="mb-3">
            <label>Default Amount</label>
            <input type="number" step="0.01" name="default_amount" value="{{ old('default_amount', $paymentCategory->default_amount) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $paymentCategory->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Applicable Grades</label>
            <select name="applicable_grades[]" class="form-control" multiple>
                @foreach ($gradelevels as $grade)
                    <option value="{{ $grade->id }}" {{ in_array($grade->id, old('applicable_grades', $paymentCategory->applicable_grades ?? [])) ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $paymentCategory->is_active ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('payment.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
