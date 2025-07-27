<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Staff;
use App\Models\Parents;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    
public function __construct()
{
    $this->middleware('auth');
    $this->middleware('verified');
    
    // Add policy middleware for specific methods
    $this->middleware('can:viewAny,App\Models\Student')->only(['students', 'exportStudents']);
    $this->middleware('can:viewAny,App\Models\Teacher')->only(['teachers', 'exportTeachers']);
    $this->middleware('can:viewAny,App\Models\Staff')->only(['staff', 'exportStaff']);
    $this->middleware('can:viewAny,App\Models\Parents')->only(['parents', 'exportParents']);
    $this->middleware('can:viewAny,App\Models\User')->only(['users', 'exportUsers']);
}

    /**
     * Show export options for students
     */
    public function students()
    {
        $this->authorize('viewAny', Student::class);
        
        $school = Auth::user()->school;
        $grades = $school->grades()->get();
        $sections = $school->sections()->get();
        
        return view('in.school.export.students', compact('grades', 'sections'));
    }

    /**
     * Export students data
     */
    public function exportStudents(Request $request)
    {
        $this->authorize('viewAny', Student::class);
        
        $request->validate([
            'format' => 'required|in:xlsx,csv,pdf',
            'grade_id' => 'nullable|exists:grade_levels,id',
            'section_id' => 'nullable|exists:sections,id',
            'status' => 'nullable|in:active,graduated,transferred,suspended',
            'gender' => 'nullable|in:male,female',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $school = Auth::user()->school;
        $query = Student::with(['user', 'grade', 'section', 'parents'])
            ->where('school_id', $school->id);

        // Apply filters
        if ($request->grade_id) {
            $query->where('grade_id', $request->grade_id);
        }

        if ($request->section_id) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        if ($request->date_from && $request->date_to) {
            $query->whereBetween('admission_date', [$request->date_from, $request->date_to]);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->search . '%')
                  ->orWhere('lname', 'like', '%' . $request->search . '%')
                  ->orWhere('admission_number', 'like', '%' . $request->search . '%');
            });
        }

        $students = $query->get();

        return $this->generateExport($students, $request->format, 'students', [
            'Admission Number', 'First Name', 'Middle Name', 'Last Name', 'Grade', 'Section',
            'Roll Number', 'Date of Birth', 'Gender', 'Blood Group', 'Religion', 'Nationality',
            'Admission Date', 'Status', 'Transport', 'Hostel'
        ]);
    }

    /**
     * Show export options for teachers
     */
    public function teachers()
    {
        $this->authorize('viewAny', Teacher::class);
        
        $school = Auth::user()->school;
        $subjects = $school->subjects()->get();
        
        return view('in.school.export.teachers', compact('subjects'));
    }

    /**
     * Export teachers data
     */
    public function exportTeachers(Request $request)
    {
        $this->authorize('viewAny', Teacher::class);
        
        $request->validate([
            'format' => 'required|in:xlsx,csv,pdf',
            'department' => 'nullable|string',
            'specialization' => 'nullable|string',
            'status' => 'nullable|boolean',
            'is_class_teacher' => 'nullable|boolean',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $school = Auth::user()->school;
        $query = Teacher::with(['user', 'subjects'])
            ->where('school_id', $school->id);

        // Apply filters
        if ($request->department) {
            $query->where('department', $request->department);
        }

        if ($request->specialization) {
            $query->where('specialization', 'like', '%' . $request->specialization . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('is_class_teacher')) {
            $query->where('is_class_teacher', $request->is_class_teacher);
        }

        if ($request->date_from && $request->date_to) {
            $query->whereBetween('joining_date', [$request->date_from, $request->date_to]);
        }

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhere('employee_id', 'like', '%' . $request->search . '%');
        }

        $teachers = $query->get();

        return $this->generateExport($teachers, $request->format, 'teachers', [
            'Employee ID', 'Name', 'Email', 'Joining Date', 'Qualification', 'Specialization',
            'Experience', 'Department', 'Class Teacher', 'Status', 'Subjects'
        ]);
    }

    /**
     * Show export options for staff
     */
    public function staff()
    {
        $this->authorize('viewAny', Staff::class);
        
        return view('in.school.export.staff');
    }

    /**
     * Export staff data
     */
    public function exportStaff(Request $request)
    {
        $this->authorize('viewAny', Staff::class);
        
        $request->validate([
            'format' => 'required|in:xlsx,csv,pdf',
            'department' => 'nullable|string',
            'designation' => 'nullable|string',
            'status' => 'nullable|boolean',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $school = Auth::user()->school;
        $query = Staff::with(['user'])
            ->where('school_id', $school->id);

        // Apply filters
        if ($request->department) {
            $query->where('department', $request->department);
        }

        if ($request->designation) {
            $query->where('designation', 'like', '%' . $request->designation . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->date_from && $request->date_to) {
            $query->whereBetween('joining_date', [$request->date_from, $request->date_to]);
        }

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhere('employee_id', 'like', '%' . $request->search . '%');
        }

        $staff = $query->get();

        return $this->generateExport($staff, $request->format, 'staff', [
            'Employee ID', 'Name', 'Email', 'Joining Date', 'Designation', 'Department',
            'Qualification', 'Experience', 'Status'
        ]);
    }

    /**
     * Show export options for parents
     */
    public function parents()
    {
        $this->authorize('viewAny', Parents::class);
        
        return view('in.school.export.parents');
    }

    /**
     * Export parents data
     */
    public function exportParents(Request $request)
    {
        $this->authorize('viewAny', Parents::class);
        
        $request->validate([
            'format' => 'required|in:xlsx,csv,pdf',
            'relation_type' => 'nullable|in:father,mother,guardian',
            'occupation' => 'nullable|string',
            'income_from' => 'nullable|numeric',
            'income_to' => 'nullable|numeric|gte:income_from',
        ]);

        $school = Auth::user()->school;
        $query = Parents::with(['user', 'student.user'])
            ->where('school_id', $school->id);

        // Apply filters
        if ($request->relation_type) {
            $query->where('relation_type', $request->relation_type);
        }

        if ($request->occupation) {
            $query->where('occupation', 'like', '%' . $request->occupation . '%');
        }

        if ($request->income_from && $request->income_to) {
            $query->whereBetween('annual_income', [$request->income_from, $request->income_to]);
        }

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $parents = $query->get();

        return $this->generateExport($parents, $request->format, 'parents', [
            'Name', 'Email', 'Student Name', 'Relation Type', 'Occupation', 'Education',
            'Company', 'Annual Income'
        ]);
    }

    /**
     * Show export options for all users
     */
    public function users()
    {
        $this->authorize('viewAny', User::class);
        
        return view('in.school.export.users');
    }

    /**
     * Export all users data
     */
    public function exportUsers(Request $request)
    {
        $this->authorize('viewAny', User::class);
        
        $request->validate([
            'format' => 'required|in:xlsx,csv,pdf',
            'role' => 'nullable|string',
            'status' => 'nullable|in:active,pending,suspended,blocked',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $school = Auth::user()->school;
        $query = User::where('school_id', $school->id);

        // Apply filters
        if ($request->role) {
            $query->where('role', $request->role);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from && $request->date_to) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->get();

        return $this->generateExport($users, $request->format, 'users', [
            'Name', 'Email', 'Role', 'Status', 'Created At', 'Last Login'
        ]);
    }

    /**
     * Generate export file based on format
     */
    private function generateExport($data, $format, $type, $headers)
    {
        $filename = $type . '_export_' . date('Y-m-d_H-i-s');

        switch ($format) {
            case 'xlsx':
                return $this->generateExcel($data, $type, $headers, $filename . '.xlsx');
            case 'csv':
                return $this->generateCsv($data, $type, $headers, $filename . '.csv');
            case 'pdf':
                return $this->generatePdf($data, $type, $headers, $filename . '.pdf');
        }
    }

    /**
     * Generate Excel export
     */
    private function generateExcel($data, $type, $headers, $filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $col = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($col, 1, $header);
            $col++;
        }

        // Set data
        $row = 2;
        foreach ($data as $item) {
            $rowData = $this->formatRowData($item, $type);
            $col = 1;
            foreach ($rowData as $value) {
                $sheet->setCellValueByColumnAndRow($col, $row, $value);
                $col++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($tempFile);

        return Response::download($tempFile, $filename)->deleteFileAfterSend();
    }

    /**
     * Generate CSV export
     */
    private function generateCsv($data, $type, $headers, $filename)
    {
        $callback = function() use ($data, $type, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($data as $item) {
                $rowData = $this->formatRowData($item, $type);
                fputcsv($file, $rowData);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Generate PDF export
     */
    private function generatePdf($data, $type, $headers, $filename)
    {
        $pdf = Pdf::loadView('in.school.export.pdf.' . $type, compact('data', 'headers'));
        return $pdf->download($filename);
    }

    /**
     * Format row data based on type
     */
    private function formatRowData($item, $type)
    {
        switch ($type) {
            case 'students':
                return [
                    $item->admission_number,
                    $item->fname,
                    $item->mname,
                    $item->lname,
                    $item->grade->name ?? '',
                    $item->section->name ?? '',
                    $item->roll_number,
                    $item->date_of_birth?->format('Y-m-d'),
                    $item->gender,
                    $item->blood_group,
                    $item->religion,
                    $item->nationality,
                    $item->admission_date?->format('Y-m-d'),
                    $item->status,
                    $item->is_transport ? 'Yes' : 'No',
                    $item->is_hostel ? 'Yes' : 'No',
                ];

            case 'teachers':
                return [
                    $item->employee_id,
                    $item->user->name,
                    $item->user->email,
                    $item->joining_date?->format('Y-m-d'),
                    $item->qualification,
                    $item->specialization,
                    $item->experience,
                    $item->department,
                    $item->is_class_teacher ? 'Yes' : 'No',
                    $item->status ? 'Active' : 'Inactive',
                    $item->subjects->pluck('name')->join(', '),
                ];

            case 'staff':
                return [
                    $item->employee_id,
                    $item->user->name,
                    $item->user->email,
                    $item->joining_date?->format('Y-m-d'),
                    $item->designation,
                    $item->department,
                    $item->qualification,
                    $item->experience,
                    $item->status ? 'Active' : 'Inactive',
                ];

            case 'parents':
                return [
                    $item->user->name,
                    $item->user->email,
                    $item->student->user->name ?? '',
                    ucfirst($item->relation_type),
                    $item->occupation,
                    $item->education,
                    $item->company,
                    $item->annual_income,
                ];

            case 'users':
                return [
                    $item->name,
                    $item->email,
                    $item->role,
                    $item->status,
                    $item->created_at?->format('Y-m-d H:i:s'),
                    $item->last_login_at?->format('Y-m-d H:i:s') ?? 'Never',
                ];

            default:
                return [];
        }
    }
}