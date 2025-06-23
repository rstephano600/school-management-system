@extends('layouts.app')

@section('content')
<h4 class="mb-3">Edit School: {{ $school->name }}</h4>

<form action="{{ route('superadmin.schools.update', $school) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('in.superadmin.schools._form', ['school' => $school])
    <button class="btn btn-primary">Update</button>
</form>
@endsection
