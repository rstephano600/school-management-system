@extends('layouts.app')

@section('title', 'user Details')

@section('content')
<div class="container">
    <h1 class="mb-4">user: {{ $user->name }}</h1>

    <!-- Toggle Buttons -->
    <div class="mb-4 d-flex flex-wrap gap-2">
        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#personalInfo">
            Personal Info
        </button>

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
                    <div class="form-control bg-light">{{ $user->email }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Role</strong></label>
                    <div class="form-control bg-light">{{ $user->role ?? '-' }}</div>
                </div>

                
                <div class="col-md-6">
                    <label class="form-label"><strong>Status</strong></label>
                    <div class="form-control bg-light">
                        <span class="badge bg-success">{{ ucfirst($user->status) }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


   
</div>
@endsection
