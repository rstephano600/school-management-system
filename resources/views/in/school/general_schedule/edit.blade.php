@extends('layouts.app')
@section('title', 'Edit School Activity')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit General School Activity</h3>

    <form method="POST" action="{{ route('general-schedule.update', $generalSchedule->id) }}">
        @csrf @method('PUT')
        @include('in.school.general_schedule._form', ['schedule' => $generalSchedule])
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('general-schedule.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
