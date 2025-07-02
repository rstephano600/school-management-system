<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\dashboard\dashboardController;
use App\Http\Controllers\superadmin\SuperAdminController;
use App\Http\Controllers\superadmin\SchoolController;
use App\Http\Controllers\superadmin\UsersController;
use App\Http\Controllers\superadmin\SchoolUserController;
use App\Http\Controllers\schooladmin\SchoolAdmindashboardController;
use App\Http\Controllers\schooladmin\SchoolAdminController;
use App\Http\Controllers\school\StudentController;
use App\Http\Controllers\school\GradeLevelController;
use App\Http\Controllers\student\StudentDashboardController;
use App\Http\Controllers\school\TeacherController;
use App\Http\Controllers\school\StaffController;
use App\Http\Controllers\school\ParentController;
use App\Http\Controllers\FeePaymentController;
use App\Http\Controllers\StudentFeeController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AssignFeeController;
use App\Http\Controllers\SemesterController;
// use App\Http\Controllers\SubjectController;

Route::get('/', function () {
    return view('tamplates.index');
});

// AUTHENTICATION
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [ RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [ RegisterController::class, 'store'])->name('register');
Route::get('/dashboard',[StudentDashboardController::class, 'index'])->name('student.dashboard');
Route::get('/resset-password', function () { return view('auth.resset-password'); })->name('resset-password');

// DASHBOARD
Route::get('/admin/dashboard', function () {

    return view('admin.dashboard');

})->middleware(['auth', 'role:admin']);

Route::get('/dashboard', function () {
    $user = Auth::user();
    return match ($user->role) {
        'super_admin' => redirect()->route('superadmin.dashboard'),
        'school_admin' => redirect()->route('schooladmin.dashboard'),
        'director' => redirect()->route('director.dashboard'),
        'manager' => redirect()->route('manager.dashboard'),
        'head_master' => redirect()->route('headmaster.dashboard'),
        'secretary' => redirect()->route('secretary.dashboard'),
        'academic_master' => redirect()->route('academicmaster.dashboard'),
        'teacher' => redirect()->route('teacher.dashboard'),
        'staff' => redirect()->route('staff.dashboard'),
        'school_doctor' => redirect()->route('schooldoctor.dashboard'),
        'school_libralian' => redirect()->route('schoollibralian.dashboard'),
        'parent' => redirect()->route('parent.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => redirect()->route('user.dashboard')
    };

})->middleware('auth')->name('dashboard');

use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;

Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    });


Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    });

use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;

Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    });

use App\Http\Controllers\ParentUser\DashboardController as ParentDashboardController;

Route::middleware(['auth', 'role:parent'])
    ->prefix('parent')
    ->name('parent.')
    ->group(function () {
        Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    });

    
Route::middleware(['auth', 'role:super_admin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
        Route::get('/schools', [SchoolController::class, 'index'])->name('schools');
        Route::get('/create/schools', [SchoolController::class, 'create'])->name('schools.create');
        Route::post('/store/schools', [SchoolController::class, 'store'])->name('schools.store');
        Route::get('/edit/schools', [SchoolController::class, 'edit'])->name('schools.edit');
        Route::post('/update/schools', [SchoolController::class, 'update'])->name('schools.update');
        Route::post('/delete/schools', [SchoolController::class, 'destroy'])->name('schools.destroy');
        Route::get('/schools/{school}', [SchoolController::class, 'show'])->name('schools.show');


        // USERS
        Route::get('/system-users', [UsersController::class, 'index'])->name('users');
        Route::get('/create/User', [UsersController::class, 'create'])->name('users.create');
        Route::get('/edit/User', [UsersController::class, 'edit'])->name('users.edit');
        Route::get('/destroy/User', [UsersController::class, 'destroy'])->name('users.destroy');
        Route::get('/schools/{school}/register-user', [SchoolUserController::class, 'create'])->name('schools.users.create');
        Route::post('/schools/{school}/register-user', [SchoolUserController::class, 'store'])->name('schools.users.store');
        Route::get('/schools/{school}/users', [SchoolController::class, 'showUsers'])->name('schools.users');
        Route::get('/schools/{school}/users/export/{type}', [SchoolController::class, 'exportUsers'])->name('superadmin.schools.users.export');

    });

