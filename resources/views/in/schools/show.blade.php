@extends('layouts.app')

@section('title', 'School Details - ' . $school->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    @if($school->logo)
                        <img src="{{ Storage::url($school->logo) }}" 
                             alt="{{ $school->name }}" 
                             class="img-thumbnail me-3"
                             style="width: 60px; height: 60px; object-fit: cover;">
                    @endif
                    <div>
                        <h1 class="h3 mb-0">{{ $school->name }}</h1>
                        <p class="text-muted mb-0">School Code: {{ $school->code }}</p>
                    </div>
                </div>
                <div class="btn-group">
                    @if(in_array(auth()->user()->role, ['super_admin', 'school_creator']) && 
                        (auth()->user()->role === 'super_admin' || $school->modified_by === auth()->id()))
                        <a href="{{ route('schools.edit', $school) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit School
                        </a>
                    @endif
                    <a href="{{ route('schools.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Schools
                    </a>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- School Information -->
                <div class="col-lg-8">
                    <!-- Basic Information Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>Basic Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-4">Name:</dt>
                                        <dd class="col-sm-8">{{ $school->name }}</dd>
                                        
                                        <dt class="col-sm-4">Code:</dt>
                                        <dd class="col-sm-8">
                                            <code>{{ $school->code }}</code>
                                        </dd>
                                        
                                        <dt class="col-sm-4">Status:</dt>
                                        <dd class="col-sm-8">
                                            @if(in_array(auth()->user()->role, ['super_admin', 'school_creator']) && 
                                                (auth()->user()->role === 'super_admin' || $school->modified_by === auth()->id()))
                                                <form action="{{ route('schools.toggle-status', $school) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $school->status ? 'btn-success' : 'btn-danger' }}">
                                                        <i class="fas fa-{{ $school->status ? 'check' : 'times' }} me-1"></i>
                                                        {{ $school->status ? 'Active' : 'Inactive' }}
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge {{ $school->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $school->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            @endif
                                        </dd>
                                        
                                        <dt class="col-sm-4">Established:</dt>
                                        <dd class="col-sm-8">
                                            @if($school->established_date)
                                                {{ $school->established_date->format('F d, Y') }}
                                                <small class="text-muted">
                                                    ({{ $school->established_date->diffForHumans() }})
                                                </small>
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-4">Created:</dt>
                                        <dd class="col-sm-8">
                                            {{ $school->created_at->format('M d, Y g:i A') }}
                                            <br><small class="text-muted">{{ $school->created_at->diffForHumans() }}</small>
                                        </dd>
                                        
                                        <dt class="col-sm-4">Last Updated:</dt>
                                        <dd class="col-sm-8">
                                            {{ $school->updated_at->format('M d, Y g:i A') }}
                                            <br><small class="text-muted">{{ $school->updated_at->diffForHumans() }}</small>
                                        </dd>
                                        
                                        <dt class="col-sm-4">School ID:</dt>
                                        <dd class="col-sm-8">
                                            <code>#{{ $school->id }}</code>
                                        </dd>
                                    </dl>
                                </div>
                            </div>

                            @if($school->address)
                            <div class="mt-3">
                                <h6><i class="fas fa-map-marker-alt me-2"></i>Address</h6>
                                <p class="mb-0">{{ $school->address }}</p>
                                <div class="text-muted small mt-1">
                                    @if($school->city){{ $school->city }}@endif
                                    @if($school->city && $school->state), @endif
                                    @if($school->state){{ $school->state }}@endif
                                    @if($school->postal_code) {{ $school->postal_code }}@endif
                                    @if($school->country)<br>{{ $school->country }}@endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Information Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-phone me-2"></i>Contact Information
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($school->phone || $school->email || $school->website)
                            <div class="row">
                                @if($school->phone)
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Phone</small>
                                            <a href="tel:{{ $school->phone }}" class="text-decoration-none">
                                                {{ $school->phone }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($school->email)
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Email</small>
                                            <a href="mailto:{{ $school->email }}" class="text-decoration-none">
                                                {{ $school->email }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($school->website)
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-globe text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Website</small>
                                            <a href="{{ $school->website }}" target="_blank" class="text-decoration-none">
                                                {{ parse_url($school->website, PHP_URL_HOST) }}
                                                <i class="fas fa-external-link-alt ms-1 small"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @else
                            <div class="text-center py-3">
                                <i class="fas fa-info-circle text-muted fa-2x mb-2"></i>
                                <p class="text-muted mb-0">No contact information available</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Statistics Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-bar me-2"></i>School Statistics
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-2 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h4 mb-1 text-primary">{{ $stats['total_users'] }}</div>
                                        <small class="text-muted">Total Users</small>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h4 mb-1 text-success">{{ $stats['active_users'] }}</div>
                                        <small class="text-muted">Active Users</small>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h4 mb-1 text-warning">{{ $stats['pending_users'] }}</div>
                                        <small class="text-muted">Pending Users</small>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h4 mb-1 text-info">{{ $stats['teachers'] }}</div>
                                        <small class="text-muted">Teachers</small>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h4 mb-1 text-secondary">{{ $stats['students'] }}</div>
                                        <small class="text-muted">Students</small>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h4 mb-1 text-dark">{{ $stats['parents'] }}</div>
                                        <small class="text-muted">Parents</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- School Logo Card -->
                    @if($school->logo)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-image me-2"></i>School Logo
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ Storage::url($school->logo) }}" 
                                 alt="{{ $school->name }}" 
                                 class="img-fluid rounded"
                                 style="max-height: 200px;">
                        </div>
                    </div>
                    @endif

                    <!-- Quick Actions Card -->
                    @if(in_array(auth()->user()->role, ['super_admin', 'school_creator']) && 
                        (auth()->user()->role === 'super_admin' || $school->modified_by === auth()->id()))
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cog me-2"></i>Quick Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('schools.edit', $school) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Edit School
                                </a>
                                @if(in_array(auth()->user()->role, ['super_admin']))
                                <form action="{{ route('schools.toggle-status', $school) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn {{ $school->status ? 'btn-outline-danger' : 'btn-outline-success' }} w-100">
                                        <i class="fas fa-{{ $school->status ? 'times' : 'check' }} me-2"></i>
                                        {{ $school->status ? 'Deactivate' : 'Activate' }} School
                                    </button>
                                </form>

                                <button type="button" 
                                        class="btn btn-outline-danger"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-2"></i>Delete School
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- School Details Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info me-2"></i>Additional Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-6">School ID:</dt>
                                <dd class="col-6"><code>#{{ $school->name }}</code></dd>
                                
                                @if($school->modified_by)
                                <dt class="col-6">Created By:</dt>
                                <!-- <dd class="col-6">User #{{ $school->modified_by }}</dd> -->
                                <dd class="col-6">User you</dd>
                                @endif
                                
                                <dt class="col-6">Record Created:</dt>
                                <dd class="col-6">
                                    <small>{{ $school->created_at->format('M d, Y') }}</small>
                                </dd>
                                
                                <dt class="col-6">Last Modified:</dt>
                                <dd class="col-6">
                                    <small>{{ $school->updated_at->format('M d, Y') }}</small>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@if(in_array(auth()->user()->role, ['super_admin', 'school_creator']) && 
    (auth()->user()->role === 'super_admin' || $school->modified_by === auth()->id()))
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    @if($school->logo)
                        <img src="{{ Storage::url($school->logo) }}" 
                             alt="{{ $school->name }}" 
                             class="img-thumbnail mb-2"
                             style="width: 80px; height: 80px; object-fit: cover;">
                    @endif
                    <h6>{{ $school->name }}</h6>
                    <small class="text-muted">Code: {{ $school->code }}</small>
                </div>
                
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Warning!</strong> This action cannot be undone.
                </div>
                
                <p>Are you sure you want to permanently delete this school?</p>
                
                @if($stats['total_users'] > 0)
                <div class="alert alert-warning">
                    <i class="fas fa-users me-2"></i>
                    This school has <strong>{{ $stats['total_users'] }} user(s)</strong> associated with it. 
                    You must remove all users before deleting the school.
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <form action="{{ route('schools.destroy', $school) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-danger"
                            @if($stats['total_users'] > 0) disabled @endif>
                        <i class="fas fa-trash me-1"></i>Delete School
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection