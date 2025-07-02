@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Grade</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('grades.update', $grade) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Copy the form fields from create.blade.php and prefill using $grade --}}
        {{-- Example: --}}
        <div class="mb-3">
            <label class="form-label">Student</label>
            <select name="student_id" class="form-select" required>
                @foreach($students as $student)
                    <option value="{{ $student->user_id }}" {{ $grade->student_id == $student->user_id ? 'selected' : '' }}>
                        {{ $student->first_name }} {{ $student->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Add the rest of the fields (class_id, submission_id, score, etc.) just like create view --}}
        {{-- Pre-fill them with $grade->... values --}}

        {{-- ... --}}

        <button class="btn btn-primary">Update Grade</button>
        <a href="{{ route('grades.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
