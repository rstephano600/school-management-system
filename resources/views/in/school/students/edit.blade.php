@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Student</h1>
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
    <form action="{{ route('students.update', $student->user_id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="admission_date" class="form-label">Admission Date</label>
            <input type="date" name="admission_date" class="form-control" value="{{ old('admission_date', $student->admission_date->format('Y-m-d')) }}" required>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="grade_id" class="form-label">Grade Level</label>
                <select name="grade_id" class="form-select" required>
                    <option value="">Select Grade</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ old('grade_id', $student->grade_id) == $grade->id ? 'selected' : '' }}>
                            {{ $grade->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="section_id" class="form-label">Section</label>
                <select name="section_id" class="form-select" required>
                    <option value="2">Select Section</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" {{ old('section_id', $student->section_id) == $section->id ? 'selected' : '' }}>
                            {{ $section->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $student->date_of_birth->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-select">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="blood_group" class="form-label">Blood Group</label>
            <input type="text" name="blood_group" class="form-control" value="{{ old('blood_group', $student->blood_group) }}">
        </div>

        <div class="mb-3">
            <label for="religion" class="form-label">Religion</label>
            <input type="text" name="religion" class="form-control" value="{{ old('religion', $student->religion) }}">
        </div>

        <div class="mb-3">
            <label for="nationality" class="form-label">Nationality</label>
            <input type="text" name="nationality" class="form-control" value="{{ old('nationality', $student->nationality) }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_transport" class="form-check-input" {{ old('is_transport', $student->is_transport) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_transport">Transport Facility</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_hostel" class="form-check-input" {{ old('is_hostel', $student->is_hostel) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_hostel">Hostel Facility</label>
        </div>

        <button type="submit" class="btn btn-primary">Update Student</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
