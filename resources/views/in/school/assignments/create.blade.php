@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-3">Create Assignment</h2>
    <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('in.school.assignments.form')
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection