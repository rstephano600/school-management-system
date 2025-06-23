@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Behavior Record Details</h3>
    <p><strong>Student:</strong> {{ $behavior_record->student->user->name ?? 'N/A' }}</p>
    <p><strong>Date:</strong> {{ $behavior_record->incident_date }}</p>
    <p><strong>Type:</strong> {{ ucfirst($behavior_record->incident_type) }}</p>
    <p><strong>Description:</strong> {{ $behavior_record->description }}</p>
    <p><strong>Action Taken:</strong> {{ $behavior_record->action_taken }}</p>
    <p><strong>Status:</strong> {{ ucfirst($behavior_record->status) }}</p>
    <p><strong>Reported By:</strong> {{ $behavior_record->reporter->name ?? 'N/A' }}</p>
    <p><strong>Resolved By:</strong> {{ $behavior_record->resolver->name ?? 'Pending' }}</p>
    <p><strong>Resolved Date:</strong> {{ $behavior_record->resolved_date ?? 'Pending' }}</p>
    <a href="{{ route('behavior_records.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection