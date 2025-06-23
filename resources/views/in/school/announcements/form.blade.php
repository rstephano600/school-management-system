<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $announcement->title ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Start Date</label>
    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $announcement->start_date ?? '') }}" required>
</div>
<div class="mb-3">
    <label>End Date</label>
    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $announcement->end_date ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Audience</label>
    <select name="audience" class="form-control" required>
        @foreach(['all', 'teachers', 'students', 'parents', 'staff'] as $aud)
            <option value="{{ $aud }}" @if(($announcement->audience ?? old('audience')) === $aud) selected @endif>{{ ucfirst($aud) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control" required>
        @foreach(['draft', 'published', 'archived'] as $status)
            <option value="{{ $status }}" @if(($announcement->status ?? old('status')) === $status) selected @endif>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Content</label>
    <textarea name="content" class="form-control" rows="4">{{ old('content', $announcement->content ?? '') }}</textarea>
</div>