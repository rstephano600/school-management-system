@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Academic Record</h2>
    <form method="POST" action="{{ route('academic-records.update', $academicRecord) }}">
        @csrf
        @method('PUT')
        @include('in.school.academic_records.form', ['academicRecord' => $academicRecord])
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection