@extends('layouts.app')
@section('title', 'Edit Test')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Test</h3>

    <form method="POST" action="{{ route('exams.update', $exam->id) }}">
        @csrf @method('PUT')
        @include('in.school.exams.timetable._form', ['exam' => $exam])
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('exams.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
