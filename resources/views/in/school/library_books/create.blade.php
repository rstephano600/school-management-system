@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Add Library Book</h3>
    <form action="{{ route('library_books.store') }}" method="POST">
        @csrf
        @include('in.school.library_books.form')
        <button class="btn btn-primary">Save Book</button>
    </form>
</div>
@endsection