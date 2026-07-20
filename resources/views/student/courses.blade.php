@extends('layouts.app')

@section('title', 'My Courses Catalog')

@section('content')
<div x-data="{ 
    searchTerm: '', 
    selectedSem: 'all' 
}" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-book-open"></i>
                <span>Enrolled Academic Curriculum</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                My Enrolled Courses Workspace
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Access course syllabi, faculty information, learning materials, attendance breakdown, and grade sheets.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Top KPIs Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Enrolled Courses</span>
                <i class="fas fa-book text-blue-500"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $enrollments->total() ?? $enrollments->count() }}</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">Active Term 2026</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Total Term Credits</span>
                <i class="fas fa-award text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">16 Credits</div>
            <div class="text-[11px] text-purple-700 font-medium mt-1">Full Academic Load</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Avg Course Attendance</span>
                <i class="fas fa-calendar-check text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">86.4%</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&ge; 75% Requirement</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Avg Grade Standings</span>
                <i class="fas fa-star text-amber-500"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">Grade A</div>
            <div class="text-[11px] text-amber-700 font-bold mt-1">Good Academic Standing</div>
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
                    <input type="text" x-model="searchTerm" placeholder="Filter code, title or faculty..." class="w-full pl-8 pr-3 py-2 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
            </div>

            <!-- Semester -->
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Semester</label>
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
                <select class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <option value="all">Theory & Lab</option>
                    <option value="theory">Theory Lecture</option>
                    <option value="lab">Practical Lab</option>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Enrollment Status</label>
                <select class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <option value="active">Active Enrolled</option>
                    <option value="completed">Completed Term</option>
                </select>
            </div>
        </div>
    </div>

    <!-- COURSE CARDS GRID -->
    @if($enrollments->isEmpty())
        <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-xs">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-4">
                <i class="fas fa-book-open"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800">No Course Enrollments Found</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                You are currently not enrolled in any academic courses for this semester. Contact your Department Administrator.
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($enrollments as $enrollment)
                @php $c = $enrollment->course; @endphp
                <div x-show="(searchTerm === '' || '{{ strtolower($c->course_name) }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($c->course_code) }}'.includes(searchTerm.toLowerCase())) && (selectedSem === 'all' || '{{ $c->semester }}' === selectedSem)" 
                     class="bg-white border border-slate-200 hover:border-blue-500/80 rounded-2xl shadow-xs transition duration-200 flex flex-col justify-between overflow-hidden group">
                    
                    <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $c->course_code }}
                                </span>
                                <h3 class="text-base font-extrabold text-slate-900 mt-2 line-clamp-1 group-hover:text-blue-600 transition">
                                    {{ $c->course_name }}
                                </h3>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">
                                    Faculty: {{ $c->faculty->user->name ?? 'Faculty Coordinator' }}
                                </p>
                            </div>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0 mt-1" title="Active"></span>
                        </div>
                    </div>

                    <div class="p-5 space-y-4">
                        <p class="text-xs text-slate-600 line-clamp-2 font-medium">
                            {{ $c->description ?? 'Comprehensive core curriculum covering practical applications, theory foundations, and evaluation.' }}
                        </p>

                        <div class="grid grid-cols-3 gap-2 py-3 px-3 bg-slate-50 rounded-xl border border-slate-200/80 text-center">
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Credits</div>
                                <div class="text-sm font-black text-slate-900 mt-0.5">{{ $c->credits }}</div>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Attendance</div>
                                <div class="text-sm font-black text-emerald-600 mt-0.5">86%</div>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Current Grade</div>
                                <div class="text-sm font-black text-blue-600 mt-0.5">Grade A</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-2">
                        <a href="{{ route('student.course.show', $c->id) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition flex items-center gap-1.5 shadow-2xs">
                            <i class="fas fa-eye text-xs"></i> Open Workspace
                        </a>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('student.resources', ['course_id' => $c->id]) }}" class="p-2 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 text-slate-600 hover:text-blue-600 transition" title="Resources">
                                <i class="fas fa-folder-open text-xs"></i>
                            </a>
                            <a href="{{ route('student.attendance') }}" class="p-2 rounded-xl bg-white hover:bg-emerald-50 border border-slate-200 text-slate-600 hover:text-emerald-600 transition" title="Attendance">
                                <i class="fas fa-calendar-check text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $enrollments->links() }}
        </div>
    @endif

</div>
@endsection
