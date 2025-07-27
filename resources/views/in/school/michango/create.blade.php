@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="mb-4">Create New Michango Category</h4>

    <form method="POST" action="{{ route('michango.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Code</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Target Amount</label>
            <input type="number" name="target_amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Suggested Amount</label>
            <input type="number" name="suggested_amount" class="form-control">
        </div>
        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>
        <div class="mb-3">
            <label>Contribution Type</label>
            <select name="contribution_type" class="form-control" required>
                <option value="per_student">Per Student</option>
                <option value="per_parent">Per Parent</option>
                <option value="voluntary">Voluntary</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Applicable Grades</label>
            <select name="applicable_grades[]" class="form-control" multiple>
                @foreach ($grades as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary">Create</button>
    </form>
</div>
@endsection