@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-receipt me-2"></i>Payment Receipt
                </h4>
                <div>
                    <a href="{{ route('fee-payments.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i>Back to List
                    </a>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print me-1"></i>Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow" id="receipt">
                <!-- Receipt Header -->
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0">Payment Receipt</h3>
                    <p class="mb-0">{{ $payment->fee->school->name ?? 'School Name' }}</p>
                </div>

                <div class="card-body p-4">
                    <!-- Receipt Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">RECEIPT INFORMATION</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="fw-bold">Receipt No:</td>
                                    <td>#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Payment Date:</td>
                                    <td>{{ $payment->payment_date ? $payment->payment_date->format('F d, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Reference:</td>
                                    <td>{{ $payment->reference ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Payment Method:</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">RECEIVED BY</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-secondary text-white rounded-circle me-3">
                                    {{ substr($payment->receivedBy->name ?? 'N/A', 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $payment->receivedBy->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $payment->receivedBy->email ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="border rounded p-3 bg-light">
                                <h6 class="text-muted mb-3">STUDENT INFORMATION</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar avatar-md bg-primary text-white rounded-circle me-3">
                                                {{ substr($payment->student->name ?? 'N/A', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $payment->student->name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $payment->student->email ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td class="fw-bold">Student ID:</td>
                                                <td>{{ $payment->student->student_id ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Class/Grade:</td>
                                                <td>{{ $payment->student->class ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fee Structure Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-3">FEE DETAILS</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fee Structure</th>
                                            <th>Academic Year</th>
                                            <th>Frequency</th>
                                            <th>Total Amount</th>
                                            <th>Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $payment->fee->name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $payment->fee->description ?? '' }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $payment->fee->academicYear->name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>{{ ucfirst($payment->fee->frequency ?? 'N/A') }}</td>
                                            <td class="fw-bold text-primary">
                                                ${{ number_format($payment->fee->amount ?? 0, 2) }}
                                            </td>
                                            <td>{{ $payment->fee->due_date ? $payment->fee->due_date->format('M d, Y') : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">PAYMENT SUMMARY</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold">Payment Amount:</td>
                                                    <td class="text-end fw-bold text-success fs-4">
                                                        ${{ number_format($payment->amount_paid, 2) }}
                                                    </td>
                                                </tr>
                                                @if($payment->note)
                                                <tr>
                                                    <td class="fw-bold">Note:</td>
                                                    <td class="text-end">{{ $payment->note }}</td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <div class="bg-success text-white rounded p-3">
                                                <h4 class="mb-0">PAID</h4>
                                                <small>{{ $payment->payment_date->format('M d, Y') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status for this Fee Structure -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">OVERALL PAYMENT STATUS FOR THIS FEE</h6>
                                </div>
                                <div class="card-body" id="paymentStatus">
                                    <div class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Loading payment status...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="row">
                        <div class="col-12">
                            <div class="border-top pt-3 mt-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            Generated on: {{ now()->format('F d, Y \a\t h:i A') }}
                                        </small>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small class="text-muted">
                                            This is a computer-generated receipt
                                        </small>
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
@endsection

@push('styles')
<style>
    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
    
    .avatar-md {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
    
    .avatar-lg {
        width: 48px;
        height: 48px;
        font-size: 18px;
    }
    
    @media print {
        .btn, .d-flex .btn {
            display: none !important;
        }
        
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        
        .container-fluid {
            padding: 0 !important;
        }
        
        body {
            font-size: 12px;
        }
        
        .card-header {
            background-color: #0d6efd !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
        }
        
        .bg-success, .bg-info, .bg-primary {
            -webkit-print-color-adjust: exact;
        }
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
    }
    
    .border-success {
        border-color: #198754 !important;
    }
    
    .border-info {
        border-color: #0dcaf0 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadPaymentStatus();
    });
    
    function loadPaymentStatus() {
        const studentId = {{ $payment->student_id }};
        const feeStructureId = {{ $payment->fee_structure_id }};
        
        fetch(`{{ route('fee-payments.student.payment-summary') }}?student_id=${studentId}&fee_structure_id=${feeStructureId}`)
            .then(response => response.json())
            .then(data => {
                updatePaymentStatus(data);
            })
            .catch(error => {
                console.error('Error loading payment status:', error);
                document.getElementById('paymentStatus').innerHTML = `
                    <div class="text-center text-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Error loading payment status</p>
                    </div>
                `;
            });
    }
    
    function updatePaymentStatus(data) {
        const totalAmount = parseFloat(data.total_amount || 0);
        const totalPaid = parseFloat(data.total_paid || 0);
        const remainingAmount = parseFloat(data.remaining_amount || 0);
        const percentage = totalAmount > 0 ? (totalPaid / totalAmount) * 100 : 0;
        
        let status = 'Not Paid';
        let statusClass = 'danger';
        
        if (totalPaid >= totalAmount) {
            status = 'Fully Paid';
            statusClass = 'success';
        } else if (totalPaid > 0) {
            status = 'Partially Paid';
            statusClass = 'warning';
        }
        
        const statusHtml = `
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold">Total Fee Amount:</td>
                            <td class="text-end fw-bold">${totalAmount.toFixed(2)}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Total Amount Paid:</td>
                            <td class="text-end fw-bold text-success">${totalPaid.toFixed(2)}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Remaining Amount:</td>
                            <td class="text-end fw-bold text-${remainingAmount > 0 ? 'danger' : 'success'}">
                                ${remainingAmount.toFixed(2)}
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Payment Status:</td>
                            <td class="text-end">
                                <span class="badge bg-${statusClass} fs-6">${status}</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-${statusClass}" role="progressbar" 
                                style="width: ${percentage}%" 
                                aria-valuenow="${percentage}" aria-valuemin="0" aria-valuemax="100">
                                ${percentage.toFixed(1)}%
                            </div>
                        </div>
                        <small class="text-muted">Payment Progress</small>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('paymentStatus').innerHTML = statusHtml;
    }
</script>
@endpush