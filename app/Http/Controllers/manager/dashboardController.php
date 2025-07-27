<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    
    public function dashboard()
    {
        $user = Auth::user();
        $schoolId = $user->school_id;
        
        // Basic Statistics
        $totalStudents = Student::where('school_id', $schoolId)
            ->where('status', 'active')
            ->count();
            
        $totalTeachers = Teacher::where('school_id', $schoolId)
            ->where('status', true)
            ->count();
            
        $totalStaff = User::where('school_id', $schoolId)
            ->where('role', 'staff')
            ->where('status', 'active')
            ->count();
            
        $totalParents = User::where('school_id', $schoolId)
            ->where('role', 'parent')
            ->where('status', 'active')
            ->count();

        // Current Academic Year
        $currentAcademicYear = AcademicYear::where('school_id', $schoolId)
            ->where('is_current', true)
            ->first();

        // Current Semester
        $currentSemester = Semester::where('school_id', $schoolId)
            ->where('is_current', true)
            ->first();

        // Fee Collection Statistics
        $feeStats = $this->getFeeStatistics($schoolId);
        
        // Recent Activities
        $recentActivities = $this->getRecentActivities($schoolId);
        
        // Notices
        $recentNotices = Notice::where('school_id', $schoolId)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Upcoming Events
        $upcomingEvents = Event::where('school_id', $schoolId)
            ->where('start_datetime', '>=', now())
            ->orderBy('start_datetime', 'asc')
            ->limit(5)
            ->get();

        // Student Enrollment by Grade
        $enrollmentByGrade = Student::join('grade_levels', 'students.grade_id', '=', 'grade_levels.id')
            ->where('students.school_id', $schoolId)
            ->where('students.status', 'active')
            ->select('grade_levels.name', DB::raw('count(*) as total'))
            ->groupBy('grade_levels.name')
            ->get();

        // Monthly Fee Collection Chart Data
        $monthlyFeeCollection = FeePayment::where('fee_payments.school_id', $schoolId)
            ->join('fee_structures', 'fee_payments.fee_structure_id', '=', 'fee_structures.id')
            ->select(
                DB::raw('MONTH(payment_date) as month'),
                DB::raw('YEAR(payment_date) as year'),
                DB::raw('SUM(amount_paid) as total')
            )
            ->where('payment_date', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Pending Tasks/Alerts
        $pendingTasks = $this->getPendingTasks($schoolId);

        return view('in.schooladmin.dashboard', compact(
            'totalStudents',
            'totalTeachers', 
            'totalStaff',
            'totalParents',
            'currentAcademicYear',
            'currentSemester',
            'feeStats',
            'recentActivities',
            'recentNotices',
            'upcomingEvents',
            'enrollmentByGrade',
            'monthlyFeeCollection',
            'pendingTasks'
        ));
    }

    private function getFeeStatistics($schoolId)
    {
        $currentMonth = now()->format('Y-m');
        
        return [
            'total_collected' => FeePayment::whereHas('fee', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            })->sum('amount_paid'),
            
            'monthly_collected' => FeePayment::whereHas('fee', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            })->whereRaw('DATE_FORMAT(payment_date, "%Y-%m") = ?', [$currentMonth])
            ->sum('amount_paid'),
            
            'pending_fees' => 0, // Calculate based on your fee structure
        ];
    }

    private function getRecentActivities($schoolId)
    {
        $activities = collect();

        // Recent student registrations
        $recentStudents = Student::where('school_id', $schoolId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        foreach ($recentStudents as $student) {
            $activities->push([
                'type' => 'student_registered',
                'message' => "New student {$student->fname} {$student->lname} registered",
                'time' => $student->created_at,
                'icon' => 'fas fa-user-plus',
                'color' => 'success'
            ]);
        }

        // Recent fee payments
        $recentPayments = FeePayment::whereHas('fee', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            })
            ->with(['student', 'fee'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        foreach ($recentPayments as $payment) {
            $activities->push([
                'type' => 'payment_received',
                'message' => "Payment of {$payment->amount_paid} received from {$payment->student->name}",
                'time' => $payment->created_at,
                'icon' => 'fas fa-money-bill-wave',
                'color' => 'info'
            ]);
        }

        return $activities->sortByDesc('time')->take(10);
    }

    private function getPendingTasks($schoolId)
    {
        $tasks = [];

        // Check for unpublished exam results
        $unpublishedResults = ExamResult::where('school_id', $schoolId)
            ->where('published', false)
            ->count();

        if ($unpublishedResults > 0) {
            $tasks[] = [
                'title' => 'Unpublished Exam Results',
                'count' => $unpublishedResults,
                'url' => route('exam-results.index'),
                'color' => 'warning'
            ];
        }

        // Check for pending user approvals
        $pendingUsers = User::where('school_id', $schoolId)
            ->where('status', 'pending')
            ->count();

        if ($pendingUsers > 0) {
            $tasks[] = [
                'title' => 'Pending User Approvals',
                'count' => $pendingUsers,
                'url' => route('users.index'),
                'color' => 'info'
            ];
        }

        return $tasks;
    }
}
