@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<div class="container">
    <h1 class="mb-4">Student: {{ $student->user->name }}</h1>

    <!-- Toggle Buttons -->
    <div class="mb-4 d-flex flex-wrap gap-2">
        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#personalInfo">
            Personal Info
        </button>
        <button class="btn btn-outline-info" type="button" data-bs-toggle="collapse" data-bs-target="#parentInfo">
            Parent Info
        </button>
        <button class="btn btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#feesStructure">
            Fees Structure
        </button>
        <button class="btn btn-outline-warning" type="button" data-bs-toggle="collapse" data-bs-target="#academicRecords">
            Academic Records
        </button>
        <button class="btn btn-outline-danger" type="button" data-bs-toggle="collapse" data-bs-target="#behaviourRecords">
            Behaviour Records
        </button>
<a href="{{ route('students.assessments.summary', $student->user_id) }}" class="btn btn-outline-primary mt-2">
    View Assessment Summary
</a>

                    <!-- Grade Progress -->
<div class="collaps" id="gradeHistory">
    <div class="card mb-3">
        <div class="card-header bg-indigo text-white d-flex justify-content-between align-items-center">
            <span>Grade Level History</span>
            <a href="{{ route('student.grades.promote', $student->user_id) }}" class="btn btn-sm btn-light">
                <i class="fas fa-arrow-up"></i> Promote Now
            </a>
        </div>
        <div class="card-body">
            <a href="{{ route('student.grades.index', $student->user_id) }}" class="btn btn-outline-primary">
                View Grade History
            </a>
        </div>
    </div>
</div>
    </div>

<!-- Personal Information -->
<div class="collapse" id="personalInfo">
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-user"></i> Personal Information
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label"><strong>Email</strong></label>
                    <div class="form-control bg-light">{{ $student->user->email }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Admission Number</strong></label>
                    <div class="form-control bg-light">{{ $student->admission_number ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Admission Date</strong></label>
                    <div class="form-control bg-light">{{ $student->admission_date->format('d M Y') }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Date of Birth</strong></label>
                    <div class="form-control bg-light">{{ $student->date_of_birth->format('d M Y') }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Grade</strong></label>
                    <div class="form-control bg-light">{{ $student->grade->name ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Section</strong></label>
                    <div class="form-control bg-light">{{ $student->section->name ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Gender</strong></label>
                    <div class="form-control bg-light">{{ ucfirst($student->gender) }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Blood Group</strong></label>
                    <div class="form-control bg-light">{{ $student->blood_group }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Religion</strong></label>
                    <div class="form-control bg-light">{{ $student->religion }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Nationality</strong></label>
                    <div class="form-control bg-light">{{ $student->nationality }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Status</strong></label>
                    <div class="form-control bg-light">
                        <span class="badge bg-success">{{ ucfirst($student->status) }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Transport</strong></label>
                    <div class="form-control bg-light">{{ $student->is_transport ? 'Yes' : 'No' }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Hostel</strong></label>
                    <div class="form-control bg-light">{{ $student->is_hostel ? 'Yes' : 'No' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Parent Information -->
    <div class="collapse" id="parentInfo">
        <div class="card mb-3">
            <div class="card-header bg-info text-white">Parents Details</div>
            <div class="card-body">
                <a href="{{ route('student.parent.create', $student) }}" class="btn btn-outline-info mb-3">
    <i class="fas fa-plus-circle"></i> Add Parent Information
</a>

@if ($student->parents->isEmpty())
    <p class="text-muted">No parent information available yet.</p>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-info">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Relation</th>
                    <th>Occupation</th>
                    <th>Education</th>
                    <th>Company</th>
                    <th>Annual Income</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
                @foreach($student->parents as $parent)
                <tr>
                    <td>{{ $parent->user->name }}</td>
                    <td>{{ $parent->user->email }}</td>
                    <td>{{ ucfirst($parent->relation_type) }}</td>
                    <td>{{ $parent->occupation ?? '-' }}</td>
                    <td>{{ $parent->education ?? '-' }}</td>
                    <td>{{ $parent->company ?? '-' }}</td>
                    <td>{{ $parent->formatted_annual_income ?? '-' }}</td>
                    <td>
    <a href="{{ route('student.parent.edit', [$student->user_id, $parent->user_id]) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('student.parent.destroy', [$student->user_id, $parent->user_id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this parent?');">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
    </form>
</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

            </div>
        </div>
    </div>

<!-- Fees Structure -->
<div class="collapse" id="feesStructure">
    <div class="card mb-3">
        <div class="card-header bg-success text-white">Fees Structure</div>
        <div class="card-body">
            @if(empty($feesByYear) || collect($feesByYear)->flatten()->isEmpty())
                <p class="text-muted">No fees available for this student.</p>
            @else
                @foreach($feesByYear as $yearName => $fees)
    <h5>{{ $yearName }}</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Remaining</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fees as $fee)
                                    <tr>
                                        <td>{{ $fee->name }}</td>
                                        <td>TZS {{ number_format($fee->amount, 2) }}</td>
                                        <td>TZS {{ number_format($fee->paid, 2) }}</td>
                                        <td>
                                            @if($fee->balance <= 0)
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                TZS {{ number_format($fee->balance, 2) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($fee->balance <= 0)
                                                <span class="badge bg-success">Complete</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($fee->payment_history->isNotEmpty())
                                        <tr>
                                            <td colspan="5">
                                                <strong>Payment History:</strong>
                                                <ul class="list-unstyled small mb-0">
                                                    @foreach($fee->payment_history as $pay)
                                                        <li>
                                                            • {{ $pay->payment_date->format('d M Y') }}:
                                                            TZS {{ number_format($pay->amount_paid, 2) }}
                                                            via {{ ucfirst($pay->method) }}
                                                            @if($pay->reference) (Ref: {{ $pay->reference }}) @endif
                                                            <br>
                                                            <small class="text-muted">Received by: {{ $pay->receivedBy->name ?? '-' }}</small>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr><td colspan="5" class="text-muted">No fee structure defined.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>


    <!-- Academic Records -->
    <div class="collapse" id="academicRecords">
        <div class="card mb-3">
            <div class="card-header bg-warning text-dark">Academic Records</div>
            <div class="card-body">
                <p>No data yet, implement academics module here.</p>
            </div>
        </div>
    </div>

    <!-- Behaviour Records -->
    <div class="collapse" id="behaviourRecords">
        <div class="card mb-3">
            <div class="card-header bg-danger text-white">Behaviour Records</div>
            <div class="card-body">
                <p>No data yet, implement behaviour module here.</p>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="mt-3">
        <a href="{{ route('students.edit', $student->user_id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>
@endsection
