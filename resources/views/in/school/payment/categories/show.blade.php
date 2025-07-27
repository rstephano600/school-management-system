@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Payment Category Details</h4>

    <div class="card">
        <div class="card-body">
            <h5>{{ $paymentCategory->name }} ({{ $paymentCategory->code }})</h5>
            <p><strong>Type:</strong> {{ ucfirst($paymentCategory->type) }}</p>
            <p><strong>Category:</strong> {{ ucfirst($paymentCategory->category) }}</p>
            <p><strong>Frequency:</strong> {{ ucfirst($paymentCategory->payment_frequency) }}</p>
            <p><strong>Required at Registration:</strong> {{ $paymentCategory->required_at_registration ? 'Yes' : 'No' }}</p>
            <p><strong>Required at Grade Entry:</strong> {{ $paymentCategory->required_at_grade_entry ? 'Yes' : 'No' }}</p>
            <p><strong>Default Amount:</strong> {{ number_format($paymentCategory->default_amount, 2) }}</p>
            <p><strong>Status:</strong> {{ $paymentCategory->is_active ? 'Active' : 'Inactive' }}</p>
            <p><strong>Description:</strong> {{ $paymentCategory->description }}</p>
            <p><strong>Created by:</strong> {{ optional($paymentCategory->createdBy)->name }}</p>
            <p><strong>Updated by:</strong> {{ optional($paymentCategory->updatedBy)->name }}</p>

            <a href="{{ route('payment.categories.edit', $paymentCategory) }}" class="btn btn-primary mt-3">Edit</a>
            <a href="{{ route('payment.categories.index') }}" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>
</div>
@endsection
