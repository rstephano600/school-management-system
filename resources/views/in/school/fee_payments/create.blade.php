@extends('layouts.app')

@section('title', 'Record Fee Payment')

@section('content')
<div class="container">
    <h3 class="mb-4">Record Fee Payment for {{ $student->name }}</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form action="{{ route('admin.fee-payments.store', $student) }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Fee Structure *</label>
                <select name="fee_structure_id" class="form-select" required>
                    <option value="">-- Select --</option>
                    @foreach($fees as $fee)
                        <option value="{{ $fee->id }}">{{ $fee->name }} (TZS {{ number_format($fee->amount, 2) }})</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Amount Paid *</label>
                <input type="number" name="amount_paid" step="0.01" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Payment Date *</label>
                <input type="date" name="payment_date" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Payment Method *</label>
                <input type="text" name="method" class="form-control" required placeholder="e.g. Cash, M-Pesa, Bank">
            </div>

            <div class="col-md-6">
                <label class="form-label">Reference</label>
                <input type="text" name="reference" class="form-control">
            </div>

            <div class="col-md-12">
                <label class="form-label">Note</label>
                <textarea name="note" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Payment</button>
            <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
