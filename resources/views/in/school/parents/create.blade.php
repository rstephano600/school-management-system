@extends('layouts.app')

@section('title', 'Add Parent')

@section('content')
<div class="container">
    <h3 class="mb-3">Add Parent for {{ $student->user->name }}</h3>

    @if ($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('student.parent.store', $student) }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Full Name *</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="relation_type" class="form-label">Relation *</label>
                <select name="relation_type" class="form-select" required>
                    <option value="">-- Select --</option>
                    <option value="father">Father</option>
                    <option value="mother">Mother</option>
                    <option value="guardian">Guardian</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="occupation" class="form-label">Occupation</label>
                <input type="text" name="occupation" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="education" class="form-label">Education</label>
                <input type="text" name="education" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="company" class="form-label">Company</label>
                <input type="text" name="company" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="annual_income" class="form-label">Annual Income (TZS)</label>
                <input type="number" name="annual_income" class="form-control" step="0.01">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save Parent Info</button>
            <a href="{{ route('students.show', $student->user_id) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
