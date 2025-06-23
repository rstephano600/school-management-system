@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Edit Health Record</h3>
    <form action="{{ route('health_records.update', $health_record->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Record Date</label>
            <input type="date" name="record_date" value="{{ $health_record->record_date }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Height (cm)</label>
            <input type="number" step="0.01" name="height" value="{{ $health_record->height }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Weight (kg)</label>
            <input type="number" step="0.01" name="weight" value="{{ $health_record->weight }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Blood Group</label>
            <input type="text" name="blood_group" value="{{ $health_record->blood_group }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Vision Left</label>
            <input type="text" name="vision_left" value="{{ $health_record->vision_left }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Vision Right</label>
            <input type="text" name="vision_right" value="{{ $health_record->vision_right }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Allergies</label>
            <input type="text" name="allergies" value="{{ implode(',', $health_record->allergies ?? []) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Medical Conditions</label>
            <input type="text" name="medical_conditions" value="{{ implode(',', $health_record->medical_conditions ?? []) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Immunizations</label>
            <input type="text" name="immunizations" value="{{ implode(',', $health_record->immunizations ?? []) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Last Checkup Date</label>
            <input type="date" name="last_checkup_date" value="{{ $health_record->last_checkup_date }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control">{{ $health_record->notes }}</textarea>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection