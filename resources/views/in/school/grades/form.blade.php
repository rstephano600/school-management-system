<div class="mb-3">
    <label for="min_score" class="form-label">Min Score %</label>
    <input type="number" name="min_score" class="form-control" value="{{ old('min_score', $grade->min_score ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="max_score" class="form-label">Max Score %</label>
    <input type="number" name="max_score" class="form-control" value="{{ old('max_score', $grade->max_score ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="grade_letter" class="form-label">Grade Letter</label>
    <input type="text" name="grade_letter" class="form-control" value="{{ old('grade_letter', $grade->grade_letter ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="grade_point" class="form-label">Grade Point</label>
    <input type="number" step="0.01" name="grade_point" class="form-control" value="{{ old('grade_point', $grade->grade_point ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="remarks" class="form-label">Remarks</label>
    <input type="text" name="remarks" class="form-control" value="{{ old('remarks', $grade->remarks ?? '') }}">
</div>

<div class="mb-3">
    <label for="level" class="form-label">Level</label>
    <input type="text" name="level" class="form-control" value="{{ old('level', $grade->level ?? '') }}">
</div>