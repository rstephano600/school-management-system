@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Add New Division</h3>

    <form action="{{ route('divisions.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Min Point</label>
            <input type="number" step="0.01" name="min_point" value="{{ old('min_point') }}" class="form-control" required>
            @error('min_point') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Max Point</label>
            <input type="number" step="0.01" name="max_point" value="{{ old('max_point') }}" class="form-control" required>
            @error('max_point') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Division</label>
            <input type="text" name="division" value="{{ old('division') }}" class="form-control" required>
            @error('division') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Remarks (optional)</label>
            <input type="text" name="remarks" value="{{ old('remarks') }}" class="form-control">
            @error('remarks') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-primary" type="submit">Save</button>
        <a href="{{ route('divisions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
