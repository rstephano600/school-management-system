@extends('layouts.app')

@section('title', 'School Timetable')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-primary mb-1">School Timetable</h2>
                    <p class="text-muted mb-0">
                        Academic Year: {{ $currentAcademicYear->name ?? 'Not Set' }} 
                        <span class="badge bg-primary ms-2">{{ $currentAcademicYear->status ?? 'Inactive' }}</span>
                    </p>
                </div>
                <div>
                    <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-filter text-primary"></i> Filters & Search
                </h5>
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filtersCollapse">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>
        <div class="collapse show" id="filtersCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('timetable.index') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Subject</label>
                            <select name="subject_id" class="form-select">
                                <option value="">All Subjects</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->code }} - {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Grade</label>
                            <select name="grade_id" class="form-select">
                                <option value="">All Grades</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                                        {{ $grade->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Section</label>
                            <select name="section_id" class="form-select">
                                <option value="">All Sections</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                        {{ $section->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Teacher</label>
                            <select name="teacher_id" class="form-select">
                                <option value="">All Teachers</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Room</label>
                            <select name="room_id" class="form-select">
                                <option value="">All Rooms</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->name ?? $room->number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search timetable..." 
                                   onkeyup="searchTimetable()">
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('timetable.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Clear Filters
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Timetable Section -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0" id="timetableTable">
                    <thead class="table-dark sticky-top">
                        <tr>
                            <th class="text-center" style="width: 100px;">Time</th>
                            @foreach($days as $day)
                                <th class="text-center">{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timeSlots as $time)
                            <tr>
                                <td class="text-center fw-bold bg-light align-middle time-slot">
                                    {{ \Carbon\Carbon::parse($time)->format('H:i') }}
                                </td>
                                @foreach($days as $day)
                                    <td class="p-1 day-cell" data-day="{{ $day }}" data-time="{{ $time }}">
                                        @if(isset($timetableData[$time][$day]) && count($timetableData[$time][$day]) > 0)
                                            @foreach($timetableData[$time][$day] as $item)
                                                @if($item['type'] == 'class')
                                                    <div class="timetable-item class-item mb-1 p-2 rounded border-start border-4 border-primary bg-light position-relative"
                                                         data-bs-toggle="tooltip" 
                                                         title="Duration: {{ $item['duration'] }}, Capacity: {{ $item['capacity'] }}, Enrolled: {{ $item['enrollment'] }}">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <strong class="text-primary small">{{ $item['code'] }}</strong>
                                                            <span class="badge bg-primary rounded-pill small">{{ $item['duration'] }}</span>
                                                        </div>
                                                        <div class="text-dark fw-semibold small">{{ $item['title'] }}</div>
                                                        <div class="text-muted small">
                                                            <i class="fas fa-user"></i> {{ $item['teacher'] }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            <i class="fas fa-door-open"></i> {{ $item['room'] }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            <i class="fas fa-users"></i> {{ $item['grade'] }} - {{ $item['section'] }}
                                                        </div>
                                                        @if($item['status'] == 'cancelled')
                                                            <div class="position-absolute top-0 end-0 me-1 mt-1">
                                                                <i class="fas fa-times-circle text-danger" title="Cancelled"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="timetable-item general-item mb-1 p-2 rounded border-start border-4 border-success bg-light-success"
                                                         data-bs-toggle="tooltip" 
                                                         title="General Activity - Duration: {{ $item['duration'] }}">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <strong class="text-success small">General</strong>
                                                            <span class="badge bg-success rounded-pill small">{{ $item['duration'] }}</span>
                                                        </div>
                                                        <div class="text-dark fw-semibold small">{{ $item['title'] }}</div>
                                                        @if($item['description'])
                                                            <div class="text-muted small">{{ $item['description'] }}</div>
                                                        @endif
                                                        @if($item['status'] == 'cancelled')
                                                            <div class="position-absolute top-0 end-0 me-1 mt-1">
                                                                <i class="fas fa-times-circle text-danger" title="Cancelled"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Legend -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Legend:</h6>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="d-flex align-items-center">
                                    <div class="border-start border-4 border-primary bg-light p-1 me-2" style="width: 20px; height: 20px;"></div>
                                    <small>Class Sessions</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="border-start border-4 border-success bg-light-success p-1 me-2" style="width: 20px; height: 20px;"></div>
                                    <small>General Activities</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-times-circle text-danger me-1"></i>
                                    <small>Cancelled</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                Last updated: {{ now()->format('d M Y, H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Timetable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('timetable.export') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Export Format</label>
                        <select name="format" class="form-select" required>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Include</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_classes" value="1" checked>
                            <label class="form-check-label">Class Sessions</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_general" value="1" checked>
                            <label class="form-check-label">General Activities</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Export</button>
            </div>
        </div>
    </div>
</div>

<style>
.bg-light-success {
    background-color: #d1e7dd !important;
}

.timetable-item {
    min-height: 80px;
    transition: all 0.2s ease;
}

.timetable-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.day-cell {
    min-width: 200px;
    vertical-align: top;
}

.time-slot {
    font-size: 0.9rem;
    writing-mode: horizontal-tb;
}

@media (max-width: 768px) {
    .day-cell {
        min-width: 150px;
    }
    
    .timetable-item {
        min-height: 60px;
    }
}

@media print {
    .card-header, .btn, .modal, .filters-section {
        display: none !important;
    }
    
    .table {
        font-size: 10px;
    }
    
    .timetable-item {
        border: 1px solid #000 !important;
        background-color: white !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-submit form on filter change
    document.querySelectorAll('select[name]').forEach(function(select) {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
});

function searchTimetable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('timetableTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let found = false;

        for (let j = 1; j < cells.length; j++) {
            const cell = cells[j];
            const items = cell.getElementsByClassName('timetable-item');
            
            for (let k = 0; k < items.length; k++) {
                const item = items[k];
                const text = item.textContent || item.innerText;
                
                if (text.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    item.style.display = '';
                } else {
                    item.style.display = filter === '' ? '' : 'none';
                }
            }
        }

        // Show/hide entire row based on whether any items are visible
        if (filter === '') {
            row.style.display = '';
        } else {
            const visibleItems = row.querySelectorAll('.timetable-item:not([style*="display: none"])');
            row.style.display = visibleItems.length > 0 ? '' : 'none';
        }
    }
}

// Real-time search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(searchTimetable, 300);
    });
});
</script>
@endsection