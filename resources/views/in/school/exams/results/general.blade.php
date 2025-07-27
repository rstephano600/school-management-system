@extends('layouts.app')

@section('title', 'General Exam Results')

@section('content')
<div class="container">
    <h4 class="mb-4">General Examination Results</h4>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
            <select name="academic_year_id" class="form-select">
                <option value="">All Years</option>
                @foreach($academicYears as $year)
                    <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="semester_id" class="form-select">
                <option value="">All Semester</option>
                @foreach($semesters as $semester)
                    <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>{{ $semester->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="exam_type_id" class="form-select">
                <option value="">All Semester</option>
                @foreach($examTypes as $semester)
                    <option value="{{ $semester->id }}" {{ request('exam_type_id') == $semester->id ? 'selected' : '' }}>{{ $semester->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="grade_id" class="form-select">
                <option value="">All Grades</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="subject_id" class="form-select">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('exam-results.general') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>
<div class="d-flex mb-3">
    <a href="{{ route('exam-results.print', request()->all()) }}" class="btn btn-secondary me-2" target="_blank">
        <i class="fas fa-print"></i> Print
    </a>
    <!-- <a href="{{ route('exam-results.export', request()->all()) }}" class="btn btn-success me-2">
        <i class="fas fa-file-excel"></i> Export Excel
    </a> -->
</div>

    @if($results->isEmpty())
        <p class="text-muted">No results found.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Admission No</th>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>Exam</th>
                        <th>Year</th>
                        <th>Marks</th>
                        <th>Grade</th>
                        <th>Remarks</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $i => $res)
                    <tr>
                        <td>{{ $results->firstItem() + $i }}</td>
                        <td>{{ $res->student->admission_number }}</td>
                        <td>{{ $res->student->user->name }}</td>
                        <td>{{ $res->exam->subject->name ?? '-' }}</td>
                        <td>{{ $res->exam->title }}</td>
                        <td>{{ $res->exam->academicYear->name ?? '-' }}</td>
                        <td>{{ $res->marks_obtained }}</td>
                        <td>{{ $res->grade }}</td>
                        <td>{{ $res->remarks ?? '-' }}</td>
                        <td>
                            @if($res->published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h5 class="mt-5">Subject-wise Averages</h5>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Average Score</th>
            <th>Total Students</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results->groupBy('exam.subject.name') as $subject => $group)
        <tr>
            <td>{{ $subject ?? 'N/A' }}</td>
            <td>{{ number_format($group->avg('marks_obtained'), 2) }}</td>
            <td>{{ $group->count() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

        </div>

        {{ $results->withQueryString()->links() }}
    @endif
</div>
@endsection
