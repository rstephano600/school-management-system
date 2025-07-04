@extends('layouts.app')
@section('title', 'Assessment Summary')

@section('content')
<div class="container">
    <h4>Assessment Summary for: {{ $student->user->name }} ({{ $student->admission_number }})</h4>

    @forelse($results as $year => $yearResults)
        <div class="card my-3">
            <div class="card-header bg-primary text-white">{{ $year }}</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Assessment</th>
                            <th>Subject</th>
                            <th>Score (%)</th>
                            <th>Recorded By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($yearResults as $res)
                            <tr>
                                <td>{{ $res->assessment->title }}</td>
                                <td>{{ $res->assessment->subject->name }}</td>
                                <td>{{ $res->score }}</td>
                                <td>{{ $res->recordedBy->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <p>No assessment results found for this student.</p>
    @endforelse

    <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
