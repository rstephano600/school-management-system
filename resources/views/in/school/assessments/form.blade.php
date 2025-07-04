<form action="{{ isset($assessment) ? route('assessments.update', $assessment) : route('assessments.store') }}" method="POST">
    @csrf
    @if(isset($assessment)) @method('PUT') @endif

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $assessment->title ?? '') }}" required>
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
        <select name="grade_level_id" class="form-control" required>
            @foreach($gradeLevels as $grade)
                <option value="{{ $grade->id }}" {{ (old('grade_level_id', $assessment->grade_level_id ?? '') == $grade->id) ? 'selected' : '' }}>{{ $grade->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Subject</label>
        <select name="subject_id" class="form-control" required>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ (old('subject_id', $assessment->subject_id ?? '') == $subject->id) ? 'selected' : '' }}>{{ $subject->name }}</option>
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
        <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $assessment->due_date ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description', $assessment->description ?? '') }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">{{ isset($assessment) ? 'Update' : 'Save' }}</button>
    <a href="{{ route('assessments.index') }}" class="btn btn-secondary">Cancel</a>
</form>

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
