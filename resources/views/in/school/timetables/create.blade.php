{{-- create.blade.php --}}
@extends('layouts.app')
@section('title', 'Create Timetable Slot')

@section('content')
<div class="container">
    <h3 class="mb-4">Create Timetable Slot</h3>
    <form action="{{ route('timetables.store') }}" method="POST">
        @csrf
        @include('in.school.timetables._form', ['mode' => 'create'])
        <button type="submit" class="btn btn-success">Create Slot</button>
    </form>
</div>
@endsection