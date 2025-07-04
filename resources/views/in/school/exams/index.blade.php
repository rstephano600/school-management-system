@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Exams</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('exams.create') }}" class="btn btn-primary mb-3">Create New Exam</a>
<form method="GET" class="row g-3 mb-3">
    <div class="col-md-3">
        <select name="academic_year_id" class="form-select">
            <option value="">All Years</option>
            @foreach($academicYears as $year)
                <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                    {{ $year->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <select name="grade_id" class="form-select">
            <option value="">All Grades</option>
            @foreach($grades as $grade)
                <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                    {{ $grade->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <select name="subject_id" class="form-select">
            <option value="">All Subjects</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Grade</th>
                <th>Subject</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th>Total Marks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exams as $exam)
            <tr>
                <td>{{ $exam->title }}</td>
                <td>{{ $exam->examType->name ?? 'N/A' }}</td>
                <td>{{ $exam->grade->name ?? '-' }}</td>
                <td>{{ $exam->subject->name ?? '-' }}</td>
                <td>{{ $exam->start_date }}</td>
                <td>{{ $exam->end_date }}</td>
                <td>{{ ucfirst($exam->status) }}</td>
                <td>{{ $exam->total_marks }}</td>
                <td>
                    <a href="{{ route('exams.results.index', $exam->id) }}" class="btn btn-success btn-sm">Enter Results</a>
<a href="{{ route('exam-results.index', $exam->id) }}" class="btn btn-outline-primary btn-sm">
    <i class="fas fa-eye"></i> Results
</a>

                    <a href="{{ route('exam-results.import.form', $exam->id) }}" class="btn btn-success btn-sm">Import Results</a>

                    <a href="{{ route('exams.show', $exam) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('exams.edit', $exam) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('exams.destroy', $exam) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this exam?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $exams->links() }}
</div>
@endsection
