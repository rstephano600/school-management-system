@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="mb-3">Michango: {{ $michangoCategory->name }}</h4>

    <div class="mb-3">
        <strong>Description:</strong> {{ $michangoCategory->description }}<br>
        <strong>Target:</strong> {{ number_format($michangoCategory->target_amount) }}<br>
        <strong>Collected:</strong> {{ number_format($michangoCategory->collected_amount) }}<br>
        <strong>Start Date:</strong> {{ $michangoCategory->start_date }}<br>
        <strong>End Date:</strong> {{ $michangoCategory->end_date }}<br>
        <strong>Contribution Type:</strong> {{ ucfirst(str_replace('_', ' ', $michangoCategory->contribution_type)) }}
    </div>

    <div class="mb-4">
        <strong>Stats:</strong><br>
        Total Students: {{ $contributionStats['total_students'] }}<br>
        Students Pledged: {{ $contributionStats['students_pledged'] }}<br>
        Completed: {{ $contributionStats['students_completed'] }}<br>
        Total Pledged: {{ number_format($contributionStats['total_pledged']) }}<br>
        Total Paid: {{ number_format($contributionStats['total_paid']) }}<br>
        Completion Rate: {{ $contributionStats['completion_rate'] }}%
    </div>

    <a href="{{ route('michango.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
