@extends('layouts.app')

@section('title', 'Assessment Results')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Assessment Results</h2>
            <p class="text-muted">View and manage student assessment results</p>
        </div>
        <div>
            <button class="btn btn-outline-primary" onclick="exportResults()">
                <i class="fas fa-download me-2"></i>Export Results
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-clipboard-list text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Total Results</h6>
                            <h4 class="mb-0">{{ number_format($totalResults) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-chart-line text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Average Score</h6>
                            <h4 class="mb-0">{{ $averageScore ? number_format($averageScore, 1) : 'N/A' }}%</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-arrow-up text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Highest Score</h6>
                            <h4 class="mb-0">{{ $highestScore ? $highestScore : 'N/A' }}%</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-arrow-down text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Lowest Score</h6>
                            <h4 class="mb-0">{{ $lowestScore ? $lowestScore : 'N/A' }}%</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>Filters
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('assessment-results.index') }}" id="filterForm">
                <div class="row g-3">
                    <!-- Search Input -->
                    <div class="col-lg-3 col-md-6">
                        <label for="search" class="form-label">Search Student</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="search" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Name or Admission No."
                            >
                        </div>
                    </div>

                    <!-- Academic Year Filter -->
                    <div class="col-lg-2 col-md-6">
                        <label for="academic_year_id" class="form-label">Academic Year</label>
                        <select class="form-select" id="academic_year_id" name="academic_year_id">
                            <option value="">All Years</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                                    {{ $year->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Semester Filter -->
                    <div class="col-lg-2 col-md-6">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select class="form-select" id="semester_id" name="semester_id">
                            <option value="">All Semesters</option>
                            @foreach($semesters as $semester)
                                <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Grade Level Filter -->
                    <div class="col-lg-2 col-md-6">
                        <label for="grade_level_id" class="form-label">Grade Level</label>
                        <select class="form-select" id="grade_level_id" name="grade_level_id">
                            <option value="">All Grades</option>
                            @foreach($gradeLevels as $grade)
                                <option value="{{ $grade->id }}" {{ request('grade_level_id') == $grade->id ? 'selected' : '' }}>
                                    {{ $grade->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Filter -->
                    <div class="col-lg-2 col-md-6">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select class="form-select" id="subject_id" name="subject_id">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Actions -->
                    <div class="col-lg-1 col-md-12">
                        <label class="form-label d-block">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('assessment-results.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Assessment Results</h5>
                <small class="text-muted">{{ $results->total() }} result(s) found</small>
            </div>
        </div>
        <div class="card-body p-0">
            @if($results->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 fw-semibold">Student</th>
                                <th class="border-0 fw-semibold">Assessment</th>
                                <th class="border-0 fw-semibold">Subject</th>
                                <th class="border-0 fw-semibold">Grade</th>
                                <th class="border-0 fw-semibold">Score</th>
                                <th class="border-0 fw-semibold">Academic Year</th>
                                <th class="border-0 fw-semibold">Semester</th>
                                <th class="border-0 fw-semibold">Recorded By</th>
                                <th class="border-0 fw-semibold">Date</th>
                                <th class="border-0 fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                                <tr>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $result->student->fname }} {{ $result->student->mname }} {{ $result->student->lname }}</h6>
                                                <small class="text-muted">{{ $result->student->admission_number }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div>
                                            <h6 class="mb-0">{{ $result->assessment->title }}</h6>
                                            <small class="text-muted">{{ ucfirst($result->assessment->type) }}</small>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            {{ $result->assessment->subject->name }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            {{ $result->assessment->gradeLevel->name }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <span class="badge {{ $result->score >= 70 ? 'bg-success' : ($result->score >= 50 ? 'bg-warning' : 'bg-danger') }} me-2">
                                                {{ $result->score }}%
                                            </span>
                                            @if($result->score >= 70)
                                                <i class="fas fa-check-circle text-success"></i>
                                            @elseif($result->score >= 50)
                                                <i class="fas fa-exclamation-circle text-warning"></i>
                                            @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3">{{ $result->assessment->academicYear->name }}</td>
                                    <td class="py-3">{{ $result->assessment->semester->name }}</td>
                                    <td class="py-3">
                                        <small class="text-muted">{{ $result->recordedBy->name }}</small>
                                    </td>
                                    <td class="py-3">
                                        <small class="text-muted">{{ $result->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td class="py-3">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('assessment-results.show', $result->id) }}">
                                                        <i class="fas fa-eye me-2"></i>View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="printResult({{ $result->id }})">
                                                        <i class="fas fa-print me-2"></i>Print
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-search fs-1 text-muted"></i>
                    </div>
                    <h5 class="text-muted">No results found</h5>
                    <p class="text-muted">Try adjusting your filters or search criteria</p>
                </div>
            @endif
        </div>
        
        @if($results->hasPages())
            <div class="card-footer bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing {{ $results->firstItem() }} to {{ $results->lastItem() }} of {{ $results->total() }} results
                    </div>
                    <div>
                        {{ $results->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="mb-0">Processing...</p>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}

.table td {
    vertical-align: middle;
}

.form-label {
    font-weight: 600;
    color: #495057;
    font-size: 0.875rem;
}

.card {
    transition: all 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.dropdown-toggle::after {
    display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter changes
    const filterSelects = document.querySelectorAll('#academic_year_id, #semester_id, #grade_level_id, #subject_id');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Search input with debounce
    let searchTimeout;
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });
});

function exportResults() {
    const modal = new bootstrap.Modal(document.getElementById('loadingModal'));
    modal.show();
    
    // Add current filters to export request
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);
    
    // Simulate export process
    setTimeout(() => {
        modal.hide();
        // Here you would typically trigger the actual export
        alert('Export feature will be implemented based on your requirements');
    }, 2000);
}

function printResult(resultId) {
    window.open(`/assessment-results/${resultId}/print`, '_blank');
}
</script>
@endsection