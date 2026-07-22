<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - EduInsight Platform</title>

    <!-- Dark Mode Inline Script to Prevent Initial Flash -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Flowbite & Alpine.js -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Custom CSS Asset -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Modern Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Global Component Table UI (Sticky Header & Hover Effects) */
        .table-responsive {
            border-radius: 1rem !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03) !important;
            background-color: #ffffff !important;
            overflow: auto !important;
            max-height: 70vh;
        }
        table, .table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            width: 100% !important;
            border: none !important;
        }
        table th, .table th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-size: 0.6875rem !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.06em !important;
            padding: 0.875rem 1.25rem !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }
        table td, .table td {
            padding: 0.875rem 1.25rem !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #1e293b !important;
            vertical-align: middle !important;
        }
        table tbody tr:hover, .table tbody tr:hover {
            background-color: #f8fafc !important;
        }

        /* Complete Dark Theme Global Overrides */
        html.dark, html.dark body, html.dark main {
            background-color: #0b0f19 !important;
            color: #f1f5f9 !important;
        }
        html.dark header, html.dark aside, html.dark footer {
            background-color: #111827 !important;
            border-color: #1f293d !important;
        }
        html.dark .bg-white, html.dark .bg-slate-50 {
            background-color: #151d30 !important;
            border-color: #243049 !important;
            color: #f1f5f9 !important;
        }
        html.dark .bg-slate-100, html.dark .bg-slate-200\/50, html.dark .bg-slate-50\/50 {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        html.dark .bg-slate-200, html.dark .bg-slate-300 {
            background-color: #27354f !important;
            border-color: #3b4d6e !important;
            color: #ffffff !important;
        }
        html.dark .text-slate-900, html.dark .text-slate-800, html.dark .text-slate-700, html.dark .text-slate-600 {
            color: #f8fafc !important;
        }
        html.dark .text-slate-500, html.dark .text-slate-400 {
            color: #cbd5e1 !important;
        }
        html.dark .border-slate-200, html.dark .border-slate-100, html.dark .border-slate-300, html.dark .border-slate-200\/60, html.dark .border-slate-200\/90 {
            border-color: #243049 !important;
        }
        html.dark input, html.dark select, html.dark textarea, html.dark .form-control {
            background-color: #0f172a !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }
        html.dark input::placeholder, html.dark textarea::placeholder {
            color: #64748b !important;
        }
        html.dark .table-responsive, html.dark .edu-card, html.dark .stat-box, html.dark .dashboard-card {
            background-color: #151d30 !important;
            border-color: #243049 !important;
            color: #f1f5f9 !important;
        }
        html.dark table th, html.dark .table th {
            background-color: #0f172a !important;
            color: #94a3b8 !important;
            border-bottom-color: #243049 !important;
        }
        html.dark table td, html.dark .table td {
            color: #e2e8f0 !important;
            border-bottom-color: #1e293b !important;
        }
        html.dark table tbody tr:hover, html.dark .table tbody tr:hover {
            background-color: #1e293b !important;
        }
        html.dark [x-show="open"], html.dark .shadow-xl, html.dark .shadow-2xl {
            background-color: #151d30 !important;
            border-color: #243049 !important;
        }
        html.dark .hover\:bg-slate-100:hover, html.dark .hover\:bg-slate-50:hover {
            background-color: #1e293b !important;
        }
    </style>
    
    @yield('styles')
</head>
<body class="h-full bg-slate-50 text-slate-900 font-sans antialiased" x-data="{ sidebarOpen: false, sidebarCollapsed: false, darkMode: document.documentElement.classList.contains('dark') }">

    @auth
    <!-- ENTERPRISE HEADER -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-slate-200 z-40 flex items-center justify-between px-4 lg:px-6 shadow-xs">
        <!-- Left Section: Brand & Sidebar Collapsible Controls -->
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen" type="button" class="lg:hidden text-slate-500 hover:text-slate-700 p-2 rounded-lg hover:bg-slate-100">
                <i class="fas fa-bars text-lg"></i>
            </button>
            <button @click="sidebarCollapsed = !sidebarCollapsed" type="button" class="hidden lg:flex text-slate-500 hover:text-slate-700 p-2 rounded-lg hover:bg-slate-100">
                <i class="fas fa-indent text-base"></i>
            </button>
            
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-blue-600 bg-linear-to-tr from-blue-700 to-blue-500 flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition" style="background: linear-gradient(to top right, #1d4ed8, #3b82f6);">
                    <i class="fas fa-graduation-cap text-lg"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-slate-900 text-lg tracking-tight leading-none">EduInsight</span>
                    <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase leading-tight mt-0.5">Enterprise Platform</span>
                </div>
            </a>
            
            <!-- Role & Department Badges -->
            <div class="hidden sm:flex items-center gap-2 ml-3 pl-3 border-l border-slate-200">
                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-100 uppercase tracking-wider">
                    {{ strtoupper(Auth::user()->role->name ?? Auth::user()->role->slug) }} PORTAL
                </span>
                
                @if(Auth::user()->role->slug === 'student' && Auth::user()->student)
                    @if(Auth::user()->student->program)
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-purple-50 text-purple-700 border border-purple-100 uppercase tracking-wider">
                            {{ Auth::user()->student->program }}
                        </span>
                    @endif
                    <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-slate-50 text-slate-600 border border-slate-200 uppercase tracking-wider">
                        SEM {{ Auth::user()->student->semester }} &bull; {{ date('Y') }}
                    </span>
                @elseif(Auth::user()->role->slug === 'faculty' && Auth::user()->faculty)
                    @if(Auth::user()->faculty->department)
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-purple-50 text-purple-700 border border-purple-100 uppercase tracking-wider">
                            {{ Auth::user()->faculty->department }}
                        </span>
                    @endif
                @elseif(Auth::user()->role->slug === 'hod' && Auth::user()->hod)
                    @if(Auth::user()->hod->department)
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-purple-50 text-purple-700 border border-purple-100 uppercase tracking-wider">
                            {{ Auth::user()->hod->department }}
                        </span>
                    @endif
                @elseif(Auth::user()->role->slug === 'parent')
                    @php
                        $child = \App\Models\Student::where('parent_id', Auth::id())->first();
                    @endphp
                    @if($child)
                        @if($child->program)
                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-purple-50 text-purple-700 border border-purple-100 uppercase tracking-wider">
                                {{ $child->program }}
                            </span>
                        @endif
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-slate-50 text-slate-600 border border-slate-200 uppercase tracking-wider">
                            SEM {{ $child->semester }} &bull; {{ date('Y') }}
                        </span>
                    @endif
                @endif
            </div>
        </div>

        
        <!-- Right Section: Global Search, Theme Toggle, Notifications & Profile -->
        <div class="flex items-center gap-3">
            <!-- Global Search -->
            <div class="hidden lg:flex items-center relative">
                <i class="fas fa-search absolute left-3 text-slate-400 text-xs"></i>
                <input type="text" placeholder="Search students, courses, marks..." class="w-64 pl-8 pr-3 py-1.5 text-xs font-medium bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
            </div>

            <!-- Dark / Light Theme Toggle Button -->
            <button @click="darkMode = !darkMode; if(darkMode){ document.documentElement.classList.add('dark'); localStorage.setItem('color-theme', 'dark'); } else { document.documentElement.classList.remove('dark'); localStorage.setItem('color-theme', 'light'); }" 
                    type="button" 
                    class="p-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition flex items-center justify-center" 
                    title="Toggle Light/Dark Theme">
                <i x-show="!darkMode" class="fas fa-moon text-base text-slate-600"></i>
                <i x-show="darkMode" class="fas fa-sun text-base text-amber-400" x-cloak></i>
            </button>

            <!-- Notifications Bell -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="relative p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition">
                    <i class="fas fa-bell text-base"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                </button>
                
                <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50">
                    <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
                        <span class="font-bold text-xs text-slate-900 uppercase tracking-wider">System Alerts</span>
                        <span class="text-[10px] bg-red-50 text-red-600 font-bold px-2 py-0.5 rounded-full">3 Active</span>
                    </div>
                    <div class="max-h-64 overflow-y-auto divide-y divide-slate-100">
                        <a href="{{ route('email.history') }}" class="block px-4 py-2.5 hover:bg-slate-50 transition">
                            <p class="text-xs font-bold text-slate-800">Low Attendance Warning Triggered</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">5 students fell below 75% threshold</p>
                        </a>
                    </div>
                    <div class="px-4 py-2 border-t border-slate-100 text-center">
                        <a href="{{ route('email.history') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">View All Delivery Logs &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="flex items-center gap-2.5 p-1 rounded-xl hover:bg-slate-100 transition">
                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="hidden sm:flex flex-col text-left">
                        <span class="text-xs font-extrabold text-slate-900 leading-tight">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] font-medium text-slate-500 leading-tight capitalize">{{ Auth::user()->role->slug }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-slate-400 text-[10px] ml-1"></i>
                </button>
                
                <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-2xl shadow-xl py-1 z-50">
                    <div class="px-4 py-3 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                            <i class="fas fa-th-large text-slate-400 w-4"></i> Command Center
                        </a>
                    </div>
                    <div class="border-t border-slate-100 py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 transition text-left">
                                <i class="fas fa-sign-out-alt text-red-500 w-4"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- REDESIGNED MASTER SIDEBAR -->
    <aside class="fixed top-16 left-0 bottom-0 bg-white border-r border-slate-200 z-30 flex flex-col transition-all duration-200 ease-in-out lg:translate-x-0"
           :class="[
               sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
               sidebarCollapsed ? 'w-20' : 'w-64'
           ]">
        
        <!-- Sidebar Groups -->
        <div class="flex-1 overflow-y-auto px-3 py-4 space-y-5">
            
            <!-- 1. OVERVIEW -->
            <div>
                <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Overview</p>
                <div class="space-y-1">
                    @php $dashboardRoute = Auth::user()->role->slug . '.dashboard'; @endphp
                    <a href="{{ route($dashboardRoute) }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == $dashboardRoute ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600 shadow-2xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-chart-line w-4 text-center {{ Route::currentRouteName() == $dashboardRoute ? 'text-blue-600' : 'text-slate-400' }}"></i>
                        <span x-show="!sidebarCollapsed">Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- 2. ACADEMICS -->
            <div>
                <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Academics</p>
                <div class="space-y-1">
                    @if(Auth::user()->role->slug === 'faculty')
                        <a href="{{ route('faculty.courses') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'faculty.courses' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-book-open w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">My Courses</span>
                        </a>
                        <a href="{{ route('faculty.attendance') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'faculty.attendance' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-calendar-check w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Attendance</span>
                        </a>
                        <a href="{{ route('faculty.marks') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'faculty.marks' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-edit w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Marks</span>
                        </a>
                        <a href="{{ route('faculty.analytics') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'faculty.analytics' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-chart-pie w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Teaching Analytics</span>
                        </a>
                    @elseif(Auth::user()->role->slug === 'student')
                        <a href="{{ route('student.courses') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'student.courses' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-book-open w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">My Courses</span>
                        </a>
                        <a href="{{ route('student.attendance') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'student.attendance' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-calendar-check w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Attendance</span>
                        </a>
                        <a href="{{ route('student.marks') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'student.marks' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-square-poll-vertical w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Marks & Grades</span>
                        </a>
                        <a href="{{ route('student.performance') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'student.performance' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-chart-column w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Performance</span>
                        </a>
                        <a href="{{ route('student.risk') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'student.risk' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-triangle-exclamation w-4 text-center text-amber-500"></i>
                            <span x-show="!sidebarCollapsed">Risk Analysis</span>
                        </a>
                    @elseif(Auth::user()->role->slug === 'admin')
                        <a href="{{ route('admin.students') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'admin.students' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-user-graduate w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Students Tab</span>
                        </a>
                        <a href="{{ route('admin.courses') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'admin.courses' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-book w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Course Catalog</span>
                        </a>
                    @elseif(Auth::user()->role->slug === 'hod')
                        <a href="{{ route('hod.students') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ request()->routeIs('hod.students*') ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-user-graduate w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Students</span>
                        </a>
                        <a href="{{ route('hod.faculty') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ request()->routeIs('hod.faculty*') ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-user-tie w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Faculty Directory</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- 3. COMMUNICATION & WORKSPACE -->
            <div>
                <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Communication & Workspace</p>
                <div class="space-y-1">
                    @if(Auth::user()->role->slug === 'student')
                        <a href="{{ route('student.notifications') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'student.notifications' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-bell w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Notifications</span>
                        </a>
                        <a href="{{ route('student.resources') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'student.resources' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-folder-open w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Resources</span>
                        </a>
                    @else
                        <a href="{{ route('email.send') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'email.send' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-paper-plane w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Notifications</span>
                        </a>
                        <a href="{{ route('email.history') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'email.history' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-history w-4 text-center text-slate-400"></i>
                            <span x-show="!sidebarCollapsed">Email Logs</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- 4. ARTIFICIAL INTELLIGENCE -->
            <div>
                <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-black text-purple-400 uppercase tracking-wider mb-2">Artificial Intelligence</p>
                <div class="space-y-1">
                    @php 
                        $aiRoute = Auth::user()->role->slug === 'faculty' ? 'faculty.ai' : (Auth::user()->role->slug === 'hod' ? 'hod.ai' : (Auth::user()->role->slug === 'student' ? 'student.ai' : 'nlp.queries')); 
                    @endphp
                    <a href="{{ route($aiRoute) }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == $aiRoute ? 'bg-purple-50 text-purple-700 font-extrabold border-l-4 border-purple-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-robot w-4 text-center text-purple-600"></i>
                        <span x-show="!sidebarCollapsed">EduInsight AI</span>
                    </a>
                    <a href="{{ route('nlp.queries') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'nlp.queries' || Route::currentRouteName() == 'nlp.index' ? 'bg-purple-50 text-purple-700 font-extrabold border-l-4 border-purple-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-brain w-4 text-center text-purple-500"></i>
                        <span x-show="!sidebarCollapsed">AI History</span>
                    </a>
                </div>
            </div>

            <!-- 5. PERSONAL INTELLIGENCE WORKSPACE -->
            @if(Auth::user()->role->slug === 'student')
            <div>
                <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Personal Workspace</p>
                <div class="space-y-1">
                    <a href="{{ route('student.profile') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'student.profile' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-user w-4 text-center text-slate-400"></i>
                        <span x-show="!sidebarCollapsed">My Profile</span>
                    </a>
                    <a href="{{ route('student.goals') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'student.goals' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-bullseye w-4 text-center text-slate-400"></i>
                        <span x-show="!sidebarCollapsed">Academic Goals</span>
                    </a>
                    <a href="{{ route('student.achievements') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition {{ Route::currentRouteName() == 'student.achievements' ? 'bg-blue-50 text-blue-700 font-extrabold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-award w-4 text-center text-amber-500"></i>
                        <span x-show="!sidebarCollapsed">Achievements</span>
                    </a>
                </div>
            </div>
            @endif

        </div>

        <!-- Sidebar Footer -->
        <div class="p-3 border-t border-slate-200 bg-slate-50/50">
            <div class="flex items-center gap-3 p-2 rounded-xl bg-white border border-slate-200">
                <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div x-show="!sidebarCollapsed" class="flex flex-col truncate">
                    <span class="text-xs font-extrabold text-slate-800 truncate leading-tight">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] font-medium text-slate-400 truncate leading-tight">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Overlay Backdrop for Mobile Sidebar -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 bg-slate-900/40 z-20 lg:hidden"></div>

    <!-- MAIN CONTENT AREA -->
    <main class="pt-16 min-h-screen flex flex-col transition-all duration-200"
          :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-64'">
        <div class="p-4 sm:p-6 lg:p-8 flex-1 max-w-[95%] w-full mx-auto">
            
            <!-- Global Validation Alerts -->
            @if(isset($errors) && $errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 flex flex-col gap-1.5 shadow-2xs">
                    <div class="flex items-center gap-2 font-bold text-xs">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                        <span>Validation Alert</span>
                    </div>
                    <ul class="list-disc list-inside text-xs text-red-700 space-y-0.5 ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-2xs">
                    <div class="flex items-center gap-2.5 text-xs font-bold">
                        <i class="fas fa-check-circle text-emerald-600 text-sm"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            @endif

            <!-- PAGE CONTENT INJECTION -->
            @yield('content')
            @yield('hod-content')

        </div>

        <!-- System Footer -->
        <footer class="mt-auto border-t border-slate-200 bg-white py-4 px-6 text-center text-xs text-slate-500">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
                <span class="font-medium">&copy; {{ date('Y') }} EduInsight Academic Analytics Platform. All rights reserved.</span>
                <div class="flex items-center gap-4 text-slate-400 font-medium">
                    <span>System v2.5 Enterprise</span>
                    <span>&bull;</span>
                    <span>Role: {{ ucfirst(Auth::user()->role->slug) }}</span>
                </div>
            </div>
        </footer>
    </main>

    @else
    <!-- GUEST CONTAINER -->
    <main class="min-h-screen bg-slate-100 flex items-center justify-center p-4">
        @yield('content')
    </main>
    @endauth

    @yield('scripts')
</body>
</html>
