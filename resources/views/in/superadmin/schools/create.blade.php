@extends('layouts.app')

@section('content')
<h4 class="mb-3">Register New School</h4>

<form action="{{ route('superadmin.schools.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('in.superadmin.schools._form', ['school' => null])
    <button class="btn btn-primary">Save</button>
</form>
@endsection
