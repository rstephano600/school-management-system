@extends('layouts.app')
@section('content')
<div class="container">
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
    <h3>Upload Notice</h3>
    <form action="{{ route('notices.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('in.school.notices.form')
        <button class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection