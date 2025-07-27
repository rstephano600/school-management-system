<aside class="app-sidebar">
    <div class="sidebar-header px-1 py-1 text-center">
        <small class="text-green">
            @if(Auth::check())
                {{ Auth::user()->school->name ?? 'School Management System' }}
            @endif
        </small>
    </div>
    
    <div class="sidebar-menu py-2">
        <!-- Dashboard (Visible to all authenticated users) -->
        <ul class="list-unstyled">
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>

        <!-- Super Admin Menu -->
        @if(Auth::user()->role === 'super_admin')
            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Super Admin</div>
            <ul class="list-unstyled">
                <li class="{{ request()->is('admin/schools*') ? 'active' : '' }}">
                    <a href="{{ route('superadmin.schools') }}">
                        <i class="fas fa-fw fa-university"></i>
                        <span> All Schools</span>
                    </a>
                </li>
                
<li class="{{ request()->is('superadmin/users*') ? 'active' : '' }}">
    <a href="{{ route('superadmin.users.index') }}">
        <i class="fas fa-fw fa-users-cog"></i>
        <span>System Users</span>
    </a>
</li>

                            <li>
                            <a href="{{ route('admin.password.reset.form') }}">
                                <i class="fas fa-fw fa-users-cog"></i>
                                <span>Password Management</span>
                                <span class="badge bg-danger float-end">All Users</span>
                            </a>
                        </li>

<!-- <div class="list-group mb-4">
    <a href="{{ route('subscriptions.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('subscriptions.index') ? 'active' : '' }}">
        All Subscriptions
    </a>
    <a href="{{ route('subscriptions.create') }}" class="list-group-item list-group-item-action {{ request()->routeIs('subscriptions.create') ? 'active' : '' }}">
        Create Subscription
    </a>
    <a href="{{ route('subscription-categories.index') }}" class="list-group-item list-group-item-action">
        Subscription Categories
    </a>
</div> -->
                
                <li class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-fw fa-sliders-h"></i>
                        <span>System Settings</span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/reports*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-fw fa-chart-pie"></i>
                        <span>Reports & Analytics</span>
                    </a>
                </li>
            </ul>

            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Monitoring</div>
            <ul class="list-unstyled">
                <li class="{{ request()->is('admin/alerts*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-fw fa-bell"></i>
                        <span>Alerts</span>
                        <span class="badge bg-danger float-end">3</span>
                    </a>
                </li>
                
                <li class="{{ request()->is('admin/audit*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-fw fa-clipboard-list"></i>
                        <span>Audit Logs</span>
                    </a>
                </li>
                
                <li class="{{ request()->is('admin/backup*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-fw fa-database"></i>
                        <span>System Backup</span>
                    </a>
                </li>
            </ul>
        @endif

        @if(in_array(Auth::user()->role, ['super_admin','school_creator']))
        <!-- School Management -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#schoolManagement">
        <i class="fas fa-school me-2"></i> School Management
    </a>
    <div id="schoolManagement" class="collapse">
        <ul class="nav flex-column ps-4">
            <li><a href="{{ route('schools.index') }}" class="nav-link"><i class="fas fa-list me-1"></i> All Schools</a></li>
            <li><a href="{{ route('schools.create') }}" class="nav-link"><i class="fas fa-plus me-1"></i> Create School</a></li>
            <!-- <li><a href="{{ route('schools.data') }}" class="nav-link"><i class="fas fa-database me-1"></i> Schools Data API</a></li> -->
        </ul>
    </div>
</li>
        @endif
        <!-- School Admin Menu -->
        @if(in_array(Auth::user()->role, ['school_admin', 'director', 'manager','academic_master']))
            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">School Administration</div>
            
            <!-- Student Management -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#studentManagement" aria-expanded="false">
        <i class="fas fa-user-graduate me-2"></i> Student Management
    </a>
    <div id="studentManagement" class="collapse">
        <ul class="nav flex-column ps-4">
            <!-- Student List & Registration -->
            <li>
                <a href="{{ route('students.index') }}" class="nav-link">
                    <i class="fas fa-users me-2"></i> Student List
                </a>
            </li>
            <li>
                <a href="{{ route('students.create') }}" class="nav-link">
                    <i class="fas fa-user-plus me-2"></i> Register Student
                </a>
            </li>

            <!-- Parent Management -->
            <li>
                <a href="{{ route('student.parent.index') }}" class="nav-link">
                    <i class="fas fa-user-friends me-2"></i> Parents
                </a>
            </li>
            <li>
                <a href="{{ route('student-requirement-submissions.index') }}" class="nav-link">
                    <i class="fas fa-upload me-2"></i> Requirement Submissions
                </a>
            </li>
            <li>
                <a href="{{ route('student-requirement-submissions.create') }}" class="nav-link">
                    <i class="fas fa-plus-circle me-2"></i> Add Requirement Submissions
                </a>
            </li>


            <!-- Payments -->
            <li>
                <a href="{{ route('student-payments.index') }}" class="nav-link">
                    <i class="fas fa-money-bill-wave me-2"></i> Student Payments
                </a>
            </li>

            <!-- Export Students -->
            <li>
                <a href="{{ route('export.students') }}" class="nav-link">
                    <i class="fas fa-file-export me-2"></i> Export Students
                </a>
            </li>

        </ul>
    </div>
