@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Subscription Details</h4>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $subscription->subscriptionCategory->name }}</h5>
            <p><strong>Total Users:</strong> {{ $subscription->total_users }}</p>
            <p><strong>Amount:</strong> {{ number_format($subscription->amount, 2) }} TZS</p>
            <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($subscription->start_date)->format('d M Y') }}</p>
            <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($subscription->end_date)->format('d M Y') }}</p>
            <p><strong>Notes:</strong> {{ $subscription->notes ?: 'None' }}</p>
            <p><strong>Status:</strong> 
                <span class="badge bg-{{ $subscription->is_active ? 'success' : 'secondary' }}">
                    {{ $subscription->is_active ? 'Active' : 'Inactive' }}
                </span>
            </p>
            <p><strong>Created:</strong> {{ $subscription->created_at->diffForHumans() }}</p>
            <p><strong>Updated:</strong> {{ $subscription->updated_at->diffForHumans() }}</p>
        </div>
    </div>

    <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="btn btn-primary mt-3">Edit</a>
    <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
