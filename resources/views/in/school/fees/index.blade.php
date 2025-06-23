@extends('layouts.app')

@section('title', 'Fee Structures')

@section('content')
<div class="container">
    <h3 class="mb-4">Fee Structures</h3>

    <a href="{{ route('fee-structures.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add New Fee Structure
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($feeStructures->isEmpty())
        <div class="alert alert-info">No fee structures available.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Academic Year</th>
                        <th>Frequency</th>
                        <th>Amount (TZS)</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feeStructures as $fee)
                    <tr>
                        <td>{{ $fee->name }}</td>
                        <td>{{ $fee->academicYear->name ?? '-' }}</td>
                        <td>{{ ucfirst($fee->frequency) }}</td>
                        <td>{{ number_format($fee->amount, 2) }}</td>
                        <td>{{ $fee->due_date->format('d M Y') }}</td>
                        <td>
                            <span class="badge {{ $fee->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $fee->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('fee-structures.show', $fee->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
