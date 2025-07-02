@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Exam</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('exams.update', $exam) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Copy all fields from create.blade.php and change old('...') to $exam->... --}}

        <div class="mb-3">
            <label>Exam Title</label>
            <input type="text" name="title" class="form-control" required value="{{ $exam->title }}">
        </div>

        {{-- Continue for exam_type_id, dates, academic_year_id, etc. --}}

        <button class="btn btn-primary">Update Exam</button>
        <a href="{{ route('exams.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