</li>


            <!-- User Management -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#userManagement">
                    <i class="fas fa-users me-2"></i> User Management
                </a>
                <div id="userManagement" class="collapse">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('students.index') }}" class="nav-link"><i class="fas fa-user-graduate me-1"></i> Students</a></li>
                        <li><a href="{{ route('teachers.index') }}" class="nav-link"><i class="fas fa-chalkboard-teacher me-1"></i> Teachers</a></li>
                        <li><a href="{{ route('schools.staff.index') }}" class="nav-link"><i class="fas fa-users me-1"></i> Staff</a></li>
                        <li><a href="{{ route('student.parent.index') }}" class="nav-link"><i class="fas fa-user-tie me-1"></i> Parents</a></li>
                        <li><a href="{{ route('users.index') }}" class="nav-link"><i class="fas fa-users me-1"></i> All System Users</a></li>
                            <li>
                            <a href="{{ route('admin.password.reset.form') }}">
                                <i class="fas fa-fw fa-users-cog"></i>
                                <span>Password Management</span>
                                <span class="badge bg-danger float-end">All Users</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Academic Management -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#academicManagement">
                    <i class="fas fa-graduation-cap me-2"></i> Academic Structure
                </a>
                <div id="academicManagement" class="collapse">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('academic-years.index') }}" class="nav-link"><i class="fas fa-calendar me-1"></i> Academic Years</a></li>
                        <li><a href="{{ route('semesters.index') }}" class="nav-link"><i class="fas fa-calendar-alt me-1"></i> Semesters</a></li>
                        <li><a href="{{ route('grade-levels.index') }}" class="nav-link"><i class="fas fa-layer-group me-1"></i> Grade Levels/Form</a></li>
                        <li><a href="{{ route('classes.index') }}" class="nav-link"><i class="fas fa-school me-1"></i> Classes</a></li>
                        <li><a href="{{ route('sections.index') }}" class="nav-link"><i class="fas fa-object-group me-1"></i> Sections</a></li>
                        <li><a href="{{ route('subjects.index') }}" class="nav-link"><i class="fas fa-book me-1"></i> Subjects</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="nav-link"><i class="fas fa-door-closed me-1"></i> Rooms</a></li>
                        <li><a href="{{ route('grades.index') }}" class="nav-link"><i class="fas fa-chart-line me-1"></i> Grades Scores</a></li>
                        <li><a href="{{ route('divisions.index') }}" class="nav-link"><i class="fas fa-chart-line me-1"></i>Divisions Settings</a></li>
                    </ul>
                </div>
            </li>

            
            <!-- Academic Records -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#academicRecords">
                    <i class="fas fa-book-open me-2"></i> Academic Records
                </a>
                <div id="academicRecords" class="collapse">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('exam-types.index') }}" class="nav-link"><i class="fas fa-list-alt me-1"></i> Exam Types</a></li>
                        <li><a href="{{ route('exams.index') }}" class="nav-link"><i class="fas fa-file-alt me-2"></i> Examinations</a></li>
                        <li><a href="{{ route('student-examinations.index') }}" class="nav-link"><i class="fas fa-chart-line me-3"></i>Student Result Sheet</a></li>
                        <li><a href="{{ route('exam-results.general') }}" class="nav-link"><i class="fas fa-file-alt me-3"></i>Genaral Exam Results</a></li>
                        <li><a href="{{ route('exam-results.index') }}" class="nav-link"><i class="fas fa-file-alt me-3"></i>All Exam Results</a></li>
                        
                    <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Assesments</div>
                        <li><a href="{{ route('assessments.index') }}" class="nav-link"><i class="fas fa-clipboard-check me-1"></i> Assessments</a></li>
                        <li><a href="{{ route('assessment-results.index') }}" class="nav-link"><i class="fas fa-clipboard-check me-1"></i> Assessments Results</a></li>

                        <li><a href="{{ route('assignments.index') }}" class="nav-link"><i class="fas fa-tasks me-1"></i> Assignments</a></li>
                        <li><a href="{{ route('submissions.index') }}" class="nav-link"><i class="fas fa-upload me-1"></i> Submissions</a></li>

                    </ul>
                </div>
            </li>

            <!-- Timetable Management -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#timetableManagement">
                    <i class="fas fa-calendar-alt me-2"></i> Timetable Management
                </a>
                <div id="timetableManagement" class="collapse">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('timetables.index') }}" class="nav-link"><i class="fas fa-table me-1"></i> Class Timetables</a></li>
                        <li><a href="{{ route('general-schedule.index') }}" class="nav-link"><i class="fas fa-calendar-week me-1"></i> General Schedule</a></li>
                        <li><a href="{{ route('timetable.index') }}" class="nav-link"><i class="fas fa-calendar-week me-1"></i> General TimeTable</a></li>
                        <li><a href="{{ route('calendar.simple') }}" class="nav-link"><i class="fas fa-calendar me-1"></i> Calendar View</a></li>
                        <li><a href="{{ route('tests.index') }}" class="nav-link"><i class="fas fa-pen-alt me-1"></i> Tests Schedule</a></li>
                        <li><a href="{{ route('exams.index') }}" class="nav-link"><i class="fas fa-file-alt me-1"></i> Exams Schedule</a></li>
                        <li><a href="#" class="nav-link"><i class="fas fa-umbrella-beach me-1"></i> Holidays</a></li>
                        <li><a href="{{ route('events.index') }}" class="nav-link"><i class="fas fa-calendar-plus me-1"></i> Events</a></li>
                    </ul>
                </div>
            </li>


            <!-- Fee Management -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#feeManagement">
                    <i class="fas fa-money-bill-wave me-2"></i> Fee Payment Management
                </a>
                <div id="feeManagement" class="collapse">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('fee-structures.index') }}" class="nav-link"><i class="fas fa-coins me-1"></i> Fee Structures</a></li>
                        <li><a href="{{ route('admin.fee-payments.search') }}" class="nav-link"><i class="fas fa-credit-card me-1"></i> Record Payment</a></li>
                        <li><a href="{{ route('fee-payments.index') }}" class="nav-link"><i class="fas fa-credit-card me-1"></i> Payment Records</a></li>
                        <li><a href="{{ route('fee-payments.export') }}" class="nav-link"><i class="fas fa-file-export me-1"></i> Export Reports</a></li>
                    </ul>
                </div>
            </li>
            <!-- Fee Management -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#studentrequirement">
                    <i class="fas fa-money-bill-wave me-2"></i> Student Requirement Management
                </a>
                <div id="studentrequirement" class="collapse">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('student-requirements.index') }}" class="nav-link"><i class="fas fa-clipboard-list me-2"></i> Student Requirements</a> </li>
             <li>
        <a href="{{ route('student-requirement-submissions.index') }}" class="nav-link">
            <i class="fas fa-check-circle me-2"></i> Requirement Submissions
        </a>
    </li>
    <li>
        <a href="{{ route('student-requirement-submissions.create') }}" class="nav-link">
            <i class="fas fa-plus-circle me-2"></i> Add Submission
        </a>
    </li>
