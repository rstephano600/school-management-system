@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-3">Edit Assignment</h2>
    <form action="{{ route('assignments.update', $assignment) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('in.school.assignments.form', ['assignment' => $assignment])
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
