@extends('layouts.app')

@section('title', 'Examination Results')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Examination Results
                    </h2>
                    <p class="text-muted mb-0">View and manage student examination results</p>
                </div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-download me-2"></i>Export Results
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="exportResults('excel')">
                            <i class="fas fa-file-excel me-2"></i>Excel (.xlsx)
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="exportResults('csv')">
                            <i class="fas fa-file-csv me-2"></i>CSV (.csv)
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="exportResults('pdf')">
                            <i class="fas fa-file-pdf me-2"></i>PDF (.pdf)
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $statistics['total_students'] }}</h4>
                    <small>Total Students</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $statistics['total_exams'] }}</h4>
                    <small>Total Exams</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ number_format($statistics['average_marks'], 1) }}</h4>
                    <small>Average Marks</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-trophy fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $statistics['highest_marks'] }}</h4>
                    <small>Highest Score</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $statistics['lowest_marks'] }}</h4>
                    <small>Lowest Score</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-percentage fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ number_format($statistics['pass_rate'], 1) }}%</h4>
                    <small>Pass Rate</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>Filters & Search
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('exam-results.index') }}" id="filterForm">
                <div class="row g-3">
                    <!-- Academic Year Filter -->
                    <div class="col-md-2">
                        <label for="academic_year_id" class="form-label">Academic Year</label>
                        <select name="academic_year_id" id="academic_year_id" class="form-select">
                            <option value="">All Years</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" 
                                    {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                                    {{ $year->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Semester Filter -->
                    <div class="col-md-2">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select name="semester_id" id="semester_id" class="form-select">
                            <option value="">All Semesters</option>
                            @foreach($semesters as $semester)
                                <option value="{{ $semester->id }}" 
                                    {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Exam Type Filter -->
                    <div class="col-md-2">
                        <label for="exam_type_id" class="form-label">Exam Type</label>
                        <select name="exam_type_id" id="exam_type_id" class="form-select">
                            <option value="">All Types</option>
                            @foreach($examTypes as $type)
                                <option value="{{ $type->id }}" 
                                    {{ request('exam_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Grade Level Filter -->
                    <div class="col-md-2">
                        <label for="grade_id" class="form-label">Grade/Class</label>
                        <select name="grade_id" id="grade_id" class="form-select">
                            <option value="">All Grades</option>
                            @foreach($gradeLevels as $grade)
                                <option value="{{ $grade->id }}" 
                                    {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                                    {{ $grade->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Filter -->
                    <div class="col-md-2">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select name="subject_id" id="subject_id" class="form-select">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" 
                                    {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="col-md-2">
                        <label for="search" class="form-label">Search Student</label>
                        <input type="text" name="search" id="search" class="form-control" 
                               placeholder="Name or Admission No."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>Apply Filters
                        </button>
                        <a href="{{ route('exam-results.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Clear Filters
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-table me-2"></i>Examination Results
            </h5>
            <span class="badge bg-primary">{{ $results->total() }} results found</span>
        </div>
        <div class="card-body p-0">
            @if($results->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Student</th>
                                <th>Admission No.</th>
                                <th>Class/Section</th>
                                <th>Academic Year</th>
                                <th>Semester</th>
                                <th>Exam Type</th>
                                <th>Subject</th>
                                <th>Marks</th>
                                <th>Grade</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-white small">
                                                    {{ strtoupper(substr($result->student->fname, 0, 1) . substr($result->student->lname, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">
                                                    {{ $result->student->fname }} 
                                                    {{ $result->student->mname ? $result->student->mname . ' ' : '' }}
                                                    {{ $result->student->lname }}
                                                </div>
                                                <small class="text-muted">{{ $result->student->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $result->student->admission_number }}</span>
                                    </td>
                                    <td>
                                        {{ $result->student->grade->name ?? 'N/A' }} - 
                                        {{ $result->student->section->name ?? 'N/A' }}
                                    </td>
                                    <td>{{ $result->exam->academicYear->name ?? 'N/A' }}</td>
                                    <td>{{ $result->exam->semester->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $result->exam->examType->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ $result->exam->subject->name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="text-center">
                                            <div class="fw-bold">{{ $result->marks_obtained }}/{{ $result->exam->total_marks }}</div>
                                            <small class="text-muted">
                                                @if($result->exam->total_marks > 0)
                                                    {{ number_format(($result->marks_obtained / $result->exam->total_marks) * 100, 1) }}%
                                                @else
                                                    N/A
                                                @endif
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $gradeClass = match($result->grade) {
                                                'A+', 'A' => 'bg-success',
                                                'B+', 'B' => 'bg-primary',
                                                'C+', 'C' => 'bg-warning',
                                                'D+', 'D' => 'bg-info',
                                                'F' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $gradeClass }}">{{ $result->grade }}</span>
                                    </td>
                                    <td>
                                        <div class="small">
                                            {{ $result->published_at->format('M d, Y') }}<br>
                                            <span class="text-muted">by {{ $result->publisher->user->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('exam-results.show', $result->id) }}" 
                                               class="btn btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('exam-results.student-history', $result->student->user_id) }}" 
                                               class="btn btn-outline-info" title="Student History">
                                                <i class="fas fa-history"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $results->firstItem() }} to {{ $results->lastItem() }} of {{ $results->total() }} results
                        </div>
                        {{ $results->withQueryString()->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No examination results found</h5>
                    <p class="text-muted">Try adjusting your filters or search criteria.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Export Form (Hidden) -->
<form id="exportForm" method="POST" action="{{ route('exam-results.export') }}" style="display: none;">
    @csrf
    <input type="hidden" name="format" id="exportFormat">
    <input type="hidden" name="academic_year_id" value="{{ request('academic_year_id') }}">
    <input type="hidden" name="semester_id" value="{{ request('semester_id') }}">
    <input type="hidden" name="exam_type_id" value="{{ request('exam_type_id') }}">
    <input type="hidden" name="grade_id" value="{{ request('grade_id') }}">
    <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
    <input type="hidden" name="search" value="{{ request('search') }}">
</form>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .avatar-sm {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        white-space: nowrap;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .table-responsive {
        border-radius: 0.375rem;
    }
    
    .badge {
        font-size: 0.75em;
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Academic Year change handler to load semesters
    const academicYearSelect = document.getElementById('academic_year_id');
    const semesterSelect = document.getElementById('semester_id');
    
    academicYearSelect.addEventListener('change', function() {
        const academicYearId = this.value;
        
        // Clear semester options
        semesterSelect.innerHTML = '<option value="">All Semesters</option>';
        
        if (academicYearId) {
            // Add loading state
            semesterSelect.classList.add('loading');
            
            // Fetch semesters for selected academic year
            fetch(`{{ route('exam-results.get-semesters') }}?academic_year_id=${academicYearId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(semester => {
                        const option = document.createElement('option');
                        option.value = semester.id;
                        option.textContent = semester.name;
                        
                        // Maintain selected semester if it exists
                        if ('{{ request("semester_id") }}' == semester.id) {
                            option.selected = true;
                        }
                        
                        semesterSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching semesters:', error);
                    showToast('Error loading semesters', 'error');
                })
                .finally(() => {
                    semesterSelect.classList.remove('loading');
                });
        }
    });
    
    // Auto-submit form on filter change
    const filterElements = document.querySelectorAll('#filterForm select');
    filterElements.forEach(element => {
        element.addEventListener('change', function() {
            // Small delay to allow for visual feedback
            setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 100);
        });
    });
    
    // Search input handler with debounce
    const searchInput = document.getElementById('search');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500); // 500ms debounce
    });
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Export functionality
function exportResults(format) {
    document.getElementById('exportFormat').value = format;
    document.getElementById('exportForm').submit();
    
    // Show loading toast
    showToast(`Preparing ${format.toUpperCase()} export...`, 'info');
}

// Toast notification function
function showToast(message, type = 'info') {
    // Create toast container if it doesn't exist
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '1055';
        document.body.appendChild(toastContainer);
    }
    
    // Create toast element
    const toastId = 'toast-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fas fa-${getToastIcon(type)} me-2 text-${getToastColor(type)}"></i>
                <strong class="me-auto">Exam Results</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    
    // Initialize and show toast
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 3000
    });
    
    toast.show();
    
    // Remove toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', function() {
        toastElement.remove();
    });
}

function getToastIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-triangle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

function getToastColor(type) {
    const colors = {
        'success': 'success',
        'error': 'danger',
        'warning': 'warning',
        'info': 'info'
    };
    return colors[type] || 'info';
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + F to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        document.getElementById('search').focus();
    }
    
    // Escape to clear search
    if (e.key === 'Escape' && document.activeElement === document.getElementById('search')) {
        document.getElementById('search').value = '';
        document.getElementById('filterForm').submit();
    }
});
</script>
@endpush