@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Unallocated Students</h3>
    <form method="GET" class="row g-3 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone" value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="gender" class="form-control">
            <option value="">Filter by Gender</option>
            <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
    <div class="col-md-2">
        <a href="{{ route('hostel-allocations.unallocated') }}" class="btn btn-secondary w-100">Reset</a>
    </div>
</form>

    @if($students->isEmpty())
        <div class="alert alert-info">All students are allocated.</div>
    @else

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Admission No.</th>
                <th>Name</th>
                <th>Gender</th>
                <th>GradeLevel</th>
                <th>Admission date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                            <td>{{ $student->admission_number ?? '-' }}</td>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>{{ $student->grade->name ?? '-' }}</td>
                            <td>{{ $student->admission_date->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                <td>
        <a href="{{ route('hostel-allocations.create', ['student' => $student->user_id]) }}" class="btn btn-sm btn-primary">
            Allocate Now
        </a>
    </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @endif
        <div class="d-flex justify-content-center">
    {{ $students->links() }}
</div>
</div>
@endsection