</ul>

                </div>
            </li>


            <!-- Hostel Management -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#hostelManagement">
                    <i class="fas fa-building me-2"></i> Hostel Management
                </a>
                <div id="hostelManagement" class="collapse">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('hostels.index') }}" class="nav-link"><i class="fas fa-home me-1"></i> Hostels</a></li>
                        <li><a href="{{ route('hostel-rooms.index') }}" class="nav-link"><i class="fas fa-bed me-1"></i> Hostel Rooms</a></li>
                        <li><a href="{{ route('hostel-allocations.index') }}" class="nav-link"><i class="fas fa-user-check me-1"></i> Allocations</a></li>
                        <li><a href="{{ route('hostel-allocations.unallocated') }}" class="nav-link"><i class="fas fa-user-slash me-1"></i> Unallocated Students</a></li>
                    </ul>
                </div>
            </li>

            <!-- Other Modules -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('behavior_records.index') }}">
                    <i class="fas fa-user-shield me-2"></i> Behavior Records
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('library_books.index') }}">
                    <i class="fas fa-book-reader me-2"></i> Library Books
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('book_loans.index') }}">
                    <i class="fas fa-book-medical me-2"></i> Book Loans
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('health_records.index') }}">
                    <i class="fas fa-heartbeat me-2"></i> Health Records
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('announcements.index') }}">
                    <i class="fas fa-bullhorn me-2"></i> Announcements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('notices.index') }}">
                    <i class="fas fa-sticky-note me-2"></i> Notices
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-bus me-2"></i> Transportation
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-envelope me-2"></i> Messages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-cog me-2"></i> School Settings
                </a>
            </li>



            <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#exportManagement">
        <i class="fas fa-file-export me-2"></i> Export options
    </a>
    <div id="exportManagement" class="collapse">
        <ul class="nav flex-column ps-4">
<li><a href="{{ route('school.export.users') }}" class="nav-link"><i class="fas fa-users me-1"></i> User Export</a></li>
<li><a href="{{ route('school.export.students') }}" class="nav-link"><i class="fas fa-user-graduate me-1"></i> Students Export</a></li>
<li><a href="{{ route('school.export.teachers') }}" class="nav-link"><i class="fas fa-chalkboard-teacher me-1"></i> Teachers Export</a></li>
<li><a href="{{ route('school.export.staff') }}" class="nav-link"><i class="fas fa-user-tie me-1"></i> Staff Export</a></li>
<li><a href="{{ route('school.export.parents') }}" class="nav-link"><i class="fas fa-user-friends me-1"></i> Parents Export</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-calendar-week me-1"></i> TimeTable Export</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-money-bill-wave me-1"></i> Fee Payment Export</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-building me-1"></i> Student Hostel Export</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-book me-1"></i> Books Export</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-notes-medical me-1"></i> Health Record Export</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-frown me-1"></i> Behaviour Export</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-user-check me-1"></i> Attendance Export</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-clipboard-list me-1"></i> Logs Export</a></li>
        </ul>
    </div>
