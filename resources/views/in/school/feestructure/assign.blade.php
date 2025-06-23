@extends('layouts.app')
@section('title', 'Assign Fee Structure')

@section('content')
<div class="container">
    <h4 class="mb-4">Assign Fee Structure to {{ $student->name }}</h4>

    <form action="{{ route('admin.fee-assign.store', $student->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Fee Structure</label>
            <select name="fee_structure_id" class="form-select" required>
                <option value="">-- Select Fee --</option>
                @foreach($fees as $fee)
                    <option value="{{ $fee->id }}">{{ $fee->name }} - {{ $fee->academicYear->name ?? 'No Year' }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success"><i class="fas fa-plus"></i> Assign</button>
        <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
