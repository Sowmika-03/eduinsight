<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - EduInsight Platform</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN (For instant master styling compatibility) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
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
        
        /* Modern Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    
    @yield('styles')
</head>
<body class="h-full bg-slate-50 text-slate-900 font-sans antialiased" x-data="{ sidebarOpen: false, profileDropdown: false, notificationsOpen: false }">

    @auth
    <!-- TOP NAVIGATION BAR (Microsoft 365 / Linear Style) -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-slate-200 z-40 flex items-center justify-between px-4 lg:px-6 shadow-xs">
        <!-- Left Section: Brand & Mobile Toggle -->
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen" type="button" class="lg:hidden text-slate-500 hover:text-slate-700 focus:outline-none p-2 rounded-lg hover:bg-slate-100">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-sm group-hover:bg-blue-700 transition">
                    <i class="fas fa-graduation-cap text-lg"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-slate-900 text-lg tracking-tight leading-none">EduInsight</span>
                    <span class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase leading-tight mt-0.5">Academic Analytics</span>
                </div>
            </a>
            
            <!-- Context Badge -->
            <div class="hidden sm:flex items-center ml-3 pl-3 border-l border-slate-200">
                <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 border border-blue-100 uppercase tracking-wider">
                    {{ Auth::user()->role->slug }} PORTAL
                </span>
            </div>
        </div>
        
        <!-- Center Section: Breadcrumb & Title -->
        <div class="hidden md:flex items-center text-sm text-slate-500 gap-2">
            <i class="fas fa-home text-slate-400 text-xs"></i>
            <span>/</span>
            <span class="capitalize font-medium text-slate-600">{{ Auth::user()->role->slug }}</span>
            <span>/</span>
            <span class="font-semibold text-slate-900">@yield('title', 'Dashboard')</span>
        </div>
        
        <!-- Right Section: Actions & User Dropdown -->
        <div class="flex items-center gap-3">
            <!-- Search Bar Mockup -->
            <div class="hidden lg:flex items-center relative">
                <i class="fas fa-search absolute left-3 text-slate-400 text-xs"></i>
                <input type="text" placeholder="Search analytics, students, courses..." class="w-64 pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
            </div>

            <!-- Notifications Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="relative p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition">
                    <i class="fas fa-bell text-base"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                </button>
                
                <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-xl shadow-lg py-2 z-50 animate-fadeIn">
                    <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
                        <span class="font-semibold text-xs text-slate-900 uppercase tracking-wider">System Notifications</span>
                        <span class="text-[10px] bg-blue-50 text-blue-600 font-semibold px-2 py-0.5 rounded">Active</span>
                    </div>
                    <div class="max-h-64 overflow-y-auto divide-y divide-slate-100">
                        <a href="{{ route('admin.alerts') }}" class="block px-4 py-2.5 hover:bg-slate-50 transition">
                            <p class="text-xs font-medium text-slate-800">Academic Risk Detection System</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">319 early-warning alerts monitored.</p>
                        </a>
                    </div>
                    <div class="px-4 py-2 border-t border-slate-100 text-center">
                        <a href="{{ route('admin.alerts') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">View All Alerts &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="flex items-center gap-2.5 p-1.5 rounded-lg hover:bg-slate-100 transition">
                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="hidden sm:flex flex-col text-left">
                        <span class="text-xs font-semibold text-slate-900 leading-tight">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-slate-500 leading-tight capitalize">{{ Auth::user()->role->slug }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-slate-400 text-[10px] ml-1"></i>
                </button>
                
                <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-lg py-1 z-50">
                    <div class="px-4 py-3 border-b border-slate-100">
                        <p class="text-xs font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 transition">
                            <i class="fas fa-th-large text-slate-400 w-4"></i> Dashboard
                        </a>
                    </div>
                    <div class="border-t border-slate-100 py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition text-left">
                                <i class="fas fa-sign-out-alt text-red-500 w-4"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- SIDEBAR NAVIGATION (Linear / GitHub Style Master Sidebar) -->
    <aside class="fixed top-16 left-0 bottom-0 w-64 bg-white border-r border-slate-200 z-30 flex flex-col transition-transform duration-200 ease-in-out lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        
        <!-- Sidebar Navigation Groups -->
        <div class="flex-1 overflow-y-auto px-3 py-4 space-y-6">
            
            <!-- 1. OVERVIEW SECTION -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Overview</p>
                <div class="space-y-1">
                    @if(Auth::user()->role->slug === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'admin.dashboard' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-chart-line w-4 text-center {{ Route::currentRouteName() == 'admin.dashboard' ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Admin Dashboard</span>
                        </a>
                    @elseif(Auth::user()->role->slug === 'hod')
                        <a href="{{ route('hod.dashboard') }}" 
                           class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'hod.dashboard' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-chart-pie w-4 text-center {{ Route::currentRouteName() == 'hod.dashboard' ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>HOD Dashboard</span>
                        </a>
                    @elseif(Auth::user()->role->slug === 'faculty')
                        <a href="{{ route('faculty.dashboard') }}" 
                           class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'faculty.dashboard' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-chart-line w-4 text-center {{ Route::currentRouteName() == 'faculty.dashboard' ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Faculty Dashboard</span>
                        </a>
                    @elseif(Auth::user()->role->slug === 'student')
                        <a href="{{ route('student.dashboard') }}" 
                           class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'student.dashboard' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600 shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-chart-line w-4 text-center {{ Route::currentRouteName() == 'student.dashboard' ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Student Dashboard</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- 2. ACADEMIC MANAGEMENT -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Academics</p>
                <div class="space-y-1">
                    @if(Auth::user()->role->slug === 'admin')
                        <a href="{{ route('admin.students') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'admin.students' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-user-graduate w-4 text-center text-slate-400"></i>
                            <span>Students List</span>
                        </a>
                        <a href="{{ route('admin.courses') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'admin.courses' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-book-open w-4 text-center text-slate-400"></i>
                            <span>Courses & Subjects</span>
                        </a>
                        <a href="{{ route('admin.alerts') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'admin.alerts' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-bell w-4 text-center text-slate-400"></i>
                            <span>System Alerts</span>
                        </a>
                    @elseif(Auth::user()->role->slug === 'hod')
                        <a href="{{ route('hod.faculty') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ request()->routeIs('hod.faculty*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-user-tie w-4 text-center text-slate-400"></i>
                            <span>Faculty Directory</span>
                        </a>
                        <a href="{{ route('hod.students') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ request()->routeIs('hod.students*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-graduation-cap w-4 text-center text-slate-400"></i>
                            <span>Student Directory</span>
                        </a>
                        <a href="{{ route('hod.courses') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ request()->routeIs('hod.courses*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-book w-4 text-center text-slate-400"></i>
                            <span>Department Courses</span>
                        </a>
                    @elseif(Auth::user()->role->slug === 'faculty')
                        <a href="{{ route('faculty.courses') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'faculty.courses' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-chalkboard-teacher w-4 text-center text-slate-400"></i>
                            <span>My Assigned Courses</span>
                        </a>
                        <a href="{{ route('faculty.attendance') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'faculty.attendance' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-calendar-check w-4 text-center text-slate-400"></i>
                            <span>Attendance Management</span>
                        </a>
                    @elseif(Auth::user()->role->slug === 'student')
                        <a href="{{ route('student.marks') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'student.marks' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-file-alt w-4 text-center text-slate-400"></i>
                            <span>Academic Marks</span>
                        </a>
                        <a href="{{ route('student.attendance') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'student.attendance' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-user-check w-4 text-center text-slate-400"></i>
                            <span>My Attendance</span>
                        </a>
                        <a href="{{ route('student.risk') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'student.risk' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-exclamation-triangle w-4 text-center text-slate-400"></i>
                            <span>Risk Indicator</span>
                        </a>
                        <a href="{{ route('student.alerts') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'student.alerts' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-bell w-4 text-center text-slate-400"></i>
                            <span>My Warnings</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- 3. ADMINISTRATION & ANALYTICS -->
            @if(Auth::user()->role->slug === 'admin')
                <div>
                    <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Faculty Management</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.faculty.pending') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'admin.faculty.pending' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-clipboard-check w-4 text-center text-slate-400"></i>
                            <span>Pending Approvals</span>
                        </a>
                        <a href="{{ route('admin.faculty.manage') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'admin.faculty.manage' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-users-cog w-4 text-center text-slate-400"></i>
                            <span>Faculty Directory</span>
                        </a>
                        <a href="{{ route('admin.faculty.statistics') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'admin.faculty.statistics' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-chart-bar w-4 text-center text-slate-400"></i>
                            <span>Faculty Statistics</span>
                        </a>
                    </div>
                </div>
            @endif

            @if(Auth::user()->role->slug === 'hod')
                <div>
                    <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Department Intelligence</p>
                    <div class="space-y-1">
                        <a href="{{ route('hod.analytics') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'hod.analytics' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-chart-area w-4 text-center text-slate-400"></i>
                            <span>Department Analytics</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 4. COMMUNICATIONS & AI TOOLKIT -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Communication & AI</p>
                <div class="space-y-1">
                    @if(Auth::user()->role->slug === 'admin' || Auth::user()->role->slug === 'faculty' || Auth::user()->role->slug === 'hod')
                        <a href="{{ route('email.send') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'email.send' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-paper-plane w-4 text-center text-slate-400"></i>
                            <span>Send Notification</span>
                        </a>
                        <a href="{{ route('email.history') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'email.history' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-history w-4 text-center text-slate-400"></i>
                            <span>Email Delivery Logs</span>
                        </a>
                    @endif

                    @if(Auth::user()->role->slug === 'admin' || Auth::user()->role->slug === 'faculty')
                        <a href="{{ route('nlp.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'nlp.index' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-brain w-4 text-center text-purple-500"></i>
                            <span>NLP Query Engine</span>
                        </a>
                        <a href="{{ route('nlp.create') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-medium rounded-lg transition {{ Route::currentRouteName() == 'nlp.create' ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-search-plus w-4 text-center text-purple-500"></i>
                            <span>New Natural Query</span>
                        </a>
                    @endif
                </div>
            </div>

        </div>

        <!-- Sidebar Footer -->
        <div class="p-3 border-t border-slate-200 bg-slate-50/50">
            <div class="flex items-center gap-3 p-2 rounded-lg bg-white border border-slate-200">
                <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex flex-col truncate">
                    <span class="text-xs font-semibold text-slate-800 truncate leading-tight">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-slate-400 truncate leading-tight">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Overlay Backdrop for Mobile Sidebar -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 bg-slate-900/40 z-20 lg:hidden"></div>

    <!-- MAIN CONTENT AREA -->
    <main class="lg:ml-64 pt-16 min-h-screen flex flex-col">
        <div class="p-4 sm:p-6 lg:p-8 flex-1 max-w-[1700px] w-full mx-auto">
            
            <!-- Global Flash Messages -->
            @if(isset($errors) && $errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 flex flex-col gap-1.5 shadow-xs">
                    <div class="flex items-center gap-2 font-semibold text-sm">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                        <span>Validation Exception</span>
                    </div>
                    <ul class="list-disc list-inside text-xs text-red-700 space-y-0.5 ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5 text-xs font-medium">
                        <i class="fas fa-check-circle text-emerald-600 text-base"></i>
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
                <span>&copy; {{ date('Y') }} EduInsight Academic Analytics Platform. All rights reserved.</span>
                <div class="flex items-center gap-4 text-slate-400">
                    <span class="hover:text-slate-600">System v2.4</span>
                    <span>&bull;</span>
                    <span class="hover:text-slate-600">Light Theme Master Framework</span>
                </div>
            </div>
        </footer>
    </main>

    @else
    <!-- GUEST / UNAUTHENTICATED ROUTE CONTAINER -->
    <main class="min-h-screen bg-slate-100 flex items-center justify-center p-4">
        @yield('content')
    </main>
    @endauth

    @yield('scripts')
</body>
</html>
