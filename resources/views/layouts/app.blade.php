<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EduInsight</title>
    
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
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding-top: 56px;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1030;
        }
        
        .sidebar {
            background-color: #2c3e50;
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
            top: 56px;
            left: 0;
            width: 16.666667%;
            bottom: 0;
            overflow-y: auto;
        }
        
        .main-content {
            margin-left: 16.666667%;
            padding-top: 56px;
            min-height: 100vh;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 15px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(102, 126, 234, 0.1);
            border-left-color: var(--primary-color);
        }
        
        .dashboard-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-top: 3px solid var(--primary-color);
        }
        
        .stat-box {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .stat-box h3 {
            margin: 10px 0 0 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .stat-box p {
            margin: 5px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        
        .alert-badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .alert-high {
            background-color: #ff6b6b;
            color: white;
        }
        
        .alert-medium {
            background-color: #ffa500;
            color: white;
        }
        
        .alert-low {
            background-color: #51cf66;
            color: white;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 20px;
        }
        
        .btn-group-vertical {
            width: 100%;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-graduation-cap"></i> EduInsight
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <span class="navbar-text text-white me-3">{{ Auth::user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar & Main Content -->
    @auth
        <nav class="sidebar">
                        <div class="nav flex-column">
                            @if(Auth::user()->role->slug === 'admin')
                                <a class="nav-link @if(Route::currentRouteName() == 'admin.dashboard') active @endif" 
                                   href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-chart-line"></i> Dashboard
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'admin.students') active @endif" 
                                   href="{{ route('admin.students') }}">
                                    <i class="fas fa-users"></i> Students
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'admin.courses') active @endif" 
                                   href="{{ route('admin.courses') }}">
                                    <i class="fas fa-book"></i> Courses
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'admin.alerts') active @endif" 
                                   href="{{ route('admin.alerts') }}">
                                    <i class="fas fa-bell"></i> Alerts
                                </a>

                                <hr style="border-color: rgba(255,255,255,0.2);">
                                
                                <a class="nav-link @if(Route::currentRouteName() == 'admin.faculty.pending') active @endif" 
                                   href="{{ route('admin.faculty.pending') }}">
                                    <i class="fas fa-clipboard-check"></i> Faculty Approvals
                                </a>

                                <a class="nav-link @if(Route::currentRouteName() == 'admin.faculty.manage') active @endif" 
                                   href="{{ route('admin.faculty.manage') }}">
                                    <i class="fas fa-users-cog"></i> Manage Faculty
                                </a>

                                <a class="nav-link @if(Route::currentRouteName() == 'admin.faculty.statistics') active @endif" 
                                   href="{{ route('admin.faculty.statistics') }}">
                                    <i class="fas fa-bar-chart"></i> Faculty Stats
                                </a>

                                <hr style="border-color: rgba(255,255,255,0.2);">

                                <a class="nav-link @if(Route::currentRouteName() == 'email.send') active @endif" 
                                   href="{{ route('email.send') }}">
                                    <i class="fas fa-envelope"></i> Send Notification
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'email.history') active @endif" 
                                   href="{{ route('email.history') }}">
                                    <i class="fas fa-history"></i> Email History
                                </a>
                            @elseif(Auth::user()->role->slug === 'faculty')
                                <a class="nav-link @if(Route::currentRouteName() == 'faculty.dashboard') active @endif" 
                                   href="{{ route('faculty.dashboard') }}">
                                    <i class="fas fa-chart-line"></i> Dashboard
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'faculty.courses') active @endif" 
                                   href="{{ route('faculty.courses') }}">
                                    <i class="fas fa-book"></i> My Courses
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'faculty.attendance') active @endif" 
                                   href="{{ route('faculty.attendance') }}">
                                    <i class="fas fa-check"></i> Attendance
                                </a>
                                <a class="nav-link" href="#" onclick="alert('Marks - Coming soon')">
                                    <i class="fas fa-pen"></i> Add Marks
                                </a>

                                <hr style="border-color: rgba(255,255,255,0.2);">

                                <a class="nav-link @if(Route::currentRouteName() == 'email.send') active @endif" 
                                   href="{{ route('email.send') }}">
                                    <i class="fas fa-envelope"></i> Send Notification
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'email.history') active @endif" 
                                   href="{{ route('email.history') }}">
                                    <i class="fas fa-history"></i> Email History
                                </a>
                            @elseif(Auth::user()->role->slug === 'hod')
                                <a class="nav-link @if(Route::currentRouteName() == 'hod.dashboard') active @endif" 
                                   href="{{ route('hod.dashboard') }}">
                                    <i class="fas fa-chart-pie"></i> Dashboard
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'hod.faculty') active @endif" 
                                   href="{{ route('hod.faculty') }}">
                                    <i class="fas fa-user-tie"></i> Faculty
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'hod.students') active @endif" 
                                   href="{{ route('hod.students') }}">
                                    <i class="fas fa-graduation-cap"></i> Students
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'hod.courses') active @endif" 
                                   href="{{ route('hod.courses') }}">
                                    <i class="fas fa-book"></i> Courses
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'hod.analytics') active @endif" 
                                   href="{{ route('hod.analytics') }}">
                                    <i class="fas fa-chart-bar"></i> Analytics
                                </a>

                                <hr style="border-color: rgba(255,255,255,0.2);">

                                <a class="nav-link @if(Route::currentRouteName() == 'email.send') active @endif" 
                                   href="{{ route('email.send') }}">
                                    <i class="fas fa-envelope"></i> Send Notification
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'email.history') active @endif" 
                                   href="{{ route('email.history') }}">
                                    <i class="fas fa-history"></i> Email History
                                </a>
                            @elseif(Auth::user()->role->slug === 'student')
                                <a class="nav-link @if(Route::currentRouteName() == 'student.dashboard') active @endif" 
                                   href="{{ route('student.dashboard') }}">
                                    <i class="fas fa-chart-line"></i> Dashboard
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'student.marks') active @endif" 
                                   href="{{ route('student.marks') }}">
                                    <i class="fas fa-pen"></i> Marks
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'student.attendance') active @endif" 
                                   href="{{ route('student.attendance') }}">
                                    <i class="fas fa-check"></i> Attendance
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'student.risk') active @endif" 
                                   href="{{ route('student.risk') }}">
                                    <i class="fas fa-exclamation-triangle"></i> Risk Analysis
                                </a>
                                <a class="nav-link @if(Route::currentRouteName() == 'student.alerts') active @endif" 
                                   href="{{ route('student.alerts') }}">
                                    <i class="fas fa-bell"></i> Alerts
                                </a>
                            @endif
                            
                            @if(Auth::user()->role->slug === 'admin' || Auth::user()->role->slug === 'faculty')
                                <hr style="border-color: rgba(255,255,255,0.2);">
                                
                                <a class="nav-link @if(Route::currentRouteName() == 'nlp.index') active @endif" 
                                   href="{{ route('nlp.index') }}">
                                    <i class="fas fa-brain"></i> NLP Queries
                                </a>

                                <a class="nav-link @if(Route::currentRouteName() == 'nlp.create') active @endif" 
                                   href="{{ route('nlp.create') }}">
                                    <i class="fas fa-search"></i> New Query
                                </a>
                            @endif
                        </div>
                    </nav>

                <!-- Main Content -->
                <div class="main-content">
                    <div style="padding: 30px;">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            @else
                <!-- Login/Register Page (No Sidebar) -->
                <div style="padding: 30px;">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            @endauth
            
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
