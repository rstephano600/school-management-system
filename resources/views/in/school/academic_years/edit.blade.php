@extends('layouts.app')
@section('title', 'Edit Academic Year')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Academic Year</h3>

    <form action="{{ route('academic-years.update', $academicYear) }}" method="POST">
        @csrf @method('PUT')
        @include('in.school.academic_years.form')
        <div class="mt-4">
            <button class="btn btn-primary"><i class="fas fa-sync"></i> Update</button>
            <a href="{{ route('academic-years.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
