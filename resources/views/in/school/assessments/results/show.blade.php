@extends('layouts.app')

@section('title', 'Assessment Result Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item">
                        <a href="{{ route('assessment-results.index') }}" class="text-decoration-none">Assessment Results</a>
                    </li>
                    <li class="breadcrumb-item active">Result Details</li>
                </ol>
            </nav>
            <h2 class="mb-0">Assessment Result Details</h2>
        </div>
        <div>
            <button class="btn btn-outline-primary me-2" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Print
            </button>
            <a href="{{ route('assessment-results.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Results
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Student Information -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Student Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-lg bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="fas fa-user text-primary fs-2"></i>
                        </div>
                        <h4 class="mb-1">{{ $result->student->fname }} {{ $result->student->mname }} {{ $result->student->lname }}</h4>
                        <p class="text-muted mb-0">{{ $result->student->admission_number }}</p>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">Grade Level:</span>
                                <span class="fw-semibold">{{ $result->student->grade->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">Section:</span>
                                <span class="fw-semibold">{{ $result->student->section->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">Roll Number:</span>
                                <span class="fw-semibold">{{ $result->student->roll_number ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">Gender:</span>
                                <span class="fw-semibold">{{ ucfirst($result->student->gender ?? 'N/A') }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted">Date of Birth:</span>
                                <span class="fw-semibold">{{ $result->student->date_of_birth ? $result->student->date_of_birth->format('M d, Y') : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assessment Information -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Assessment Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Assessment Title</h6>
                            <h4 class="mb-0">{{ $result->assessment->title }}</h4>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Assessment Type</h6>
                            <span class="badge bg-primary fs-6 px-3 py-2">{{ ucfirst($result->assessment->type) }}</span>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Subject</h6>
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 rounded-3 p-2 me-3">
                                    <i class="fas fa-book text-info"></i>
                                </div>
                                <span class="fw-semibold">{{ $result->assessment->subject->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Grade Level</h6>
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary bg-opacity-10 rounded-3 p-2 me-3">
                                    <i class="fas fa-graduation-cap text-secondary"></i>
                                </div>
                                <span class="fw-semibold">{{ $result->assessment->gradeLevel->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Academic Year</h6>
                            <span class="fw-semibold">{{ $result->assessment->academicYear->name }}</span>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Semester</h6>
                            <span class="fw-semibold">{{ $result->assessment->semester->name }}</span>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Due Date</h6>
                            <span class="fw-semibold">{{ $result->assessment->due_date ? $result->assessment->due_date->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Created By</h6>
                            <span class="fw-semibold">{{ $result->assessment->creator->name ?? 'N/A' }}</span>
                        </div>
                    </div>

                    @if($result->assessment->description)
                        <div class="mt-4">
                            <h6 class="text-muted mb-2">Description</h6>
                            <div class="bg-light rounded-3 p-3">
                                <p class="mb-0">{{ $result->assessment->description }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Score Details -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Score Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-4 text-center mb-4 mb-lg-0">
                            <div class="position-relative d-inline-block">
                                <svg width="120" height="120" class="progress-circle">
                                    <circle cx="60" cy="60" r="50" fill="none" stroke="#e9ecef" stroke-width="8"/>
                                    <circle cx="60" cy="60" r="50" fill="none" 
                                            stroke="{{ $result->score >= 70 ? '#198754' : ($result->score >= 50 ? '#ffc107' : '#dc3545') }}" 
                                            stroke-width="8"
                                            stroke-dasharray="{{ 2 * 3.14159 * 50 }}"
                                            stroke-dashoffset="{{ 2 * 3.14159 * 50 * (1 - $result->score / 100) }}"
                                            transform="rotate(-90 60 60)"/>
                                </svg>
                                <div class="position-absolute top-50 start-50 translate-middle text-center">
                                    <h2 class="mb-0 fw-bold">{{ $result->score }}%</h2>
                                    <small class="text-muted">Score</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="text-center p-3 border rounded-3">
                                        <div class="mb-2">
                                            @if($result->score >= 90)
                                                <i class="fas fa-star text-warning fs-2"></i>
                                                <h6 class="mb-0 mt-2">Excellent</h6>
                                            @elseif($result->score >= 80)
                                                <i class="fas fa-thumbs-up text-success fs-2"></i>
                                                <h6 class="mb-0 mt-2">Very Good</h6>
                                            @elseif($result->score >= 70)
                                                <i class="fas fa-check-circle text-info fs-2"></i>
                                                <h6 class="mb-0 mt-2">Good</h6>
                                            @elseif($result->score >= 50)
                                                <i class="fas fa-exclamation-triangle text-warning fs-2"></i>
                                                <h6 class="mb-0 mt-2">Needs Improvement</h6>
                                            @else
                                                <i class="fas fa-times-circle text-danger fs-2"></i>
                                                <h6 class="mb-0 mt-2">Poor</h6>
                                            @endif
                                        </div>
                                        <small class="text-muted">Performance Level</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 border rounded-3">
                                        <div class="mb-2">
                                            @if($result->score >= 70)
                                                <i class="fas fa-check text-success fs-2"></i>
                                                <h6 class="mb-0 mt-2 text-success">Passed</h6>
                                            @else
                                                <i class="fas fa-times text-danger fs-2"></i>
                                                <h6 class="mb-0 mt-2 text-danger">Failed</h6>
                                            @endif
                                        </div>
                                        <small class="text-muted">Result Status</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 border rounded-3">
                                        <div class="mb-2">
                                            @if($result->score >= 90)
                                                <h3 class="mb-0 text-success">A+</h3>
                                            @elseif($result->score >= 80)
                                                <h3 class="mb-0 text-success">A</h3>
                                            @elseif($result->score >= 70)
                                                <h3 class="mb-0 text-info">B</h3>
                                            @elseif($result->score >= 60)
                                                <h3 class="mb-0 text-warning">C</h3>
                                            @elseif($result->score >= 50)
                                                <h3 class="mb-0 text-warning">D</h3>
                                            @else
                                                <h3 class="mb-0 text-danger">F</h3>
                                            @endif
                                        </div>
                                        <small class="text-muted">Grade</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Record Information -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Record Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <h6 class="text-muted mb-2">Recorded By</h6>
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-user text-secondary"></i>
                                </div>
                                <span class="fw-semibold">{{ $result->recordedBy->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted mb-2">Record Date</h6>
                            <span class="fw-semibold">{{ $result->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted mb-2">Record Time</h6>
                            <span class="fw-semibold">{{ $result->created_at->format('h:i A') }}</span>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted mb-2">Last Updated</h6>
                            <span class="fw-semibold">{{ $result->updated_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-lg {
    width: 80px;
    height: 80px;
}

.progress-circle {
    transition: all 0.3s ease-in-out;
}

.card {
    transition: all 0.2s ease-in-out;
}

@media print {
    .btn, .breadcrumb {
        display: none !important;
    }
    
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
    
    .card-header {
        background-color: #f8f9fa !important;
        color: #000 !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress circle on load
    const circle = document.querySelector('.progress-circle circle:last-child');
    if (circle) {
        circle.style.strokeDashoffset = circle.getAttribute('stroke-dasharray');
        setTimeout(() => {
            circle.style.strokeDashoffset = circle.getAttribute('stroke-dashoffset');
        }, 500);
    }
});
</script>
@endsection