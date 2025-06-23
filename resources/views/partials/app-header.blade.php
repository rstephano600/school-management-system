<header class="app-header d-flex align-items-center px-3 px-lg-4">
    <!-- Sidebar Toggle (Mobile) -->
    <button class="btn btn-link text-white sidebar-toggle d-lg-none me-2">
        <i class="fas fa-bars fa-lg"></i>
    </button>
    
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="navbar-brand text-white fw-bold d-flex align-items-center">
        <i class="fas fa-book me-2"></i>
        <span class="d-none d-sm-inline">School management System</span>
        <span class="d-sm-none">SMS</span>
    </a>
    
    <!-- Right Side Of Navbar -->
    <div class="ms-auto d-flex align-items-center">
        <!-- Notifications -->
        <div class="dropdown me-3">
            <a class="text-white position-relative" href="#" role="button" id="notificationsDropdown" 
               data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fa-lg"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    3
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="notificationsDropdown">
                <li><h6 class="dropdown-header">Notifications</h6></li>
                <li><a class="dropdown-item" href="#">New member joined</a></li>
                <li><a class="dropdown-item" href="#">Upcoming event reminder</a></li>
                <li><a class="dropdown-item" href="#">Prayer request update</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-center" href="#">View all</a></li>
            </ul>
        </div>
        
        <!-- User Dropdown -->
        <div class="dropdown">
            <a href="#" class="dropdown-toggle text-white text-decoration-none d-flex align-items-center" 
               id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=fff&color=3a7bd5" 
                     alt="User" class="rounded-circle me-2" width="36">
                <span class="d-none d-lg-inline">{{ Auth::user()->name ?? 'User' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="userDropdown">
                <li class="px-3 py-2">
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=3a7bd5&color=fff" 
                             alt="User" class="rounded-circle me-2" width="40">
                        <div>
                            <h6 class="mb-0">{{ Auth::user()->name ?? 'User' }}</h6>
<small class="text-muted">
    @if(Auth::user()->role === 'super_admin')
        <span class="badge bg-danger">Super Admin</span>
    @elseif(Auth::user()->role === 'school_admin')
        <span class="badge bg-purple">School Admin</span>
    @elseif(Auth::user()->role === 'director')
        <span class="badge bg-primary">School Director</span>
    @elseif(Auth::user()->role === 'manager')
        <span class="badge bg-indigo">School Manager</span>
    @elseif(Auth::user()->role === 'head_master')
        <span class="badge bg-navy">Head Master</span>
    @elseif(Auth::user()->role === 'secretary')
        <span class="badge bg-teal">School Secretary</span>
    @elseif(Auth::user()->role === 'academic_master')
        <span class="badge bg-info">Academic Master</span>
    @elseif(Auth::user()->role === 'teacher')
        <span class="badge bg-success">Teacher</span>
    @elseif(Auth::user()->role === 'staff')
        <span class="badge bg-secondary">School Staff</span>
    @elseif(Auth::user()->role === 'school_doctor')
        <span class="badge bg-pink">School Doctor</span>
    @elseif(Auth::user()->role === 'school_librarian')
        <span class="badge bg-warning text-dark">School Librarian</span>
    @elseif(Auth::user()->role === 'parent')
        <span class="badge bg-orange">Parent</span>
    @elseif(Auth::user()->role === 'student')
        <span class="badge bg-blue">Student</span>
    @else
        <span class="badge bg-dark">User</span>
    @endif
</small>


                        </div>
                    </div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog fa-sm me-2"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt fa-sm me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>