<aside class="app-sidebar">
    <div class="sidebar-header px-1 py-1 text-center">
        <small class="text-green">
            @if(Auth::check())
                {{ Auth::user()->school->name ?? 'School management' }}
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

    <!-- Super Admin Menu (Visible only to super_admins) -->
    @if(Auth::user()->role === 'super_admin')
        <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Super Admin</div>
        <ul class="list-unstyled">
            <li class="{{ request()->is('admin/schools*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.schools') }}">
                    <i class="fas fa-fw fa-university"></i>
                    <span>Schools</span>
                    <span class="badge bg-primary float-end">15</span>
                </a>
            </li>
            
            <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.users') }}">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>System Users</span>
                    <span class="badge bg-info float-end">1245</span>
                </a>
            </li>
            
            <li class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-sliders-h"></i>
                    <span>System Settings</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/reports*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-chart-pie"></i>
                    <span>Reports & Analytics</span>
                </a>
            </li>
        </ul>

        <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Monitoring</div>
        <ul class="list-unstyled">
            <li class="{{ request()->is('admin/alerts*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-bell"></i>
                    <span>Alerts</span>
                    <span class="badge bg-danger float-end">3</span>
                </a>
            </li>
            
            <li class="{{ request()->is('admin/audit*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Audit Logs</span>
                </a>
            </li>
            
            <li class="{{ request()->is('admin/backup*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-database"></i>
                    <span>System Backup</span>
                </a>
            </li>
        </ul>
    @endif

    @if(Auth::user()->role === 'school_admin')
    <!-- <p class="text-muted small">School Administration</p> -->
    
                <!-- User Management -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#userManagement">
                        <i class="fas fa-users me-2"></i> school User Management
                    </a>
                    <div id="userManagement" class="collapse show">
                        <ul class="nav flex-column ps-4">
                            <li><a href="{{ route('students.index') }}" class="nav-link">Students</a></li>
                            <li><a href="{{ route('teachers.index') }}" class="nav-link">Teachers</a></li>
                            <li><a href="{{ route('schools.staff.index') }}" class="nav-link">Staff</a></li>
                            <li><a href="{{ route('student.parent.index') }}" class="nav-link">Parents</a></li>
                        </ul>
                    </div>
                </li>
                
                <!-- Academic Management -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#academicManagement">
                        <i class="fas fa-book me-2"></i> Academic
                    </a>
                    <div id="academicManagement" class="collapse">
                        <ul class="nav flex-column ps-4">
                            <li><a href="{% url 'manage_classes' %}" class="nav-link">Classes</a></li>
                            <li><a href="{{ route('subjects.index') }}" class="nav-link">Subjects</a></li>
                            <li><a href="{% url 'manage_timetables' %}" class="nav-link">Timetables</a></li>
                            <li><a href="{% url 'manage_exams' %}" class="nav-link">Exams</a></li>
                            <li><a href="{{ route('grade-levels.index') }}" class="nav-link">Grade Levels</a></li>
                             <li><a href="{{ route('academic-years.index') }}" class="nav-link">Academic Years</a></li>
                        <li><a href="{{ route('semesters.index') }}" class="nav-link">Semesters</a></li> {{-- ✅ New Link --}}
                        <li><a href="{{ route('rooms.index') }}" class="nav-link"><i class="fas fa-door-closed me-1"></i> Rooms</a></li>
                        <li><a href="{{ route('sections.index') }}" class="nav-link"> Sections</a></li>
                        <li><a href="{{ route('classes.index') }}" class="nav-link"> Classes</a></li>
                        <li><a href="{{ route('timetables.index') }}" class="nav-link"> Timetable</a></li>
                        <li><a href="{{ route('assessments.index') }}" class="nav-link"> assessments</a></li>

                            </ul>
                    </div>
                </li>


                <!-- Time table management Management -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#schoolTimetableMenu" aria-expanded="false">
        <i class="fas fa-calendar-alt me-2"></i> School Timetable
    </a>
    <div id="schoolTimetableMenu" class="collapse">
        <ul class="nav flex-column ps-4">
            <li class="nav-item">
                <a href="{{ route('calendar.simple') }}" class="nav-link">
                    <i class="fas fa-calendar-week me-2"></i> General Timetable
                </a>
            </li>
<li class="{{ request()->is('school/general-schedule*') ? 'active' : '' }}">
    <a href="{{ route('general-schedule.index') }}" class="nav-link">
        <i class="fas fa-calendar-alt me-2"></i>
        <span>General School Timetable</span>
    </a>
</li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-chalkboard-teacher me-2"></i> Class Sessions
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tests.index') }}" class="nav-link">
                    <i class="fas fa-pen-alt me-2"></i> Tests Timetable
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('exams.index') }}" class="nav-link">
                    <i class="fas fa-file-alt me-2"></i> Exams Timetable
                </a>
            </li>
            <li class="nav-item">
                <a href="{% url 'manage_classes' %}" class="nav-link">
                    <i class="fas fa-umbrella-beach me-2"></i> Holidays
                </a>
            </li>
            <li class="nav-item">
                <a href="{% url 'manage_classes' %}" class="nav-link">
                    <i class="fas fa-bullhorn me-2"></i> Events
                </a>
            </li>
        </ul>
    </div>
