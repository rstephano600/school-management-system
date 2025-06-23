{{-- edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit Timetable Slot')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Timetable Slot</h3>
    <form action="{{ route('timetables.update', $timetable->id) }}" method="POST">
        @csrf @method('PUT')
        @include('in.school.timetables._form', ['timetable' => $timetable, 'mode' => 'edit'])
        <button type="submit" class="btn btn-primary">Update Slot</button>
    </form>
</div>
@endsection