
@extends('layouts.app')

@section('title', 'Enter Assessment Results')

@section('content')
<div class="container">
    <h3 class="mb-4">Enter Results: <span class="text-primary">{{ $assessment->title }}</span> - {{ $assessment->subject->name }} ({{ $assessment->gradeLevel->name }})</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name or admission number" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </div>
        </div>
    </form>

    <form id="resultForm" action="{{ route('assessments.results.store', $assessment->id) }}" method="POST">
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Admission No</th>
                        <th>Name</th>
                        <th>Score (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $student->admission_number }}</td>
                            <td>{{ $student->user->name }}</td>
                            <td>
                                <input type="number" step="0.01" min="0" max="100"
                                       name="marks[{{ $student->user_id }}][score]"
                                       class="form-control score-input"
                                       value="{{ $resultsMap[$student->user_id]->score ?? '' }}">
                                <input type="hidden" name="marks[{{ $student->user_id }}][student_id]" value="{{ $student->user_id }}">
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">No students found for this grade level.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Save Results</button>
            <a href="{{ route('assessments.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>

    <div class="mt-4">
        {{ $students->appends(request()->query())->links() }}
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('resultForm').addEventListener('submit', function(e) {
        let inputs = document.querySelectorAll('.score-input');
        inputs.forEach(input => {
            if (input.value === '') {
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });
    });
</script>
@endpush
@endsection
