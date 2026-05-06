<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HOD Dashboard') - EduInsight</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --sidebar-width: 280px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
            padding-top: 60px;
        }
        
        /* Top Navbar - Fixed */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 12px 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1030;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: white !important;
        }
        
        /* Main Wrapper */
        .hod-wrapper {
            display: flex;
            min-height: calc(100vh - 60px);
        }
        
        /* Sidebar */
        .hod-sidebar {
            width: var(--sidebar-width);
            background-color: #2c3e50;
            padding: 0;
            overflow-y: auto;
            position: fixed;
            left: 0;
            top: 60px;
            height: calc(100vh - 60px);
            box-shadow: 2px 0 8px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h5 {
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: white;
        }
        
        .sidebar-header small {
            color: rgba(255,255,255,0.6);
            font-size: 0.80rem;
        }
        
        .hod-nav {
            list-style: none;
            padding: 15px 0;
        }
        
        .hod-nav .nav-item {
            margin: 0;
        }
        
        .hod-nav .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 14px 20px;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .hod-nav .nav-link:hover {
            color: white;
            background-color: rgba(102, 126, 234, 0.15);
            border-left-color: var(--primary-color);
        }
        
        .hod-nav .nav-link.active {
            color: white;
            background-color: rgba(102, 126, 234, 0.25);
            border-left-color: var(--primary-color);
            font-weight: 600;
        }
        
        .nav-divider {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin: 12px 0;
        }
        
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: rgba(0,0,0,0.1);
        }
        
        .sidebar-footer small {
            color: rgba(255,255,255,0.6);
            font-size: 0.80rem;
        }
        
        .sidebar-footer .user-name {
            color: white;
            font-weight: 600;
            margin-top: 5px;
        }
        
        /* Main Content */
        .hod-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 30px;
        }
        
        /* Scrollbar */
        .hod-sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .hod-sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }
        
        .hod-sidebar::-webkit-scrollbar-thumb {
            background: rgba(102, 126, 234, 0.5);
            border-radius: 3px;
        }
        
        .hod-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(102, 126, 234, 0.8);
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <span class="navbar-brand">
                <i class="fas fa-graduation-cap me-2"></i> EduInsight
            </span>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="text-white">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- Wrapper -->
    <div class="hod-wrapper">
        <!-- Sidebar -->
        <aside class="hod-sidebar">
            <ul class="hod-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('hod.dashboard') ? 'active' : '' }}" href="{{ route('hod.dashboard') }}">
                        <i class="fas fa-chart-pie me-3" style="width: 18px;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('hod.faculty*') ? 'active' : '' }}" href="{{ route('hod.faculty') }}">
                        <i class="fas fa-user-tie me-3" style="width: 18px;"></i>
                        <span>Faculty</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('hod.students*') ? 'active' : '' }}" href="{{ route('hod.students') }}">
                        <i class="fas fa-graduation-cap me-3" style="width: 18px;"></i>
                        <span>Students</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('hod.courses*') ? 'active' : '' }}" href="{{ route('hod.courses') }}">
                        <i class="fas fa-book me-3" style="width: 18px;"></i>
                        <span>Courses</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('hod.analytics') ? 'active' : '' }}" href="{{ route('hod.analytics') }}">
                        <i class="fas fa-chart-bar me-3" style="width: 18px;"></i>
                        <span>Analytics</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('email.send') ? 'active' : '' }}" href="{{ route('email.send') }}">
                        <i class="fas fa-envelope me-3" style="width: 18px;"></i>
                        <span>Send Notification</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('email.history') ? 'active' : '' }}" href="{{ route('email.history') }}">
                        <i class="fas fa-history me-3" style="width: 18px;"></i>
                        <span>Email History</span>
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <small><i class="fas fa-user me-1"></i>Logged in as:</small>
                <div class="user-name">{{ auth()->user()->name }}</div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="hod-content">
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <h5>Validation Errors</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('hod-content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
        bottom: 0;
        width: 100%;
    }

    .sidebar {
        position: relative;
        width: 250px;
    }

    main {
        background-color: #f8f9fa;
    }
</style>
</body>
</html>