</li>
        @endif

        <!-- Head Master Menu -->
        @if(Auth::user()->role === 'head_master')
            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">School Leadership</div>
            <ul class="list-unstyled">
                <li><a href="{{ route('students.index') }}" class="nav-link"><i class="fas fa-user-graduate me-2"></i> Students Overview</a></li>
                <li><a href="{{ route('teachers.index') }}" class="nav-link"><i class="fas fa-chalkboard-teacher me-2"></i> Teachers</a></li>
                <li><a href="{{ route('classes.index') }}" class="nav-link"><i class="fas fa-school me-2"></i> Classes</a></li>
                <li><a href="{{ route('exam-results.index') }}" class="nav-link"><i class="fas fa-chart-bar me-2"></i> Academic Performance</a></li>
                <li><a href="{{ route('behavior_records.index') }}" class="nav-link"><i class="fas fa-user-shield me-2"></i> Discipline Records</a></li>
                <li><a href="{{ route('announcements.index') }}" class="nav-link"><i class="fas fa-bullhorn me-2"></i> Announcements</a></li>
                <li><a href="{{ route('events.index') }}" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> School Events</a></li>
            </ul>
        @endif

        <!-- Academic Master Menu -->
        @if(Auth::user()->role === 'academic_master')
            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Academic Affairs</div>
            <ul class="list-unstyled">
                <li><a href="{{ route('exam-results.general') }}" class="nav-link">All Exam Results</a></li>

                <li><a href="{{ route('subjects.index') }}" class="nav-link"><i class="fas fa-book me-2"></i> Subjects</a></li>
                <li><a href="{{ route('timetables.index') }}" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> Timetables</a></li>
                <li><a href="{{ route('exams.index') }}" class="nav-link"><i class="fas fa-file-alt me-2"></i> Examinations</a></li>

                <li><a href="{{ route('exams.index') }}" class="nav-link"><i class="fas fa-file-alt me-2"></i> Examinations</a></li>


                <li><a href="{{ route('assignments.index') }}" class="nav-link"><i class="fas fa-tasks me-2"></i> Assignments</a></li>
                <li><a href="{{ route('assessments.index') }}" class="nav-link"><i class="fas fa-clipboard-check me-2"></i> Assessments</a></li>
                <li><a href="{{ route('teachers.index') }}" class="nav-link"><i class="fas fa-chalkboard-teacher me-2"></i> Teachers</a></li>
            </ul>
                        <!-- Academic Management -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#academicManagement">
                    <i class="fas fa-graduation-cap me-2"></i> Academic Structure
                </a>
                <div id="academicManagement" class="collapse">
                    <ul class="nav flex-column ps-4">
                        <li><a href="{{ route('academic-years.index') }}" class="nav-link"><i class="fas fa-calendar me-1"></i> Academic Years</a></li>
                        <li><a href="{{ route('semesters.index') }}" class="nav-link"><i class="fas fa-calendar-alt me-1"></i> Semesters</a></li>
                        <li><a href="{{ route('grade-levels.index') }}" class="nav-link"><i class="fas fa-layer-group me-1"></i> Grade Levels</a></li>
                        <li><a href="{{ route('classes.index') }}" class="nav-link"><i class="fas fa-school me-1"></i> Classes</a></li>
                        <li><a href="{{ route('sections.index') }}" class="nav-link"><i class="fas fa-object-group me-1"></i> Sections</a></li>
                        <li><a href="{{ route('subjects.index') }}" class="nav-link"><i class="fas fa-book me-1"></i> Subjects</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="nav-link"><i class="fas fa-door-closed me-1"></i> Rooms</a></li>

                        <br>
                        <li><a href="{{ route('grades.index') }}" class="nav-link">Grade Settings</a></li>
                        <li><a href="{{ route('divisions.index') }}" class="nav-link">Divisions Settings</a></li>
                    </ul>
                </div>
            </li>

        @endif

        <!-- Teacher Menu -->
        @if(Auth::user()->role === 'teacher')
            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Teaching</div>
            <ul class="list-unstyled">
                <li><a href="{{ route('teacher.classes.index') }}" class="nav-link"><i class="fas fa-school me-2"></i> My Classes</a></li>
                <li><a href="{{ route('teacher.students.index') }}" class="nav-link"><i class="fas fa-user-graduate me-2"></i> My Students</a></li>
                                        <li><a href="{{ route('assessments.index') }}" class="nav-link"><i class="fas fa-clipboard-check me-1"></i> Assessments</a></li>
                <li><a href="{{ route('assignments.index') }}" class="nav-link"><i class="fas fa-tasks me-2"></i> Assignments</a></li>
                <!-- <li><a href="{{ route('teacher.assessments.create') }}" class="nav-link"><i class="fas fa-tasks me-2"></i> Create an assesment</a></li> -->
                <!-- <li><a href="{{ route('submissions.index') }}" class="nav-link"><i class="fas fa-upload me-2"></i> Submissions</a></li> -->
                <li><a href="{{ route('exams.index') }}" class="nav-link"><i class="fas fa-file-alt me-2"></i> Exams</a></li>
                <li><a href="{{ route('grades.index') }}" class="nav-link"><i class="fas fa-chart-line me-2"></i> Grades</a></li>
                <li><a href="{{ route('timetables.index') }}" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> My Schedule</a></li>
                <li><a href="{{ route('behavior_records.index') }}" class="nav-link"><i class="fas fa-user-shield me-2"></i> Behavior Records</a></li>
                <li><a href="{{ route('assessments.index') }}" class="nav-link">Assessments</a></li>
                <!-- <li><a href="{{ route('exam-results.general') }}" class="nav-link">All Exam Results</a></li> -->

            </ul>
        @endif

        <!-- Secretary Menu -->
        @if(Auth::user()->role === 'secretary')
            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Administrative Support</div>
            <ul class="list-unstyled">
                <li><a href="{{ route('students.index') }}" class="nav-link"><i class="fas fa-user-graduate me-2"></i> Student Records</a></li>
                <li><a href="{{ route('announcements.index') }}" class="nav-link"><i class="fas fa-bullhorn me-2"></i> Announcements</a></li>
                <li><a href="{{ route('notices.index') }}" class="nav-link"><i class="fas fa-sticky-note me-2"></i> Notices</a></li>
                <li><a href="{{ route('events.index') }}" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> Events</a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-envelope me-2"></i> Messages</a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-phone me-2"></i> Communication</a></li>
            </ul>
        @endif

        <!-- School Doctor Menu -->
        @if(Auth::user()->role === 'school_doctor')
            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Health Services</div>
            <ul class="list-unstyled">
                <li><a href="{{ route('health_records.index') }}" class="nav-link"><i class="fas fa-heartbeat me-2"></i> Health Records</a></li>
                <li><a href="{{ route('students.index') }}" class="nav-link"><i class="fas fa-user-graduate me-2"></i> Student Health</a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-pills me-2"></i> Medical Inventory</a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-calendar-check me-2"></i> Health Checkups</a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-exclamation-triangle me-2"></i> Health Alerts</a></li>
            </ul>
        @endif

        <!-- School Librarian Menu -->
        @if(Auth::user()->role === 'school_librarian')
            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Library Services</div>
            <ul class="list-unstyled">
                <li><a href="{{ route('library_books.index') }}" class="nav-link"><i class="fas fa-book me-2"></i> Books Catalog</a></li>
                <li><a href="{{ route('book_loans.index') }}" class="nav-link"><i class="fas fa-book-medical me-2"></i> Book Loans</a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-user-graduate me-2"></i> Student Records</a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-calendar-times me-2"></i> Overdue Books</a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-chart-bar me-2"></i> Library Reports</a></li>
            </ul>
        @endif

        <!-- Staff Menu -->
        @if(Auth::user()->role === 'staff')
            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">General Staff</div>
            <ul class="list-unstyled">
                <li><a href="{{ route('students.index') }}" class="nav-link"><i class="fas fa-user-graduate me-2"></i> Students</a></li>
                <li><a href="{{ route('announcements.index') }}" class="nav-link"><i class="fas fa-bullhorn me-2"></i> Announcements</a></li>
                <li><a href="{{ route('notices.index') }}" class="nav-link"><i class="fas fa-sticky-note me-2"></i> Notices</a></li>
                <li><a href="{{ route('events.index') }}" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> Events</a></li>
            </ul>
        @endif

        <!-- Parent Menu -->
        @if(Auth::user()->role === 'parent')
            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Parent Portal</div>
            <ul class="list-unstyled">
                <li><a href="#" class="nav-link"><i class="fas fa-child me-2"></i> My Children</a></li>
                <li><a href="{{ route('exam-results.index') }}" class="nav-link"><i class="fas fa-poll me-2"></i> Academic Results</a></li>
                <li><a href="{{ route('assignments.index') }}" class="nav-link"><i class="fas fa-tasks me-2"></i> Assignments</a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-money-bill me-2"></i> Fee Status</a></li>
                <li><a href="{{ route('behavior_records.index') }}" class="nav-link"><i class="fas fa-user-shield me-2"></i> Behavior Reports</a></li>
                <li><a href="{{ route('announcements.index') }}" class="nav-link"><i class="fas fa-bullhorn me-2"></i> School News</a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-envelope me-2"></i> Messages</a></li>
                <li><a href="{{ route('events.index') }}" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> School Events</a></li>
            </ul>
        @endif

        <!-- Student Menu -->
        @if(Auth::user()->role === 'student')
            <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Student Portal</div>
            <ul class="list-unstyled">
                <li><a href="{{ route('notices.index') }}" class="nav-link"><i class="fas fa-bullhorn me-2"></i> School Notices</a></li>
                <li><a href="{{ route('classes.index') }}" class="nav-link"><i class="fas fa-chalkboard me-2"></i> My Classes</a></li>
                <li><a href="{{ route('subjects.index') }}" class="nav-link"><i class="fas fa-book me-2"></i> My Subjects</a></li>
                <li><a href="{{ route('assignments.index') }}" class="nav-link"><i class="fas fa-money-check-alt me-2"></i> Fee Payment Records</a></li>
                <li><a href="{{ route('submissions.index') }}" class="nav-link"><i class="fas fa-clipboard-check me-2"></i> My Assessment Results</a></li>
                <li><a href="{{ route('exam-results.general') }}" class="nav-link"><i class="fas fa-poll me-2"></i> My Exam Results</a></li>
                <li><a href="{{ route('exam-results.general') }}" class="nav-link"> <i class="fas fa-tasks me-2"></i> My Assessments</a></li>
                <li><a href="{{ route('timetables.index') }}" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> My Timetable</a></li>
                <li><a href="{{ route('library_books.index') }}" class="nav-link"><i class="fas fa-book-reader me-2"></i> Library Resources</a></li>
                <li><a href="{{ route('announcements.index') }}" class="nav-link"><i class="fas fa-bullhorn me-2"></i> Announcements</a></li>
                <li><a href="{{ route('events.index') }}" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> School Events</a></li>
                <li><a href="{{ route('events.index') }}" class="nav-link"><i class="fas fa-notes-medical me-2"></i> My Health Record</a></li>
            </ul>

            

        @endif


        @if(Auth::user()->role === 'super_admin')
    <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Super Admin</div>
    <ul class="list-unstyled">
        <!-- Admin Password Management -->
        <li class="mt-2 {{ request()->is('admin/password-reset*') ? 'active' : '' }}">
            <a href="{{ route('admin.password.reset.form') }}">
                <i class="fas fa-key me-2"></i>
                <span>Reset Admin Password</span>
            </a>
        </li>


        <!-- Personal Profile / Change Password -->
        <li class="mt-2 {{ request()->is('profile') ? 'active' : '' }}">
            <a href="{{ route('profile.index') }}">
                <i class="fas fa-user me-2"></i>
                <span>My Profile</span>
            </a>
        </li>
        <li class="{{ request()->is('change-password') ? 'active' : '' }}">
            <a href="{{ route('password.change.form') }}">
                <i class="fas fa-lock me-2"></i>
                <span>Change My Password</span>
            </a>
        </li>

    </ul>

    <li class="{{ request()->is('admin/password-reset*') ? 'active' : '' }}">
                            <a href="{{ route('admin.password.reset.form') }}">
                                <i class="fas fa-fw fa-users-cog"></i>
                                <span>Password Management</span>
                                <span class="badge bg-danger float-end">All Users</span>
                            </a>
                        </li>
