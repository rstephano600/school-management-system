@extends('layouts.app')
@section('title', 'Schedule Test')

@section('content')
<div class="container">
    <h3 class="mb-4">Schedule New Examp</h3>

    <form method="POST" action="{{ route('exams.store') }}">
        @csrf
        @include('in.school.exams.timetable._form', ['test' => null])
        <button class="btn btn-success">Save</button>
        <a href="{{ route('exams.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
