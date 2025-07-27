@extends('layouts.app')

@section('title', 'Exam Result Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Exam Result Details
                    </h2>
                    <p class="text-muted mb-0">Detailed view of examination result</p>
                </div>
                <div>
                    <a href="{{ route('exam-results.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i>Back to Results
                    </a>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print me-1"></i>Print Result
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Information Card -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Student Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center mb-3">
                            <div class="avatar-lg bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                                <span class="text-white fs-3">
                                    {{ strtoupper(substr($result->student->fname, 0, 1) . substr($result->student->lname, 0, 1)) }}
                                </span>
                            </div>
                            <h4 class="mb-1">
                                {{ $result->student->fname }} 
                                {{ $result->student->mname ? $result->student->mname . ' ' : '' }}
                                {{ $result->student->lname }}
                            </h4>
                            <p class="text-muted">{{ $result->student->user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label text-muted small">Admission Number</label>
                            <div class="fw-semibold">{{ $result->student->admission_number }}</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Roll Number</label>
                            <div class="fw-semibold">{{ $result->student->roll_number ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Grade/Class</label>
                            <div class="fw-semibold">{{ $result->student->grade->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Section</label>
                            <div class="fw-semibold">{{ $result->student->section->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Date of Birth</label>
                            <div class="fw-semibold">
                                {{ $result->student->date_of_birth ? $result->student->date_of_birth->format('M d, Y') : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Gender</label>
                            <div class="fw-semibold">{{ ucfirst($result->student->gender ?? 'N/A') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exam Information Card -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Exam Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-muted small">Exam Title</label>
                            <div class="fw-semibold">{{ $result->exam->title }}</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Academic Year</label>
                            <div class="fw-semibold">{{ $result->exam->academicYear->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Semester</label>
                            <div class="fw-semibold">{{ $result->exam->semester->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Exam Type</label>
                            <div>
                                <span class="badge bg-info fs-6">{{ $result->exam->examType->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Subject</label>
                            <div class="fw-semibold">{{ $result->exam->subject->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Start Date</label>
                            <div class="fw-semibold">
                                {{ $result->exam->start_date ? \Carbon\Carbon::parse($result->exam->start_date)->format('M d, Y') : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">End Date</label>
                            <div class="fw-semibold">
                                {{ $result->exam->end_date ? \Carbon\Carbon::parse($result->exam->end_date)->format('M d, Y') : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Total Marks</label>
                            <div class="fw-semibold">{{ $result->exam->total_marks }}</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Passing Marks</label>
                            <div class="fw-semibold">{{ $result->exam->passing_marks }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Result Details Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Result Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Marks Obtained -->
                        <div class="col-md-3 text-center">
                            <div class="p-4 bg-light rounded">
                                <h2 class="display-4 mb-0 text-primary">{{ $result->marks_obtained }}</h2>
                                <p class="text-muted mb-0">Marks Obtained</p>
                                <small class="text-muted">out of {{ $result->exam->total_marks }}</small>
                            </div>
                        </div>

                        <!-- Percentage -->
                        <div class="col-md-3 text-center">
                            <div class="p-4 bg-light rounded">
                                @php
                                    $percentage = $result->exam->total_marks > 0 ? 
                                        round(($result->marks_obtained / $result->exam->total_marks) * 100, 2) : 0;
                                @endphp
                                <h2 class="display-4 mb-0 text-info">{{ $percentage }}%</h2>
                                <p class="text-muted mb-0">Percentage</p>
                            </div>
                        </div>

                        <!-- Grade -->
                        <div class="col-md-3 text-center">
                            <div class="p-4 bg-light rounded">
                                @php
                                    $gradeClass = match($result->grade) {
                                        'A+', 'A' => 'success',
                                        'B+', 'B' => 'primary',
                                        'C+', 'C' => 'warning',
                                        'D+', 'D' => 'info',
                                        'F' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <h2 class="display-4 mb-0 text-{{ $gradeClass }}">{{ $result->grade }}</h2>
                                <p class="text-muted mb-0">Grade</p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-3 text-center">
                            <div class="p-4 bg-light rounded">
                                @php
                                    $isPassed = $result->marks_obtained >= $result->exam->passing_marks;
                                    $statusClass = $isPassed ? 'success' : 'danger';
                                    $statusText = $isPassed ? 'PASSED' : 'FAILED';
                                    $statusIcon = $isPassed ? 'check-circle' : 'times-circle';
                                @endphp
                                <h3 class="mb-0 text-{{ $statusClass }}">
                                    <i class="fas fa-{{ $statusIcon }} me-2"></i>{{ $statusText }}
                                </h3>
                                <p class="text-muted mb-0">Result Status</p>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-4">
                        <label class="form-label">Performance Progress</label>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-{{ $gradeClass }}" 
                                 role="progressbar" 
                                 style="width: {{ $percentage }}%"
                                 aria-valuenow="{{ $percentage }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                {{ $percentage }}%
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">0</small>
                            <small class="text-muted">Passing: {{ $result->exam->passing_marks }}</small>
                            <small class="text-muted">{{ $result->exam->total_marks }}</small>
                        </div>
                    </div>

                    <!-- Remarks -->
                    @if($result->remarks)
                        <div class="mt-4">
                            <label class="form-label fw-semibold">Remarks</label>
                            <div class="alert alert-info">
                                <i class="fas fa-comment me-2"></i>
                                {{ $result->remarks }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Publication Information -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Publication Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Published By</label>
                            <div class="fw-semibold">
                                <i class="fas fa-user me-2"></i>
                                {{ $result->publisher->user->name ?? 'System' }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Published Date</label>
                            <div class="fw-semibold">
                                <i class="fas fa-calendar me-2"></i>
                                {{ $result->published_at->format('M d, Y H:i:s') }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Status</label>
                            <div>
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Published
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .avatar-lg {
        width: 80px;
        height: 80px;
        font-size: 24px;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .progress {
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    .display-4 {
        font-weight: 700;
    }
    
    @media print {
        .btn, .card-header {
            display: none !important;
        }
        
        .card {
            border: 1px solid #000 !important;
            box-shadow: none !important;
        }
        
        .container-fluid {
            max-width: 100% !important;
        }
        
        body {
            font-size: 12px !important;
        }
        
        .display-4 {
            font-size: 2rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush