@extends('layouts.app')
@section('title', 'Add School Activity')

@section('content')
<div class="container">
    <h3 class="mb-4">Add General School Activity</h3>

    <form method="POST" action="{{ route('general-schedule.store') }}">
        @csrf
        @include('in.school.general_schedule._form', ['schedule' => null])
        <button class="btn btn-success">Save</button>
        <a href="{{ route('general-schedule.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
