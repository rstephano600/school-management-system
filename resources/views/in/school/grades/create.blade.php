@extends('layouts.app')

@section('title', 'Add Grade')

@section('content')
<div class="container">
    <h3 class="mb-4">Add Grade</h3>

    <form action="{{ route('grades.store') }}" method="POST">
        @csrf
        @include('in.school.grades.form', ['grade' => null])
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('grades.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection