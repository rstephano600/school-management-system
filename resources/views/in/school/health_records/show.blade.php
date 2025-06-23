@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Health Record Details</h3>
    <p><strong>Student:</strong> {{ $health_record->student->user->name ?? 'N/A' }}</p>
    <p><strong>Record Date:</strong> {{ $health_record->record_date }}</p>
    <p><strong>Height:</strong> {{ $health_record->height }} cm</p>
    <p><strong>Weight:</strong> {{ $health_record->weight }} kg</p>
    <p><strong>Blood Group:</strong> {{ $health_record->blood_group }}</p>
    <p><strong>Vision Left:</strong> {{ $health_record->vision_left }}</p>
    <p><strong>Vision Right:</strong> {{ $health_record->vision_right }}</p>
    <p><strong>Allergies:</strong> {{ implode(', ', $health_record->allergies ?? []) }}</p>
    <p><strong>Medical Conditions:</strong> {{ implode(', ', $health_record->medical_conditions ?? []) }}</p>
    <p><strong>Immunizations:</strong> {{ implode(', ', $health_record->immunizations ?? []) }}</p>
    <p><strong>Last Checkup Date:</strong> {{ $health_record->last_checkup_date }}</p>
    <p><strong>Notes:</strong> {{ $health_record->notes }}</p>
    <a href="{{ route('health_records.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection