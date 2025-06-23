<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $notice->title ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Topic</label>
    <input type="text" name="topic" class="form-control" value="{{ old('topic', $notice->topic ?? '') }}">
</div>
<div class="mb-3">
    <label>Notice Date</label>
    <input type="date" name="notice_date" class="form-control" value="{{ old('notice_date', $notice->notice_date ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Audience</label>
    <select name="audience" class="form-control" required>
        @foreach(['all', 'teachers', 'students', 'parents', 'staff'] as $aud)
            <option value="{{ $aud }}" @if(($notice->audience ?? old('audience')) === $aud) selected @endif>{{ ucfirst($aud) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control" required>
        @foreach(['draft', 'published', 'archived'] as $status)
            <option value="{{ $status }}" @if(($notice->status ?? old('status')) === $status) selected @endif>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Upload Document</label>
    <input type="file" name="content" class="form-control" accept=".pdf,.doc,.docx" @if(!isset($notice)) required @endif>
    <small class="text-muted">Max 500KB. Allowed: PDF, DOC, DOCX</small>
</div>