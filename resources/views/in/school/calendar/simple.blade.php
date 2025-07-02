@extends('layouts.app')
@section('title', 'Weekly Timetable View')

@section('content')

<div class="container">
    <h4 class="mb-4">Weekly Timetable</h4>
<a href="{{ route('calendar.pdf', request()->only('academic_year_id', 'class_id')) }}" class="btn btn-outline-dark mb-3" target="_blank">
    <i class="fas fa-file-pdf"></i> Export PDF
</a>

    {{-- 🔍 Filters --}}
    <form method="GET" class="row mb-3">
        <div class="col-md-4">
            <select name="academic_year_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- All Academic Years --</option>
                @foreach($academicYears as $year)
                    <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                        {{ $year->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="class_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- All Classes --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->class_name ?? 'Class '.$class->id }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    {{-- 🗓 Weekly Grid --}}
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
                @php
                    $dayMap = ['Monday'=>1, 'Tuesday'=>2, 'Wednesday'=>3, 'Thursday'=>4, 'Friday'=>5, 'Saturday'=>6, 'Sunday'=>7];
                @endphp

                @for($h = 7; $h < 22; $h++)
                    @php
                        $from = sprintf('%02d:00:00', $h);
                        $to = sprintf('%02d:00:00', $h+1);
                    @endphp
                    <tr>
                        <td><strong>{{ substr($from,0,5) }} - {{ substr($to,0,5) }}</strong></td>
                        @foreach($dayMap as $dayName => $dayNum)
                            <td style="min-width:160px">
                                {{-- 🔵 General Activities --}}
                                @foreach($general->where('day_of_week', $dayName) as $activity)
                                    @if($activity->start_time <= $from && $activity->end_time > $from)
                                        <div class="badge bg-primary mb-1">{{ $activity->activity }}</div><br>
                                    @endif
                                @endforeach

                                {{-- 🟩 Class Sessions --}}
                                @foreach($sessions->where('day_of_week', $dayNum) as $slot)
                                    @if(
                                        $slot->start_time <= $from && $slot->end_time > $from &&
                                        (request('class_id') == null || $slot->class_id == request('class_id')) &&
                                        (request('academic_year_id') == null || $slot->academic_year_id == request('academic_year_id'))
                                    )
                                        <div class="badge bg-success mb-1">
                                            {{ $slot->class->subject->name ?? '-' }} ({{ $slot->class->section->name ?? '' }})<br>
                                            ({{ $slot->teacher->user->name ?? '' }}) <br>
                                            {{ $slot->room->name ?? $slot->room->number ?? 'N/A' }}
                                        </div><br>
                                    @endif
                                @endforeach

                                {{-- 🟡 Tests --}}
                                @foreach($tests as $test)
                                    @if(
                                        \Carbon\Carbon::parse($test->test_date)->englishDayOfWeek === $dayName &&
                                        $test->start_time <= $from && $test->end_time > $from &&
                                        (request('class_id') == null || $test->class_id == request('class_id')) &&
                                        (request('academic_year_id') == null || $test->academic_year_id == request('academic_year_id'))
                                    )
                                        <div class="badge bg-warning text-dark mb-1">Test: {{ $test->title }}</div><br>
                                    @endif
                                @endforeach

                                {{-- 🔴 Exams --}}
                                @foreach($exams as $exam)
                                    @if(
                                        \Carbon\Carbon::parse($exam->test_date)->englishDayOfWeek === $dayName &&
                                        $exam->start_time <= $from && $exam->end_time > $from &&
                                        (request('class_id') == null || $exam->class_id == request('class_id')) &&
                                        (request('academic_year_id') == null || $exam->academic_year_id == request('academic_year_id'))
                                    )
                                        <div class="badge bg-danger mb-1">Exam: {{ $exam->title }}</div><br>
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
