@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Edit Library Book</h3>
    <form action="{{ route('library_books.update', $library_book->id) }}" method="POST">
        @csrf @method('PUT')
        @include('in.school.library_books.form', ['library_book' => $library_book])
        <button class="btn btn-success">Update Book</button>
    </form>
</div>
@endsection