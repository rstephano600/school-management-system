@extends('layouts.app')
@section('title', 'Edit Test')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Test</h3>

    <form method="POST" action="{{ route('tests.update', $test->id) }}">
        @csrf @method('PUT')
        @include('in.school.tests.timetable._form', ['test' => $test])
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('tests.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
