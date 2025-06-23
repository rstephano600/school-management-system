@extends('layouts.app')
@section('title', 'Timetable Slots')

@section('content')
<div class="container">
    <h3 class="mb-4">Timetable Slots</h3>

    <a href="{{ route('timetables.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add Slot
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Day</th>
                <th>Time</th>
                <th>Period</th>
                <th>Class</th>
                <th>Teacher</th>
                <th>Room</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timetables as $slot)
                <tr>
                    <td>{{ [1=>'Mon',2=>'Tue',3=>'Wed',4=>'Thu',5=>'Fri',6=>'Sat',7=>'Sun'][$slot->day_of_week] }}</td>
                    <td>{{ $slot->start_time }} - {{ $slot->end_time }}</td>
                    <td>{{ $slot->period_number }}</td>
                    <td>{{ $slot->class->subject->name ?? '-' }} ({{ $slot->class->section->name ?? '' }})</td>
                    <td>{{ $slot->teacher->user->name ?? '-' }}</td>
                    <td>{{ $slot->room->name ?? $slot->room->number ?? 'N/A' }}</td>
                    <td><span class="badge bg-{{ $slot->status ? 'success' : 'secondary' }}">{{ $slot->status ? 'Active' : 'Inactive' }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('timetables.edit', $slot->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('timetables.destroy', $slot->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this slot?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>{{ $timetables->links() }}</div>
</div>
@endsection
