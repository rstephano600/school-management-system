
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Behavior Record</h3>
    <form action="{{ route('behavior_records.update', $behavior_record->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Date of Incident</label>
            <input type="date" name="incident_date" value="{{ $behavior_record->incident_date }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Incident Type</label>
            <select name="incident_type" class="form-control">
                @foreach(['disruption', 'bullying', 'cheating', 'absenteeism', 'other'] as $type)
                    <option value="{{ $type }}" @if($behavior_record->incident_type === $type) selected @endif>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $behavior_record->description }}</textarea>
        </div>
        <div class="mb-3">
            <label>Action Taken</label>
            <textarea name="action_taken" class="form-control">{{ $behavior_record->action_taken }}</textarea>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="open" @if($behavior_record->status == 'open') selected @endif>Open</option>
                <option value="resolved" @if($behavior_record->status == 'resolved') selected @endif>Resolved</option>
            </select>
        </div>
        <button class="btn btn-success">Update Record</button>
    </form>
</div>
@endsection