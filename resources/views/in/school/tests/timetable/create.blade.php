@extends('layouts.app')
@section('title', 'Schedule Test')

@section('content')
<div class="container">
    <h3 class="mb-4">Schedule New Test</h3>

    <form method="POST" action="{{ route('tests.store') }}">
        @csrf
        @include('in.school.tests.timetable._form', ['test' => null])
        <button class="btn btn-success">Save</button>
        <a href="{{ route('tests.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
