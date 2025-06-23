@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Book Loans</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('book_loans.index') }}" class="row g-3 mb-3">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by student name">
        </div>
        <div class="col-md-2">
            <button class="btn btn-secondary" type="submit">Search</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('book_loans.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <a href="{{ route('book_loans.create') }}" class="btn btn-primary mb-3">Issue New Loan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Book</th>
                <th>Borrower</th>
                <th>Loan Date</th>
                <th>Due Date</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td>{{ $loan->book->title }}</td>
                <td>{{ $loan->borrower->name }}</td>
                <td>{{ $loan->loan_date }}</td>
                <td>{{ $loan->due_date }}</td>
                <td>{{ $loan->return_date ?? '-' }}</td>
                <td>{{ ucfirst($loan->status) }}</td>
                <td>
                    @if($loan->status === 'issued')
                    <form action="{{ route('book_loans.return', $loan->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-success" onclick="return confirm('Mark as returned?')">Return</button>
                    </form>
                    @endif
                    <form action="{{ route('book_loans.destroy', $loan->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this loan?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $loans->withQueryString()->links() }}
    </div>

    <hr>
    <div class="mt-4">
        <h5>Loan Summary</h5>
        <canvas id="loanChart" width="400" height="200"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('loanChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Issued', 'Returned', 'Overdue', 'Lost'],
            datasets: [{
                label: 'Book Loan Status',
                data: [
                    {{ $loans->where('status', 'issued')->count() }},
                    {{ $loans->where('status', 'returned')->count() }},
                    {{ $loans->where('status', 'overdue')->count() }},
                    {{ $loans->where('status', 'lost')->count() }}
                ],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
            }]
        }
    });
</script>
@endsection