@extends('layouts.app')
@section('title', 'Timetable Calendar')

@section('content')
<div class="container">
    <h4 class="mb-3">Class Sessions Calendar</h4>
  <div id="calendar" style="min-height:600px;"></div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'timeGridWeek',
        height: 650,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'timeGridWeek,dayGridMonth,listWeek'
        },
        events: "{{ route('timetables.events', request()->only('academic_year_id', 'class_id')) }}",
    });
    calendar.render();
});
</script>
@endpush
