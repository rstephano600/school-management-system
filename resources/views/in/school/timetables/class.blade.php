@extends('layouts.app')
@section('title', 'Class Timetable')

@section('content')
<div class="container">
    <h3 class="mb-4">Timetable for {{ $class->grade->name }} - {{ $class->section->name }}</h3>

    @php
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $slots = $timetables->groupBy('day_of_week');
    @endphp

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Teacher</th>
                    <th>Room</th>
                    <th>Period</th>
                </tr>
            </thead>
            <tbody>
                @foreach($days as $i => $day)
                    @php $dayTimetables = $slots[$i+1] ?? collect(); @endphp
                    @if($dayTimetables->isEmpty())
                        <tr><td>{{ $day }}</td><td colspan="4"><em>No Classes</em></td></tr>
                    @else
                        @foreach($dayTimetables as $slot)
                        <tr>
                            <td>{{ $day }}</td>
                            <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</td>
                            <td>{{ $slot->teacher->user->name ?? 'N/A' }}</td>
                            <td>{{ $slot->room->name ?? $slot->room->number ?? 'N/A' }}</td>
                            <td>Period {{ $slot->period_number }}</td>
                        </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
