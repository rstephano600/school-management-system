@extends('layouts.app')

@section('title', 'Fee Payments Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-money-bill-wave me-2"></i>Fee Payments Management
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <form method="GET" action="{{ route('fee-payments.index') }}" id="filterForm">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">
                                            <i class="fas fa-filter me-2"></i>Search & Filter Options
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- Academic Year Filter -->
                                            <div class="col-md-3">
                                                <label for="academic_year_id" class="form-label">Academic Year</label>
                                                <select class="form-select" name="academic_year_id" id="academic_year_id">
                                                    <option value="">All Academic Years</option>
                                                    @foreach($academicYears as $year)
                                                        <option value="{{ $year->id }}" 
                                                            {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                                                            {{ $year->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <!-- School Filter -->
                                            <div class="col-md-3">
                                                <label for="school_id" class="form-label">School</label>
                                                <select class="form-select" name="school_id" id="school_id">
                                                    <option value="">All Schools</option>
                                                    @foreach($schools as $school)
                                                        <option value="{{ $school->id }}" 
                                                            {{ request('school_id') == $school->id ? 'selected' : '' }}>
                                                            {{ $school->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Fee Structure Filter -->
                                            <div class="col-md-3">
                                                <label for="fee_structure_id" class="form-label">Fee Structure</label>
                                                <select class="form-select" name="fee_structure_id" id="fee_structure_id">
                                                    <option value="">All Fee Structures</option>
                                                    @foreach($feeStructures as $fee)
                                                        <option value="{{ $fee->id }}" 
                                                            {{ request('fee_structure_id') == $fee->id ? 'selected' : '' }}>
                                                            {{ $fee->name }} ({{ $fee->academicYear->name ?? 'N/A' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Payment Method Filter -->
                                            <div class="col-md-3">
                                                <label for="payment_method" class="form-label">Payment Method</label>
                                                <select class="form-select" name="payment_method" id="payment_method">
                                                    <option value="">All Methods</option>
                                                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                                    <option value="mobile_money" {{ request('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                                    <option value="cheque" {{ request('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                                    <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                                </select>
                                            </div>

                                            <!-- Student Search -->
                                            <div class="col-md-4">
                                                <label for="student_search" class="form-label">Student Search</label>
                                                <input type="text" class="form-control" name="student_search" id="student_search"
                                                    placeholder="Search by name or email..."
                                                    value="{{ request('student_search') }}">
                                            </div>

                                            <!-- Date From -->
                                            <div class="col-md-4">
                                                <label for="date_from" class="form-label">Date From</label>
                                                <input type="date" class="form-control" name="date_from" id="date_from"
                                                    value="{{ request('date_from') }}">
                                            </div>

                                            <!-- Date To -->
                                            <div class="col-md-4">
                                                <label for="date_to" class="form-label">Date To</label>
                                                <input type="date" class="form-control" name="date_to" id="date_to"
                                                    value="{{ request('date_to') }}">
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary me-2">
                                                    <i class="fas fa-search me-1"></i>Search
                                                </button>
                                                <a href="{{ route('fee-payments.index') }}" class="btn btn-secondary me-2">
                                                    <i class="fas fa-times me-1"></i>Clear Filters
                                                </a>
                                                <button type="button" class="btn btn-success" onclick="exportData()">
                                                    <i class="fas fa-download me-1"></i>Export
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Statistics Summary -->
                    @if($paymentStats->count() > 0)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-chart-bar me-2"></i>Payment Statistics
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Student</th>
                                                    <th>Fee Structure</th>
                                                    <th>Total Amount</th>
                                                    <th>Amount Paid</th>
                                                    <th>Remaining Amount</th>
                                                    <th>Payment Status</th>
                                                    <th>Progress</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($paymentStats as $stat)
                                                <tr>
                                                    <td>{{ $stat->student_name }}</td>
                                                    <td>{{ $stat->fee_name }}</td>
                                                    <td>
                                                        <span class="fw-bold text-primary">
                                                            ${{ number_format($stat->total_amount, 2) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">
                                                            ${{ number_format($stat->total_paid, 2) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold {{ $stat->remaining_amount > 0 ? 'text-danger' : 'text-success' }}">
                                                            ${{ number_format($stat->remaining_amount, 2) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusClass = match($stat->payment_status) {
                                                                'Fully Paid' => 'badge bg-success',
                                                                'Partially Paid' => 'badge bg-warning',
                                                                'Not Paid' => 'badge bg-danger',
                                                                default => 'badge bg-secondary'
                                                            };
                                                        @endphp
                                                        <span class="{{ $statusClass }}">{{ $stat->payment_status }}</span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $percentage = $stat->total_amount > 0 ? ($stat->total_paid / $stat->total_amount) * 100 : 0;
                                                        @endphp
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar bg-success" role="progressbar" 
                                                                style="width: {{ $percentage }}%" 
                                                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                                {{ number_format($percentage, 1) }}%
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3">
    {{ $paymentStats->links('pagination::bootstrap-5') }}
</div>


                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Payment Records Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-list me-2"></i>Payment Records ({{ $payments->total() }} records)
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @if($payments->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Student</th>
                                                        <th>Fee Structure</th>
                                                        <th>Academic Year</th>
                                                        <th>Amount Paid</th>
                                                        <th>Payment Date</th>
                                                        <th>Method</th>
                                                        <th>Reference</th>
                                                        <th>Received By</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($payments as $payment)
                                                    <tr>
                                                        <td>{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-sm bg-primary text-white rounded-circle me-2">
                                                                    {{ substr($payment->student->name ?? 'N/A', 0, 1) }}
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bold">{{ $payment->student->name ?? 'N/A' }}</div>
                                                                    <small class="text-muted">{{ $payment->student->email ?? 'N/A' }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="fw-bold">{{ $payment->fee->name ?? 'N/A' }}</div>
                                                            <small class="text-muted">{{ $payment->fee->description ?? '' }}</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-info">
                                                                {{ $payment->fee->academicYear->name ?? 'N/A' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="fw-bold text-success">
                                                                ${{ number_format($payment->amount_paid, 2) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</td>
                                                        <td>
                                                            @php
                                                                $methodClass = match($payment->method) {
                                                                    'cash' => 'badge bg-success',
                                                                    'bank_transfer' => 'badge bg-primary',
                                                                    'mobile_money' => 'badge bg-warning',
                                                                    'cheque' => 'badge bg-info',
                                                                    'card' => 'badge bg-secondary',
                                                                    default => 'badge bg-light text-dark'
                                                                };
                                                            @endphp
                                                            <span class="{{ $methodClass }}">
                                                                {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <small class="text-muted">{{ $payment->reference ?? 'N/A' }}</small>
                                                        </td>
                                                        <td>{{ $payment->receivedBy->name ?? 'N/A' }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('fee-payments.show', $payment->id) }}" 
                                                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-sm btn-outline-info" 
                                                                        onclick="printReceipt({{ $payment->id }})" title="Print Receipt">
                                                                    <i class="fas fa-print"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div>
                                                <small class="text-muted">
                                                    Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} 
                                                    of {{ $payments->total() }} results
                                                </small>
                                            </div>
                                            <div>
                                                {{ $payments->appends(request()->query())->links('pagination::bootstrap-5') }}
                                            </div>

                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No payment records found</h5>
                                            <p class="text-muted">Try adjusting your search criteria or filters.</p>
                                        </div>
                                    @endif
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

@push('styles')
<style>
    .avatar {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
    }
    
    .progress {
        min-width: 100px;
    }
    
    .card-header h6 {
        margin: 0;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function exportData() {
        // Get current form data
        const form = document.getElementById('filterForm');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        
        // Add export parameter
        params.append('export', 'true');
        
        // Create download URL
        const exportUrl = '{{ route("fee-payments.export") }}?' + params.toString();
        
        // Trigger download
        window.open(exportUrl, '_blank');
    }
    
    function printReceipt(paymentId) {
        // Open receipt in new window for printing
        const receiptUrl = '{{ route("fee-payments.show", ":id") }}'.replace(':id', paymentId) + '?print=true';
        window.open(receiptUrl, '_blank', 'width=800,height=600');
    }
    
    // Auto-submit form when academic year or school changes
    document.getElementById('academic_year_id').addEventListener('change', function() {
        // Update fee structures based on selected academic year
        updateFeeStructures();
    });
    
    document.getElementById('school_id').addEventListener('change', function() {
        // Update fee structures based on selected school
        updateFeeStructures();
    });
    
    function updateFeeStructures() {
        const academicYearId = document.getElementById('academic_year_id').value;
        const schoolId = document.getElementById('school_id').value;
        const feeStructureSelect = document.getElementById('fee_structure_id');
        
        // You can implement AJAX call here to filter fee structures
        // based on selected academic year and school
    }
    
    // Add loading states for better UX
    document.getElementById('filterForm').addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Searching...';
        submitBtn.disabled = true;
    });
</script>
@endpush