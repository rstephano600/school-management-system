@extends('layouts.app')

@section('title', 'View Fee Structure')

@section('content')
<div class="container">
    <h3 class="mb-4">Fee Structure Details</h3>

    <div class="card">
        <div class="card-header bg-primary text-white">
            {{ $feeStructure->name }}
        </div>
        <div class="card-body">
            <p><strong>Academic Year:</strong> {{ $feeStructure->academicYear->name ?? '-' }}</p>
            <p><strong>Frequency:</strong> {{ ucfirst($feeStructure->frequency) }}</p>
            <p><strong>Amount:</strong> TZS {{ number_format($feeStructure->amount, 2) }}</p>
            <p><strong>Due Date:</strong> {{ $feeStructure->due_date->format('d M Y') }}</p>
            <p><strong>Status:</strong>
                <span class="badge {{ $feeStructure->is_active ? 'bg-success' : 'bg-secondary' }}">
                    {{ $feeStructure->is_active ? 'Active' : 'Inactive' }}
                </span>
            </p>
            @if($feeStructure->description)
                <p><strong>Description:</strong> {{ $feeStructure->description }}</p>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('fee-structures.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>
@endsection
