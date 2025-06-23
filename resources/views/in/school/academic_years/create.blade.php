@extends('layouts.app')
@section('title', 'Add Academic Year')

@section('content')
<div class="container">
    <h3 class="mb-4">Add Academic Year</h3>

    <form action="{{ route('academic-years.store') }}" method="POST">
        @csrf
        @include('in.school.academic_years.form')
        <div class="mt-4">
            <button class="btn btn-success"><i class="fas fa-save"></i> Save</button>
            <a href="{{ route('academic-years.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
