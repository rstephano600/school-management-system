@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Create New Subscription</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following issues:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('subscriptions.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="subscription_category_id" class="form-label">Subscription Category</label>
            <select name="subscription_category_id" id="subscription_category_id" class="form-select" required>
                <option value="">Select Category</option>
                @foreach ($subscriptionCategories as $category)
                    <option value="{{ $category->id }}" {{ old('subscription_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="total_users" class="form-label">Total Users (Students)</label>
            <input type="number" name="total_users" class="form-control" value="{{ old('total_users') }}" required min="0">
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Subscription Amount (TZS)</label>
            <input type="number" name="amount" class="form-control" value="{{ old('amount') }}" required min="0" step="0.01">
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes (Optional)</label>
            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Create Subscription</button>
        <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
