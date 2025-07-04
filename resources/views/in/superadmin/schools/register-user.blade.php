@extends('layouts.app')

@section('content')
<div class="container">
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
    <h2>Register New User to {{ $school->name }}</h2>
    <form method="POST" action="{{ route('superadmin.schools.users.store', $school) }}">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Select Role --</option>
                    <option value="school_admin">School Admin</option>
                    <option value="student">Student</option>
                    <option value="parent">Parent</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                    <option value="academic_master">Academic Master</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

        </div>

        <button type="submit" class="btn btn-primary">Register User</button>
    </form>
</div>
@endsection
