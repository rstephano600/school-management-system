@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="card">
        <div class="card-header">
            <h5 class="mb-0">dashboard</h5>
        </div>
        <div class="card-body">
         

                <!-- Welcome Header -->
                <div class="welcome-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-1">Welcome back, {{ auth()->user()->name }}!</h2>
                            <p class="mb-0 opacity-75">
                                @if($currentAcademicYear)
                                    Academic Year: {{ $currentAcademicYear->name }}
                                @endif
                                @if($currentSemester)
                                    | Current Semester: {{ $currentSemester->name }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="fs-1 opacity-50">
                                <i class="fas fa-school"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card primary">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-primary mb-1">{{ number_format($totalStudents) }}</h3>
                                    <p class="text-muted mb-0">Total Students</p>
                                </div>
                                <div class="fs-1 text-primary opacity-25">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> 12% from last month
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card success">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-success mb-1">{{ number_format($totalTeachers) }}</h3>
                                    <p class="text-muted mb-0">Total Teachers</p>
                                </div>
                                <div class="fs-1 text-success opacity-25">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> 5% from last month
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card warning">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-warning mb-1">{{ number_format($totalStaff) }}</h3>
                                    <p class="text-muted mb-0">Staff Members</p>
                                </div>
                                <div class="fs-1 text-warning opacity-25">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-info">
                                    <i class="fas fa-minus"></i> No change
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card info">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-info mb-1">{{ number_format($feeStats['monthly_collected']) }}</h3>
                                    <p class="text-muted mb-0">Monthly Collection</p>
                                </div>
                                <div class="fs-1 text-info opacity-25">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> 8% from last month
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Charts Section -->
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-line me-2"></i>Monthly Fee Collection
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="feeCollectionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Tasks -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-tasks me-2"></i>Pending Tasks
                                    <span class="badge bg-danger ms-2">{{ count($pendingTasks) }}</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                @if(count($pendingTasks) > 0)
                                    @foreach($pendingTasks as $task)
                                        <div class="pending-task border-{{ $task['color'] }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">{{ $task['title'] }}</h6>
                                                    <small class="text-muted">{{ $task['count'] }} items pending</small>
                                                </div>
                                                <a href="{{ $task['url'] }}" class="btn btn-{{ $task['color'] }} btn-sm">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-check-circle fs-1 text-success mb-3"></i>
                                        <p class="text-muted">All tasks completed!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Recent Activities -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-clock me-2"></i>Recent Activities
                                </h5>
                            </div>
                            <div class="card-body">
                                @foreach($recentActivities as $activity)
                                    <div class="activity-item">
                                        <div class="d-flex align-items-start">
                                            <div class="me-3">
                                                <div class="bg-{{ $activity['color'] }} text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                    <i class="{{ $activity['icon'] }} fa-sm"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1">{{ $activity['message'] }}</p>
                                                <small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Notices & Events -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-bullhorn me-2"></i>Recent Notices & Events
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="text-primary">
                                        <i class="fas fa-bullhorn me-1"></i>Latest Notices
                                    </h6>
                                    @foreach($recentNotices->take(3) as $notice)
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <p class="mb-0 fw-medium">{{ Str::limit($notice->title, 30) }}</p>
                                                <small class="text-muted">{{ $notice->created_at->format('M d, Y') }}</small>
                                            </div>
                                            <span class="badge bg-primary">New</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div>
                                    <h6 class="text-success">
                                        <i class="fas fa-calendar-check me-1"></i>Upcoming Events
                                    </h6>
                                    @foreach($upcomingEvents->take(3) as $event)
                                        <div class="d-flex justify-content-between align-items-center py-2">
                                            <div>
                                                <p class="mb-0 fw-medium">{{ Str::limit($event->title, 30) }}</p>
                                                <small class="text-muted">{{ $event->start_date->format('M d, Y') }}</small>
                                            </div>
                                            <span class="badge bg-success">{{ $event->start_date->diffForHumans() }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enrollment by Grade -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-pie me-2"></i>Student Enrollment By Grade
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($enrollmentByGrade as $grade)
                                        <div class="col-md-2 col-sm-4 mb-3">
                                            <div class="text-center p-3 bg-light rounded">
                                                <h4 class="text-primary mb-1">{{ $grade->total }}</h4>
                                                <small class="text-muted">{{ $grade->name }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
