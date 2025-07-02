<?php

namespace App\Imports;

use App\Models\ExamResult;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExamResultsImport implements ToCollection
{
    protected $examId;
    protected $schoolId;
    public $errors = [];

    public function __construct($examId)
    {
        $this->examId = $examId;
        $this->schoolId = Auth::user()->school_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows->skip(1) as $index => $row) {
            $rowNumber = $index + 2; // +2 because header row is 1 and zero-based index

            $admissionNumber = trim($row[0]);
            $marksObtained = $row[1];
            $grade = $row[2];
            $remarks = $row[3] ?? null;

            if (!$admissionNumber || !is_numeric($marksObtained) || !$grade) {
                $this->errors[] = "Row $rowNumber: Missing required fields.";
                continue;
            }

            $student = Student::where('admission_number', $admissionNumber)
                              ->where('school_id', $this->schoolId)
                              ->first();

            if (!$student) {
                $this->errors[] = "Row $rowNumber: Student with admission number '$admissionNumber' not found.";
                continue;
            }

            $existingResult = ExamResult::where('exam_id', $this->examId)
                ->where('student_id', $student->user_id)
                ->first();

            if ($existingResult) {
                $existingResult->update([
                    'marks_obtained' => $marksObtained,
                    'grade' => $grade,
                    'remarks' => $remarks,
                ]);
            } else {
                ExamResult::create([
                    'school_id' => $this->schoolId,
                    'exam_id' => $this->examId,
                    'student_id' => $student->user_id,
                    'marks_obtained' => $marksObtained,
                    'grade' => $grade,
                    'remarks' => $remarks,
                    'published' => false,
                ]);
            }
        }
    }
}
