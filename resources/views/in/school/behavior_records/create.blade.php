@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Behavior Record</h3>
    <form action="{{ route('behavior_records.store') }}" method="POST">
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
            <label>Date of Incident</label>
            <input type="date" name="incident_date" class="form-control">
        </div>
        <div class="mb-3">
            <label>Incident Type</label>
            <select name="incident_type" class="form-control">
                <option value="disruption">Disruption</option>
                <option value="bullying">Bullying</option>
                <option value="cheating">Cheating</option>
                <option value="absenteeism">Absenteeism</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Action Taken</label>
            <textarea name="action_taken" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">Save Record</button>
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

