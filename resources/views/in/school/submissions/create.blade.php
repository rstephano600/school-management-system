@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Submit Assignment</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="assignment_id" class="form-label">Select Assignment</label>
            <select name="assignment_id" id="assignment_id" class="form-select" required>
                <option value="">-- Choose Assignment --</option>
                @foreach($assignments as $assignment)
                    <option value="{{ $assignment->id }}" {{ old('assignment_id') == $assignment->id ? 'selected' : '' }}>
                        {{ $assignment->title }} (Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('Y-m-d H:i') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Upload File (optional)</label>
            <input type="file" name="file" class="form-control">
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes (optional)</label>
            <textarea name="notes" class="form-control" rows="4">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
@endsection
