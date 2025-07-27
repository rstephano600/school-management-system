@extends('layouts.app')

@section('title', 'Examination Result Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-graduation-cap me-2"></i>
                    <h4 class="mb-0">Examination Result Details</h4>
                    <div class="ms-auto">
                        <a href="{{ route('student-examinations.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Results
                        </a>
                    </div>
                </div>
            </div>

            <!-- Student Information -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>Student Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-muted">Full Name</label>
                                    <p class="fs-5 fw-bold text-dark">{{ $result->student->user->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted">Email Address</label>
                                    <p class="text-dark">{{ $result->student->user->email ?? 'N/A' }}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted">Student ID</label>
                                    <p class="text-dark">{{ $result->student_id }}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted">School</label>
                                    <p class="text-dark">{{ $result->school->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exam Information -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-clipboard-list me-2"></i>Examination Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-muted">Exam Name</label>
                                    <p class="fs-5 fw-bold text-dark">{{ $result->exam->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted">Academic Year</label>
                                    <p class="text-dark">{{ $result->exam->academic_year ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted">Semester</label>
                                    <p class="text-dark">{{ $result->exam->semester ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted">Grade Level</label>
                                    <p class="text-dark">{{ $result->exam->grade_level ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted">Examination Type</label>
                                    <p class="text-dark">{{ $result->exam->examination_type ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Result Summary -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Result Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4 text-center">
                        <div class="col-md-3">
                            <div class="p-4 bg-light rounded">
                                <h2 class="text-primary mb-2">{{ $result->marks_obtained }}</h2>
                                <p class="mb-0 text-muted">Total Marks</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-4 bg-light rounded">
                                <h2 class="text-secondary mb-2">{{ $result->grade }}</h2>
                                <p class="mb-0 text-muted">Grade</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-4 bg-light rounded">
                                @if($result->marks_obtained >= 300)
                                    <h2 class="text-success mb-2">
                                        <i class="fas fa-check-circle"></i> PASS
                                    </h2>
                                @else
                                    <h2 class="text-danger mb-2">
                                        <i class="fas fa-times-circle"></i> FAIL
                                    </h2>
                                @endif
                                <p class="mb-0 text-muted">Result Status</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-4 bg-light rounded">
                                <h2 class="text-info mb-2">
                                    {{ $result->marks_obtained >= 300 ? round(($result->marks_obtained / 500) * 100, 1) : round(($result->marks_obtained / 500) * 100, 1) }}%
                                </h2>
                                <p class="mb-0 text-muted">Percentage</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subject-wise Breakdown (if available) -->
            @if($result->exam->subjects ?? false)
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-book me-2"></i>Subject-wise Breakdown
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>Subject</th>
                                    <th>Max Marks</th>
                                    <th>Obtained Marks</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- This would be populated if you have subject-wise marks -->
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Subject-wise breakdown not available for this result
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Additional Information -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Additional Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Remarks</label>
                            <p class="text-dark">{{ $result->remarks ?: 'No remarks available' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Published By</label>
                            <p class="text-dark">{{ $result->publisher->user->name ?? 'System' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Published At</label>
                            <p class="text-dark">{{ $result->published_at ? $result->published_at->format('F j, Y \a\t g:i A') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Result ID</label>
                            <p class="text-dark">#{{ $result->id }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-sm mt-4">
                <div class="card-body text-center">
                    <button class="btn btn-primary me-2" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Result
                    </button>
                    <button class="btn btn-success me-2" onclick="downloadPDF()">
                        <i class="fas fa-download"></i> Download PDF
                    </button>
                    <a href="{{ route('student-examinations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list"></i> View All Results
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .card {
        border: none;
        border-radius: 10px;
    }
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }
    @media print {
        .btn, .card-header .ms-auto {
            display: none !important;
        }
        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function downloadPDF() {
    // You can implement PDF generation here using libraries like jsPDF or server-side PDF generation
    alert('PDF download functionality would be implemented here');
}
</script>
@endsection