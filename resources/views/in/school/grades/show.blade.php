@extends('layouts.app')

@section('title', 'Grade Details')

@section('content')
<div class="container">
    <h3 class="mb-3">Grade Details</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Min Score:</strong> {{ $grade->min_score }}</p>
            <p><strong>Max Score:</strong> {{ $grade->max_score }}</p>
            <p><strong>Grade Letter:</strong> {{ $grade->grade_letter }}</p>
            <p><strong>Grade Point:</strong> {{ $grade->grade_point }}</p>
            <p><strong>Remarks:</strong> {{ $grade->remarks }}</p>
            <p><strong>Level:</strong> {{ $grade->level }}</p>
        </div>
    </div>

    <a href="{{ route('grades.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection