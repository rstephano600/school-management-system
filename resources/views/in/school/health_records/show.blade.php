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
@php
    $allergies = $health_record->allergies;
    $medical_conditions = $health_record->medical_conditions;
    $immunizations = $health_record->immunizations;

    // Normalize to arrays
    $allergies = is_array($allergies)
        ? $allergies
        : (is_string($allergies) ? explode(',', $allergies) : []);

    $medical_conditions = is_array($medical_conditions)
        ? $medical_conditions
        : (is_string($medical_conditions) ? explode(',', $medical_conditions) : []);

    $immunizations = is_array($immunizations)
        ? $immunizations
        : (is_string($immunizations) ? explode(',', $immunizations) : []);
@endphp

<p><strong>Allergies:</strong> {{ implode(', ', $allergies) }}</p>
<p><strong>Medical Conditions:</strong> {{ implode(', ', $medical_conditions) }}</p>
<p><strong>Immunizations:</strong> {{ implode(', ', $immunizations) }}</p>
    <p><strong>Last Checkup Date:</strong> {{ $health_record->last_checkup_date }}</p>
    <p><strong>Notes:</strong> {{ $health_record->notes }}</p>
    <a href="{{ route('health_records.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection