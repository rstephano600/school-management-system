@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Import Results for Exam: {{ $exam->title }}</h2>

@if(session('error'))
    <div class="alert alert-danger">
        <strong>{{ session('error') }}</strong>
        <ul>
            @foreach(session('importErrors', []) as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('exam-results.import', $exam) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="excel_file" class="form-label">Upload Excel File</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control" required>
            <small class="form-text text-muted">File format: XLSX, XLS, or CSV</small>
        </div>

        <button type="submit" class="btn btn-success">Upload & Import</button>
        <a href="{{ route('exam-results.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <hr>
    <h5>Excel Template Format</h5>
    <p>The Excel should have the following columns in the first row:</p>
    <ul>
        <li><strong>admission_number</strong> (student admission number)</li>
        <li><strong>marks_obtained</strong></li>
        <li><strong>grade</strong></li>
        <li><strong>remarks</strong> (optional)</li>
    </ul>
</div>
@endsection
