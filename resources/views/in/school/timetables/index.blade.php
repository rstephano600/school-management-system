@extends('layouts.app')
@section('title', 'Timetable Slots')

@section('content')
<div class="container">
    <h3 class="mb-4">Timetable Slots</h3>

    <a href="{{ route('timetables.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Add Slot
    </a>
    <div class="mb-3">
    <a href="{{ route('timetables.calendar', request()->all()) }}" class="btn btn-outline-info">🗓 View Calendar</a>
    <a href="{{ route('timetables.export.excel', request()->all()) }}" class="btn btn-outline-success">📥 Export Excel</a>
    <a href="{{ route('timetables.export.pdf', request()->all()) }}" class="btn btn-outline-danger" target="_blank">📄 Export PDF</a>
</div>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="row mb-3">
    <div class="col-md-3">
        <select name="academic_year_id" class="form-select" onchange="this.form.submit()">
            <option value="">-- Academic Year --</option>
            @foreach($academicYears as $year)
                <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                    {{ $year->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="class_id" class="form-select" onchange="this.form.submit()">
            <option value="">-- Class --</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->class_name ?? 'Class '.$class->id }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search by teacher or subject"
            value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
    </div>
</form>


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

<div class="mt-3">
    {{ $timetables->withQueryString()->links() }}
</div>

</div>
@endsection
