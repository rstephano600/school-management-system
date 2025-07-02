<div class="row">
    <div class="col-md-6 mb-3">
        <label>Student</label>
        <select name="student_id" class="form-control" required>
            <option value="">Select</option>
            @foreach($students as $student)
                <option value="{{ $student->user_id }}" {{ old('student_id', $academicRecord->student_id ?? '') == $student->user_id ? 'selected' : '' }}>
                    {{ $student->user->full_name ?? 'Unknown' }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>Subject</label>
        <select name="subject_id" class="form-control" required>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ old('subject_id', $academicRecord->subject_id ?? '') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>Class</label>
        <select name="class_id" class="form-control" required>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ old('class_id', $academicRecord->class_id ?? '') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>Academic Year</label>
        <select name="academic_year_id" class="form-control" required>
            @foreach($academicYears as $year)
                <option value="{{ $year->id }}" {{ old('academic_year_id', $academicRecord->academic_year_id ?? '') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>Semester</label>
        <select name="semester_id" class="form-control">
            <option value="">--</option>
            @foreach($semesters as $sem)
                <option value="{{ $sem->id }}" {{ old('semester_id', $academicRecord->semester_id ?? '') == $sem->id ? 'selected' : '' }}>{{ $sem->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>Average Exam Score</label>
        <input type="number" step="0.01" name="average_exam_score" value="{{ old('average_exam_score', $academicRecord->average_exam_score ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label>Average Assignment Score</label>
        <input type="number" step="0.01" name="average_assignment_score" value="{{ old('average_assignment_score', $academicRecord->average_assignment_score ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label>Final Score</label>
        <input type="number" step="0.01" name="final_score" value="{{ old('final_score', $academicRecord->final_score ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label>Final Grade</label>
        <input type="text" name="final_grade" value="{{ old('final_grade', $academicRecord->final_grade ?? '') }}" class="form-control">
    </div>
    <div class="col-12 mb-3">
        <label>Remarks</label>
        <textarea name="remarks" class="form-control">{{ old('remarks', $academicRecord->remarks ?? '') }}</textarea>
    </div>
</div>
