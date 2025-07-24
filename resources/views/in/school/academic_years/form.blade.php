<div class="row g-3">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mb-3">
        <label for="year" class="form-label">Year name *</label>
        <select name="name" id="year" class="form-select" required>
            <option value="">-- Select Year --</option>
            @for ($year = date('Y') + 1; $year >= 2015; $year--)
                <option value="{{ $year }}">{{ $year }}</option>
            @endfor
        </select>
    </div>
    <div class="mb-3">
    <label for="code" class="form-label">Academic Year Code</label>
    <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $academicYear->code ?? '') }}">
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select class="form-select" id="status" name="status">
        <option value="active" {{ old('status', $academicYear->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ old('status', $academicYear->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
</div>

    <div class="col-md-6">
        <label class="form-label">Start Date *</label>
        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $academicYear->start_date ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">End Date *</label>
        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $academicYear->end_date ?? '') }}" required>
    </div>
    <div class="col-md-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $academicYear->description ?? '') }}</textarea>
    </div>
    <div class="col-md-6 form-check mt-3 ms-2">
        <input type="checkbox" name="is_current" class="form-check-input" {{ (old('is_current', $academicYear->is_current ?? false)) ? 'checked' : '' }}>
        <label class="form-check-label">Mark as Current Academic Year</label>
    </div>
</div>