@endif



        <!-- Personal Profile / Change Password -->
        <li class="mt-2 {{ request()->is('profile') ? 'active' : '' }}">
            <a href="{{ route('profile.index') }}">
                <i class="fas fa-user me-2"></i>
                <span>My Profile</span>
            </a>
        </li>
        <li class="{{ request()->is('change-password') ? 'active' : '' }}">
            <a href="{{ route('password.change.form') }}">
                <i class="fas fa-lock me-2"></i>
                <span>Change My Password</span>
            </a>
        </li>

    </div>
</aside>


<!-- 

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#paymentManagement">
        <i class="fas fa-money-bill-wave me-2"></i> Payment Management
    </a>
    <div id="paymentManagement" class="collapse">
        <ul class="nav flex-column ps-4">
            <li><a href="{{ route('payment.categories.index') }}" class="nav-link"><i class="fas fa-tags me-1"></i> Payment Categories</a></li>
            <li><a href="{{ route('student-payments.index') }}" class="nav-link"><i class="fas fa-users me-1"></i> Student Payments</a></li>
            <li><a href="{{ route('michango.index') }}" class="nav-link"><i class="fas fa-hands-helping me-1"></i> Michango</a></li>
            <li><a href="{{ route('payment-reports.index') }}" class="nav-link"><i class="fas fa-chart-bar me-1"></i> Payment Reports</a></li>
            <li><a href="{{ route('payment-settings.index') }}" class="nav-link"><i class="fas fa-cog me-1"></i> Payment Settings</a></li>
        </ul>
    </div>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#paymentReports">
        <i class="fas fa-chart-line me-2"></i> Payment Reports
    </a>
    <div id="paymentReports" class="collapse">
        <ul class="nav flex-column ps-4">
            <li><a href="{{ route('payment-reports.school-summary') }}" class="nav-link"><i class="fas fa-school me-1"></i> School Summary</a></li>
            <li><a href="{{ route('payment-reports.grade-analysis') }}" class="nav-link"><i class="fas fa-graduation-cap me-1"></i> Grade Analysis</a></li>
            <li><a href="{{ route('payment-reports.payment-methods') }}" class="nav-link"><i class="fas fa-credit-card me-1"></i> Payment Methods</a></li>
            <li><a href="{{ route('payment-reports.overdue-payments') }}" class="nav-link"><i class="fas fa-exclamation-triangle me-1"></i> Overdue Payments</a></li>
            <li><a href="{{ route('payment-reports.michango-progress') }}" class="nav-link"><i class="fas fa-progress-bar me-1"></i> Michango Progress</a></li>
            <li><a href="{{ route('payment-reports.daily-collections') }}" class="nav-link"><i class="fas fa-calendar-day me-1"></i> Daily Collections</a></li>
        </ul>
    </div>
</li>


<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#bulkOperations">
        <i class="fas fa-tasks me-2"></i> Bulk Operations
    </a>
    <div id="bulkOperations" class="collapse">
        <ul class="nav flex-column ps-4">
            <li><a href="#" onclick="showBulkModal('generate-requirements')" class="nav-link"><i class="fas fa-file-invoice me-1"></i> Generate Requirements</a></li>
            <li><a href="#" onclick="showBulkModal('update-amounts')" class="nav-link"><i class="fas fa-edit me-1"></i> Update Amounts</a></li>
            <li><a href="#" onclick="showBulkModal('send-reminders')" class="nav-link"><i class="fas fa-envelope me-1"></i> Send Reminders</a></li>
            <li><a href="#" onclick="showBulkModal('apply-late-fees')" class="nav-link"><i class="fas fa-clock me-1"></i> Apply Late Fees</a></li>
            <li><a href="#" onclick="showBulkModal('waive-payments')" class="nav-link"><i class="fas fa-hand-paper me-1"></i> Waive Payments</a></li>
        </ul>
    </div>
</li>
-->