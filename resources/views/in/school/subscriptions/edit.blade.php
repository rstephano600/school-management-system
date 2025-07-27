@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Subscription</h4>

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

    <form action="{{ route('subscriptions.update', $subscription->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Subscription Category</label>
            <select name="subscription_category_id" class="form-select" required>
                <option value="">Select Category</option>
                @foreach ($subscriptionCategories as $category)
                    <option value="{{ $category->id }}" {{ $subscription->subscription_category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Total Users</label>
            <input type="number" name="total_users" class="form-control" value="{{ $subscription->total_users }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount (TZS)</label>
            <input type="number" name="amount" class="form-control" value="{{ $subscription->amount }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $subscription->start_date }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $subscription->end_date }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control">{{ $subscription->notes }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ $subscription->is_active ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
