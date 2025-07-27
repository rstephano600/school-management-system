<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Categories - School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .category-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .audit-info {
            font-size: 0.8rem;
            color: #6c757d;
        }
        .table-actions {
            white-space: nowrap;
        }
        .filter-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stats-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1"><i class="fas fa-money-bill-wave text-primary me-2"></i>Payment Categories</h2>
                        <p class="text-muted mb-0">Manage school fee structures and payment categories</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#quickAddModal">
                            <i class="fas fa-magic me-1"></i>Quick Add
                        </button>
                        <a href="{{ route('payment.categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Add Category
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card border-0 shadow-sm" style="border-left-color: #28a745!important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title text-success mb-1">{{ $paymentCategories->where('category', 'fees')->count() }}</h5>
                                <p class="card-text text-muted mb-0">School Fees</p>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-graduation-cap fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card border-0 shadow-sm" style="border-left-color: #17a2b8!important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title text-info mb-1">{{ $paymentCategories->where('category', 'bills')->count() }}</h5>
                                <p class="card-text text-muted mb-0">Bills & Services</p>
                            </div>
                            <div class="text-info">
                                <i class="fas fa-file-invoice fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card border-0 shadow-sm" style="border-left-color: #ffc107!important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title text-warning mb-1">{{ $paymentCategories->where('category', 'michango')->count() }}</h5>
                                <p class="card-text text-muted mb-0">Michango</p>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-hands-helping fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card border-0 shadow-sm" style="border-left-color: #6f42c1!important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title text-primary mb-1">{{ $paymentCategories->where('is_active', true)->count() }}</h5>
                                <p class="card-text text-muted mb-0">Active Categories</p>
                            </div>
                            <div class="text-primary">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card filter-card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Search</label>
                        <input type="text" class="form-control bg-white bg-opacity-20 border-0 text-white placeholder-white-50" 
                               name="search" value="{{ request('search') }}" placeholder="Search categories...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select bg-white bg-opacity-20 border-0 text-white">
                            <option value="">All Categories</option>
                            <option value="fees" {{ request('category') == 'fees' ? 'selected' : '' }}>Fees</option>
                            <option value="bills" {{ request('category') == 'bills' ? 'selected' : '' }}>Bills</option>
                            <option value="michango" {{ request('category') == 'michango' ? 'selected' : '' }}>Michango</option>
                            <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select bg-white bg-opacity-20 border-0 text-white">
                            <option value="">All Types</option>
                            <option value="mandatory" {{ request('type') == 'mandatory' ? 'selected' : '' }}>Mandatory</option>
                            <option value="optional" {{ request('type') == 'optional' ? 'selected' : '' }}>Optional</option>
                            <option value="conditional" {{ request('type') == 'conditional' ? 'selected' : '' }}>Conditional</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-light">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('payment.categories.index') }}" class="btn btn-outline-light">
                                <i class="fas fa-times me-1"></i>Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Categories Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Payment Categories ({{ $paymentCategories->total() }})</h5>
                    <div>
                        <button class="btn btn-sm btn-outline-success" onclick="bulkToggleStatus(true)">
                            <i class="fas fa-check me-1"></i>Activate Selected
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="bulkToggleStatus(false)">
                            <i class="fas fa-ban me-1"></i>Deactivate Selected
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                <th>Category Details</th>
                                <th>Type & Frequency</th>
                                <th>Applicable Grades</th>
                                <th>Amount</th>
                                <th>Requirements</th>
                                <th>Status</th>
                                <th>Audit Info</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paymentCategories as $category)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input category-checkbox" 
                                           value="{{ $category->id }}">
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ $category->name }}</h6>
                                        <small class="text-muted">{{ $category->code }}</small>
                                        @if($category->description)
                                        <br><small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge category-badge
                                        @if($category->category == 'fees') bg-success
                                        @elseif($category->category == 'bills') bg-info
                                        @elseif($category->category == 'michango') bg-warning
                                        @else bg-secondary @endif">
                                        {{ ucfirst($category->category) }}
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        {{ ucfirst($category->type) }} • {{ ucfirst($category->payment_frequency) }}
                                    </small>
                                </td>
                                <td>
                                    @if($category->applicable_grades)
                                        @php
                                            $grades = $gradelevels->whereIn('id', $category->applicable_grades)->pluck('name');
                                        @endphp
                                        <small class="text-muted">{{ $grades->implode(', ') }}</small>
                                    @else
                                        <small class="text-muted">All Grades</small>
                                    @endif
                                </td>
                                <td>
                                    @if($category->default_amount)
                                        <strong>TZS {{ number_format($category->default_amount) }}</strong>
                                    @else
                                        <small class="text-muted">Variable</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @if($category->required_at_registration)
                                        <span class="badge bg-danger category-badge">Registration Required</span>
                                        @endif
                                        @if($category->required_at_grade_entry)
                                        <span class="badge bg-warning category-badge">Grade Entry Required</span>
                                        @endif
                                        @if(!$category->required_at_registration && !$category->required_at_grade_entry)
                                        <small class="text-muted">No special requirements</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="audit-info">
                                        <small>Created by: {{ $category->createdBy->name }}</small><br>
                                        <small>{{ $category->created_at->format('M d, Y') }}</small>
                                        @if($category->updatedBy)
                                        <br><small>Updated by: {{ $category->updatedBy->name }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td class="table-actions">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('payment.categories.show', $category) }}" 
                                           class="btn btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('payment.categories.setup-fees', $category) }}" 
                                           class="btn btn-outline-success" title="Setup Fees">
                                            <i class="fas fa-money-bill"></i>
                                        </a>
                                        <a href="{{ route('payment.categories.edit', $category) }}" 
                                           class="btn btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" 
                                                onclick="confirmDelete({{ $category->id }})" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-money-bill-wave fa-3x mb-3"></i>
                                        <h5>No payment categories found</h5>
                                        <p>Start by creating your first payment category.</p>
                                        <a href="{{ route('payment.categories.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i>Add Category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($paymentCategories->hasPages())
            <div class="card-footer">
                {{ $paymentCategories->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Add Modal -->
    <div class="modal fade" id="quickAddModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Add Common Categories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-success">School Fees</h6>
                            <div id="fees-categories" class="mb-3"></div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info">Bills & Services</h6>
                            <div id="bills-categories" class="mb-3"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-warning">Michango (Contributions)</h6>
                            <div id="michango-categories" class="mb-3"></div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-secondary">Other Categories</h6>
                            <div id="other-categories" class="mb-3"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addSelectedCategories()">
                        <i class="fas fa-plus me-1"></i>Add Selected
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this payment category? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Select all functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

        // Load common categories for quick add
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/payment/categories/common')
                .then(response => response.json())
                .then(data => {
                    populateQuickAddCategories(data);
                });
        });

        function populateQuickAddCategories(categories) {
            Object.keys(categories).forEach(type => {
                const container = document.getElementById(`${type}-categories`);
                categories[type].forEach(category => {
                    const checkbox = `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="${category.code}" 
                                   id="${category.code}" data-name="${category.name}" data-type="${type}">
                            <label class="form-check-label" for="${category.code}">
                                ${category.name}
                            </label>
                        </div>
                    `;
                    container.innerHTML += checkbox;
                });
            });
        }

        function addSelectedCategories() {
            const selectedCategories = [];
            document.querySelectorAll('#quickAddModal input[type="checkbox"]:checked').forEach(checkbox => {
                selectedCategories.push({
                    name: checkbox.dataset.name,
                    code: checkbox.value,
                    category: checkbox.dataset.type
                });
            });

            if (selectedCategories.length === 0) {
                alert('Please select at least one category to add.');
                return;
            }

            // Here you would typically make an AJAX request to add the categories
            // For now, we'll redirect to the create page with pre-filled data
            const params = new URLSearchParams();
            selectedCategories.forEach((cat, index) => {
                params.append(`categories[${index}][name]`, cat.name);
                params.append(`categories[${index}][code]`, cat.code);
                params.append(`categories[${index}][category]`, cat.category);
            });
            
            window.location.href = `/payment/categories/create?${params.toString()}`;
        }

        function confirmDelete(categoryId) {
            const form = document.getElementById('deleteForm');
            form.action = `/payment/categories/${categoryId}`;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        function bulkToggleStatus(status) {
            const selectedIds = [];
            document.querySelectorAll('.category-checkbox:checked').forEach(checkbox => {
                selectedIds.push(checkbox.value);
            });

            if (selectedIds.length === 0) {
                alert('Please select at least one category.');
                return;
            }

            fetch('/payment/categories/bulk-toggle-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    category_ids: selectedIds,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    </script>
</body>
</html>