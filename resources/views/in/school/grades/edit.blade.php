@extends('layouts.app')

@section('title', 'Edit Grade')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Grade</h3>

    <form action="{{ route('grades.update', $grade) }}" method="POST">
        @csrf @method('PUT')
        @include('in.school.grades.form', ['grade' => $grade])
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('grades.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection