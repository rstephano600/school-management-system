@extends('layouts.app')

@section('content')
<h4 class="text-center mb-4">General Exam Results - Print View</h4>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th><th>Student</th><th>Admission</th><th>Subject</th>
            <th>Exam</th><th>Year</th><th>Marks</th><th>Grade</th><th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $i => $res)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $res->student->user->name }}</td>
            <td>{{ $res->student->admission_number }}</td>
            <td>{{ $res->exam->subject->name ?? '-' }}</td>
            <td>{{ $res->exam->title }}</td>
            <td>{{ $res->exam->academicYear->name ?? '-' }}</td>
            <td>{{ $res->marks_obtained }}</td>
            <td>{{ $res->grade }}</td>
            <td>{{ $res->published ? 'Published' : 'Draft' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
