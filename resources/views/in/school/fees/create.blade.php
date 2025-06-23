@extends('layouts.app')

@section('title', 'Create Fee Structure')

@section('content')
<div class="container">
    <h3 class="mb-4">Create Fee Structure</h3>

    @if ($errors->any())
        <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form action="{{ route('fee-structures.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name *</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Academic Year *</label>
                <select name="academic_year_id" class="form-select" required>
                    <option value="">-- Select Year --</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Frequency *</label>
                <select name="frequency" class="form-select" required>
                    <option value="">-- Select Frequency --</option>
                    <option value="monthly">Monthly</option>
                    <option value="quarterly">Quarterly</option>
                    <option value="semester">Semester</option>
                    <option value="annual">Annual</option>
                    <option value="one-time">One-time</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Amount (TZS) *</label>
                <input type="number" name="amount" step="0.01" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Due Date *</label>
                <input type="date" name="due_date" class="form-control" required>
            </div>

            <div class="col-md-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-md-6 form-check mt-3 ms-2">
                <input type="checkbox" name="is_active" class="form-check-input" checked>
                <label class="form-check-label">Mark as Active</label>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
            <a href="{{ route('fee-structures.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
