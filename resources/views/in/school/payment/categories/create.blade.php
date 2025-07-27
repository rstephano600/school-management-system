@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Create Payment Category</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following issues:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payment.categories.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Name *</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6">
                <label for="code" class="form-label">Code *</label>
                <input type="text" class="form-control" name="code" value="{{ old('code') }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="type" class="form-label">Type *</label>
                <select name="type" class="form-select" required>
                    <option value="">-- Select Type --</option>
                    <option value="mandatory" {{ old('type') == 'mandatory' ? 'selected' : '' }}>Mandatory</option>
                    <option value="optional" {{ old('type') == 'optional' ? 'selected' : '' }}>Optional</option>
                    <option value="conditional" {{ old('type') == 'conditional' ? 'selected' : '' }}>Conditional</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="category" class="form-label">Category *</label>
                <select name="category" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    <option value="fees" {{ old('category') == 'fees' ? 'selected' : '' }}>Fees</option>
                    <option value="bills" {{ old('category') == 'bills' ? 'selected' : '' }}>Bills</option>
                    <option value="michango" {{ old('category') == 'michango' ? 'selected' : '' }}>Michango</option>
                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="payment_frequency" class="form-label">Payment Frequency *</label>
            <select name="payment_frequency" class="form-select" required>
                <option value="">-- Select Frequency --</option>
                <option value="once" {{ old('payment_frequency') == 'once' ? 'selected' : '' }}>Once</option>
                <option value="monthly" {{ old('payment_frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="termly" {{ old('payment_frequency') == 'termly' ? 'selected' : '' }}>Termly</option>
                <option value="annually" {{ old('payment_frequency') == 'annually' ? 'selected' : '' }}>Annually</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="applicable_grades" class="form-label">Applicable Grades</label>
            <select name="applicable_grades[]" class="form-select" multiple>
                @foreach ($gradelevels as $grade)
                    <option value="{{ $grade->id }}" {{ collect(old('applicable_grades'))->contains($grade->id) ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold Ctrl (or Command on Mac) to select multiple grades.</small>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="required_at_registration" class="form-check-input" {{ old('required_at_registration') ? 'checked' : '' }}>
            <label class="form-check-label">Required at Registration</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="required_at_grade_entry" class="form-check-input" {{ old('required_at_grade_entry') ? 'checked' : '' }}>
            <label class="form-check-label">Required at Grade Entry</label>
        </div>

        <div class="mb-3">
            <label for="default_amount" class="form-label">Default Amount</label>
            <input type="number" name="default_amount" class="form-control" step="0.01" value="{{ old('default_amount') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_active" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
            <label class="form-check-label">Is Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Save Category</button>
        <a href="{{ route('payment.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
