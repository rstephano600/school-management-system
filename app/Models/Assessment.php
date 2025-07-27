<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

protected $fillable = [
    'school_id', 'title', 'type', 'grade_level_id',
    'subject_id', 'academic_year_id', 'semester_id',
    'due_date', 'description', 'attachment',
    'created_by', 'updated_by'  // ✅ Add these
];

    protected $casts = [
    'due_date' => 'date',
];
    public function school()         { return $this->belongsTo(School::class); }
    public function gradeLevel()     { return $this->belongsTo(GradeLevel::class); }
    public function subject()        { return $this->belongsTo(Subject::class); }
    public function academicYear()   { return $this->belongsTo(AcademicYear::class); }
    public function semester()       { return $this->belongsTo(Semester::class); }
    public function creator(){  return $this->belongsTo(User::class); }
    public function updater(){  return $this->belongsTo(User::class); }

    public function results()
    {
        return $this->hasMany(AssessmentResult::class);
    }

    /**
     * Get the average score for this assessment.
     */
    public function getAverageScoreAttribute()
    {
        return $this->results()->avg('score');
    }

    /**
     * Get the highest score for this assessment.
     */
    public function getHighestScoreAttribute()
    {
        return $this->results()->max('score');
    }

    /**
     * Get the lowest score for this assessment.
     */
    public function getLowestScoreAttribute()
    {
        return $this->results()->min('score');
    }

    /**
     * Get the total number of students who took this assessment.
     */
    public function getTotalStudentsAttribute()
    {
        return $this->results()->count();
    }

    /**
     * Get the number of students who passed this assessment (score >= 50).
     */
    public function getPassedStudentsAttribute()
    {
        return $this->results()->where('score', '>=', 50)->count();
    }

    /**
     * Get the pass rate percentage for this assessment.
     */
    public function getPassRateAttribute()
    {
        $total = $this->total_students;
        return $total > 0 ? round(($this->passed_students / $total) * 100, 2) : 0;
    }

    /**
     * Scope to filter by school.
     */
    public function scopeForSchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    /**
     * Scope to filter by academic year.
     */
    public function scopeForAcademicYear($query, $academicYearId)
    {
        return $query->where('academic_year_id', $academicYearId);
    }

    /**
     * Scope to filter by semester.
     */
    public function scopeForSemester($query, $semesterId)
    {
        return $query->where('semester_id', $semesterId);
    }

    /**
     * Scope to filter by grade level.
     */
    public function scopeForGradeLevel($query, $gradeLevelId)
    {
        return $query->where('grade_level_id', $gradeLevelId);
    }

    /**
     * Scope to filter by subject.
     */
    public function scopeForSubject($query, $subjectId)
    {
        return $query->where('subject_id', $subjectId);
    }

    /**
     * Scope to filter by assessment type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

}