</li>


<!-- Academic Records Management -->
<li class="nav-item">
    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="collapse" data-bs-target="#academicmanagement" aria-expanded="false" aria-controls="academicmanagement">
        <i class="fas fa-book me-2"></i> Academic Records
    </a>
    <div id="academicmanagement" class="collapse">
        <ul class="nav flex-column ps-4">
            <li class="nav-item">
                <a href="{{ route('assignments.index')}}" class="nav-link d-flex align-items-center">
                    <i class="fas fa-tasks me-2"></i> Assignments
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('submissions.index')}}" class="nav-link d-flex align-items-center">
                    <i class="fas fa-upload me-2"></i> Submissions
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('exam-types.index')}}" class="nav-link d-flex align-items-center">
                    <i class="fas fa-layer-group me-2"></i> Exam Types
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('exams.index')}}" class="nav-link d-flex align-items-center">
                    <i class="fas fa-pencil-alt me-2"></i> Exams
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('exam-results.index')}}" class="nav-link d-flex align-items-center">
                    <i class="fas fa-poll me-2"></i> Exam Results
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('grades.index')}}" class="nav-link d-flex align-items-center">
                    <i class="fas fa-chart-line me-2"></i> School Grades
                </a>
            </li>
        </ul>
    </div>
</li>

                <!-- Fee Management -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#feeManagement">
        <i class="fas fa-money-bill-wave me-2"></i> Fee Management
    </a>
    <div id="feeManagement" class="collapse">
        <ul class="nav flex-column ps-4">
            <li><a href="{{ route('fee-structures.index') }}" class="nav-link">Fee Structures</a></li>
<li><a href="{{ route('admin.fee-payments.search') }}" class="nav-link">Record Payment</a></li>
            <li><a href="{{ route('fee-payments.export') }}" class="nav-link">Export Reports</a></li>
        </ul>
    </div>
</li>


                <!-- Other Modules -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('behavior_records.index') }}">
                        <i class="fas fa-chart-line me-2"></i> Behavior Records
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('library_books.index') }}">
                        <i class="fas fa-book-open me-2"></i> Library
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('book_loans.index') }}">
                        <i class="fas fa-book-open me-2"></i> Library bookloans
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
                     <a class="nav-link" href="{{ route('events.index') }}">
                         <i class="fas fa-calendar-alt me-2"></i> Events / Almanac
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link" href="{% url 'school_transportation' %}">
                         <i class="fas fa-bus me-2"></i> Transportation
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link" href="{% url 'school_messages' %}">
                         <i class="fas fa-envelope me-2"></i> Messages
                     </a>
                 </li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#hostelManagement">
        <i class="fas fa-building me-2"></i> Hostel Management
    </a>
    <div id="hostelManagement" class="collapse">
        <ul class="nav flex-column ps-4">
            <li><a href="{{ route('hostels.index') }}" class="nav-link">Hostels</a></li>
            <li><a href="{{ route('hostel-rooms.index') }}" class="nav-link">Hostel Rooms</a></li>
            <li><a href="{{ route('hostel-allocations.index') }}" class="nav-link">Hostel Allocations</a></li>
       <li>
  <a class="nav-link" href="{{ route('hostel-allocations.unallocated') }}">
    <i class="fas fa-user-slash me-2"></i> Unallocated Students
  </a>
</li>

        </ul>
    </div>
