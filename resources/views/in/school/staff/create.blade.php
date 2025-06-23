@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Staff Member</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('schools.staff.store', $school->id) }}" method="POST">
        @csrf
    <input type="hidden" name="school_id" value="{{ auth()->user()->school_id }}">

    <div class="mb-3">
        <label for="name" class="form-label">Staff Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Staff Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>
        <div class="mb-3">
            <label for="employee_id" class="form-label">Employee ID</label>
            <input type="text" name="employee_id" class="form-control" required value="{{ old('employee_id') }}">
        </div>
        <div class="mb-3">
            <label for="joining_date" class="form-label">Joining Date</label>
            <input type="date" name="joining_date" class="form-control" required value="{{ old('joining_date') }}">
        </div>
        <div class="mb-3">
            <label for="designation" class="form-label">Designation</label>
            <input type="text" name="designation" class="form-control" required value="{{ old('designation') }}">
        </div>
        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <input type="text" name="department" class="form-control" value="{{ old('department') }}">
        </div>
        <div class="mb-3">
            <label for="qualification" class="form-label">Qualification</label>
            <input type="text" name="qualification" class="form-control" value="{{ old('qualification') }}">
        </div>
        <div class="mb-3">
            <label for="experience" class="form-label">Experience</label>
            <input type="text" name="experience" class="form-control" value="{{ old('experience') }}">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Save Staff</button>
    </form>
</div>
@endsection
