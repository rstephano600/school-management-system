@extends('layouts.app')

@section('title', 'Student Examination Results')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="fas fa-chart-line me-2"></i>
                    <h4 class="mb-0">Student Result Sheet</h4>
                    <div class="ms-auto">
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#analyticsModal">
                            <i class="fas fa-chart-bar"></i> Analytics
                        </button>
                        <button class="btn btn-light btn-sm" onclick="exportResults()">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>
                
                <!-- Pass/Fail Legend -->
                <div class="card-body p-2">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <div class="alert alert-success mb-0 py-2">
                                <strong>Pass</strong> - ≥300 Marks
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-danger mb-0 py-2">
                                <strong>Fail</strong> - <300 Marks
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>Search & Filter
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('student-examinations.index') }}" id="filterForm">
                        <div class="row g-3">
                            <!-- Search -->
                            <div class="col-md-3">
                                <label class="form-label">Search Student</label>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" placeholder="Student name or email">
                            </div>

                            <!-- Academic Year -->
                            <div class="col-md-2">
                                <label class="form-label">Academic Year</label>
                                <select class="form-select" name="academic_year_id">
                                    <option value="">All Years</option>
                                    @foreach($academicYears as $year)
                                        <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                                            {{ $year->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Semester -->
                            <div class="col-md-2">
                                <label class="form-label">Semester</label>
                                <select class="form-select" name="semester_id">
                                    <option value="">All Semesters</option>
                                    @foreach($semesters as $semester)
                                        <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                            {{ $semester->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Grade Level -->
                            <div class="col-md-2">
                                <label class="form-label">Grade Level</label>
                                <select class="form-select" name="grade_id">
                                    <option value="">All Grades</option>
                                    @foreach($gradeLevels as $level)
                                        <option value="{{ $level->id }}" {{ request('grade_id') == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Examination Type -->
                            <div class="col-md-3">
                                <label class="form-label">Examination Type</label>
                                <select class="form-select" name="exam_type_id">
                                    <option value="">All Types</option>
                                    @foreach($examTypes as $type)
                                        <option value="{{ $type->id }}" {{ request('exam_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Specific Student -->
                            <div class="col-md-3">
                                <label class="form-label">Specific Student</label>
                                <select class="form-select" name="student_id">
                                    <option value="">All Students</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->user_id }}" {{ request('student_id') == $student->user_id ? 'selected' : '' }}>
                                            {{ $student->user->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Specific Exam -->
                            <div class="col-md-3">
                                <label class="form-label">Specific Exam</label>
                                <select class="form-select" name="exam_id">
                                    <option value="">All Exams</option>
                                    @foreach($exams as $exam)
                                        <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                            {{ $exam->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subject Filter -->
                            <div class="col-md-2">
                                <label class="form-label">Subject</label>
                                <select class="form-select" name="subject_id">
                                    <option value="">All Subjects</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Grade Filter -->
                            <div class="col-md-2">
                                <label class="form-label">Grade</label>
                                <select class="form-select" name="grade">
                                    <option value="">All Grades</option>
                                    @foreach($grades as $grade)
                                        <option value="{{ $grade }}" {{ request('grade') == $grade ? 'selected' : '' }}>
                                            {{ $grade }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-md-2 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="{{ route('student-examinations.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>Student Results ({{ $results->total() }} records)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 200px;">Name</th>
                                    <th>Exam</th>
                                    <th>Academic Year</th>
                                    <th>Semester</th>
                                    <th>Grade Level</th>
                                    <th>Subject</th>
                                    <th>Total Marks</th>
                                    <th>Obtained</th>
                                    <th>Grade</th>
                                    <th style="width: 100px;">Result</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($results as $result)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>{{ $result->student->user->name ?? 'N/A' }}</strong>
                                            <small class="text-muted">{{ $result->student->user->email ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>{{ $result->exam->title ?? 'N/A' }}</strong>
                                            <small class="text-muted">{{ $result->exam->examType->name ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $result->exam->academicYear->name ?? 'N/A' }}</td>
                                    <td>{{ $result->exam->semester->name ?? 'N/A' }}</td>
                                    <td>{{ $result->exam->grade->name ?? 'N/A' }}</td>
                                    <td>{{ $result->exam->subject->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-secondary fs-6">{{ $result->exam->total_marks ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info fs-6">{{ $result->marks_obtained }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $result->grade }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $passingMarks = $result->exam->passing_marks ?? 300;
                                        @endphp
                                        @if($result->marks_obtained >= $passingMarks)
                                            <span class="badge bg-success">Pass</span>
                                        @else
                                            <span class="badge bg-danger">Fail</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('student-examinations.show', $result->id) }}" 
                                           class="btn btn-sm btn-outline-primary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-search fa-3x mb-3"></i>
                                            <p>No examination results found matching your criteria.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($results->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $results->firstItem() }} to {{ $results->lastItem() }} of {{ $results->total() }} results
                        </div>
                        {{ $results->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Analytics Modal -->
<div class="modal fade" id="analyticsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-chart-pie me-2"></i>Analytics Overview
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="analyticsContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
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
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .badge {
        font-size: 0.8rem;
    }
    .card {
        border: none;
        border-radius: 10px;
    }
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #333;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function exportResults() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData).toString();
    
    window.location.href = `{{ route('student-examinations.export') }}?${params}`;
}

// Load analytics when modal is shown
document.getElementById('analyticsModal').addEventListener('show.bs.modal', function() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData).toString();
    
    fetch(`{{ route('student-examinations.analytics') }}?${params}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('analyticsContent').innerHTML = `
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h3>${data.total_results}</h3>
                                <p class="mb-0">Total Results</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h3>${data.pass_count}</h3>
                                <p class="mb-0">Pass (${data.pass_percentage}%)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <h3>${data.fail_count}</h3>
                                <p class="mb-0">Fail</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h3>${Math.round(data.average_marks)}</h3>
                                <p class="mb-0">Average Marks</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h3>${data.highest_marks}</h3>
                                <p class="mb-0">Highest Marks</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-secondary text-white">
                            <div class="card-body text-center">
                                <h3>${data.lowest_marks}</h3>
                                <p class="mb-0">Lowest Marks</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            document.getElementById('analyticsContent').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error loading analytics data.
                </div>
            `;
        });
});
</script>
@endsection