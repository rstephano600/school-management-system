@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Requirement Submission</h3>

    <form method="POST" action="{{ route('student-requirement-submissions.update', $submission->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Student</label>
            <select name="student_id" class="form-control" required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ $submission->student_id == $student->id ? 'selected' : '' }}>
                        {{ $student->full_name ?? $student->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Requirement</label>
            <select name="requirement_id" class="form-control" required>
                @foreach($requirements as $requirement)
                    <option value="{{ $requirement->id }}" {{ $submission->requirement_id == $requirement->id ? 'selected' : '' }}>
                        {{ $requirement->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="paid" {{ $submission->status == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="provided" {{ $submission->status == 'provided' ? 'selected' : '' }}>Provided</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="quantity_received" class="form-label">quantity received</label>
            <input type="number" name="quantity_received" class="form-control" step="0.01">
        </div>

        <div class="mb-3">
            <label for="quantity_remain" class="form-label">quantity remain</label>
            <input type="number" name="quantity_remain" class="form-control" step="0.01">
        </div>

        <div class="mb-3">
            <label>Amount Paid</label>
            <input type="number" step="0.01" name="amount_paid" class="form-control" value="{{ $submission->amount_paid }}">
        </div>

                <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
        </div>


        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('student-requirement-submissions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
