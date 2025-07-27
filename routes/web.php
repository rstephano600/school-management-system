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
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Password Reset Routes
Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::get('/import/file', [UsersController::class, 'showimport'])->name('import.userfile');
Route::get('/export', [UsersController::class, 'export'])->name('export.user');
Route::post('/import', [UsersController::class, 'import'])->name('import.user');

Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {

    Route::resource('users', UsersController::class);

    Route::get('users-import', [UsersController::class, 'showimport'])->name('users.import');
    Route::post('users-import', [UsersController::class, 'import'])->name('users.import.post');
    Route::get('users-export', [UsersController::class, 'export'])->name('users.export');
});


// DASHBOARD
Route::get('/admin/dashboard', function () {

    return view('admin.dashboard');

})->middleware(['auth', 'role:admin']);

Route::get('/dashboard', function () {
    $user = Auth::user();
    return match ($user->role) {
        'super_admin' => redirect()->route('superadmin.dashboard'),
        'school_admin' => redirect()->route('schooladmin.dashboard'),
        'school_creator' => redirect()->route('schoolcreator.dashboard'),
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

use App\Http\Controllers\Academicmaster\DashboardController as AcademicmasterDashboardController;

Route::middleware(['auth', 'role:academic_master'])
    ->prefix('academicmaster')
    ->name('academicmaster.')
    ->group(function () {
        Route::get('/dashboard', [AcademicmasterDashboardController::class, 'index'])->name('dashboard');
    });

use App\Http\Controllers\secretary\DashboardController as SecretaryDashboardController;

Route::middleware(['auth', 'role:secretary'])
    ->prefix('secretary')
    ->name('secretary.')
    ->group(function () {
        Route::get('/dashboard', [SecretaryDashboardController::class, 'index'])->name('dashboard');
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

        Route::get('/schools/{school}/register-user', [SchoolUserController::class, 'create'])->name('schools.users.create');
        Route::post('/schools/{school}/register-user', [SchoolUserController::class, 'store'])->name('schools.users.store');
        Route::get('/schools/{school}/users', [SchoolController::class, 'showUsers'])->name('schools.users');
        Route::get('/schools/{school}/users/export/{type}', [SchoolController::class, 'exportUsers'])->name('superadmin.schools.users.export');

    });

use App\Http\Controllers\school\SchoolUsersController;

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


Route::middleware(['auth', 'role:school_admin'])
    ->group(function () {
        
    Route::get('/school/users/list', [SchoolUsersController::class, 'index'])->name('users.index');
    Route::get('/school/users/register', [SchoolUsersController::class, 'create'])->name('users.create');
    Route::post('/school/users/Store', [SchoolUsersController::class, 'store'])->name('users.store');
    Route::get('/school/users/Show/{user}', [SchoolUsersController::class, 'show'])->name('users.show');
    Route::get('/school/users/edit/{user}', [SchoolUsersController::class, 'edit'])->name('users.edit');
    Route::post('/school/users/update/{user}', [SchoolUsersController::class, 'update'])->name('users.update');
    Route::get('/school/users/delete', [SchoolUsersController::class, 'destroy'])->name('users.destroy');

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
Route::get('/students/parent/{user}/edit', [ParentController::class, 'edit'])->name('student.parent.edit');
Route::put('/students/{student}/parent/{user}', [ParentController::class, 'update'])->name('student.parent.update');
Route::delete('/students/parent/{user}', [ParentController::class, 'destroy'])->name('student.parent.destroy');

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

Route::prefix('fee-payments')->name('fee-payments.')->group(function () {
    Route::get('/', [FeePaymentController::class, 'index'])->name('index');
    Route::get('/{id}', [FeePaymentController::class, 'show'])->name('show');
    Route::get('/export/data', [FeePaymentController::class, 'export'])->name('export');
    Route::get('/student/payment-summary', [FeePaymentController::class, 'getStudentPaymentSummary'])->name('student.payment-summary');
});


Route::middleware(['auth', 'role:school_admin,academic_master'])->group(function () {
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

Route::middleware(['auth'])->prefix('school')->group(function () {

    // Exams CRUD
    Route::resource('exams', ExamController::class);

    // Exam Results
    Route::get('exams/{exam}/results', [ExamResultController::class, 'index'])
        ->name('exams.results.index'); // View & enter results

    Route::post('exams/{exam}/results', [ExamResultController::class, 'store'])
        ->name('exams.results.store'); // Submit results

    Route::post('exams/{exam}/results/publish', [ExamResultController::class, 'publish'])
        ->name('exams.results.publish'); // Optional: publish results

    // Route::get('exams/the/{exam}/results', [ExamResultController::class, 'examresult'])->name('exam-results.index');
});
Route::middleware(['auth'])->prefix('exam-results')->name('exam-results.')->group(function () {
    // Main listing page with filters and search
    Route::get('/', [ExamResultController::class, 'index'])->name('index');
    
    // Show individual result details
    Route::get('/{id}', [ExamResultController::class, 'show'])->name('show');
    
    // Student exam history
    Route::get('/student/{studentId}/history', [ExamResultController::class, 'studentHistory'])->name('student-history');
    
    // AJAX route to get semesters based on academic year
    Route::get('/ajax/semesters', [ExamResultController::class, 'getSemesters'])->name('get-semesters');
    
    // Export routes
    Route::post('/export', [ExamResultController::class, 'export'])->name('export');
});


Route::middleware(['auth'])->prefix('school')->group(function () {
    Route::get('exams/results', [ExamResultController::class, 'index'])->name('generalexam-results.index');
});


Route::middleware(['auth'])->prefix('school')->group(function () {
    Route::get('exam-results/general', [ExamResultController::class, 'generalResults'])
        ->name('exam-results.general');
});
Route::get('exam-results/print', [ExamResultController::class, 'print'])->name('exam-results.print');
Route::get('exam-results/Export/Excel', [ExamResultController::class, 'export'])->name('exam-results.export');


use App\Http\Controllers\StudentGradeLevelController;

// Group routes under "students/{student}/grades"
Route::prefix('students/{student}/grades')->middleware(['auth'])->group(function () {

    // View all grade records for a student (with pagination, filters)
    Route::get('/', [StudentGradeLevelController::class, 'index'])
        ->name('student.grades.index');

    // Show form to promote student to a new grade
    Route::get('/promote', [StudentGradeLevelController::class, 'create'])
        ->name('student.grades.promote');

    // Handle promotion (store new grade level)
    Route::post('/', [StudentGradeLevelController::class, 'store'])
        ->name('student.grades.store');

    // Mark student as graduated (optional)
    Route::post('/graduate', [StudentGradeLevelController::class, 'graduate'])
        ->name('student.grades.graduate');
});


use App\Http\Controllers\School\GradeController;

Route::middleware(['auth'])->prefix('school')->name('grades.')->group(function () {
    Route::get('grades', [\App\Http\Controllers\School\GradeController::class, 'index'])->name('index');
    Route::get('grades/create', [\App\Http\Controllers\School\GradeController::class, 'create'])->name('create');
    Route::post('grades', [\App\Http\Controllers\School\GradeController::class, 'store'])->name('store');
    Route::get('grades/{grade}', [\App\Http\Controllers\School\GradeController::class, 'show'])->name('show');
    Route::get('grades/{grade}/edit', [\App\Http\Controllers\School\GradeController::class, 'edit'])->name('edit');
    Route::put('grades/{grade}', [\App\Http\Controllers\School\GradeController::class, 'update'])->name('update');
    Route::delete('grades/{grade}', [\App\Http\Controllers\School\GradeController::class, 'destroy'])->name('destroy');
});

use App\Http\Controllers\School\DivisionController;

Route::middleware(['auth'])->group(function () {
    Route::resource('divisions', DivisionController::class);
});


// routes/web.php

use App\Http\Controllers\School\AssessmentController;
// use App\Http\Controllers\School\AssessmentResultController;

Route::middleware(['auth'])->prefix('school')->name('assessments.')->group(function () {
    Route::get('assessments', [AssessmentController::class, 'index'])->name('index');
    Route::get('assessments/create', [AssessmentController::class, 'create'])->name('create');
    Route::post('assessments', [AssessmentController::class, 'store'])->name('store');
    Route::get('assessments/{assessment}', [AssessmentController::class, 'show'])->name('show');
    Route::get('assessments/{assessment}/edit', [AssessmentController::class, 'edit'])->name('edit');
    Route::put('assessments/{assessment}', [AssessmentController::class, 'update'])->name('update');
    Route::delete('assessments/{assessment}', [AssessmentController::class, 'destroy'])->name('destroy');
});


use App\Http\Controllers\AssessmentResultController;

// Assessment Results Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/assessment-results', [AssessmentResultController::class, 'index'])
        ->name('assessment-results.index');
    
    Route::get('/assessment-results/{id}', [AssessmentResultController::class, 'show'])
        ->name('assessment-results.show');
    
    Route::get('/assessment-results/export', [AssessmentResultController::class, 'export'])
        ->name('assessment-results.export');
    
    Route::get('/assessment-results/{id}/print', [AssessmentResultController::class, 'print'])
        ->name('assessment-results.print');
});


Route::get('assessments/{assessment}/results', [AssessmentResultController::class, 'index'])->name('assessments.results.index');
Route::post('assessments/{assessment}/results', [AssessmentResultController::class, 'store'])->name('assessments.results.store');
Route::get('students/{student}/assessment-summary', [AssessmentResultController::class, 'summary'])
    ->name('students.assessments.summary');






// routes/web.php

use App\Http\Controllers\teacher\TeacherController as TeacherClassController;

Route::middleware(['auth'])->group(function () {
    Route::get('/teacher/classes', [TeacherClassController::class, 'myclasses'])->name('teacher.classes.index');
    Route::get('/teacher/students', [TeacherClassController::class, 'myStudents'])->name('teacher.students.index');

});
use App\Http\Controllers\teacher\TeacherAssessmentController;

Route::middleware(['auth'])->group(function () {
    Route::get('/teacher/assessments/create', [TeacherAssessmentController::class, 'create'])->name('teacher.assessments.create');
    Route::post('/teacher/assessments', [TeacherAssessmentController::class, 'store'])->name('teacher.assessments.store');
    Route::get('/teacher/semesters', [TeacherAssessmentController::class, 'getSemesters'])->name('teacher.semesters.get');
});



// Add these routes to your web.php file

use App\Http\Controllers\school\TimetableController as SchoolTimetableController;

Route::middleware(['auth'])->group(function () {
    // Timetable routes
    Route::get('/timetable', [SchoolTimetableController::class, 'index'])->name('timetable.index');
    Route::post('/timetable/export', [SchoolTimetableController::class, 'export'])->name('timetable.export');
    
    // Additional timetable management routes (optional)
    Route::get('/timetable/create', [SchoolTimetableController::class, 'create'])->name('timetable.create');
    Route::post('/timetable', [SchoolTimetableController::class, 'store'])->name('timetable.store');
    Route::get('/timetable/{id}/edit', [SchoolTimetableController::class, 'edit'])->name('timetable.edit');
    Route::put('/timetable/{id}', [SchoolTimetableController::class, 'update'])->name('timetable.update');
    Route::delete('/timetable/{id}', [SchoolTimetableController::class, 'destroy'])->name('timetable.destroy');
    
    // AJAX routes for dynamic loading
    Route::get('/timetable/ajax/sections/{grade_id}', [TimetableController::class, 'getSectionsByGrade']);
    Route::get('/timetable/ajax/conflicts', [TimetableController::class, 'checkConflicts']);
});

use App\Http\Controllers\school\UserExportController;
Route::middleware(['auth'])->group(function () {
    // Timetable routes
    Route::get('/school/students', [UserExportController::class, 'students'])->name('export.students');
    Route::post('/Students/exportStudents', [UserExportController::class, 'exportStudents'])->name('export.exportStudents');

});


use App\Http\Controllers\school\ExportController;

Route::middleware(['auth'])->prefix('school')->name('school.')->group(function () {
    
    // Export Routes Group
    Route::prefix('export')->name('export.')->group(function () {
        
        // Students Export
        Route::get('/students', [App\Http\Controllers\School\ExportController::class, 'students'])
            ->name('students')
            ->middleware('can:viewAny,App\Models\Student');
        
        Route::post('/students/export', [App\Http\Controllers\School\ExportController::class, 'exportStudents'])
            ->name('students.export')
            ->middleware('can:viewAny,App\Models\Student');
        
        // Teachers Export
        Route::get('/teachers', [App\Http\Controllers\School\ExportController::class, 'teachers'])
            ->name('teachers')
            ->middleware('can:viewAny,App\Models\Teacher');
        
        Route::post('/teachers/export', [App\Http\Controllers\School\ExportController::class, 'exportTeachers'])
            ->name('teachers.export')
            ->middleware('can:viewAny,App\Models\Teacher');
        
        // Staff Export
        Route::get('/staff', [App\Http\Controllers\School\ExportController::class, 'staff'])
            ->name('staff')
            ->middleware('can:viewAny,App\Models\Staff');
        
        Route::post('/staff/export', [App\Http\Controllers\School\ExportController::class, 'exportStaff'])
            ->name('staff.export')
            ->middleware('can:viewAny,App\Models\Staff');
        
        // Parents Export
        Route::get('/parents', [App\Http\Controllers\School\ExportController::class, 'parents'])
            ->name('parents')
            ->middleware('can:viewAny,App\Models\Parents');
        
        Route::post('/parents/export', [App\Http\Controllers\School\ExportController::class, 'exportParents'])
            ->name('parents.export')
            ->middleware('can:viewAny,App\Models\Parents');
        
        // All Users Export
        Route::get('/users', [App\Http\Controllers\School\ExportController::class, 'users'])
            ->name('users');
            // ->middleware('can:viewAny,App\Models\User');
        
        Route::post('/users/export', [App\Http\Controllers\School\ExportController::class, 'exportUsers'])
            ->name('users.export');
            // ->middleware('can:viewAny,App\Models\User');
    });
});



use App\Http\Controllers\PaymentCategoryController;
use App\Http\Controllers\StudentPaymentController;
use App\Http\Controllers\MichangoController;
use App\Http\Controllers\PaymentReportController;

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Payment Categories Management
    Route::prefix('payment/categories')->name('payment.categories.')->group(function () {
        Route::get('/', [PaymentCategoryController::class, 'index'])->name('index');
        Route::get('/create', [PaymentCategoryController::class, 'create'])->name('create');
        Route::post('/', [PaymentCategoryController::class, 'store'])->name('store');
        Route::get('/{paymentCategory}', [PaymentCategoryController::class, 'show'])->name('show');
        Route::get('/{paymentCategory}/edit', [PaymentCategoryController::class, 'edit'])->name('edit');
        Route::put('/{paymentCategory}', [PaymentCategoryController::class, 'update'])->name('update');
        Route::delete('/{paymentCategory}', [PaymentCategoryController::class, 'destroy'])->name('destroy');
        
        // Grade Level Fee Setup
        Route::get('/{paymentCategory}/setup-fees', [PaymentCategoryController::class, 'setupGradeFees'])->name('setup-fees');
        Route::post('/{paymentCategory}/setup-fees', [PaymentCategoryController::class, 'storeGradeFees'])->name('store-fees');
        
        // AJAX Routes
        Route::get('/api/common', [PaymentCategoryController::class, 'getCommonCategories'])->name('api.common');
        Route::get('/api/active', [PaymentCategoryController::class, 'getActiveCategories'])->name('api.active');
        Route::post('/api/bulk-toggle-status', [PaymentCategoryController::class, 'bulkToggleStatus'])->name('api.bulk-toggle');
    });

    // Student Payments Management
    Route::prefix('student-payments')->name('student-payments.')->group(function () {
        Route::get('/', [StudentPaymentController::class, 'index'])->name('index');
        Route::get('/{student}', [StudentPaymentController::class, 'show'])->name('show');
        Route::get('/{student}/history', [StudentPaymentController::class, 'paymentHistory'])->name('history');
        
        // Payment Recording
        Route::post('/{student}/record-payment', [StudentPaymentController::class, 'recordPayment'])->name('record-payment');
        Route::post('/{student}/record-michango', [StudentPaymentController::class, 'recordMichangoPayment'])->name('record-michango');
        
        // Requirement Generation
        Route::post('/generate-requirements', [StudentPaymentController::class, 'generateRequirements'])->name('generate-requirements');
        Route::post('/bulk-generate-requirements', [StudentPaymentController::class, 'bulkGenerateRequirements'])->name('bulk-generate-requirements');
        
        // AJAX Routes
        Route::get('/{student}/payment-categories', [StudentPaymentController::class, 'getStudentPaymentCategories'])->name('api.categories');
        Route::get('/export', [StudentPaymentController::class, 'exportPayments'])->name('export');
    });

    // Michango (Contributions) Management
    Route::prefix('michango')->name('michango.')->group(function () {
        Route::get('/', [MichangoController::class, 'index'])->name('index');
        Route::get('/create', [MichangoController::class, 'create'])->name('create');
        Route::post('/', [MichangoController::class, 'store'])->name('store');
        Route::get('/{michangoCategory}', [MichangoController::class, 'show'])->name('show');
        Route::get('/{michangoCategory}/edit', [MichangoController::class, 'edit'])->name('edit');
        Route::put('/{michangoCategory}', [MichangoController::class, 'update'])->name('update');
        Route::delete('/{michangoCategory}', [MichangoController::class, 'destroy'])->name('destroy');
        
        // Student Michango Management
        Route::get('/{michangoCategory}/students', [MichangoController::class, 'showStudents'])->name('students');
        Route::post('/{michangoCategory}/set-pledge', [MichangoController::class, 'setPledge'])->name('set-pledge');
        Route::get('/{michangoCategory}/contributions-report', [MichangoController::class, 'contributionsReport'])->name('contributions-report');
        
        // AJAX Routes
        Route::get('/api/active', [MichangoController::class, 'getActiveMichango'])->name('api.active');
        Route::post('/api/bulk-set-pledges', [MichangoController::class, 'bulkSetPledges'])->name('api.bulk-pledges');
    });

    // Payment Reports
    Route::prefix('payment-reports')->name('payment-reports.')->group(function () {
        Route::get('/', [PaymentReportController::class, 'index'])->name('index');
        Route::get('/school-summary', [PaymentReportController::class, 'schoolSummary'])->name('school-summary');
        Route::get('/grade-analysis', [PaymentReportController::class, 'gradeAnalysis'])->name('grade-analysis');
        Route::get('/payment-methods', [PaymentReportController::class, 'paymentMethods'])->name('payment-methods');
        Route::get('/overdue-payments', [PaymentReportController::class, 'overduePayments'])->name('overdue-payments');
        Route::get('/michango-progress', [PaymentReportController::class, 'michangoProgress'])->name('michango-progress');
        Route::get('/daily-collections', [PaymentReportController::class, 'dailyCollections'])->name('daily-collections');
        
        // Export Routes
        Route::get('/export/school-summary', [PaymentReportController::class, 'exportSchoolSummary'])->name('export.school-summary');
        Route::get('/export/grade-analysis', [PaymentReportController::class, 'exportGradeAnalysis'])->name('export.grade-analysis');
        Route::get('/export/overdue-payments', [PaymentReportController::class, 'exportOverduePayments'])->name('export.overdue-payments');
        Route::get('/export/daily-collections', [PaymentReportController::class, 'exportDailyCollections'])->name('export.daily-collections');
    });

    // Payment Receipts
    Route::prefix('payment-receipts')->name('payment-receipts.')->group(function () {
        Route::get('/{studentPayment}', [PaymentReceiptController::class, 'show'])->name('show');
        Route::get('/{studentPayment}/pdf', [PaymentReceiptController::class, 'generatePDF'])->name('pdf');
        Route::get('/{studentPayment}/print', [PaymentReceiptController::class, 'printReceipt'])->name('print');
        Route::post('/{studentPayment}/email', [PaymentReceiptController::class, 'emailReceipt'])->name('email');
    });

    // Bulk Operations
    Route::prefix('bulk-operations')->name('bulk-operations.')->group(function () {
        Route::post('/generate-requirements', [BulkOperationController::class, 'generateRequirements'])->name('generate-requirements');
        Route::post('/update-amounts', [BulkOperationController::class, 'updateAmounts'])->name('update-amounts');
        Route::post('/send-reminders', [BulkOperationController::class, 'sendPaymentReminders'])->name('send-reminders');
        Route::post('/apply-late-fees', [BulkOperationController::class, 'applyLateFees'])->name('apply-late-fees');
        Route::post('/waive-payments', [BulkOperationController::class, 'waivePayments'])->name('waive-payments');
    });

    // Payment Settings
    Route::prefix('payment-settings')->name('payment-settings.')->group(function () {
        Route::get('/', [PaymentSettingsController::class, 'index'])->name('index');
        Route::post('/update', [PaymentSettingsController::class, 'update'])->name('update');
        Route::post('/reset', [PaymentSettingsController::class, 'reset'])->name('reset');
    });
});

// API Routes for mobile app or external integrations
Route::prefix('api/v1')->middleware(['auth:sanctum'])->group(function () {
    
    // Student Payment API
    Route::get('/students/{student}/payments', [Api\StudentPaymentApiController::class, 'index']);
    Route::get('/students/{student}/payment-summary', [Api\StudentPaymentApiController::class, 'summary']);
    Route::post('/students/{student}/payments', [Api\StudentPaymentApiController::class, 'store']);
    
    // Payment Categories API
    Route::get('/payment-categories', [Api\PaymentCategoryApiController::class, 'index']);
    Route::get('/payment-categories/{category}/fees', [Api\PaymentCategoryApiController::class, 'fees']);
    
    // Michango API
    Route::get('/michango', [Api\MichangoApiController::class, 'index']);
    Route::get('/michango/{category}/contributions', [Api\MichangoApiController::class, 'contributions']);
    Route::post('/michango/{category}/contribute', [Api\MichangoApiController::class, 'contribute']);
    
    // Payment Reports API
    Route::get('/payment-reports/dashboard', [Api\PaymentReportApiController::class, 'dashboard']);
    Route::get('/payment-reports/summary', [Api\PaymentReportApiController::class, 'summary']);
});

// Webhook Routes for payment gateways (if using online payments)
Route::prefix('webhooks')->name('webhooks.')->group(function () {
    Route::post('/mobile-money/callback', [WebhookController::class, 'mobileMoneyCallback'])->name('mobile-money');
    Route::post('/bank-transfer/callback', [WebhookController::class, 'bankTransferCallback'])->name('bank-transfer');
    Route::post('/card-payment/callback', [WebhookController::class, 'cardPaymentCallback'])->name('card-payment');
});

// Public routes for payment verification (no auth required)
Route::prefix('payments/verify')->name('payments.verify.')->group(function () {
    Route::get('/{reference}', [PaymentVerificationController::class, 'verify'])->name('reference');
    Route::post('/receipt-lookup', [PaymentVerificationController::class, 'receiptLookup'])->name('receipt-lookup');
});


use App\Http\Controllers\StudentRequirementController;

Route::prefix('student-requirements')->name('student-requirements.')->group(function () {
    Route::get('/', [StudentRequirementController::class, 'index'])->name('index');
    Route::get('/create', [StudentRequirementController::class, 'create'])->name('create');
    Route::post('/', [StudentRequirementController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [StudentRequirementController::class, 'edit'])->name('edit');
    Route::put('/{id}', [StudentRequirementController::class, 'update'])->name('update');
    Route::delete('/{id}', [StudentRequirementController::class, 'destroy'])->name('destroy');
});

use App\Http\Controllers\StudentRequirementSubmissionController;

Route::prefix('student-requirement-submissions')->name('student-requirement-submissions.')->group(function () {
    Route::get('/', [StudentRequirementSubmissionController::class, 'index'])->name('index');
    Route::get('/create', [StudentRequirementSubmissionController::class, 'create'])->name('create');
    Route::post('/', [StudentRequirementSubmissionController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [StudentRequirementSubmissionController::class, 'edit'])->name('edit');
    Route::put('/{id}', [StudentRequirementSubmissionController::class, 'update'])->name('update');
    Route::delete('/{id}', [StudentRequirementSubmissionController::class, 'destroy'])->name('destroy');
});




// Add these routes to your existing routes/web.php file

use App\Http\Controllers\SchoolController as CreatorSchoolController;

// School management routes
Route::group(['prefix' => 'schools'], function () {
    Route::get('/', [CreatorSchoolController::class, 'index'])->name('schools.index');
    Route::get('/create', [CreatorSchoolController::class, 'create'])->name('schools.create');
    Route::post('/', [CreatorSchoolController::class, 'store'])->name('schools.store');
    Route::get('/{school}', [CreatorSchoolController::class, 'show'])->name('schools.show');
    Route::get('/{school}/edit', [CreatorSchoolController::class, 'edit'])->name('schools.edit');
    Route::put('/{school}', [CreatorSchoolController::class, 'update'])->name('schools.update');
    Route::delete('/{school}', [CreatorSchoolController::class, 'destroy'])->name('schools.destroy');
    Route::patch('/{school}/toggle-status', [CreatorSchoolController::class, 'toggleStatus'])->name('schools.toggle-status');
    Route::get('/api/data', [CreatorSchoolController::class, 'getData'])->name('schools.data');
});

// School Creator Dashboard Route (add this to your existing dashboard routes)
Route::get('/school-creator/dashboard', function () {
    if (!auth()->check() || auth()->user()->role !== 'school_creator') {
        abort(403, 'Unauthorized access');
    }
    
    return view('in.school-creator.dashboard');
})->name('schoolcreator.dashboard');

use App\Http\Controllers\SubscriptionController;
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('subscriptions', SubscriptionController::class);
});
use App\Http\Controllers\SubscriptionCategoryController;

Route::resource('subscription-categories', SubscriptionCategoryController::class);



use App\Http\Controllers\auth\PasswordController;

Route::middleware(['auth'])->group(function () {
    
    // User's own password change routes
    Route::get('/change-password', [PasswordController::class, 'showChangePasswordForm'])
        ->name('password.change.form');
    Route::post('/change-password', [PasswordController::class, 'changePassword'])
        ->name('password.change');
    
    // User profile route
    Route::get('/profile', [PasswordController::class, 'showProfile'])
        ->name('profile.index');
    
    // Admin password reset routes (for super_admin and school_admin)
    Route::middleware(['role:super_admin,school_admin'])->group(function () {
        Route::get('/admin/password-reset', [PasswordController::class, 'showAdminResetForm'])
            ->name('admin.password.reset.form');
        Route::post('/admin/password-reset', [PasswordController::class, 'adminResetPassword'])
            ->name('admin.password.reset');
        Route::post('/admin/bulk-password-reset', [PasswordController::class, 'bulkResetPassword'])
            ->name('admin.password.bulk.reset');
        Route::get('/admin/generate-password', [PasswordController::class, 'generatePassword'])
            ->name('admin.password.generate');
        Route::get('/admin/users-for-reset', [PasswordController::class, 'getUsersForReset'])
            ->name('admin.users.for.reset');
    });
});

use App\Http\Controllers\StudentAllExaminationController;

// Student Examination Results Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('student-examinations')->name('student-examinations.')->group(function () {
        Route::get('/', [StudentAllExaminationController::class, 'index'])->name('index');
        Route::get('/show/{id}', [StudentAllExaminationController::class, 'show'])->name('show');
        Route::get('/export', [StudentAllExaminationController::class, 'export'])->name('export');
        Route::get('/analytics', [StudentAllExaminationController::class, 'analytics'])->name('analytics');
    });
});

// Note: You'll need to create a custom middleware for role checking
// Create app/Http/Middleware/CheckRole.php and register it in bootstrap/app.php