@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Exam Result</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('exam-results.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Exam</label>
            <select name="exam_id" class="form-select" required>
                <option value="">-- Select Exam --</option>
                @foreach($exams as $exam)
                    <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Student</label>
            <select name="student_id" class="form-select" required>
                <option value="">-- Select Student --</option>
                @foreach($students as $student)
                    <option value="{{ $student->user_id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Marks Obtained</label>
                <input type="number" name="marks_obtained" class="form-control" required>
            </div>
            <div class="col">
                <label>Grade</label>
                <input type="text" name="grade" class="form-control" required maxlength="5">
            </div>
        </div>

        <div class="mb-3">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Save Result</button>
        <a href="{{ route('exam-results.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
