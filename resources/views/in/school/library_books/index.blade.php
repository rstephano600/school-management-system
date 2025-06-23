@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Library Books</h3>

    <form method="GET" action="{{ route('library_books.index') }}" class="row g-3 mb-3">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title, author, ISBN or category">
        </div>
        <div class="col-md-2">
            <button class="btn btn-secondary" type="submit">Search</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('library_books.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <a href="{{ route('library_books.create') }}" class="btn btn-primary mb-3">Add Book</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Category</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->category }}</td>
                <td>{{ $book->available_quantity }} / {{ $book->quantity }}</td>
                <td>
                    <a href="{{ route('library_books.show', $book->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('library_books.edit', $book->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('library_books.destroy', $book->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this book?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6">No books found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $books->withQueryString()->links() }}
    </div>
</div>
@endsection