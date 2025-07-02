@extends('layouts.app')
@section('title', 'Activity Details')

@section('content')
<div class="container">
    <h3>Activity Details</h3>

    <div class="card mt-4">
        <div class="card-body">
            <p><strong>Day:</strong> {{ $generalSchedule->day_of_week }}</p>
            <p><strong>Activity:</strong> {{ $generalSchedule->activity }}</p>
            <p><strong>Time:</strong> {{ $generalSchedule->start_time }} - {{ $generalSchedule->end_time }}</p>
            <p><strong>Academic Year:</strong> {{ $generalSchedule->academicYear->name ?? 'N/A' }}</p>
            <p><strong>Description:</strong> {{ $generalSchedule->description }}</p>
        </div>
    </div>
</div>
@endsection
