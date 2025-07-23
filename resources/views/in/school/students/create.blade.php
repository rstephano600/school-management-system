@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Register New Student</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<form action="{{ route('students.store') }}" method="POST">
    @csrf

    <input type="hidden" name="school_id" value="{{ auth()->user()->school_id }}">

    <div class=" row mb-3">
        <div class="col-md-6">
        <label for="name" class="form-label">First Name</label>
        <input type="text" name="fname" class="form-control" value="{{ old('fname') }}" required>
    </div>
    <div class="col-md-6">
        <label for="name" class="form-label">Student Middle Name</label>
        <input type="text" name="mname" class="form-control" value="{{ old('mname') }}" required>
    </div>
    </div>

    <div class="row mb-3">
         <div class="col-md-6">
        <label for="name" class="form-label">Student Last Name</label>
        <input type="text" name="lname" class="form-control" value="{{ old('lname') }}" required>
    </div>

     <div class="col-md-6">
        <label for="email" class="form-label">Student Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
        <label for="admission_date" class="form-label">Admission Date</label>
        <input type="date" name="admission_date" class="form-control" value="{{ old('admission_date') }}" required>
    </div>
    
        <div class="col-md-6">
            <label for="grade_id" class="form-label">status</label>
            <select name="status" class="form-select" >
                <option value="active">Active</option> 
                <option value="graduated">graduated</option> 
                <option value="transferred">transferred</option> 
                <option value="dropped">Droped</option> 
            </select>
            </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="grade_id" class="form-label">Grade Level</label>
            <select name="grade_id" class="form-select" required>
                <option value="">Select Grade</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="section_id" class="form-label">Section</label>
            <select name="section_id" class="form-select">
                <option value="">Select Section</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                        {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-3">
         <div class="col-md-6">
        <label for="date_of_birth" class="form-label">Date of Birth</label>
        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
    </div>

     <div class="col-md-6">
        <label for="gender" class="form-label">Gender</label>
        <select name="gender" class="form-select" required>
            <option value="">Select Gender</option>
            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>
    </div>

    <div class="row mb-3">
         <div class="col-md-6">
        <label for="blood_group" class="form-label">Blood Group</label>
        <input type="text" name="blood_group" class="form-control" value="{{ old('blood_group') }}">
    </div>

     <div class="col-md-6">
        <label for="religion" class="form-label">Religion</label>
        <input type="text" name="religion" class="form-control" value="{{ old('religion') }}">
    </div> 
    </div> 

    <div class="mb-3">
        <label for="nationality" class="form-label">Nationality</label>
        <input type="text" name="nationality" class="form-control" value="{{ old('nationality') }}" required>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" name="is_transport" class="form-check-input" {{ old('is_transport') ? 'checked' : '' }}>
        <label class="form-check-label" for="is_transport">Transport Facility</label>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" name="is_hostel" class="form-check-input" {{ old('is_hostel') ? 'checked' : '' }}>
        <label class="form-check-label" for="is_hostel">Hostel Facility</label>
    </div>

    <button type="submit" class="btn btn-success">Register Student</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
</form>

</div>
@endsection
