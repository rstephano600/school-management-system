<div class="mb-3">
    <label for="class_id" class="form-label">Class</label>
    <select name="class_id" class="form-control" required>
        <option value="">Select Class</option>
        @foreach($classes as $class)
        <option value="{{ $class->id }}" {{ old('class_id', $assignment->class_id ?? '') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $assignment->title ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $assignment->description ?? '') }}</textarea>
</div>
<div class="mb-3"> 
    <label for="due_date" class="form-label">Due Date</label>
    <input type="datetime-local" name="due_date" class="form-control" 
        value="{{ old('due_date', isset($assignment->due_date) ? \Carbon\Carbon::parse($assignment->due_date)->format('Y-m-d\TH:i') : '') }}" 
        required>
</div>

<div class="mb-3">
    <label for="max_points" class="form-label">Max Points</label>
    <input type="number" step="0.01" name="max_points" class="form-control" value="{{ old('max_points', $assignment->max_points ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="assignment_type" class="form-label">Assignment Type</label>
    <select name="assignment_type" class="form-control" required>
        <option value="">Select Type</option>
        @foreach(['homework', 'quiz', 'test', 'other'] as $type)
        <option value="{{ $type }}" {{ old('assignment_type', $assignment->assignment_type ?? '') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" class="form-control" required>
        @foreach(['draft', 'published', 'graded'] as $status)
        <option value="{{ $status }}" {{ old('status', $assignment->status ?? '') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="file" class="form-label">Upload File (optional)</label>
    <input type="file" name="file" class="form-control">
</div>
