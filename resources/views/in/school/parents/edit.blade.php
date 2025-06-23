@extends('layouts.app')

@section('title', 'Edit Parent Info')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Parent Information for {{ $student->user->name }}</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('student.parent.update', [$student->user_id, $user->id]) }}">
        @csrf
        @method('PUT')
        
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" value="{{ $user->name }}" disabled>
            </div>
            
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label">Relation Type</label>
                <select name="relation_type" class="form-select" required>
                    <option value="father" {{ $parent->relation_type == 'father' ? 'selected' : '' }}>Father</option>
                    <option value="mother" {{ $parent->relation_type == 'mother' ? 'selected' : '' }}>Mother</option>
                    <option value="guardian" {{ $parent->relation_type == 'guardian' ? 'selected' : '' }}>Guardian</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Occupation</label>
                <input type="text" name="occupation" class="form-control" value="{{ old('occupation', $parent->occupation) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Education</label>
                <input type="text" name="education" class="form-control" value="{{ old('education', $parent->education) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Company</label>
                <input type="text" name="company" class="form-control" value="{{ old('company', $parent->company) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Annual Income (TZS)</label>
                <input type="number" name="annual_income" step="0.01" class="form-control" value="{{ old('annual_income', $parent->annual_income) }}">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('students.show', $student->user_id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
