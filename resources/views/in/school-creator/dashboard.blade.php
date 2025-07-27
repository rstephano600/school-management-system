@extends('layouts.app')

@section('title', 'School Creator Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">School Creator Dashboard</h1>
                    <p class="text-muted">Welcome back, {{ auth()->user()->name }}!</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('schools.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New School
                    </a>
                    <a href="{{ route('schools.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-school me-2"></i>Manage Schools
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Active Schools
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ App\Models\School::where('modified_by', auth()->id())->where('status', true)->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Inactive Schools
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ App\Models\School::where('modified_by', auth()->id())->where('status', false)->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Users
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ App\Models\User::whereIn('school_id', App\Models\School::where('modified_by', auth()->id())->pluck('id'))->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Schools -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-school me-2"></i>Recent Schools
                            </h6>
                            <a href="{{ route('schools.index') }}" class="btn btn-sm btn-outline-primary">
                                View All
                            </a>
                        </div>
                        <div class="card-body">
                            @php
                                $recentSchools = App\Models\School::where('modified_by', auth()->id())
                                    ->latest()
                                    ->limit(5)
                                    ->get();
                            @endphp

                            @if($recentSchools->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>School</th>
                                                <th>Code</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentSchools as $school)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($school->logo)
                                                            <img src="{{ Storage::url($school->logo) }}" 
                                                                 alt="{{ $school->name }}" 
                                                                 class="img-thumbnail me-2"
                                                                 style="width: 30px; height: 30px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center rounded me-2"
                                                                 style="width: 30px; height: 30px;">
                                                                <i class="fas fa-school text-muted small"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-bold">{{ $school->name }}</div>
                                                            @if($school->city)
                                                                <small class="text-muted">{{ $school->city }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <code>{{ $school->code }}</code>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $school->status ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $school->status ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <small>{{ $school->created_at->format('M d, Y') }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('schools.show', $school) }}" 
                                                           class="btn btn-outline-info btn-sm"
                                                           title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('schools.edit', $school) }}" 
                                                           class="btn btn-outline-warning btn-sm"
                                                           title="Edit School">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('schools.toggle-status', $school) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="btn btn-outline-{{ $school->status ? 'danger' : 'success' }} btn-sm"
                                                                    title="{{ $school->status ? 'Deactivate' : 'Activate' }} School">
                                                                <i class="fas fa-{{ $school->status ? 'times' : 'check' }}"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-school fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No schools created yet</h5>
                                    <p class="text-muted">Start by creating your first school.</p>
                                    <a href="{{ route('schools.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Create School
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Monthly Activity Chart -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="fas fa-chart-area me-2"></i>School Creation Activity
                            </h6>
                        </div>
                        <div class="card-body">
                            @php
                                $monthlyData = App\Models\School::where('modified_by', auth()->id())
                                    ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                    ->whereYear('created_at', date('Y'))
                                    ->groupBy('month')
                                    ->orderBy('month')
                                    ->get()
                                    ->pluck('count', 'month')
                                    ->toArray();
                                
                                $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                $chartData = [];
                                for($i = 1; $i <= 12; $i++) {
                                    $chartData[] = $monthlyData[$i] ?? 0;
                                }
                            @endphp
                            
                            <canvas id="schoolActivityChart" width="100%" height="30"></canvas>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="small text-muted">
                                        <strong>This Year:</strong> {{ array_sum($chartData) }} schools created
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">
                                        <strong>This Month:</strong> {{ $monthlyData[date('n')] ?? 0 }} schools created
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="fas fa-history me-2"></i>Recent Activity
                            </h6>
                        </div>
                        <div class="card-body">
                            @php
                                $recentActivities = App\Models\School::where('modified_by', auth()->id())
                                    ->latest('updated_at')
                                    ->limit(10)
                                    ->get();
                            @endphp

                            @if($recentActivities->count() > 0)
                                <div class="timeline">
                                    @foreach($recentActivities as $activity)
                                    <div class="timeline-item">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">{{ $activity->name }}</h6>
                                                    <p class="mb-1 text-muted small">
                                                        @if($activity->created_at->eq($activity->updated_at))
                                                            School was created
                                                        @else
                                                            School information was updated
                                                        @endif
                                                    </p>
                                                    <small class="text-muted">
                                                        {{ $activity->updated_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                                <!-- <span class="badge {{ $activity->status ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $activity->status ? 'Active' : 'Inactive' }}
                                                </span> -->
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="fas fa-clock text-muted fa-2x mb-2"></i>
                                    <p class="text-muted mb-0">No recent activity</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Quick Actions -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="fas fa-bolt me-2"></i>Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('schools.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Create New School
                                </a>
                                <a href="{{ route('schools.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-list me-2"></i>View All Schools
                                </a>
                                <a href="{{ route('schools.index', ['status' => '1']) }}" class="btn btn-outline-success">
                                    <i class="fas fa-check me-2"></i>Active Schools
                                </a>
                                <a href="{{ route('schools.index', ['status' => '0']) }}" class="btn btn-outline-warning">
                                    <i class="fas fa-pause me-2"></i>Inactive Schools
                                </a>
                                <hr>
                                <a href="{{ route('schools.index', ['search' => '']) }}" class="btn btn-outline-info">
                                    <i class="fas fa-search me-2"></i>Search Schools
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- School Status Overview -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="fas fa-chart-pie me-2"></i>School Status Overview
                            </h6>
                        </div>
                        <div class="card-body">
                            @php
                                $activeCount = App\Models\School::where('modified_by', auth()->id())->where('status', true)->count();
                                $inactiveCount = App\Models\School::where('modified_by', auth()->id())->where('status', false)->count();
                                $total = $activeCount + $inactiveCount;
                                $activePercentage = $total > 0 ? round(($activeCount / $total) * 100, 1) : 0;
                                $inactivePercentage = $total > 0 ? round(($inactiveCount / $total) * 100, 1) : 0;
                            @endphp

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small fw-bold">Active Schools</span>
                                    <span class="small">{{ $activeCount }} ({{ $activePercentage }}%)</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $activePercentage }}%"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small fw-bold">Inactive Schools</span>
                                    <span class="small">{{ $inactiveCount }} ({{ $inactivePercentage }}%)</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $inactivePercentage }}%"></div>
                                </div>
                            </div>

                            @if($total > 0)
                                <div class="text-center mt-3">
                                    <canvas id="statusPieChart" width="150" height="150"></canvas>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="fas fa-chart-pie text-muted fa-2x mb-2"></i>
                                    <p class="text-muted mb-0 small">No data to display</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="fas fa-user me-2"></i>Account Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-5">Name:</dt>
                                <dd class="col-sm-7">{{ auth()->user()->name }}</dd>
                                
                                <dt class="col-sm-5">Email:</dt>
                                <dd class="col-sm-7">
                                    <small>{{ auth()->user()->email }}</small>
                                </dd>
                                
                                <dt class="col-sm-5">Role:</dt>
                                <dd class="col-sm-7">
                                    <span class="badge bg-info">School Creator</span>
                                </dd>
                                
                                <dt class="col-sm-5">Status:</dt>
                                <dd class="col-sm-7">
                                    <span class="badge bg-success">{{ ucfirst(auth()->user()->status) }}</span>
                                </dd>
                                
                                <dt class="col-sm-5">Joined:</dt>
                                <dd class="col-sm-7">
                                    <small>{{ auth()->user()->created_at->format('M d, Y') }}</small>
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <!-- Tips & Help -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="fas fa-lightbulb me-2"></i>Tips & Help
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="helpAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne">
                                            <i class="fas fa-question-circle me-2"></i>Getting Started
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                                        <div class="accordion-body small">
                                            <ul class="mb-0">
                                                <li>Create your first school using the "Create New School" button</li>
                                                <li>Fill in all required information including school name and code</li>
                                                <li>Upload a school logo for better identification</li>
                                                <li>Set the school status to active when ready</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo">
                                            <i class="fas fa-cog me-2"></i>Managing Schools
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                                        <div class="accordion-body small">
                                            <ul class="mb-0">
                                                <li>Use the search and filter options to find specific schools</li>
                                                <li>Toggle school status between active and inactive as needed</li>
                                                <li>Update school information regularly to keep it current</li>
                                                <li>View detailed statistics for each school</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree">
                                            <i class="fas fa-shield-alt me-2"></i>Permissions
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                                        <div class="accordion-body small">
                                            <ul class="mb-0">
                                                <li>You can only manage schools that you have created</li>
                                                <li>Super administrators can view and manage all schools</li>
                                                <li>School codes must be unique across the system</li>
                                                <li>Deleting a school requires removing all associated users first</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.text-xs {
    font-size: 0.7rem;
}

.font-weight-bold {
    font-weight: 700;
}

.text-gray-800 {
    color: #5a5c69;
}

.text-gray-300 {
    color: #dddfeb;
}
</style>
@endsection
                    