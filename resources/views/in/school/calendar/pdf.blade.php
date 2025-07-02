<!DOCTYPE html>
<html>
<head>
    <title>Weekly Timetable</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 4px; text-align: center; }
        th { background-color: #eee; }
        .badge { display: inline-block; padding: 2px 5px; font-size: 10px; border-radius: 4px; }
        .bg-primary { background-color: #007bff; color: white; }
        .bg-success { background-color: #28a745; color: white; }
        .bg-warning { background-color: #ffc107; }
        .bg-danger { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <h3>Weekly School Timetable</h3>
    <table>
        <thead>
            <tr>
                <th>Time</th>
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <th>{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $dayMap = ['Monday'=>1,'Tuesday'=>2,'Wednesday'=>3,'Thursday'=>4,'Friday'=>5,'Saturday'=>6,'Sunday'=>7];
            @endphp
            @for($h = 7; $h < 22; $h++)
                @php
                    $from = sprintf('%02d:00:00', $h);
                    $to = sprintf('%02d:00:00', $h+1);
                @endphp
                <tr>
                    <td><strong>{{ substr($from,0,5) }} - {{ substr($to,0,5) }}</strong></td>
                    @foreach($dayMap as $dayName => $dayNum)
                        <td>
                            @foreach($general->where('day_of_week', $dayName) as $item)
                                @if($item->start_time <= $from && $item->end_time > $from)
                                    <div class="badge bg-primary">{{ $item->activity }}</div><br>
                                @endif
                            @endforeach
                            @foreach($sessions->where('day_of_week', $dayNum) as $slot)
                                @if($slot->start_time <= $from && $slot->end_time > $from)
                                    <div class="badge bg-success">{{ $slot->class->subject->name ?? 'Class' }}</div><br>
                                @endif
                            @endforeach
                            @foreach($tests as $test)
                                @if(\Carbon\Carbon::parse($test->test_date)->englishDayOfWeek === $dayName && $test->start_time <= $from && $test->end_time > $from)
                                    <div class="badge bg-warning">Test: {{ $test->title }}</div><br>
                                @endif
                            @endforeach
                            @foreach($exams as $exam)
                                @if(\Carbon\Carbon::parse($exam->test_date)->englishDayOfWeek === $dayName && $exam->start_time <= $from && $exam->end_time > $from)
                                    <div class="badge bg-danger">Exam: {{ $exam->title }}</div><br>
                                @endif
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>
