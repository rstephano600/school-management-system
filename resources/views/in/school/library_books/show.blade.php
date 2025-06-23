@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Book Details</h3>
    <p><strong>Title:</strong> {{ $library_book->title }}</p>
    <p><strong>Author:</strong> {{ $library_book->author }}</p>
    <p><strong>ISBN:</strong> {{ $library_book->isbn }}</p>
    <p><strong>Publisher:</strong> {{ $library_book->publisher }}</p>
    <p><strong>Edition:</strong> {{ $library_book->edition }}</p>
    <p><strong>Year Published:</strong> {{ $library_book->year_published }}</p>
    <p><strong>Category:</strong> {{ $library_book->category }}</p>
    <p><strong>Price:</strong> TSh {{ number_format($library_book->price, 2) }}</p>
    <p><strong>Quantity:</strong> {{ $library_book->quantity }}</p>
    <p><strong>Available Quantity:</strong> {{ $library_book->available_quantity }}</p>
    <p><strong>Rack Number:</strong> {{ $library_book->rack_number }}</p>
    <p><strong>Status:</strong> {{ ucfirst($library_book->status) }}</p>
    <a href="{{ route('library_books.index') }}" class="btn btn-secondary">Back to List</a>
@endsection