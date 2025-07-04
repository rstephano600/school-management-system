@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Division</h3>

    <form action="{{ route('divisions.update', $division) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="school_id" class="form-label">School</label>
            <select name="school_id" class="form-select" required>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ $division->school_id == $school->id ? 'selected' : '' }}>
                        {{ $school->name }}
                    </option>
                @endforeach
            </select>
            @error('school_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Min Point</label>
            <input type="number" step="0.01" name="min_point" value="{{ old('min_point', $division->min_point) }}" class="form-control" required>
            @error('min_point') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Max Point</label>
            <input type="number" step="0.01" name="max_point" value="{{ old('max_point', $division->max_point) }}" class="form-control" required>
            @error('max_point') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Division</label>
            <input type="text" name="division" value="{{ old('division', $division->division) }}" class="form-control" required>
            @error('division') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Remarks</label>
            <input type="text" name="remarks" value="{{ old('remarks', $division->remarks) }}" class="form-control">
            @error('remarks') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-primary" type="submit">Update</button>
        <a href="{{ route('divisions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
