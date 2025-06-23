<footer class="app-footer">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">
                    &copy; {{ date('Y') }}  @if(Auth::check()) {{ Auth::user()->university->name ?? 'School management system' }} @endif . All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">
                    <span class="d-none d-md-inline">Powered by</span> 
                    <strong>School Management System</strong> v1.0.0
                    @if(Auth::check())
                        | Logged in as: 
                        @if(Auth::user()->role === 'superadmin')
                            <span class="badge badge-superadmin">Super Admin</span>
                        @elseif(Auth::user()->role === 'school_admin')
                            <span class="badge badge-universityadmin">School Admin</span>
                        @elseif(Auth::user()->role === 'director')
                            <span class="badge badge-member">School Director</span>
                        @elseif(Auth::user()->role === 'manager')
                            <span class="badge badge-member">School Manager</span>
                        @elseif(Auth::user()->role === 'head_master')
                            <span class="badge badge-member">Head master</span>
                        @elseif(Auth::user()->role === 'secretary')
                            <span class="badge badge-member">School secretary</span>
                        @elseif(Auth::user()->role === 'academic_master')
                            <span class="badge badge-member">Academic Master</span>
                        @elseif(Auth::user()->role === 'teacher')
                            <span class="badge badge-member">School teacher</span>
                        @elseif(Auth::user()->role === 'staff')
                            <span class="badge badge-member">School Staff</span>
                        @elseif(Auth::user()->role === 'school_doctor')
                            <span class="badge badge-member">School doctor</span>
                        @elseif(Auth::user()->role === 'parent')
                            <span class="badge badge-user">Parent</span>
                        @elseif(Auth::user()->role === 'student')
                            <span class="badge badge-user">Student</span>
                        @else
                            <span class="badge badge-user">User</span>
                        @endif
                    @endif
                </p>
            </div>
        </div>
    </div>
</footer>