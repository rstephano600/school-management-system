@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Create Announcement</h3>
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
    <form action="{{ route('announcements.store') }}" method="POST">
        @csrf
        @include('in.school.announcements.form')
        <button class="btn btn-primary">Create</button>
    </form>
</div>
@endsection