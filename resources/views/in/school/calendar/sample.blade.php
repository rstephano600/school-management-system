@extends('layouts.app')
@section('title', 'Weekly Timetable View')

@section('content')
@php
    $dayMap = [
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
        'Saturday' => 6,
        'Sunday' => 7,
    ];
@endphp

<div class="container">
    <h4 class="mb-3">Simplified Weekly School Calendar</h4>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-info">
                <tr>
                    <th>Time</th>
                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                        <th>{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @for($hour = 7; $hour <= 22; $hour++)
                    @php
                        $from = sprintf('%02d:00', $hour);
                        $to = sprintf('%02d:00', $hour + 1);
                    @endphp
                    <tr>
                        <td><strong>{{ $from }} - {{ $to }}</strong></td>
                        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                            <td>
                                {{-- General activities --}}
                                @foreach($general->where('day_of_week', $day) as $item)
                                    @if($item->start_time <= $from && $item->end_time > $from)
                                        <span class="badge bg-primary">{{ $item->activity }}</span><br>
                                    @endif
                                @endforeach

                                {{-- Class sessions --}}
@foreach($sessions as $slot)
    @if($slot->day_of_week == $dayMap[$day] && $slot->start_time <= $from && $slot->end_time > $from)
        <span class="badge bg-success">
            {{ $slot->class->subject->name ?? 'Subject' }}<br>
            ({{ $slot->teacher->user->name ?? '-' }})
        </span><br>
    @endif
@endforeach


                                {{-- Tests --}}
                                @foreach($tests as $test)
                                    @if(\Carbon\Carbon::parse($test->test_date)->format('l') == $day && $test->start_time <= $from && $test->end_time > $from)
                                        <span class="badge bg-warning text-dark">Test: {{ $test->title }}</span><br>
                                    @endif
                                @endforeach

                                {{-- Exams --}}
                                @foreach($exams as $exam)
                                    @if(\Carbon\Carbon::parse($exam->test_date)->format('l') == $day && $exam->start_time <= $from && $exam->end_time > $from)
                                        <span class="badge bg-danger">Exam: {{ $exam->title }}</span><br>
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
@endsection
