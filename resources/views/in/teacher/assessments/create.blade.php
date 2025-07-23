@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Assessment</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('teacher.assessments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

    <div class="mb-3">
        <label>Type</label>
        <select name="type" class="form-control" required>
            <option value="">-- Select --</option>
            @foreach(['exam','test','assignment','lab'] as $type)
                <option value="{{ $type }}" {{ (old('type', $assessment->type ?? '') == $type) ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>
        <div class="mb-3">
            <label>Grade Level</label>
            <select name="grade_level_id" class="form-select" required>
                <option value="">Select Grade</option>
                @foreach($gradeLevels as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Subject</label>
            <select name="subject_id" class="form-select" required>
                <option value="">Select Subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
    <label>Academic Year</label>
    <select name="academic_year_id" id="academicYearSelect" class="form-control" required>
        <option value="">-- Select Year --</option>
        @foreach($academicYears->sortByDesc('name') as $year)
            <option value="{{ $year->id }}" {{ (old('academic_year_id', $assessment->academic_year_id ?? '') == $year->id) ? 'selected' : '' }}>
                {{ $year->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Semester</label>
    <select name="semester_id" id="semesterSelect" class="form-control">
        <option value="">-- Select Semester --</option>
        @foreach($semesters as $sem)
            <option value="{{ $sem->id }}" data-year="{{ $sem->academic_year_id }}" {{ (old('semester_id', $assessment->semester_id ?? '') == $sem->id) ? 'selected' : '' }}>
                {{ $sem->name }}
            </option>
        @endforeach
    </select>
</div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>

        <div class="mb-3">
    <label>Attach File (optional)</label>
    <input type="file" name="attachment" class="form-control" accept=".pdf,.doc,.docx">
</div>


        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Assessment</button>
    </form>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const yearSelect = document.getElementById('academicYearSelect');
    const semesterSelect = document.getElementById('semesterSelect');

    function filterSemesters() {
        const selectedYear = yearSelect.value;

        [...semesterSelect.options].forEach(option => {
            if (option.value === "") {
                option.hidden = false; // Keep placeholder always visible
            } else {
                option.hidden = option.dataset.year !== selectedYear;
            }
        });

        // If selected semester is now hidden, reset it
        if (semesterSelect.selectedOptions.length > 0) {
            const selectedOption = semesterSelect.selectedOptions[0];
            if (selectedOption.hidden) {
                semesterSelect.value = "";
            }
        }
    }

    yearSelect.addEventListener('change', filterSemesters);

    // Initial filtering on page load
    filterSemesters();
});
</script>


@endsection
