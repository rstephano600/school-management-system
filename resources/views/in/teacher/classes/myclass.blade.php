@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Assigned Classes</h2>

    @if($classes->isEmpty())
        <div class="alert alert-info">You have not been assigned any classes yet.</div>
    @else
    <div class="table-responsive">
<table class="table table-bordered table-striped">
    <thead class="table-light">
                <tr>
                    <th>Subject</th>
                    <th>Grade level</th>
                    <th>Section</th>
                    <th>Room</th>
                    <!-- <th>Academic Year</th> -->
                    <th>Days</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $class)
                <tr>
                    <td>{{ $class->subject->name ?? 'N/A' }}</td>
                    <td>{{ $class->grade->name ?? 'N/A' }}</td>
                    <td>{{ $class->section->name ?? 'N/A' }}</td>
                    <td>{{ $class->room->name ?? 'N/A' }}</td>
                    <!-- <td>{{ $class->academicYear->name ?? 'N/A' }}</td> -->
                    <td>{{ implode(', ', $class->class_days ?? []) }}</td>
                    <td>{{ $class->start_time }} - {{ $class->end_time }}</td>
                    <td>
                        <span class="badge bg-{{ $class->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($class->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
