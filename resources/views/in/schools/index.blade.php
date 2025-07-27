@extends('layouts.app')

@section('title', 'Schools Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Schools Management</h1>
                    <p class="text-muted">Manage schools and their information</p>
                </div>
                @if(in_array(auth()->user()->role, ['super_admin', 'school_creator']))
                <a href="{{ route('schools.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New School
                </a>
                @endif
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Search and Filters Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-search me-2"></i>Search & Filters
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('schools.index') }}" id="filterForm">
                        <div class="row g-3">
                            <!-- Search -->
                            <div class="col-md-4">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="search" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search by name, code, email, city...">
                            </div>

                            <!-- Status Filter -->
                            <div class="col-md-2">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- City Filter -->
                            <div class="col-md-2">
                                <label for="city" class="form-label">City</label>
                                <select class="form-select" id="city" name="city">
                                    <option value="">All Cities</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- State Filter -->
                            <div class="col-md-2">
                                <label for="state" class="form-label">State</label>
                                <select class="form-select" id="state" name="state">
                                    <option value="">All States</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state }}" {{ request('state') === $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Country Filter -->
                            <div class="col-md-2">
                                <label for="country" class="form-label">Country</label>
                                <select class="form-select" id="country" name="country">
                                    <option value="">All Countries</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country }}" {{ request('country') === $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row g-3 mt-2">
                            <!-- Sort By -->
                            <div class="col-md-3">
                                <label for="sort_by" class="form-label">Sort By</label>
                                <select class="form-select" id="sort_by" name="sort_by">
                                    <option value="created_at" {{ request('sort_by', 'created_at') === 'created_at' ? 'selected' : '' }}>Created Date</option>
                                    <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Name</option>
                                    <option value="code" {{ request('sort_by') === 'code' ? 'selected' : '' }}>Code</option>
                                    <option value="city" {{ request('sort_by') === 'city' ? 'selected' : '' }}>City</option>
                                    <option value="state" {{ request('sort_by') === 'state' ? 'selected' : '' }}>State</option>
                                    <option value="status" {{ request('sort_by') === 'status' ? 'selected' : '' }}>Status</option>
                                    <option value="established_date" {{ request('sort_by') === 'established_date' ? 'selected' : '' }}>Established Date</option>
                                </select>
                            </div>

                            <!-- Sort Order -->
                            <div class="col-md-2">
                                <label for="sort_order" class="form-label">Order</label>
                                <select class="form-select" id="sort_order" name="sort_order">
                                    <option value="desc" {{ request('sort_order', 'desc') === 'desc' ? 'selected' : '' }}>Descending</option>
                                    <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Ascending</option>
                                </select>
                            </div>

                            <!-- Per Page -->
                            <div class="col-md-2">
                                <label for="per_page" class="form-label">Per Page</label>
                                <select class="form-select" id="per_page" name="per_page">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-md-5 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <a href="{{ route('schools.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Schools Table Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-school me-2"></i>Schools List
                        <span class="badge bg-primary ms-2">{{ $schools->total() }}</span>
                    </h5>
                    <div class="text-muted">
                        Showing {{ $schools->firstItem() }} to {{ $schools->lastItem() }} of {{ $schools->total() }} results
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($schools->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Logo</th>
                                    <th>School Details</th>
                                    <th>Contact Info</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Established</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schools as $school)
                                <tr>
                                    <td>
                                        @if($school->logo)
                                            <img src="{{ Storage::url($school->logo) }}" 
                                                 alt="{{ $school->name }}" 
                                                 class="img-thumbnail"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-school text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">{{ $school->name }}</h6>
                                            <small class="text-muted">Code: {{ $school->code }}</small>
                                            @if($school->website)
                                                <br><a href="{{ $school->website }}" target="_blank" class="text-decoration-none small">
                                                    <i class="fas fa-external-link-alt me-1"></i>Website
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($school->phone)
                                            <div class="small">
                                                <i class="fas fa-phone me-1"></i>{{ $school->phone }}
                                            </div>
                                        @endif
                                        @if($school->email)
                                            <div class="small">
                                                <i class="fas fa-envelope me-1"></i>{{ $school->email }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small">
                                            @if($school->city){{ $school->city }}<br>@endif
                                            @if($school->state){{ $school->state }}<br>@endif
                                            @if($school->country){{ $school->country }}@endif
                                        </div>
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>
                                        @if($school->established_date)
                                            {{ $school->established_date->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('schools.show', $school) }}" 
                                               class="btn btn-sm btn-outline-info"
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if(in_array(auth()->user()->role, ['super_admin', 'school_creator']) && 
                                                (auth()->user()->role === 'super_admin' || $school->modified_by === auth()->id()))
                                                <a href="{{ route('schools.edit', $school) }}" 
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Edit School">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                 @if(in_array(auth()->user()->role, ['super_admin']))
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $school->id }}"
                                                        title="Delete School">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                @if(in_array(auth()->user()->role, ['super_admin']) && 
                                    (auth()->user()->role === 'super_admin' || $school->modified_by === auth()->id()))
                                <div class="modal fade" id="deleteModal{{ $school->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete <strong>{{ $school->name }}</strong>?</p>
                                                <p class="text-danger small">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    This action cannot be undone. The school will be permanently removed from the system.
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('schools.destroy', $school) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash me-1"></i>Delete School
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-school fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No schools found</h5>
                        <p class="text-muted">Try adjusting your search criteria or add a new school.</p>
                        @if(in_array(auth()->user()->role, ['super_admin', 'school_creator']))
                        <a href="{{ route('schools.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add New School
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
                
                @if($schools->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $schools->firstItem() }} to {{ $schools->lastItem() }} of {{ $schools->total() }} results
                        </div>
                        <div>
                            {{ $schools->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter changes
    const filterSelects = document.querySelectorAll('#status, #city, #state, #country, #sort_by, #sort_order, #per_page');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Search with enter key
    document.getElementById('search').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('filterForm').submit();
        }
    });
});
</script>
@endsection