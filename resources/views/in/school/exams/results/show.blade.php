@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Result Details</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Exam:</strong> {{ $examResult->exam->title }}</p>
            <p><strong>Student:</strong> {{ $examResult->student->first_name }} {{ $examResult->student->last_name }}</p>
            <p><strong>Marks:</strong> {{ $examResult->marks_obtained }}</p>
            <p><strong>Grade:</strong> {{ $examResult->grade }}</p>
            <p><strong>Remarks:</strong> {{ $examResult->remarks }}</p>
            <p><strong>Status:</strong>
                @if($examResult->published)
                    <span class="text-success">Published</span> on {{ $examResult->published_at }}
                @else
                    <span class="text-muted">Not Published</span>
                @endif
            </p>

            <a href="{{ route('exam-results.index') }}" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>
</div>
@endsection