Route::middleware(['auth', 'role:school_admin'])
    ->prefix('schooladmin')
    ->group(function () {
    Route::get('/dashboard', [SchoolAdmindashboardController::class, 'dashboard'])->name('schooladmin.dashboard');
    Route::get('/school/students/list', [StudentController::class, 'index'])->name('students.index');
    Route::get('/school/students/register', [StudentController::class, 'create'])->name('students.create');
    Route::post('/school/students/Store', [StudentController::class, 'store'])->name('students.store');
    Route::get('/school/students/Show/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/school/students/edit/{student}', [StudentController::class, 'edit'])->name('students.edit');
    Route::post('/school/students/update/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::get('/school/students/delete', [StudentController::class, 'destroy'])->name('students.destroy');
    
    Route::get('/school/teachers/index', [TeacherController::class, 'index'])->name('teachers.index');
    
    Route::prefix('teachers')->name('teachers.')->group(function() {
    Route::get('/', [TeacherController::class, 'index'])->name('index');
    Route::get('/create', [TeacherController::class, 'create'])->name('create');
    Route::post('/', [TeacherController::class, 'store'])->name('store');
    Route::get('/{id}', [TeacherController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [TeacherController::class, 'edit'])->name('edit');
    Route::put('/{id}', [TeacherController::class, 'update'])->name('update');
    Route::get('/{id}/delete', [TeacherController::class, 'destroy'])->name('destroy');

});


Route::prefix('schools/staff')->name('schools.')->group(function () {
    Route::get('/', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/{user_id}', [StaffController::class, 'show'])->name('staff.show');
    Route::get('/{user_id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::get('/{user_id}/update', [StaffController::class, 'update'])->name('staff.update');
    Route::get('/{user_id}/delete', [StaffController::class, 'destroy'])->name('staff.destroy');
    // Add update/destroy routes as needed
});


Route::prefix('student/parent')->name('student.parent.')->group(function () {
    Route::get('/', [ParentController::class, 'index'])->name('index');
    Route::get('/{student}/create', [ParentController::class, 'create'])->name('create');
    Route::post('/{student}', [ParentController::class, 'store'])->name('store');
    Route::get('/{user_id}', [ParentController::class, 'show'])->name('show');
    Route::get('/{user_id}/edit', [ParentController::class, 'edit'])->name('edit');
    Route::get('/{user_id}/update', [ParentController::class, 'update'])->name('update');
    Route::get('/{user_id}/delete', [ParentController::class, 'destroy'])->name('destroy');
    // Add update/destroy routes as needed
});
Route::get('/students/{student}/parent/create', [ParentController::class, 'create'])->name('student.parent.create');
Route::post('/students/{student}/parent', [ParentController::class, 'store'])->name('student.parent.store');
Route::get('/students/{student}/parent/{user}/edit', [ParentController::class, 'edit'])->name('student.parent.edit');
Route::put('/students/{student}/parent/{user}', [ParentController::class, 'update'])->name('student.parent.update');
Route::delete('/students/{student}/parent/{user}', [ParentController::class, 'destroy'])->name('student.parent.destroy');

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/fees', [StudentFeeController::class, 'index'])->name('student.fees.index');
});
Route::middleware(['auth', 'role:school_admin'])->group(function () {
    Route::get('/admin/students/{student}/fee-payments', [FeePaymentController::class, 'create'])->name('admin.fee-payments.create');
    Route::post('/admin/students/{student}/fee-payments', [FeePaymentController::class, 'store'])->name('admin.fee-payments.store');
});
Route::prefix('admin')->middleware(['auth', 'role:school_admin'])->group(function () {
    Route::resource('fee-structures', FeeStructureController::class);
    Route::get('fee-payments/export', [FeePaymentController::class, 'export'])->name('fee-payments.export');
});
Route::middleware(['auth', 'role:school_admin'])->group(function () {
    Route::resource('academic-years', AcademicYearController::class);
});
Route::middleware(['auth', 'role:school_admin,secretary'])->prefix('admin')->group(function () {
    Route::get('/fee-payments/search', [FeePaymentController::class, 'search'])->name('admin.fee-payments.search');
});

Route::resource('semesters', SemesterController::class)->middleware(['auth', 'role:school_admin']);




    Route::get('/school/grade-levels/index', [GradeLevelController::class, 'index'])->name('grade-levels.index');
    Route::get('/school/grade-levels/create', [GradeLevelController::class, 'create'])->name('grade-levels.create');
    Route::post('/school/grade-levels/store', [GradeLevelController::class, 'store'])->name('grade-levels.store');
    Route::get('/school/grade-levels/show/{gradeLevel}', [GradeLevelController::class, 'show'])->name('grade-levels.show');
    Route::get('/school/grade-levels/edit/{gradeLevel}', [GradeLevelController::class, 'edit'])->name('grade-levels.edit');
    Route::put('/school/grade-levels/update/{grade_level}', [GradeLevelController::class, 'update'])->name('grade-levels.update');

    });
    

use App\Http\Controllers\SubjectController;

Route::middleware(['auth'])->prefix('school')->name('subjects.')->group(function () {
    Route::get('subjects', [SubjectController::class, 'index'])->name('index');
    Route::get('subjects/create', [SubjectController::class, 'create'])->name('create');
    Route::post('subjects', [SubjectController::class, 'store'])->name('store');
    Route::get('subjects/{subject}', [SubjectController::class, 'show'])->name('show'); // ✅ added
    Route::get('subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('edit');
    Route::put('subjects/{subject}', [SubjectController::class, 'update'])->name('update');
    Route::delete('subjects/{subject}', [SubjectController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->prefix('school')->name('teachers.')->group(function () {
    Route::get('teachers', [TeacherController::class, 'index'])->name('index');
    Route::get('teachers/create', [TeacherController::class, 'create'])->name('create');
    Route::post('teachers', [TeacherController::class, 'store'])->name('store');
    Route::get('teachers/{id}/edit', [TeacherController::class, 'edit'])->name('edit');
    Route::put('teachers/{id}', [TeacherController::class, 'update'])->name('update');
    Route::delete('teachers/{id}', [TeacherController::class, 'destroy'])->name('destroy');
});

use App\Http\Controllers\RoomController;

Route::middleware(['auth'])->prefix('school')->name('rooms.')->group(function () {
    Route::get('rooms', [RoomController::class, 'index'])->name('index');
    Route::get('rooms/create', [RoomController::class, 'create'])->name('create');
    Route::post('rooms', [RoomController::class, 'store'])->name('store');
    Route::get('rooms/{room}/edit', [RoomController::class, 'edit'])->name('edit');
    Route::put('rooms/{room}', [RoomController::class, 'update'])->name('update');
    Route::delete('rooms/{room}', [RoomController::class, 'destroy'])->name('destroy');
});

use App\Http\Controllers\SectionController;

Route::middleware(['auth'])->prefix('school')->name('sections.')->group(function () {
    Route::get('sections', [SectionController::class, 'index'])->name('index');
    Route::get('sections/create', [SectionController::class, 'create'])->name('create');
    Route::post('sections', [SectionController::class, 'store'])->name('store');
    Route::get('sections/{section}', [SectionController::class, 'show'])->name('show');
    Route::get('sections/{section}/edit', [SectionController::class, 'edit'])->name('edit');
    Route::put('sections/{section}', [SectionController::class, 'update'])->name('update');
    Route::delete('sections/{section}', [SectionController::class, 'destroy'])->name('destroy');
});


use App\Http\Controllers\ClassesController;

Route::middleware(['auth'])->prefix('school')->name('classes.')->group(function () {
    Route::get('classes', [ClassesController::class, 'index'])->name('index');
    Route::get('classes/create', [ClassesController::class, 'create'])->name('create');
    Route::post('classes', [ClassesController::class, 'store'])->name('store');
    Route::get('classes/{class}', [ClassesController::class, 'show'])->name('show');
    Route::get('classes/{class}/edit', [ClassesController::class, 'edit'])->name('edit');
    Route::put('classes/{class}', [ClassesController::class, 'update'])->name('update');
    Route::delete('classes/{class}', [ClassesController::class, 'destroy'])->name('destroy');

    // ✅ Timetable Route
    Route::get('classes/timetable', [ClassesController::class, 'timetable'])->name('timetable');
});

use App\Http\Controllers\TimetableController;

Route::middleware(['auth'])->prefix('school')->name('timetables.')->group(function () {
    Route::get('timetables', [TimetableController::class, 'index'])->name('index');
    Route::get('timetables/create', [TimetableController::class, 'create'])->name('create');
    Route::post('timetables', [TimetableController::class, 'store'])->name('store');
    Route::get('timetables/{timetable}/edit', [TimetableController::class, 'edit'])->name('edit');
    Route::put('timetables/{timetable}', [TimetableController::class, 'update'])->name('update');
    Route::delete('timetables/{timetable}', [TimetableController::class, 'destroy'])->name('destroy');
});


use App\Http\Controllers\AssessmentController;

Route::middleware(['auth'])->prefix('school')->name('assessments.')->group(function () {
    Route::get('assessments', [AssessmentController::class, 'index'])->name('index');
    Route::get('assessments/create', [AssessmentController::class, 'create'])->name('create');
    Route::post('assessments', [AssessmentController::class, 'store'])->name('store');
    Route::get('assessments/{assessment}/edit', [AssessmentController::class, 'edit'])->name('edit');
    Route::put('assessments/{assessment}', [AssessmentController::class, 'update'])->name('update');
    Route::delete('assessments/{assessment}', [AssessmentController::class, 'destroy'])->name('destroy');
});


use App\Http\Controllers\BehaviorRecordController;

Route::middleware(['auth'])->prefix('school')->name('behavior_records.')->group(function () {
    Route::get('behavior-records', [BehaviorRecordController::class, 'index'])->name('index');
    Route::get('behavior-records/create', [BehaviorRecordController::class, 'create'])->name('create');
    Route::post('behavior-records', [BehaviorRecordController::class, 'store'])->name('store');
    Route::get('behavior-records/{behavior_record}/show', [BehaviorRecordController::class, 'show'])->name('show');
    Route::get('behavior-records/{behavior_record}/edit', [BehaviorRecordController::class, 'edit'])->name('edit');
    Route::put('behavior-records/{behavior_record}', [BehaviorRecordController::class, 'update'])->name('update');
    Route::delete('behavior-records/{behavior_record}', [BehaviorRecordController::class, 'destroy'])->name('destroy');
});


use App\Http\Controllers\HealthRecordController;

Route::middleware(['auth'])->prefix('school')->name('health_records.')->group(function () {
    Route::get('health-records', [HealthRecordController::class, 'index'])->name('index');
    Route::get('health-records/create', [HealthRecordController::class, 'create'])->name('create');
    Route::post('health-records', [HealthRecordController::class, 'store'])->name('store');
    Route::get('health-records/{health_record}', [HealthRecordController::class, 'show'])->name('show');
    Route::get('health-records/{health_record}/edit', [HealthRecordController::class, 'edit'])->name('edit');
    Route::put('health-records/{health_record}', [HealthRecordController::class, 'update'])->name('update');
    Route::delete('health-records/{health_record}', [HealthRecordController::class, 'destroy'])->name('destroy');
});



use App\Http\Controllers\LibraryBookController;

Route::middleware(['auth'])->prefix('school')->name('library_books.')->group(function () {
    Route::get('library-books', [LibraryBookController::class, 'index'])->name('index');
    Route::get('library-books/create', [LibraryBookController::class, 'create'])->name('create');
    Route::post('library-books', [LibraryBookController::class, 'store'])->name('store');
    Route::get('library-books/{library_book}', [LibraryBookController::class, 'show'])->name('show');
    Route::get('library-books/{library_book}/edit', [LibraryBookController::class, 'edit'])->name('edit');
    Route::put('library-books/{library_book}', [LibraryBookController::class, 'update'])->name('update');
    Route::delete('library-books/{library_book}', [LibraryBookController::class, 'destroy'])->name('destroy');
});


use App\Http\Controllers\BookLoanController;

Route::middleware(['auth'])->prefix('school')->name('book_loans.')->group(function () {
    Route::get('book-loans', [BookLoanController::class, 'index'])->name('index');
    Route::get('book-loans/create', [BookLoanController::class, 'create'])->name('create');
    Route::post('book-loans', [BookLoanController::class, 'store'])->name('store');
    Route::post('book-loans/{book_loan}/return', [BookLoanController::class, 'return'])->name('return');
    Route::delete('book-loans/{book_loan}', [BookLoanController::class, 'destroy'])->name('destroy');
});


use App\Http\Controllers\NoticeController;

Route::middleware(['auth'])->prefix('school')->name('notices.')->group(function () {
    Route::get('notices', [NoticeController::class, 'index'])->name('index');
    Route::get('notices/create', [NoticeController::class, 'create'])->name('create');
    Route::post('notices', [NoticeController::class, 'store'])->name('store');
    Route::get('notices/{notice}', [NoticeController::class, 'show'])->name('show');
    Route::get('notices/{notice}/edit', [NoticeController::class, 'edit'])->name('edit');
    Route::put('notices/{notice}', [NoticeController::class, 'update'])->name('update');
    Route::delete('notices/{notice}', [NoticeController::class, 'destroy'])->name('destroy');
});



use App\Http\Controllers\EventController;

Route::middleware(['auth'])->prefix('school')->name('events.')->group(function () {
    Route::get('events', [EventController::class, 'index'])->name('index');
    Route::get('events/create', [EventController::class, 'create'])->name('create');
    Route::post('events', [EventController::class, 'store'])->name('store');
    Route::get('events/{event}', [EventController::class, 'show'])->name('show');
    Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('edit');
    Route::put('events/{event}', [EventController::class, 'update'])->name('update');
    Route::delete('events/{event}', [EventController::class, 'destroy'])->name('destroy');
});



use App\Http\Controllers\AnnouncementController;

Route::middleware(['auth'])->prefix('school')->name('announcements.')->group(function () {
    Route::get('announcements', [AnnouncementController::class, 'index'])->name('index');
    Route::get('announcements/create', [AnnouncementController::class, 'create'])->name('create');
    Route::post('announcements', [AnnouncementController::class, 'store'])->name('store');
    Route::get('announcements/{announcement}', [AnnouncementController::class, 'show'])->name('show');
    Route::get('announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
    Route::put('announcements/{announcement}', [AnnouncementController::class, 'update'])->name('update');
    Route::delete('announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
});


use App\Http\Controllers\HostelController;

Route::middleware(['auth'])->prefix('school')->name('hostels.')->group(function () {
    Route::get('hostels', [HostelController::class, 'index'])->name('index');
    Route::get('hostels/create', [HostelController::class, 'create'])->name('create');
    Route::post('hostels', [HostelController::class, 'store'])->name('store');
    Route::get('hostels/{hostel}', [HostelController::class, 'show'])->name('show');
    Route::get('hostels/{hostel}/edit', [HostelController::class, 'edit'])->name('edit');
    Route::put('hostels/{hostel}', [HostelController::class, 'update'])->name('update');
    Route::delete('hostels/{hostel}', [HostelController::class, 'destroy'])->name('destroy');
});



use App\Http\Controllers\HostelRoomController;

Route::middleware(['auth'])->prefix('school')->name('hostel-rooms.')->group(function () {
    Route::get('hostel-rooms', [HostelRoomController::class, 'index'])->name('index');
    Route::get('hostel-rooms/create', [HostelRoomController::class, 'create'])->name('create');
    Route::post('hostel-rooms', [HostelRoomController::class, 'store'])->name('store');
    Route::get('hostel-rooms/{hostel_room}', [HostelRoomController::class, 'show'])->name('show');
    Route::get('hostel-rooms/{hostel_room}/edit', [HostelRoomController::class, 'edit'])->name('edit');
    Route::put('hostel-rooms/{hostel_room}', [HostelRoomController::class, 'update'])->name('update');
    Route::delete('hostel-rooms/{hostel_room}', [HostelRoomController::class, 'destroy'])->name('destroy');

Route::get('hostel-capacity/{hostel}', function (\App\Models\Hostel $hostel) {
    $used = \App\Models\HostelRoom::where('hostel_id', $hostel->id)->sum('capacity');
    return response()->json([
        'total' => $hostel->capacity,
        'used' => $used,
        'remaining' => max(0, $hostel->capacity - $used),
    ]);
})->middleware('auth');

});


use App\Http\Controllers\HostelAllocationController;

Route::middleware(['auth'])->prefix('school')->name('hostel-allocations.')->group(function () {
    Route::get('hostel-allocations', [HostelAllocationController::class, 'index'])->name('index');
    Route::get('hostel-allocations/create', [HostelAllocationController::class, 'create'])->name('create');
    Route::post('hostel-allocations', [HostelAllocationController::class, 'store'])->name('store');
    Route::get('hostel-allocations/{hostel_allocation}', [HostelAllocationController::class, 'show'])->name('show');
    Route::get('hostel-allocations/{hostel_allocation}/edit', [HostelAllocationController::class, 'edit'])->name('edit');  // ✅ Add this
    Route::put('hostel-allocations/{hostel_allocation}', [HostelAllocationController::class, 'update'])->name('update');
    Route::delete('hostel-allocations/{hostel_allocation}', [HostelAllocationController::class, 'destroy'])->name('destroy');


});

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\HostelAllocation;

Route::get('unallocated-students', function (Request $request) {
    $schoolId = Auth::user()->school_id;

    $allocatedStudentIds = HostelAllocation::where('school_id', $schoolId)
        ->where('status', true)
        ->pluck('student_id');

    $students = Student::with('user')
        ->where('school_id', $schoolId)
        ->whereNotIn('user_id', $allocatedStudentIds)
        ->when($request->filled('search'), function ($query) use ($request) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('admission_number', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->filled('gender'), function ($query) use ($request) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        })
        ->paginate(10)
        ->withQueryString();

    return view('in.school.hostels.hostel_allocations.unallocated', compact('students'));
})->name('hostel-allocations.unallocated');


Route::middleware(['auth', 'role:student'])
    ->prefix('user')
    ->group(function () {
        Route::get('/dashboard',[StudentDashboardController::class, 'index'])->name('student.dashboard');
    });


Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard',[ dashboardController::class, 'index'])->name('dashboard');
    });

Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {

});


// GENERAL TIME TABLE
use App\Http\Controllers\GeneralScheduleController;
Route::middleware(['auth'])->prefix('school')->group(function () {
    Route::resource('general-schedule', GeneralScheduleController::class)->names([
        'index' => 'general-schedule.index',
        'create' => 'general-schedule.create',
        'store' => 'general-schedule.store',
        'edit' => 'general-schedule.edit',
        'update' => 'general-schedule.update',
        'destroy' => 'general-schedule.destroy',
        'show' => 'general-schedule.show',
    ]);
});

use App\Http\Controllers\TestTimetableController;
use App\Http\Controllers\ExamTimetableController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AcademicRecordController;
Route::middleware(['auth'])->prefix('school')->group(function () {
    Route::resource('tests', TestTimetableController::class);
    Route::resource('exams', ExamTimetableController::class);
    Route::resource('holidays', HolidayTimetableController::class);
    Route::resource('holidays', EventTimetableController::class);
    Route::resource('school-events', SchoolEventController::class);
});
Route::get('school/timetables/calendar', [TimetableController::class, 'calendarView'])->name('timetables.calendar');
Route::get('school/timetables/events', [TimetableController::class, 'calendarEvents'])->name('timetables.events');
Route::get('school/timetables/export/excel', [TimetableController::class, 'exportExcel'])->name('timetables.export.excel');
Route::get('school/timetables/export/pdf', [TimetableController::class, 'exportPdf'])->name('timetables.export.pdf');

Route::get('school/simple-calendar', [CalendarController::class, 'siimplifiedWeeklyView'])->name('calendar.sample');
Route::middleware(['auth'])->prefix('school')->group(function () {
    Route::get('simple-calendar', [CalendarController::class, 'simplifiedWeeklyView'])->name('calendar.simple');
});
Route::get('school/simple-calendar/pdf', [CalendarController::class, 'exportPdf'])->name('calendar.pdf');


// Grouping under middleware for authenticated users (optional but recommended)
Route::middleware(['auth'])->group(function () {
    Route::resource('assignments', AssignmentController::class);
});


Route::middleware(['auth'])->prefix('school')->name('academic-records.')->group(function () {
    Route::get('academic-records', [AcademicRecordController::class, 'index'])->name('index');
    Route::get('academic-records/create', [AcademicRecordController::class, 'create'])->name('create');
    Route::post('academic-records', [AcademicRecordController::class, 'store'])->name('store');
    Route::get('academic-records/{academicRecord}/edit', [AcademicRecordController::class, 'edit'])->name('edit');
    Route::put('academic-records/{academicRecord}', [AcademicRecordController::class, 'update'])->name('update');
    Route::get('academic-records/{academicRecord}', [AcademicRecordController::class, 'show'])->name('show');
    Route::delete('academic-records/{academicRecord}', [AcademicRecordController::class, 'destroy'])->name('destroy');
    Route::get('academic-records/reports', [AcademicRecordController::class, 'reports'])->name('reports');
});

use App\Http\Controllers\SubmissionController;

Route::middleware(['auth'])->group(function () {
    Route::resource('submissions', SubmissionController::class)->except(['edit', 'update']);
});

use App\Http\Controllers\ExamTypeController;

Route::middleware(['auth'])->group(function () {
    Route::resource('exam-types', ExamTypeController::class);
});

use App\Http\Controllers\GradeController;

Route::middleware(['auth'])->group(function () {
    Route::resource('grades', GradeController::class);
});


use App\Http\Controllers\ExamController;

Route::middleware(['auth'])->group(function () {
    Route::resource('exams', ExamController::class);
});


use App\Http\Controllers\ExamResultController;

Route::middleware(['auth'])->group(function () {
    Route::resource('exam-results', ExamResultController::class);
    Route::post('exam-results/{examResult}/publish', [ExamResultController::class, 'publish'])->name('exam-results.publish');
});

Route::middleware(['auth'])->group(function () {
    Route::get('exam-results/import/{exam}', [ExamResultController::class, 'showImportForm'])->name('exam-results.import.form');
    Route::post('exam-results/import/{exam}', [ExamResultController::class, 'import'])->name('exam-results.import');
});
