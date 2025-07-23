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


<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <input type="hidden" name="school_id" value="{{ auth()->user()->school_id }}">

    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label"> Email Address</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
            <div class="col-md-6 mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Select Role --</option>
                    <option value="school_admin">School Admin</option>
                    <option value="director">director</option>
                    <option value="manager">manager</option>
                    <option value="head_master">head master</option>
                    <option value="secretary">Secretary</option>
                    <option value="academic_master">academic master</option>
                    <option value="school_doctor">school doctor</option>
                    <option value="staff">Staff</option>
                    <option value="school_librarian">school librarian</option>
                    <option value="student">Student</option>
                    <option value="parent">Parent</option>
                    <option value="teacher">Teacher</option>
                </select>
            </div>
        </div>

    <button type="submit" class="btn btn-success">Register User</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
</form>

</div>
@endsection
