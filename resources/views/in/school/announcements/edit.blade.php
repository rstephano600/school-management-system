@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Edit Announcement</h3>
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
    <form action="{{ route('announcements.update', $announcement->id) }}" method="POST">
        @csrf @method('PUT')
        @include('in.school.announcements.form', ['announcement' => $announcement])
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection