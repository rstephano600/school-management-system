@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Edit Event</h3>
        @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Form has errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf @method('PUT')
        @include('in.school.events.form', ['event' => $event])
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection