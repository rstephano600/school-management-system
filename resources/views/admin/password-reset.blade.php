@extends('layouts.app')

@section('title', 'Admin Password Reset')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>Admin Password Reset
                        <small class="ms-3 opacity-75">
                            @if(auth()->user()->isSuperAdmin())
                                (Super Admin - All Users)
                            @else
                                (School Admin - {{ auth()->user()->school->name ?? 'Your School' }} Users Only)
                            @endif
                        </small>
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Single User Password Reset -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Reset Individual User Password</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.password.reset') }}" id="singleResetForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="user_id" class="form-label">Select User</label>
                                        <select class="form-select @error('user_id') is-invalid @enderror" 
                                                id="user_id" 
                                                name="user_id" 
                                                required>
                                            <option value="">Choose a user...</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" 
                                                        data-role="{{ $user->getRoleDisplayNameAttribute() }}"
                                                        data-school="{{ $user->school->name ?? 'N/A' }}"
                                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="password" class="form-label">New Password</label>
                                        <div class="input-group">
                                            <input type="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" 
                                                   name="password" 
                                                   required 
                                                   autocomplete="new-password"
                                                   minlength="8">
                                            <button class="btn btn-outline-secondary" 
                                                    type="button" 
                                                    onclick="generateRandomPassword()"
                                                    title="Generate Random Password">
                                                <i class="fas fa-random"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" 
                                                    type="button" 
                                                    onclick="togglePassword('password')"
                                                    title="Toggle Password Visibility">
                                                <i class="fas fa-eye" id="password_icon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Minimum 8 characters</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" 
                                                   class="form-control" 
                                                   id="password_confirmation" 
                                                   name="password_confirmation" 
                                                   required
                                                   minlength="8">
                                            <button class="btn btn-outline-secondary" 
                                                    type="button" 
                                                    onclick="togglePassword('password_confirmation')"
                                                    title="Toggle Password Visibility">
                                                <i class="fas fa-eye" id="password_confirmation_icon"></i>
                                            </button>
                                        </div>
                                        <div id="password_match_feedback" class="form-text"></div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-danger" onclick="return confirmSingleReset()">
                                        <i class="fas fa-key me-1"></i>Reset Password
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="clearSingleForm()">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-search me-2"></i>Search & Filter Users</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.password.reset.form') }}" id="searchForm">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="search" class="form-label">Search</label>
                                        <div class="input-group">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="search" 
                                                   name="search" 
                                                   value="{{ $search }}"
                                                   placeholder="Name, email, or school...">
                                            <button class="btn btn-outline-primary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select" id="role" name="role">
                                            <option value="">All Roles</option>
                                            @foreach($availableRoles as $role)
                                                <option value="{{ $role }}" {{ $roleFilter == $role ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('_', ' ', $role)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="">All Statuses</option>
                                            @foreach($availableStatuses as $status)
                                                <option value="{{ $status }}" {{ $statusFilter == $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if(auth()->user()->isSuperAdmin() && $schools->isNotEmpty())
                                    <div class="col-md-2">
                                        <label for="school" class="form-label">School</label>
                                        <select class="form-select" id="school" name="school">
                                            <option value="">All Schools</option>
                                            @foreach($schools as $school)
                                                <option value="{{ $school->id }}" {{ $schoolFilter == $school->id ? 'selected' : '' }}>
                                                    {{ $school->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-secondary me-2" onclick="clearFilters()">
                                            <i class="fas fa-times me-1"></i>Clear
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-filter me-1"></i>Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Bulk Password Reset -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Bulk Password Reset</h5>
                            <div class="badge bg-info">
                                {{ $users->count() }} user(s) found
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.password.bulk.reset') }}" id="bulkResetForm">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="bulk_password" class="form-label">New Password for Selected Users</label>
                                        <div class="input-group">
                                            <input type="password" 
                                                   class="form-control" 
                                                   id="bulk_password" 
                                                   name="password" 
                                                   required
                                                   minlength="8">
                                            <button class="btn btn-outline-secondary" 
                                                    type="button" 
                                                    onclick="generateBulkPassword()"
                                                    title="Generate Random Password">
                                                <i class="fas fa-random"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" 
                                                    type="button" 
                                                    onclick="togglePassword('bulk_password')"
                                                    title="Toggle Password Visibility">
                                                <i class="fas fa-eye" id="bulk_password_icon"></i>
                                            </button>
                                        </div>
                                        <small class="form-text text-muted">Minimum 8 characters</small>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary me-2" onclick="selectAllUsers()">
                                            <i class="fas fa-check-square me-1"></i>Select All
                                        </button>
                                        <button type="button" class="btn btn-secondary me-2" onclick="deselectAllUsers()">
                                            <i class="fas fa-square me-1"></i>Deselect All
                                        </button>
                                        <button type="submit" class="btn btn-danger" onclick="return confirmBulkReset()">
                                            <i class="fas fa-users me-1"></i>Reset Selected
                                        </button>
                                    </div>
                                </div>

                                <!-- Users Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="50">
                                                    <input type="checkbox" id="selectAll" onchange="toggleAllUsers()">
                                                </th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>School</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($users as $user)
                                                @if(!$user->isSuperAdmin() || auth()->user()->isSuperAdmin())
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" 
                                                               name="user_ids[]" 
                                                               value="{{ $user->id }}" 
                                                               class="user-checkbox">
                                                    </td>
                                                    <td>
                                                        <strong>{{ $user->name }}</strong>
                                                        @if($user->isSuperAdmin())
                                                            <span class="badge bg-danger ms-1">SUPER ADMIN</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            {{ $user->getRoleDisplayNameAttribute() }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $user->school->name ?? 'N/A' }}</td>
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
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">
                                                        <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                                        <p class="text-muted">No users found to manage.</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function clearFilters() {
    document.getElementById('search').value = '';
    document.getElementById('role').value = '';
    document.getElementById('status').value = '';
    @if(auth()->user()->isSuperAdmin())
    const schoolSelect = document.getElementById('school');
    if (schoolSelect) {
        schoolSelect.value = '';
    }
    @endif
    document.getElementById('searchForm').submit();
}

// Auto-submit form when filters change
document.getElementById('role').addEventListener('change', function() {
    document.getElementById('searchForm').submit();
});

document.getElementById('status').addEventListener('change', function() {
    document.getElementById('searchForm').submit();
});

@if(auth()->user()->isSuperAdmin())
const schoolSelect = document.getElementById('school');
if (schoolSelect) {
    schoolSelect.addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
}
@endif

// Search on Enter key
document.getElementById('search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('searchForm').submit();
    }
});

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function generateRandomPassword() {
    fetch('{{ route("admin.password.generate") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('password').value = data.password;
            document.getElementById('password_confirmation').value = data.password;
            validatePasswordMatch();
        })
        .catch(error => {
            console.error('Error generating password:', error);
            alert('Error generating password. Please try again.');
        });
}

function generateBulkPassword() {
    fetch('{{ route("admin.password.generate") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('bulk_password').value = data.password;
        })
        .catch(error => {
            console.error('Error generating password:', error);
            alert('Error generating password. Please try again.');
        });
}

function toggleAllUsers() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.user-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

function selectAllUsers() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    const selectAll = document.getElementById('selectAll');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    selectAll.checked = true;
}

