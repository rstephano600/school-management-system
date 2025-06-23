@extends('layouts.app')
@section('title', 'Add Teacher')

@section('content')
<div class="container">
    <h3 class="mb-4">Add Teacher</h3>

    <form action="{{ route('teachers.store') }}" method="POST">

        @csrf
<input type="hidden" name="is_class_teacher" value="1">
<input type="hidden" name="status" value="1">

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

        <div class="mb-3">
            <label>Name</label>
            <input name="name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>


        <div class="mb-3">
            <label>Employee ID</label>
            <input name="employee_id" value="{{ old('employee_id') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Joining Date</label>
            <input type="date" name="joining_date" value="{{ old('joining_date') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Qualification</label>
            <input name="qualification" value="{{ old('qualification') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Specialization</label>
            <input name="specialization" value="{{ old('specialization') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Experience (years)</label>
            <input name="experience" value="{{ old('experience') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Department</label>
            <input name="department" value="{{ old('department') }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>


</div>
@endsection
