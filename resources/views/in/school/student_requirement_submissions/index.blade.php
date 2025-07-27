@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Student Requirement Submissions</h3>

    <a href="{{ route('student-requirement-submissions.create') }}" class="btn btn-primary mb-3">+ New Submission</a>

    <form method="GET" class="row g-2 mb-4">
<div class="col-md-3">
    <input type="text" name="student_search" class="form-control" placeholder="Search student..." value="{{ request('student_search') }}">
</div>

        <div class="col-md-3">
            <select name="student_requirement_id" class="form-control">
                <option value="">-- Filter by Requirement --</option>
                @foreach($requirements as $requirement)
                    <option value="{{ $requirement->id }}" {{ request('student_requirement_id') == $requirement->id ? 'selected' : '' }}>
                        {{ $requirement->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">-- Filter by Status --</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="provided" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
            </select>
        </div>

        <div class="col-md-3">
            <button class="btn btn-secondary w-100" type="submit">Filter</button>
        </div>
    </form>

    @if($submissions->count())
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Requirement</th>
                    <th>Status</th>
                    <th>Amount Paid</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $submission->student->fname ?? '' }}
                        {{ $submission->student->mname ?? '' }}
                        {{ $submission->student->lname ?? '' }}
                   </td>

                    <td>{{ $submission->requirement->name }}</td>
                    <td>
                        <span class="badge bg-{{ $submission->status == 'paid' ? 'success' : 'info' }}">
                            {{ ucfirst($submission->status) }}
                        </span>
                    </td>
                    <td>{{ $submission->amount_paid ?? '-' }}</td>
                    <td>{{ $submission->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('student-requirement-submissions.edit', $submission->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('student-requirement-submissions.destroy', $submission->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this record?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Del</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $submissions->links() }}
    @else
        <div class="alert alert-info">No submissions found.</div>
    @endif
</div>
@endsection
