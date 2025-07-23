@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Students</h2>

    @if($students->isEmpty())
        <div class="alert alert-info">No students found for your assigned classes.</div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Student Name</th>
                    <th>Admission No.</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Class (Grade)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</td>
                    <td>{{ $student->admission_number }}</td>
                    <td>{{ ucfirst($student->gender) }}</td>
                    <td>{{ $student->date_of_birth }}</td>
                    <td>{{ $student->grade->name ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
