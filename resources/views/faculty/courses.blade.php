@extends('layouts.app')

@section('title', 'My Assigned Courses Catalog')

@section('content')
<div x-data="{ 
    searchTerm: '', 
    selectedSem: 'all',
    selectedType: 'all' 
}" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-book-open"></i>
                <span>Academic Curriculum Portal</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                My Assigned Courses Catalog
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Manage course content, enrollment rosters, student attendance, and grade analytics.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('faculty.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Top KPIs Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
        <!-- KPI 1: Total Courses -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Assigned Courses</span>
                <i class="fas fa-book text-blue-500"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $courses->total() ?? $courses->count() }}</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">Active Curriculum</div>
        </div>

        <!-- KPI 2: Theory Courses -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Theory Subjects</span>
                <i class="fas fa-chalkboard-user text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">3</div>
            <div class="text-[11px] text-purple-700 font-medium mt-1">Lecture Credits</div>
        </div>

        <!-- KPI 3: Lab Subjects -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Practical Labs</span>
                <i class="fas fa-flask text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">1</div>
            <div class="text-[11px] text-emerald-700 font-medium mt-1">Hands-on Sessions</div>
        </div>

        <!-- KPI 4: Total Students -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Total Enrolled</span>
                <i class="fas fa-users text-amber-500"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">
                {{ $courses->sum(fn($c) => $c->enrollments->count()) }}
            </div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">Across all courses</div>
        </div>

        <!-- KPI 5: Avg Attendance -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Avg Attendance</span>
                <i class="fas fa-chart-line text-blue-600"></i>
            </div>
            <div class="text-2xl font-black text-blue-600 mt-1">85.4%</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; +1.2% this term</div>
        </div>

        <!-- KPI 6: Avg Performance -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Avg Performance</span>
                <i class="fas fa-trophy text-indigo-500"></i>
            </div>
            <div class="text-2xl font-black text-indigo-600 mt-1">78.2 / 100</div>
            <div class="text-[11px] text-indigo-700 font-medium mt-1">Good Standing</div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 items-center">
            <!-- Search -->
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Search Course</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="searchTerm" placeholder="Code, title or description..." class="w-full pl-8 pr-3 py-2 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
            </div>

            <!-- Semester -->
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Semester Filter</label>
                <select x-model="selectedSem" class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <option value="all">All Semesters</option>
                    <option value="4">Semester 4 (Active)</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                </select>
            </div>

            <!-- Course Type -->
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Course Type</label>
                <select x-model="selectedType" class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <option value="all">All Course Types</option>
                    <option value="theory">Theory Lecture</option>
                    <option value="lab">Practical Lab</option>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Status</label>
                <select class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <option value="active">Active Term (In Progress)</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
        </div>
    </div>

    <!-- MODERN COURSE CARDS GRID -->
    @if ($courses->isEmpty())
        <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-xs">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-4">
                <i class="fas fa-inbox"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800">No Assigned Courses Found</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                You do not have any courses assigned for the current academic session. Contact your HOD or Administrator if this is incorrect.
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($courses as $course)
                <div x-show="(searchTerm === '' || '{{ strtolower($course->course_name) }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($course->course_code) }}'.includes(searchTerm.toLowerCase())) && (selectedSem === 'all' || '{{ $course->semester }}' === selectedSem)" 
                     class="bg-white border border-slate-200 hover:border-blue-500/80 rounded-2xl shadow-xs transition duration-200 flex flex-col justify-between overflow-hidden group">
                    
                    <!-- Card Top Header -->
                    <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $course->course_code }}
                                </span>
                                <h3 class="text-base font-extrabold text-slate-900 mt-2 line-clamp-1 group-hover:text-blue-600 transition">
                                    {{ $course->course_name }}
                                </h3>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">
                                    Semester {{ $course->semester }} &bull; {{ $course->credits }} Academic Credits
                                </p>
                            </div>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0 mt-1" title="Active"></span>
                        </div>
                    </div>

                    <!-- Card Body Metrics -->
                    <div class="p-5 space-y-4">
                        <p class="text-xs text-slate-600 line-clamp-2 font-medium">
                            {{ $course->description ?? 'Comprehensive core curriculum covering practical applications, theory foundations, and evaluation.' }}
                        </p>

                        <div class="grid grid-cols-3 gap-2 py-3 px-3 bg-slate-50 rounded-xl border border-slate-200/80 text-center">
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Enrolled</div>
                                <div class="text-sm font-black text-slate-900 mt-0.5">{{ $course->enrollments->count() }}</div>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Attendance</div>
                                <div class="text-sm font-black text-emerald-600 mt-0.5">85%</div>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Pass Rate</div>
                                <div class="text-sm font-black text-blue-600 mt-0.5">90%</div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="p-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-2">
                        <a href="{{ route('faculty.course.show', $course->id) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition flex items-center gap-1.5 shadow-2xs">
                            <i class="fas fa-eye text-xs"></i> View Course Details
                        </a>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('faculty.attendance', ['course_id' => $course->id]) }}" class="p-2 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 text-slate-600 hover:text-blue-600 transition" title="Record Attendance">
                                <i class="fas fa-calendar-check text-xs"></i>
                            </a>
                            <a href="{{ route('faculty.marks', ['course_id' => $course->id]) }}" class="p-2 rounded-xl bg-white hover:bg-emerald-50 border border-slate-200 text-slate-600 hover:text-emerald-600 transition" title="Manage Marks">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $courses->links() }}
        </div>
    @endif

</div>
@endsection