</li>


                <li class="nav-item">
                    <a class="nav-link" href="{% url 'school_settings' %}">
                        <i class="fas fa-cog me-2"></i> School Settings
                    </a>
                </li>
            </ul>
        </nav>
       @endif
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       <br><br><br><br>
       <br><br><br><br>
       <br><br><br><br>
       
        <!-- University Admin Menu (Visible to superadmins and university admins) -->
        @if(in_array(Auth::user()->role, ['superadmin', 'universityadmin']))
                        <!-- Dashboard -->
        <ul class="list-unstyled">
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
        <div class="px-3 py-2 text-uppercase small fw-bold text-muted">University Admin</div>
        <ul class="list-unstyled">
            <li class="universityadmin {{ request()->is('university/members*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-user-friends"></i>
                    <span>Members</span>
                </a>
            </li>
            
            <li class="universityadmin {{ request()->is('university/events*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    <span>Events</span>
                </a>
            </li>
            
            <li class="universityadmin {{ request()->is('university/prayers*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-hands-praying"></i>
                    <span>Prayer Requests</span>
                </a>
            </li>
            
            <li class="universityadmin {{ request()->is('university/reports*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </li>
        </ul>

        <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Church Operations</div>
    <ul class="list-unstyled">
    <li class="universityadmin {{ request()->is('university/almanac*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Update Almanac</span>
        </a>
    </li>
    
    <li class="universityadmin {{ request()->is('university/timetables*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-clock-rotate-left"></i>
            <span>Update Timetables</span>
        </a>
    </li>
    
    <li class="universityadmin {{ request()->is('university/posts*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-edit"></i>
            <span>Create Posts</span>
        </a>
    </li>
    
    <li class="universityadmin {{ request()->is('university/announcements*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>Post Announcements</span>
        </a>
    </li>
    
    <li class="universityadmin {{ request()->is('university/weekly-activities*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-book-bible"></i>
            <span>Update Weekly Activities</span>
        </a>
    </li>
    
    <li class="universityadmin {{ request()->is('university/charity*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-hand-holding-dollar"></i>
            <span>Organize Charity</span>
        </a>
    </li>
    </ul>

     <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Ministry Teams</div>
    <ul class="list-unstyled">
    <li class="universityadmin {{ request()->is('university/choirs*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-people-group"></i>
            <span>Coordinate Choirs</span>
        </a>
    </li>
    
    <li class="universityadmin {{ request()->is('university/praise-teams*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-people-arrows"></i>
            <span>Organize Praise Teams</span>
        </a>
    </li>
    
    <li class="universityadmin {{ request()->is('university/singers*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-user-music"></i>
            <span>Manage Singers</span>
        </a>
    </li>
    </ul>

    <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Leadership</div>
    <ul class="list-unstyled">
    <li class="universityadmin {{ request()->is('university/leaders*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-user-shield"></i>
            <span>Appoint Leaders</span>
        </a>
    </li>
    
    <li class="universityadmin {{ request()->is('university/guardians*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-user-lock"></i>
            <span>Assign Guardians</span>
        </a>
    </li>
    </ul>
        @endif
        
        <!-- Member Menu (Visible to all authenticated users) -->
                         <!-- Dashboard -->
        <ul class="list-unstyled">
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
        <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Member</div>
        <ul class="list-unstyled">
            <li class="member {{ request()->is('member/profile*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>
            
            <li class="member {{ request()->is('member/events*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>My Events</span>
                </a>
            </li>
            
            <li class="member {{ request()->is('member/prayers*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-pray"></i>
                    <span>My Prayers</span>
                </a>
            </li>
            
            <li class="member {{ request()->is('member/groups*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Small Groups</span>
                </a>
            </li>
        </ul>
        
        <!-- General Menu (Visible to all) -->
        <div class="px-3 py-2 text-uppercase small fw-bold text-muted">General</div>
        <ul class="list-unstyled">
            <li class="user {{ request()->is('events*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-calendar-day"></i>
                    <span>Upcoming Events</span>
                </a>
            </li>
            
            <li class="user {{ request()->is('resources*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Resources</span>
                </a>
            </li>
            
            <li class="user {{ request()->is('about*') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-fw fa-info-circle"></i>
                    <span>About USCF</span>
                </a>
            </li>
        </ul>
   

    <div class="px-3 py-2 text-uppercase small fw-bold text-muted">Church Information</div>
<ul class="list-unstyled">
    <li class="member {{ request()->is('almanac*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-calendar-days"></i>
            <span>View Almanac</span>
        </a>
    </li>
    
    <li class="member {{ request()->is('timetables*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-clock"></i>
            <span>View Timetables</span>
        </a>
    </li>
    
    <li class="member {{ request()->is('posts*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>View Posts</span>
        </a>
    </li>
    
    <li class="member {{ request()->is('announcements*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>View Announcements</span>
        </a>
    </li>
    
    <li class="member {{ request()->is('weekly-activities*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-hands-praying"></i>
            <span>Weekly Activities</span>
            <small class="d-block ps-4 text-muted">Prayers & Readings</small>
        </a>
    </li>
    
    <li class="member {{ request()->is('charity*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-hand-holding-heart"></i>
            <span>Charity Programs</span>
        </a>
    </li>
</ul>

<div class="px-3 py-2 text-uppercase small fw-bold text-muted">Church Teams</div>
<ul class="list-unstyled">
    <li class="member {{ request()->is('leaders*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Church Leaders</span>
        </a>
    </li>
    
    <li class="member {{ request()->is('choirs*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-music"></i>
            <span>Choirs</span>
        </a>
    </li>
    
    <li class="member {{ request()->is('praise-teams*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-drum"></i>
            <span>Praise Teams</span>
        </a>
    </li>
    
    <li class="member {{ request()->is('singers*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-microphone"></i>
            <span>Singers</span>
        </a>
    </li>
</ul>

<!-- Guardian View (if member is a guardian) -->
@if(Auth::user()->is_guardian)
<div class="px-3 py-2 text-uppercase small fw-bold text-muted">Guardian Access</div>
<ul class="list-unstyled">
    <li class="member {{ request()->is('guardian/dashboard*') ? 'active' : '' }}">
        <a href="">
            <i class="fas fa-fw fa-shield-alt"></i>
            <span>Guardian Dashboard</span>
        </a>
    </li>
</ul>
@endif
     </div>
</aside>