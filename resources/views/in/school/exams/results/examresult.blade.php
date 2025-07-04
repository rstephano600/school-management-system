@extends('layouts.app')
@section('title', 'Exam Results')

@section('content')
<div class="container">
    <h3>Results for: {{ $exam->title }} - {{ $exam->grade->name ?? '' }} {{ $exam->subject->name ?? '' }}</h3>

    @if($results->isEmpty())
        <p class="text-muted">No results recorded yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Admission No.</th>
                        <th>Name</th>
                        <th>Marks</th>
                        <th>Grade</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Recorded At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $result)
                    <tr>
                        <td>{{ $results->firstItem() + $index }}</td>
                        <td>{{ $result->student->admission_number }}</td>
                        <td>{{ $result->student->user->name }}</td>
                        <td>{{ $result->marks_obtained }}</td>
                        <td>{{ $result->grade }}</td>
                        <td>{{ $result->remarks ?? '-' }}</td>
                        <td>
                            @if($result->published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>{{ $result->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $results->withQueryString()->links() }}
        </div>
    @endif

    <a href="{{ route('exams.index') }}" class="btn btn-secondary mt-3">Back to Exams</a>
</div>
@endsection
