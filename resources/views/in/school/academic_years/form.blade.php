<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $academicYear->name ?? '') }}" required>
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
