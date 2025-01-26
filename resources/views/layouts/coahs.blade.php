<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Vite -->

    <!-- Additional Styles -->
    @yield('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar-container">
            <div class="sidebar-header">
                <i class="fas fa-bars" id="toggle-sidebar"></i>
                <img src="{{ asset('img/sidebar-logo.png') }}" alt="COAHS Logo" class="logo-img" id="logo-img">
            </div>

            <nav>
                <ul class="sidebar-nav-menu">
                    <li class="sidebar-nav-item">
                        <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item has-submenu">
                        <a href="#" class="sidebar-nav-link {{ request()->routeIs('admin.student.*') ? 'active' : '' }}">
                            <i class="fas fa-user-graduate"></i><span>Student</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('sis.student.information') }}" class="sidebar-submenu-link {{ request()->routeIs('admin.student.information') ? 'active' : '' }}"><i class="fas fa-info-circle"></i><span>Student Information</span></a></li>
                            <li><a href="{{ route('admin.student.information') }}" class="sidebar-submenu-link {{ request()->routeIs('admin.student.enrolled') ? 'active' : '' }}"><i class="fas fa-user-check"></i><span>Enrolled Students</span></a></li>
                        </ul>
                    </li>
                    <li class="sidebar-nav-item has-submenu">
                        <a href="#" class="sidebar-nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                            <i class="fas fa-boxes"></i><span>Inventory System</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.chemicals.index') }}" class="sidebar-submenu-link"><i class="fas fa-flask"></i><span>Chemicals</span></a></li>
                            <li><a href="{{ route('admin.equipments.index') }}" class="sidebar-submenu-link"><i class="fas fa-tools"></i><span>Equipments</span></a></li>
                            <li><a href="{{ route('admin.instruments.index') }}" class="sidebar-submenu-link"><i class="fas fa-microscope"></i><span>Instruments</span></a></li>
                            <li><a href="{{ route('admin.medicines.index') }}" class="sidebar-submenu-link"><i class="fas fa-pills"></i><span>Medicines</span></a></li>
                        </ul>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="" class="sidebar-nav-link {{ request()->routeIs('scheduling.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i><span>Duty Scheduling</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('admin.academic.settings') }}" class="sidebar-nav-link {{ request()->routeIs('academic.settings') ? 'active' : '' }}">
                            <i class="fas fa-graduation-cap"></i><span>Academic Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-logout-container">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       class="sidebar-logout-link"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                    </a>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar-container');
            sidebar.classList.toggle('collapsed');
            document.querySelector('.main-content').style.marginLeft = sidebar.classList.contains('collapsed') ? '60px' : '200px';

            // Change the logo image
            const logoImg = document.getElementById('logo-img');
            if (sidebar.classList.contains('collapsed')) {
                logoImg.src = "{{ asset('img/coahs.png') }}";
            } else {
                logoImg.src = "{{ asset('img/sidebar-logo.png') }}";
            }

            // Close any open submenu
            const submenuItems = document.querySelectorAll('.has-submenu');
            submenuItems.forEach(item => item.classList.remove('submenu-open'));
        });

        // Toggle submenu
        document.querySelectorAll('.has-submenu > a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                this.parentElement.classList.toggle('submenu-open');
            });
        });
    </script>
</body>
</html>
