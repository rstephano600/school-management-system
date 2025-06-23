@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Edit Hostel Room</h3>
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
    <form action="{{ route('hostel-rooms.update', $hostel_room->id) }}" method="POST">
        @csrf @method('PUT')
        @include('in.school.hostels.hostel_rooms.form', ['room' => $hostel_room])
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection