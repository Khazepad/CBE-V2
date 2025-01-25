<!-- Sidebar -->
<aside class="main-sidebar" id="sidebar">
    <div class="sidebar-header" style="display: flex; justify-content: center; align-items: center;">
        <img src="{{ asset('images/dep.png') }}" alt="Company Logo" class="sidebar-logo img-fluid" style="max-height: 100px;">
    </div>
    <nav class="sidebar-nav">
        <ul>
            @if(Auth::check() && Auth::user()->role === 'student')
                <li class="active"><a href="{{ route('dashboard') }}"><i class='bx bxs-dashboard'></i> <span>Student Dashboard</span></a></li>
            @endif

            @if(Auth::check() && Auth::user()->role === 'officer')
                <li class="active"><a href="{{ route('officer.dashboard') }}"><i class='bx bxs-dashboard'></i> <span>Officer Dashboard</span></a></li>
            @endif

            <li><a href="#"><i class='bx bx-bell'></i> <span>Notification</span></a></li>
            <li><a href="#"><i class='bx bx-chat'></i> <span>Inbox</span></a></li>

            @if(Auth::check() && Auth::user()->role === 'student')
                <li><a href="{{ route('student.appointment-calendar') }}"><i class='bx bx-calendar'></i> <span>Appointment</span></a></li>
            @endif
            
            @if(Auth::check() && Auth::user()->role === 'officer')
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class='bx bx-user-circle'></i> 
                        <span>User Management</span>
                        <i class='bx bx-chevron-down dropdown-icon'></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href=""><i class='bx bx-user'></i> <span>Student List</span></a></li>
                        <li><a href=""><i class='bx bx-user-pin'></i> <span>Officer List</span></a></li>
                        <li><a href=""><i class='bx bx-user-voice'></i> <span>Director List</span></a></li>
                        
                    </ul>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class='bx bx-file'></i> 
                        <span>Management</span>
                        <i class='bx bx-chevron-down dropdown-icon'></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('officer.appointments.appointments-manage') }}"><i class='bx bx-calendar'></i> <span>Appointments</span></a></li>
                        <li><a href=""><i class='bx bx-line-chart'></i> <span>Reports</span></a></li>
                        <li><a href="#"><i class='bx bx-folder'></i> <span>Documents</span></a></li>
                    </ul>
                </li>
            @endif

            <li><a href="{{ route('file-explorer.index') }}"><i class='bx bx-file'></i> <span>Documentation</span></a></li>
            
            @if(Auth::check() && Auth::user()->role === 'student')
                <li><a href="#"><i class='bx bx-circle'></i> <span>Reports</span></a></li>
            @endif
        </ul>
    </nav>
    <div class="sidebar-footer">
    </div>
</aside>
