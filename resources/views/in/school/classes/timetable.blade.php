@extends('layouts.app')
@section('title', 'Class Timetable')

@section('content')
<div class="container">
    <h3 class="mb-4">Weekly Class Timetable</h3>

    @php
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $timeSlots = [
            '08:00', '09:00', '10:00', '11:00', '12:00',
            '13:00', '14:00', '15:00', '16:00'
        ];
    @endphp

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Time / Day</th>
                    @foreach($days as $day)
                        <th>{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($timeSlots as $time)
                <tr>
                    <th>{{ $time }}</th>
                    @foreach($days as $day)
                        <td>
                            @php
                                $matches = $classes->filter(function ($class) use ($day, $time) {
                                    return in_array($day, $class->class_days ?? []) &&
                                        $time >= substr($class->start_time, 0, 5) &&
                                        $time < substr($class->end_time, 0, 5);
                                });
                            @endphp

                            @foreach($matches as $match)
                                <div class="bg-light p-1 border rounded mb-1 small">
                                    <strong>{{ $match->subject->name ?? '' }}</strong><br>
                                    {{ $match->section->name ?? '' }}<br>
                                    {{ $match->teacher->name ?? '' }}
                                </div>
                            @endforeach
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
