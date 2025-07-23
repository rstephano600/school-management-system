@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Add Health Record</h3>
    <form action="{{ route('health_records.store') }}" method="POST">
        @csrf

        <div class="mb-3">
    <label for="student">Student</label>
<select name="student_id" id="student" class="form-control select2">
    <option value="">-- Select a Student --</option>
    @foreach($students as $student)
        <option value="{{ $student->user_id }}">
            {{ $student->user->name ?? 'N/A' }} - {{ $student->admission_number }}
        </option>
    @endforeach
</select>

</div>
        <div class="mb-3">
            <label>Record Date</label>
            <input type="date" name="record_date" class="form-control">
        </div>
        <div class="mb-3">
            <label>Height (cm)</label>
            <input type="number" step="0.01" name="height" class="form-control">
        </div>
        <div class="mb-3">
            <label>Weight (kg)</label>
            <input type="number" step="0.01" name="weight" class="form-control">
        </div>
        <div class="mb-3">
            <label>Blood Group</label>
            <input type="text" name="blood_group" class="form-control">
        </div>
        <div class="mb-3">
            <label>Vision Left</label>
            <input type="text" name="vision_left" class="form-control">
        </div>
        <div class="mb-3">
            <label>Vision Right</label>
            <input type="text" name="vision_right" class="form-control">
        </div>
        <div class="mb-3">
            <label>Allergies (comma-separated)</label>
            <input type="text" name="allergies" class="form-control">
        </div>
        <div class="mb-3">
            <label>Medical Conditions (comma-separated)</label>
            <input type="text" name="medical_conditions" class="form-control">
        </div>
        <div class="mb-3">
            <label>Immunizations (comma-separated)</label>
            <input type="text" name="immunizations" class="form-control">
        </div>
        <div class="mb-3">
            <label>Last Checkup Date</label>
            <input type="date" name="last_checkup_date" class="form-control">
        </div>
        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Search by name or admission number',
            allowClear: true,
            width: '100%',
            matcher: function(params, data) {
                // If no search term, return all data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Custom matching logic: case-insensitive
                if (typeof data.text === 'undefined') {
                    return null;
                }

                const term = params.term.toLowerCase();
                const text = data.text.toLowerCase();

                if (text.includes(term)) {
                    return data; // show if matches
                }

                return null; // hide if doesn't match
            }
        });
    });
</script>
