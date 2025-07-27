<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Payments - School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .payment-status-paid { background: linear-gradient(135deg, #28a745, #20c997); }
        .payment-status-partial { background: linear-gradient(135deg, #ffc107, #fd7e14); }
        .payment-status-pending { background: linear-gradient(135deg, #dc3545, #e83e8c); }
        .payment-status-overdue { background: linear-gradient(135deg, #6f42c1, #e83e8c); }
        
        .stats-card {
            border-left: 4px solid;
            transition: all 0.3s ease;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .payment-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .payment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .balance-amount {
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .filter-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 25px;
            color: white;
            margin-bottom: 25px;
        }
        
        .quick-actions {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border-radius: 15px;
            padding: 20px;
            color: white;
        }
        
        .michango-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        
        .payment-method-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }
        
        .table-modern {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .table-modern thead {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .table-modern tbody tr:hover {
            background-color: #f8f9ff;
            transform: scale(1.01);
            transition: all 0.2s ease;
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
                        <h2 class="mb-1">
                            <i class="fas fa-wallet text-primary me-2"></i>
                            Student Payments
                        </h2>
                        <p class="text-muted mb-0">
                            Manage student fee payments, bills, and michango for {{ $currentAcademicYear->name ?? 'Current' }} Academic Year
                        </p>
                    </div>
                    <div class="quick-actions">
                        <button class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#generateRequirementsModal">
                            <i class="fas fa-cogs me-1"></i>Generate Requirements
                        </button>
                        <button class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#recordPaymentModal">
                            <i class="fas fa-plus me-1"></i>Record Payment
                        </button>
                        <button class="btn btn-outline-light btn-sm" onclick="exportPayments()">
                            <i class="fas fa-download me-1"></i>Export
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card border-0" style="border-left-color: #28a745!important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="text-success mb-1">{{ number_format($stats['total_students']) }}</h3>
                                <p class="text-muted mb-0">Total Students</p>
                            </div>
                            <div class="text-success opacity-75">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card border-0" style="border-left-color: #17a2b8!important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="text-info mb-1">TZS {{ number_format($stats['total_collected']) }}</h3>
                                <p class="text-muted mb-0">Total Collected</p>
                            </div>
                            <div class="text-info opacity-75">
                                <i class="fas fa-money-bill-wave fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card border-0" style="border-left-color: #ffc107!important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="text-warning mb-1">TZS {{ number_format($stats['total_outstanding']) }}</h3>
                                <p class="text-muted mb-0">Outstanding Balance</p>
                            </div>
                            <div class="text-warning opacity-75">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card border-0" style="border-left-color: #dc3545!important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="text-danger mb-1">{{ $stats['students_with_pending'] }}</h3>
                                <p class="text-muted mb-0">Pending Payments</p>
                            </div>
                            <div class="text-danger opacity-75">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search Students</label>
                    <input type="text" class="form-control bg-white bg-opacity-20 border-0 text-white placeholder-white-50" 
                           name="search" value="{{ request('search') }}" placeholder="Name or admission number...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Grade Level</label>
                    <select name="grade_id" class="form-select bg-white bg-opacity-20 border-0 text-white">
                        <option value="">All Grades</option>
                        @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                            {{ $grade->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Payment Status</label>
                    <select name="payment_status" class="form-select bg-white bg-opacity-20 border-0 text-white">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="overdue" {{ request('payment_status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('student-payments.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-times me-1"></i>Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Students Payment Table -->
        <div class="card table-modern border-0">
            <div class="card-header bg-transparent border-0 py-3">
                <h5 class="mb-0">Student Payment Status ({{ $students->total() }} Students)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="border-0">Student</th>
                                <th class="border-0">Grade & Section</th>
                                <th class="border-0">Payment Summary</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Last Payment</th>
                                <th class="border-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            @php
                                $totalRequired = $student->paymentRequirements->sum('required_amount');
                                $totalPaid = $student->paymentRequirements->sum('paid_amount');
                                $totalBalance = $student->paymentRequirements->sum('balance');
                                $overdue = $student->paymentRequirements->where('status', 'overdue')->count();
                                $pending = $student->paymentRequirements->whereIn('status', ['pending', 'partial'])->count();
                                
                                $statusClass = 'success';
                                $statusText = 'Fully Paid';
                                if ($totalBalance > 0) {
                                    if ($overdue > 0) {
                                        $statusClass = 'danger';
                                        $statusText = 'Overdue';
                                    } elseif ($totalPaid > 0) {
                                        $statusClass = 'warning';
                                        $statusText = 'Partial';
                                    } else {
                                        $statusClass = 'info';
                                        $statusText = 'Pending';
                                    }
                                }
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="student-avatar me-3">
                                            {{ strtoupper(substr($student->fname, 0, 1) . substr($student->lname, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $student->fname }} {{ $student->lname }}</h6>
                                            <small class="text-muted">{{ $student->admission_number }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span class="badge bg-primary">{{ $student->grade->name ?? 'N/A' }}</span>
                                        @if($student->section)
                                        <br><small class="text-muted">{{ $student->section->name }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="d-flex justify-content-between">
                                            <span>Required:</span>
                                            <strong>TZS {{ number_format($totalRequired) }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between text-success">
                                            <span>Paid:</span>
                                            <span>TZS {{ number_format($totalPaid) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between balance-amount {{ $totalBalance > 0 ? 'text-danger' : 'text-success' }}">
                                            <span>Balance:</span>
                                            <span>TZS {{ number_format($totalBalance) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                    @if($pending > 0)
                                    <br><small class="text-muted">{{ $pending }} pending</small>
                                    @endif
                                </td>
                                <td>
                                    @if($student->payments->count() > 0)
                                    @php $lastPayment = $student->payments->first(); @endphp
                                    <div class="small">
                                        <div>TZS {{ number_format($lastPayment->amount) }}</div>
                                        <div class="text-muted">{{ $lastPayment->payment_date->format('M d, Y') }}</div>
                                        <div class="d-flex align-items-center">
                                            <span class="payment-method-icon bg-primary text-white">
                                                <i class="fas fa-{{ $lastPayment->payment_method == 'cash' ? 'money-bill' : ($lastPayment->payment_method == 'mobile_money' ? 'mobile' : 'credit-card') }}"></i>
                                            </span>
                                            <small>{{ ucfirst(str_replace('_', ' ', $lastPayment->payment_method)) }}</small>
                                        </div>
                                    </div>
                                    @else
                                    <small class="text-muted">No payments yet</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('student-payments.show', $student) }}" 
                                           class="btn btn-outline-primary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-outline-success" 
                                                onclick="recordPayment({{ $student->user_id }})" title="Record Payment">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <a href="{{ route('student-payments.history', $student) }}" 
                                           class="btn btn-outline-info" title="Payment History">
                                            <i class="fas fa-history"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h5>No students found</h5>
                                        <p>Try adjusting your filters or check if students are enrolled.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($students->hasPages())
            <div class="card-footer bg-transparent">
                {{ $students->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Generate Requirements Modal -->
    <div class="modal fade" id="generateRequirementsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Payment Requirements</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('student-payments.generate-requirements') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Academic Year</label>
                                <select name="academic_year_id" class="form-select" required>
                                    @if($currentAcademicYear)
                                    <option value="{{ $currentAcademicYear->id }}" selected>{{ $currentAcademicYear->name }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Target Grades</label>
                                <select name="grade_ids[]" class="form-select" multiple required>
                                    @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Hold Ctrl to select multiple grades</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Payment Categories (Optional)</label>
                            <div class="row" id="paymentCategoriesContainer">
                                <!-- Categories will be loaded via AJAX -->
                            </div>
                            <small class="text-muted">Leave empty to generate requirements for all applicable categories</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-cogs me-1"></i>Generate Requirements
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Record Payment Modal -->
    <div class="modal fade" id="recordPaymentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Record Student Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="recordPaymentForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Select Student</label>
                                <select name="student_id" class="form-select" required id="studentSelect">
                                    <option value="">Choose student...</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->user_id }}">
                                        {{ $student->fname }} {{ $student->lname }} ({{ $student->admission_number }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Category</label>
                                <select name="payment_category_id" class="form-select" required id="paymentCategorySelect">
                                    <option value="">Select category...</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label class="form-label">Amount (TZS)</label>
                                <input type="number" name="amount" class="form-control" step="0.01" min="0.01" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Payment Date</label>
                                <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Payment Method</label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="card">Card</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Reference Number</label>
                                <input type="text" name="payment_reference_number" class="form-control" 
                                       placeholder="Transaction/Receipt number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Notes</label>
                                <textarea name="payment_notes" class="form-control" rows="2" 
                                          placeholder="Additional notes..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Record Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Michango Payment Modal -->
    <div class="modal fade" id="michangoPaymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Record Michango Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="michangoPaymentForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Michango Category</label>
                            <select name="michango_category_id" class="form-select" required>
                                <option value="">Select michango...</option>
                                <!-- Options loaded via AJAX -->
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Amount (TZS)</label>
                                <input type="number" name="amount" class="form-control" step="0.01" min="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Date</label>
                                <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Payment Method</label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="card">Card</option>
                                    <option value="in_kind">In Kind</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Reference Number</label>
                                <input type="text" name="payment_reference_number" class="form-control">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Description</label>
                            <textarea name="payment_description" class="form-control" rows="2" 
                                      placeholder="Payment description (especially for in-kind contributions)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-hands-helping me-1"></i>Record Michango
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CSRF token setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Record payment for specific student
        function recordPayment(studentId) {
            const modal = new bootstrap.Modal(document.getElementById('recordPaymentModal'));
            const form = document.getElementById('recordPaymentForm');
            const studentSelect = document.getElementById('studentSelect');
            
            // Set the student
            studentSelect.value = studentId;
            
            // Load payment categories for this student
            loadPaymentCategories(studentId);
            
            // Set form action
            form.action = `/student-payments/${studentId}/record-payment`;
            
            modal.show();
        }

        // Load payment categories based on selected student
        document.getElementById('studentSelect').addEventListener('change', function() {
            if (this.value) {
                loadPaymentCategories(this.value);
                document.getElementById('recordPaymentForm').action = `/student-payments/${this.value}/record-payment`;
            }
        });

        function loadPaymentCategories(studentId) {
            const categorySelect = document.getElementById('paymentCategorySelect');
            categorySelect.innerHTML = '<option value="">Loading...</option>';
            
            fetch(`/student-payments/${studentId}/payment-categories`)
                .then(response => response.json())
                .then(data => {
                    categorySelect.innerHTML = '<option value="">Select category...</option>';
                    data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = `${category.name} (Balance: TZS ${category.balance.toLocaleString()})`;
                        categorySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                    categorySelect.innerHTML = '<option value="">Error loading categories</option>';
                });
        }

        // Export payments
        function exportPayments() {
            const params = new URLSearchParams(window.location.search);
            window.location.href = `/student-payments/export?${params.toString()}`;
        }

        // Load payment categories for generate requirements modal
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/payment/categories/active')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('paymentCategoriesContainer');
                    data.forEach(category => {
                        const checkbox = `
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category_ids[]" 
                                           value="${category.id}" id="category_${category.id}">
                                    <label class="form-check-label" for="category_${category.id}">
                                        ${category.name} (${category.category})
                                    </label>
                                </div>
                            </div>
                        `;
                        container.innerHTML += checkbox;
                    });
                })
                .catch(error => console.error('Error loading categories:', error));
        });

        // Auto-refresh every 5 minutes to show updated payment status
        setInterval(function() {
            if (document.visibilityState === 'visible') {
                location.reload();
            }
        }, 300000); // 5 minutes

        // Success/Error message handling
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
                alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                alert.innerHTML = `
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alert);
                
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 5000);
            });
        @endif

        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                alert.innerHTML = `
                    <strong>Error:</strong><br>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alert);
            });
        @endif
    </script>
</body>
</html>