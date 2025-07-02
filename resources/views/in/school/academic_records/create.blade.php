@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Add Academic Record</h2>
    <form method="POST" action="{{ route('academic-records.store') }}">
        @csrf
        @include('in.school.academic_records.form')
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection