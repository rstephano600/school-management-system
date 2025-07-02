@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Exam Type Details</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $examType->name }}</h5>
            <p><strong>Weight:</strong> {{ $examType->weight }}%</p>
            <p><strong>Description:</strong> {{ $examType->description ?? 'N/A' }}</p>

            <a href="{{ route('exam-types.index') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
@endsection
