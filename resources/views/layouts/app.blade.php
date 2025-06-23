<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>School Management System | @yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 280px;
            --header-height: 70px;
            --primary-color: #3a7bd5;
            --secondary-color: #00d2ff;
            --sidebar-bg: #2c3e50;
            --sidebar-color: #ecf0f1;
            --superadmin-color: #d35400;
            --universityadmin-color: #27ae60;
            --member-color: #3498db;
            --user-color: #9b59b6;
        }
        
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding-top: var(--header-height);
            background-color: #f8f9fc;
            min-height: 100vh;
        }
        
        /* Gradient Background for Header */
        .app-header {
            height: var(--header-height);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            color: white;
        }
        
        /* Sidebar Styles */
        .app-sidebar {
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            position: fixed;
            top: var(--header-height);
            left: 0;
            background: var(--sidebar-bg);
            color: var(--sidebar-color);
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
            z-index: 1020;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li a {
            color: var(--sidebar-color);
            padding: 0.75rem 1.5rem;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        
        .sidebar-menu li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid var(--primary-color);
        }
        
        .sidebar-menu li a i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }
        
        /* Role-specific colors */
        .sidebar-menu li.superadmin > a {
            border-left: 4px solid var(--superadmin-color);
        }
        
        .sidebar-menu li.universityadmin > a {
            border-left: 4px solid var(--universityadmin-color);
        }
        
        .sidebar-menu li.member > a {
            border-left: 4px solid var(--member-color);
        }
        
        .sidebar-menu li.user > a {
            border-left: 4px solid var(--user-color);
        }
        
        /* Main Content Styles */
        .app-main {
            margin-left: var(--sidebar-width);
            padding: 25px;
            min-height: calc(100vh - var(--header-height) - 70px);
            transition: margin 0.3s ease-in-out;
        }
        
        /* Footer Styles */
        .app-footer {
            background: white;
            padding: 15px 25px;
            margin-left: var(--sidebar-width);
            border-top: 1px solid #e3e6f0;
            transition: margin 0.3s ease-in-out;
        }
        
        /* Mobile Styles */
        @media (max-width: 992px) {
            .app-sidebar {
                transform: translateX(-100%);
            }
            
            .app-sidebar.show {
                transform: translateX(0);
            }
            
            .app-main, .app-footer {
                margin-left: 0;
            }
            
            .sidebar-overlay {
                position: fixed;
                top: var(--header-height);
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1010;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s, visibility 0.3s;
            }
            
            .sidebar-overlay.show {
                opacity: 1;
                visibility: visible;
            }
        }
        
        /* Active Menu Item */
        .sidebar-menu li.active > a {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 600;
            border-left: 4px solid var(--primary-color);
        }
        
        /* Card Styling */
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 25px;
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-bottom: none;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        
        /* Badge colors for roles */
        .badge-superadmin {
            background-color: var(--superadmin-color);
        }
        
        .badge-universityadmin {
            background-color: var(--universityadmin-color);
        }
        
        .badge-member {
            background-color: var(--member-color);
        }
        
        .badge-user {
            background-color: var(--user-color);
        }

    /* Custom badge colors */
    .bg-purple {
        background-color: #6f42c1 !important;
    }
    .bg-navy {
        background-color: #001f3f !important;
    }
    .bg-indigo {
        background-color: #6610f2 !important;
    }
    .bg-orange {
        background-color: #fd7e14 !important;
    }
    .bg-blue {
        background-color: #007bff !important;
    }

        /* Dashboard stats cards */
        .stat-card {
            border-left: 4px solid;
        }
        
        .stat-card.superadmin {
            border-left-color: var(--superadmin-color);
        }
        
        .stat-card.universityadmin {
            border-left-color: var(--universityadmin-color);
        }
        
        .stat-card.member {
            border-left-color: var(--member-color);
        }
        
        .stat-card.user {
            border-left-color: var(--user-color);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    @include('partials.app-header')
    
    <!-- Sidebar Overlay (Mobile Only) -->
    <div class="sidebar-overlay"></div>
    
    <!-- Sidebar -->
    @include('partials.app-sidebar')
    
    <!-- Main Content -->
    <main class="app-main">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('partials.app-footer')
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (for sidebar toggle) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Mobile sidebar toggle
            $('.sidebar-toggle').on('click', function() {
                $('.app-sidebar').toggleClass('show');
                $('.sidebar-overlay').toggleClass('show');
                $('body').toggleClass('sidebar-open');
            });
            
            // Close sidebar when clicking overlay
            $('.sidebar-overlay').on('click', function() {
                $(this).removeClass('show');
                $('.app-sidebar').removeClass('show');
                $('body').removeClass('sidebar-open');
            });
            
            // Close sidebar when clicking a menu item on mobile
            $('.sidebar-menu a').on('click', function() {
                if ($(window).width() < 992) {
                    $('.sidebar-overlay').removeClass('show');
                    $('.app-sidebar').removeClass('show');
                    $('body').removeClass('sidebar-open');
                }
            });
            
            // Auto-collapse dropdowns when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>