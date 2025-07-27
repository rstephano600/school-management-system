@extends('layouts.app')

@section('content')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container">
    <h4 class="mb-4">Submit Student Requirement</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('student-requirement-submissions.store') }}">
        @csrf

        <div class="mb-3">
            <label for="student_id" class="form-label">Student</label>
            <select name="student_id" id="student_id" class="form-select select2" required>
                <option value="">-- Select Student --</option>
                @foreach($students as $student)
                    <option value="{{ $student->user_id }}">
                        {{ $student->fname }} {{ $student->mname }} {{ $student->lname }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="requirement-container">
            <div class="requirement-group border p-3 mb-3 rounded">
                <div class="mb-2">
                    <label class="form-label">Requirement</label>
                    <select name="requirements[0][student_requirement_id]" class="form-select" required>
                        <option value="">-- Select Requirement --</option>
                        @foreach($requirements as $requirement)
                            <option value="{{ $requirement->id }}">{{ $requirement->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Status</label>
                        <select name="requirements[0][status]" class="form-select" required>
                            <option value="submitted">Submitted (object)</option>
                            <option value="paid">Paid (money)</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Qty Received</label>
                        <input type="number" name="requirements[0][quantity_received]" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Qty Remain</label>
                        <input type="number" name="requirements[0][quantity_remain]" class="form-control" step="0.01" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Amount Paid</label>
                        <input type="number" name="requirements[0][amount_paid]" class="form-control" step="0.01">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Notes</label>
                        <input type="text" name="requirements[0][notes]" class="form-control" maxlength="20">
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3 text-start">
            <button type="button" id="add-more" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-plus"></i> Add More Requirement
            </button>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Submit Requirements</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        let index = 1;

        $('#add-more').on('click', function () {
            let html = `
                <div class="requirement-group border p-3 mb-3 rounded">
                    <div class="mb-2">
                        <label class="form-label">Requirement</label>
                        <select name="requirements[${index}][student_requirement_id]" class="form-select" required>
                            <option value="">-- Select Requirement --</option>
                            @foreach($requirements as $requirement)
                                <option value="{{ $requirement->id }}">{{ $requirement->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Status</label>
                            <select name="requirements[${index}][status]" class="form-select" required>
                                <option value="submitted">Submitted (object)</option>
                                <option value="paid">Paid (money)</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Qty Received</label>
                            <input type="number" name="requirements[${index}][quantity_received]" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Qty Remain</label>
                            <input type="number" name="requirements[${index}][quantity_remain]" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Amount Paid</label>
                            <input type="number" name="requirements[${index}][amount_paid]" class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Notes</label>
                            <input type="text" name="requirements[${index}][notes]" class="form-control" maxlength="20">
                        </div>
                    </div>
                </div>`;
            $('#requirement-container').append(html);
            index++;
        });
    });
</script>



@endsection

