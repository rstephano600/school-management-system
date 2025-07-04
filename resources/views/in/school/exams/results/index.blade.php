@extends('layouts.app')
@section('title', 'Enter Exam Results')

@section('content')
<div class="container">
    <h4>Enter Results for: {{ $exam->title }} ({{ $exam->grade->name }})</h4>

    <form method="GET">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search student..." class="form-control mb-3">
    </form>

    <form action="{{ route('exams.results.store', $exam->id) }}" method="POST">
        @csrf

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Admission #</th>
                    <th>Student</th>
                    <th>Marks Obtained</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->admission_number }}</td>
                    <td>{{ $student->user->name }}</td>
                    <td>
                        <input type="number" name="results[{{ $student->user_id }}]" 
                               class="form-control @if($errors->has("results.{$student->user_id}")) is-invalid @endif"
                               step="0.01"
                               value="{{ old("results.{$student->user_id}", $existingResults[$student->user_id] ?? '') }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $students->appends(['search' => request('search')])->links() }}

        <button type="submit" class="btn btn-primary mt-3">Save Results</button>
    </form>
</div>
@endsection
