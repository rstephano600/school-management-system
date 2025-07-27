@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Profile Information
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-user fa-3x text-muted"></i>
                        </div>
                    </div>
                    
                    <h4 class="mb-2">{{ $user->getFullNameAttribute() }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="mb-3">
                        <span class="badge bg-info fs-6">
                            {{ $user->getRoleDisplayNameAttribute() }}
                        </span>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <strong>Status</strong>
                            <div class="mt-1">
                                @if($user->isActive())
                                    <span class="badge bg-success">Active</span>
                                @elseif($user->isPending())
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($user->isSuspended())
                                    <span class="badge bg-danger">Suspended</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($user->status) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <strong>School</strong>
                            <div class="mt-1">
                                <small class="text-muted">
                                    {{ $user->school->name ?? 'Not assigned' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Actions -->
        <div class="col-lg-8">
            <div class="row">
                <!-- Password Change -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-key me-2"></i>Password Security
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                Keep your account secure by regularly updating your password.
                            </p>
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Password requirements:
                                </small>
                                <ul class="small text-muted mt-1">
                                    <li>At least 8 characters long</li>
                                    <li>Contains uppercase & lowercase letters</li>
                                    <li>Contains numbers and symbols</li>
                                </ul>
                            </div>
                            <a href="{{ route('password.change.form') }}" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i>Change Password
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Admin Functions -->
                @if($user->hasAdminPrivileges())
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-shield-alt me-2"></i>Admin Functions
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                Administrative tools for managing user accounts and passwords.
                            </p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.password.reset.form') }}" class="btn btn-danger btn-sm">
                                    <i class="fas fa-users-cog me-1"></i>Manage User Passwords
                                </a>
                                @if($user->isSuperAdmin())
                                <small class="text-muted">
                                    <i class="fas fa-crown me-1"></i>Super Admin Access - All Users
                                </small>
                                @elseif($user->isSchoolAdmin())
                                <small class="text-muted">
                                    <i class="fas fa-school me-1"></i>School Admin Access - Your School Only
                                </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Account Information -->
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>Account Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="fw-bold">Full Name:</td>
                                            <td>{{ $user->getFullNameAttribute() }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Email:</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Role:</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $user->getRoleDisplayNameAttribute() }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Status:</td>
                                            <td>
                                                @if($user->isActive())
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($user->isPending())
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($user->isSuspended())
                                                    <span class="badge bg-danger">Suspended</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($user->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="fw-bold">School:</td>
                                            <td>{{ $user->school->name ?? 'Not assigned' }}</td>
                                        </tr>
                                        <!-- <tr>
                                            <td class="fw-bold">User ID:</td>
                                            <td><code>#{{ $user->id }}</code></td>
                                        </tr> -->
                                        <tr>
                                            <td class="fw-bold">Member Since:</td>
                                            <td>
    {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
</td>

                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Last Updated:</td>
                                            <td>
                                                    {{ $user->updated_at ? $user->updated_at->format('M d, Y') : 'N/A' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role-Specific Information -->
                @if($user->isStudent() && $user->student)
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-graduation-cap me-2"></i>Student Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>First Name:</strong><br>
                                    <span class="text-muted">{{ $user->student->fname ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Middle Name:</strong><br>
                                    <span class="text-muted">{{ $user->student->mname ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Last Name:</strong><br>
                                    <span class="text-muted">{{ $user->student->lname ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($user->isTeacher() && $user->teacher)
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Teacher Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Subjects:</strong></p>
                            @if($user->subjects->count() > 0)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($user->subjects as $subject)
                                        <span class="badge bg-primary">{{ $subject->name }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">No subjects assigned</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection