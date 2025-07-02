@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Exam Result</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('exam-results.update', $examResult) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Exam</label>
            <input type="text" class="form-control" disabled value="{{ $examResult->exam->title }}">
        </div>

        <div class="mb-3">
            <label>Student</label>
            <input type="text" class="form-control" disabled value="{{ $examResult->student->first_name }} {{ $examResult->student->last_name }}">
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Marks Obtained</label>
                <input type="number" name="marks_obtained" class="form-control" value="{{ $examResult->marks_obtained }}" required>
            </div>
            <div class="col">
                <label>Grade</label>
                <input type="text" name="grade" class="form-control" value="{{ $examResult->grade }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control">{{ $examResult->remarks }}</textarea>
        </div>

        <button class="btn btn-primary">Update Result</button>
        <a href="{{ route('exam-results.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
