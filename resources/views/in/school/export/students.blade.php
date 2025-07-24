@extends('layouts.app')

@section('title', 'Export Students')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-download me-3 fs-4"></i>
                        <div>
                            <h4 class="mb-0 fw-bold">Export Students Data</h4>
                            <p class="mb-0 opacity-75">Generate and download student reports with advanced filtering options</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form id="exportForm" action="{{ route('school.export.students.export') }}" method="POST">
                        @csrf
                        
                        <!-- Export Format Selection -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold mb-3">
                                    <i class="fas fa-file-export me-2 text-primary"></i>Export Format
                                </label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-check form-check-card">
                                            <input class="form-check-input" type="radio" name="format" id="xlsx" value="xlsx" checked>
                                            <label class="form-check-label card h-100 p-3 text-center" for="xlsx">
                                                <i class="fas fa-file-excel text-success mb-2 fs-3"></i>
                                                <div class="fw-semibold">Excel (.xlsx)</div>
                                                <small class="text-muted">Best for data analysis</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-check-card">
                                            <input class="form-check-input" type="radio" name="format" id="csv" value="csv">
                                            <label class="form-check-label card h-100 p-3 text-center" for="csv">
                                                <i class="fas fa-file-csv text-info mb-2 fs-3"></i>
                                                <div class="fw-semibold">CSV (.csv)</div>
                                                <small class="text-muted">Universal compatibility</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-check-card">
                                            <input class="form-check-input" type="radio" name="format" id="pdf" value="pdf">
                                            <label class="form-check-label card h-100 p-3 text-center" for="pdf">
                                                <i class="fas fa-file-pdf text-danger mb-2 fs-3"></i>
                                                <div class="fw-semibold">PDF (.pdf)</div>
                                                <small class="text-muted">Print-ready format</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Filters -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <h5 class="mb-0 fw-semibold">
                                        <i class="fas fa-filter me-2 text-primary"></i>Advanced Filters
                                    </h5>
                                    <button type="button" class="btn btn-sm btn-outline-secondary ms-auto" id="toggleFilters">
                                        <i class="fas fa-chevron-down"></i> Show Filters
                                    </button>
                                </div>

                                <div id="filtersContainer" class="collapse">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <!-- Search -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="fas fa-search me-1"></i>Search
                                                    </label>
                                                    <input type="text" class="form-control" name="search" 
                                                           placeholder="Search by name or admission number...">
                                                </div>

                                                <!-- Grade Filter -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="fas fa-graduation-cap me-1"></i>Grade/Class
                                                    </label>
                                                    <select class="form-select" name="grade_id">
                                                        <option value="">All Grades</option>
                                                        @foreach($grades as $grade)
                                                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Section Filter -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="fas fa-users me-1"></i>Section
                                                    </label>
                                                    <select class="form-select" name="section_id">
                                                        <option value="">All Sections</option>
                                                        @foreach($sections as $section)
                                                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Status Filter -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="fas fa-toggle-on me-1"></i>Status
                                                    </label>
                                                    <select class="form-select" name="status">
                                                        <option value="">All Status</option>
                                                        <option value="active">Active</option>
                                                        <option value="graduated">Graduated</option>
                                                        <option value="transferred">Transferred</option>
                                                        <option value="suspended">Suspended</option>
                                                    </select>
                                                </div>

                                                <!-- Gender Filter -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="fas fa-venus-mars me-1"></i>Gender
                                                    </label>
                                                    <select class="form-select" name="gender">
                                                        <option value="">All Genders</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>

                                                <!-- Date Range -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="fas fa-calendar me-1"></i>Admission Date Range
                                                    </label>
                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <input type="date" class="form-control" name="date_from" placeholder="From">
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="date" class="form-control" name="date_to" placeholder="To">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3 pt-3 border-top">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" id="clearFilters">
                                                    <i class="fas fa-times me-1"></i>Clear All Filters
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Export Statistics -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info border-0 bg-info bg-opacity-10">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle text-info me-2"></i>
                                        <div>
                                            <strong>Export Information:</strong>
                                            <span id="exportInfo">All students will be exported with the selected filters.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-3 justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary btn-lg" id="previewBtn">
                                        <i class="fas fa-eye me-2"></i>Preview Data
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg px-4" id="exportBtn">
                                        <i class="fas fa-download me-2"></i>Export Students
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Data Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="previewContent" class="table-responsive">
                    <!-- Preview content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="proceedExport">
                    <i class="fas fa-download me-2"></i>Proceed with Export
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .form-check-card .form-check-input {
        position: absolute;
        opacity: 0;
    }
    
    .form-check-card .form-check-label {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e0e0e0;
    }
    
    .form-check-card .form-check-input:checked + .form-check-label {
        border-color: var(--bs-primary);
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 0.75rem 1rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25);
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.5rem 1.5rem;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .alert {
        border-radius: 10px;
    }
    
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleFiltersBtn = document.getElementById('toggleFilters');
    const filtersContainer = document.getElementById('filtersContainer');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const previewBtn = document.getElementById('previewBtn');
    const exportForm = document.getElementById('exportForm');
    
    // Toggle filters
    toggleFiltersBtn.addEventListener('click', function() {
        const isCollapsed = filtersContainer.classList.contains('show');
        if (isCollapsed) {
            filtersContainer.classList.remove('show');
            this.innerHTML = '<i class="fas fa-chevron-down"></i> Show Filters';
        } else {
            filtersContainer.classList.add('show');
            this.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Filters';
        }
    });
    
    // Clear all filters
    clearFiltersBtn.addEventListener('click', function() {
        exportForm.querySelectorAll('input[type="text"], input[type="date"], select').forEach(input => {
            if (input.type === 'text' || input.type === 'date') {
                input.value = '';
            } else if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            }
        });
    });
    
    // Preview functionality
    previewBtn.addEventListener('click', function() {
        // Show loading state
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading Preview...';
        this.disabled = true;
        
        // Simulate preview loading (replace with actual AJAX call)
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-eye me-2"></i>Preview Data';
            this.disabled = false;
            
            // Show preview modal
            const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
            previewModal.show();
            
            // Load preview content (you can replace this with actual data)
            document.getElementById('previewContent').innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading preview data...</p>
                </div>
            `;
        }, 1500);
    });
    
    // Proceed with export from preview
    document.getElementById('proceedExport').addEventListener('click', function() {
        bootstrap.Modal.getInstance(document.getElementById('previewModal')).hide();
        exportForm.submit();
    });
    
    // Form submission handling
    exportForm.addEventListener('submit', function(e) {
        const exportBtn = document.getElementById('exportBtn');
        exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating Export...';
        exportBtn.disabled = true;
        
        // Re-enable button after 3 seconds (adjust based on your needs)
        setTimeout(() => {
            exportBtn.innerHTML = '<i class="fas fa-download me-2"></i>Export Students';
            exportBtn.disabled = false;
        }, 3000);
    });
});
</script>
@endpush