function deselectAllUsers() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    const selectAll = document.getElementById('selectAll');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    selectAll.checked = false;
}

function confirmBulkReset() {
    const selectedUsers = document.querySelectorAll('.user-checkbox:checked');
    
    if (selectedUsers.length === 0) {
        alert('Please select at least one user to reset password.');
        return false;
    }
    
    const password = document.getElementById('bulk_password').value;
    if (!password) {
        alert('Please enter a password for bulk reset.');
        return false;
    }
    
    if (password.length < 8) {
        alert('Password must be at least 8 characters long.');
        return false;
    }
    
    return confirm(`Are you sure you want to reset passwords for ${selectedUsers.length} user(s)? This action cannot be undone.`);
}

function confirmSingleReset() {
    const userId = document.getElementById('user_id').value;
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;
    
    if (!userId) {
        alert('Please select a user.');
        return false;
    }
    
    if (!password) {
        alert('Please enter a password.');
        return false;
    }
    
    if (password.length < 8) {
        alert('Password must be at least 8 characters long.');
        return false;
    }
    
    if (password !== passwordConfirmation) {
        alert('Passwords do not match.');
        return false;
    }
    
    const userSelect = document.getElementById('user_id');
    const selectedUser = userSelect.options[userSelect.selectedIndex].text;
    
    return confirm(`Are you sure you want to reset the password for ${selectedUser}? This action cannot be undone.`);
}

function clearSingleForm() {
    document.getElementById('singleResetForm').reset();
    document.getElementById('password_match_feedback').textContent = '';
}

function validatePasswordMatch() {
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;
    const feedback = document.getElementById('password_match_feedback');
    
    if (passwordConfirmation === '') {
        feedback.textContent = '';
        feedback.className = 'form-text';
        return;
    }
    
    if (password === passwordConfirmation) {
        feedback.textContent = 'Passwords match ✓';
        feedback.className = 'form-text text-success';
    } else {
        feedback.textContent = 'Passwords do not match ✗';
        feedback.className = 'form-text text-danger';
    }
}

// Auto-fill confirmation field when password changes
document.getElementById('password').addEventListener('input', function() {
    document.getElementById('password_confirmation').value = this.value;
    validatePasswordMatch();
});

// Validate password match on confirmation field change
document.getElementById('password_confirmation').addEventListener('input', validatePasswordMatch);

// Initialize tooltips if Bootstrap is available
document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>
@endsection