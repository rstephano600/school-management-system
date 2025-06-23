@extends('layouts.app')

@section('title', 'My Fee Structures')

@section('content')
<div class="container">
    <h3 class="mb-4">My Fee Structures</h3>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <select name="academic_year_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- All Academic Years --</option>
                @foreach($academicYears as $year)
                    <option value="{{ $year->id }}" {{ $yearId == $year->id ? 'selected' : '' }}>
                        {{ $year->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if($fees->isEmpty())
        <div class="alert alert-info">No fee structures found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Frequency</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Paid</th>
                        <th>Remaining</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($fees as $fee)
                    <tr>
                        <td>{{ $fee->name }}</td>
                        <td>{{ ucfirst($fee->frequency) }}</td>
                        <td>TZS {{ number_format($fee->amount, 2) }}</td>
                        <td>{{ $fee->due_date->format('d M Y') }}</td>
                        <td>TZS {{ number_format($fee->total_paid, 2) }}</td>
<td>
    @if($fee->balance <= 0)
        <span class="badge bg-success">Paid</span>
    @else
        <span class="badge bg-warning text-dark">TZS {{ number_format($fee->balance, 2) }}</span>
    @endif
</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
