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
    <h3>Edit Notice</h3>
    <form action="{{ route('notices.update', $notice->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('in.school.notices.form', ['notice' => $notice])
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection