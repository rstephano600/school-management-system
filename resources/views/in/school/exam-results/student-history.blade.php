@extends('layouts.app')

@section('title', 'Student Exam History')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        Student Exam History
                    </h2>
                    <p class="text-muted mb-0">Complete examination record for the student</p>
                </div>
                <a href="{{ route('exam-results.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Results
                </a>
            </div>
        </div>
    </div>

    <!-- Student Profile Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <div class="avatar-xl bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2">
                                <span class="text-white fs-2">
                                    {{ strtoupper(substr($student->fname, 0, 1) . substr($student->lname, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 class="mb-1">
                                {{ $student->fname }} 
                                {{ $student->mname ? $student->mname . ' ' : '' }}
                                {{ $student->lname }}
                            </h3>
                            <p class="text-muted mb-2">{{ $student->user->email }}</p>
                            <div class="row g-2">
                                <div class="col-auto">
                                    <span class="badge bg-primary">{{ $student->admission_number }}</span>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-info">{{ $student->grade->name ?? 'N/A' }}</span>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-secondary">{{ $student->section->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row g-3 text-center">
                                <div class="col-4">
                                    <div class="p-2 bg-light rounded">
                                        <h4 class="mb-0 text-primary">{{ $results->total() }}</h4>
                                        <small class="text-muted">Total Exams</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 bg-light rounded">
                                        @php
                                            $avgMarks = $results->avg('marks_obtained');
                                        @endphp
                                        <h4 class="mb-0 text-success">{{ number_format($avgMarks, 1) }}</h4>
                                        <small class="text-muted">Avg. Marks</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 bg-light rounded">
                                        @php
                                            $passCount = $results->where('grade', '!=', 'F')->count();
                                            $passRate = $results->count() > 0 ? ($passCount / $results->count()) * 100 : 0;
                                        @endphp
                                        <h4 class="mb-0 text-info">{{ number_format($passRate, 1) }}%</h4>
                                        <small class="text-muted">Pass Rate</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exam Results History -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Examination History
            </h5>
            <span class="badge bg-primary">{{ $results->total() }} exams</span>
        </div>
        <div class="card-body p-0">
            @if($results->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Academic Year</th>
                                <th>Semester</th>
                                <th>Exam Type</th>
                                <th>Subject</th>
                                <th>Marks</th>
                                <th>Percentage</th>
                                <th>Grade</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $result->published_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $result->published_at->format('H:i A') }}</small>
                                    </td>
                                    <td>{{ $result->exam->academicYear->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $result->exam->semester->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $result->exam->examType->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="fw-semibold">{{ $result->exam->subject->name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="text-center">
                                            <div class="fw-bold">{{ $result->marks_obtained }}/{{ $result->exam->total_marks }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $percentage = $result->exam->total_marks > 0 ? 
                                                round(($result->marks_obtained / $result->exam->total_marks) * 100, 2) : 0;
                                        @endphp
                                        <div class="text-center">
                                            <div class="fw-bold">{{ $percentage }}%</div>
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar 
                                                    @if($percentage >= 90) bg-success
                                                    @elseif($percentage >= 80) bg-info
                                                    @elseif($percentage >= 70) bg-warning
                                                    @elseif($percentage >= 60) bg-primary
                                                    @else bg-danger
                                                    @endif"
                                                    style="width: {{ $percentage }}%">
                                                </div>
                                            </div>
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
                                        <span class="badge {{ $gradeClass }} fs-6">{{ $result->grade }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $isPassed = $result->marks_obtained >= $result->exam->passing_marks;
                                        @endphp
                                        <span class="badge {{ $isPassed ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas fa-{{ $isPassed ? 'check' : 'times' }} me-1"></i>
                                            {{ $isPassed ? 'Passed' : 'Failed' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('exam-results.show', $result->id) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
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
                        {{ $results->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No examination results found</h5>
                    <p class="text-muted">This student hasn't taken any published exams yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Performance Chart -->
    @if($results->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Performance Trend
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="performanceChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subject-wise Performance -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Subject-wise Performance
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $subjectPerformance = $results->groupBy('exam.subject.name')
                                ->map(function($subjectResults) {
                                    $totalMarks = $subjectResults->sum('exam.total_marks');
                                    $obtainedMarks = $subjectResults->sum('marks_obtained');
                                    $percentage = $totalMarks > 0 ? ($obtainedMarks / $totalMarks) * 100 : 0;
                                    return [
                                        'count' => $subjectResults->count(),
                                        'percentage' => round($percentage, 2),
                                        'average_grade' => $subjectResults->pluck('grade')->mode()[0] ?? 'N/A'
                                    ];
                                });
                        @endphp

                        <div class="row">
                            @foreach($subjectPerformance as $subject => $performance)
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">{{ $subject ?? 'Unknown Subject' }}</h6>
                                            <div class="mb-2">
                                                <span class="badge bg-primary">{{ $performance['count'] }} exams</span>
                                            </div>
                                            <div class="progress mb-2" style="height: 20px;">
                                                <div class="progress-bar 
                                                    @if($performance['percentage'] >= 80) bg-success
                                                    @elseif($performance['percentage'] >= 70) bg-info
                                                    @elseif($performance['percentage'] >= 60) bg-warning
                                                    @else bg-danger
                                                    @endif"
                                                    style="width: {{ $performance['percentage'] }}%">
                                                    {{ number_format($performance['percentage'], 1) }}%
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                Most common grade: 
                                                <span class="fw-semibold">{{ $performance['average_grade'] }}</span>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .avatar-xl {
        width: 100px;
        height: 100px;
        font-size: 28px;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        white-space: nowrap;
    }
    
    .progress {
        border-radius: 0.25rem;
    }
    
    .badge {
        font-size: 0.75em;
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if($results->count() > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Performance Chart
    const ctx = document.getElementById('performanceChart').getContext('2d');
    
    // Prepare data for the chart
    const chartData = {
        labels: [
            @foreach($results->reverse() as $result)
                '{{ $result->exam->subject->name }} ({{ $result->published_at->format("M Y") }})',
            @endforeach
        ],
        datasets: [{
            label: 'Percentage Score',
            data: [
                @foreach($results->reverse() as $result)
                    @php
                        $percentage = $result->exam->total_marks > 0 ? 
                            round(($result->marks_obtained / $result->exam->total_marks) * 100, 2) : 0;
                    @endphp
                    {{ $percentage }},
                @endforeach
            ],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1,
            fill: true
        }]
    };

    const config = {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Performance Over Time'
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    display: true,
                    ticks: {
                        maxRotation: 45
                    }
                }
            },
            elements: {
                point: {
                    radius: 5,
                    hoverRadius: 8
                }
            }
        }
    };

    new Chart(ctx, config);
});
</script>
@endif
@endpush