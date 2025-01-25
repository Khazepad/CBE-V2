<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Yellow AdminLTE Dashboard')</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional styles -->
    @include('layouts.styles')
    @yield('additional_styles')
    <style>
        .sidebar {
            height: 100vh;
        }
        .nav-link.active {
            font-weight: bold;
        }
        .card {
            border: none;
        }
        .breadcrumb-item a {
            text-decoration: none;
            color: #3498db;
        }
        .breadcrumb-item a:hover {
            text-decoration: underline;
        }
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="content-wrapper">
            @include('layouts.navbar')

            <!-- Main content -->
            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('layouts.scripts')
    @yield('additional_scripts')
</body>
</html>
