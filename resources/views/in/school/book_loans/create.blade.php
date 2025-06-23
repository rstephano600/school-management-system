@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Issue Book Loan</h3>

    <form action="{{ route('book_loans.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Book</label>
            <select name="book_id" class="form-control" required>
                @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }} (Available: {{ $book->available_quantity }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Loan Date</label>
            <input type="date" name="loan_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>

        <button class="btn btn-primary">Issue Loan</button>
    </form>
</div>
@endsection