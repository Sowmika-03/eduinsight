@extends('layouts.app')

@section('title', $course->course_name . ' - Course Workspace')

@section('content')
<div x-data="{ activeTab: 'overview' }" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-book-open"></i>
                <span>Academic Course Workspace &bull; {{ $course->course_code }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ $course->course_name }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Faculty Coordinator: {{ $course->faculty->user->name ?? 'Dr. Faculty' }} &bull; Semester {{ $course->semester }} &bull; {{ $course->credits }} Credits
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('student.resources', ['course_id' => $course->id]) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition flex items-center gap-1.5 shadow-2xs">
                <i class="fas fa-folder-open"></i> Download Materials
            </a>
            <a href="{{ route('student.courses') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> All Courses
            </a>
        </div>
    </div>

    <!-- TABS NAVIGATION -->
    <div class="bg-white border border-slate-200 rounded-2xl p-2 shadow-xs">
        <div class="flex flex-wrap items-center gap-1">
            <button type="button" @click="activeTab = 'overview'" 
                    :class="activeTab === 'overview' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-chart-pie text-xs"></i> Overview
            </button>

            <button type="button" @click="activeTab = 'attendance'" 
                    :class="activeTab === 'attendance' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-calendar-check text-xs"></i> My Attendance
            </button>

            <button type="button" @click="activeTab = 'marks'" 
                    :class="activeTab === 'marks' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-square-poll-vertical text-xs"></i> Marks & Grades
            </button>

            <button type="button" @click="activeTab = 'assignments'" 
                    :class="activeTab === 'assignments' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-tasks text-xs"></i> Assignments
            </button>

            <button type="button" @click="activeTab = 'resources'" 
                    :class="activeTab === 'resources' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-folder-open text-xs"></i> Resources
            </button>

            <button type="button" @click="activeTab = 'announcements'" 
                    :class="activeTab === 'announcements' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-bullhorn text-xs"></i> Announcements
            </button>

            <button type="button" @click="activeTab = 'analytics'" 
                    :class="activeTab === 'analytics' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-brain text-xs"></i> AI Study Insights
            </button>
        </div>
    </div>

    <!-- TAB 1: OVERVIEW -->
    <div x-show="activeTab === 'overview'" class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
                <div class="text-[10px] font-extrabold text-slate-400 uppercase">My Attendance</div>
                <div class="text-2xl font-black text-emerald-600 mt-1">86.4%</div>
                <div class="text-[11px] text-emerald-600 font-bold mt-1">Status: Good</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
                <div class="text-[10px] font-extrabold text-slate-400 uppercase">Current Grade</div>
                <div class="text-2xl font-black text-blue-600 mt-1">Grade A</div>
                <div class="text-[11px] text-slate-500 font-medium mt-1">Internal: 44/50</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
                <div class="text-[10px] font-extrabold text-slate-400 uppercase">Course Progress</div>
                <div class="text-2xl font-black text-purple-600 mt-1">75%</div>
                <div class="text-[11px] text-purple-700 font-medium mt-1">Week 12 of 16</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
                <div class="text-[10px] font-extrabold text-slate-400 uppercase">Faculty Advisor</div>
                <div class="text-sm font-extrabold text-slate-900 mt-2 truncate">{{ $course->faculty->user->name ?? 'Dr. Faculty' }}</div>
                <div class="text-[11px] text-slate-400 font-medium mt-0.5">{{ $course->faculty->user->email ?? 'faculty@edu.in' }}</div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2">Course Syllabus & Description</h3>
            <p class="text-xs text-slate-600 leading-relaxed font-medium">
                {{ $course->description ?? 'Comprehensive core curriculum covering practical applications, theory foundations, and continuous academic evaluation.' }}
            </p>
        </div>
    </div>

    <!-- TAB 2: MY ATTENDANCE -->
    <div x-show="activeTab === 'attendance'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-3">Attendance History for {{ $course->course_name }}</h3>
            <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-2.5 px-4">Session Date</th>
                            <th class="py-2.5 px-4">Status</th>
                            <th class="py-2.5 px-4">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($attendance as $att)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 font-mono font-bold text-slate-900">{{ $att->attendance_date->format('M d, Y') }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-1 rounded-lg {{ $att->status === 'present' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }} font-extrabold">
                                        {{ ucfirst($att->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-slate-500">{{ $att->remarks ?? 'Regular Session' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-slate-400">No attendance records logged for this course yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB 3: MARKS -->
    <div x-show="activeTab === 'marks'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-3">Marks & Assessment Log for {{ $course->course_name }}</h3>
            <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-2.5 px-4">Assessment Type</th>
                            <th class="py-2.5 px-4">Internal Marks (/50)</th>
                            <th class="py-2.5 px-4">External Marks (/50)</th>
                            <th class="py-2.5 px-4">Total Score (/100)</th>
                            <th class="py-2.5 px-4 text-right">Grade</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($marks as $m)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 font-bold text-slate-900">{{ ucfirst($m->assessment_type) }}</td>
                                <td class="py-3 px-4 text-slate-700 font-semibold">{{ $m->internal_marks }}</td>
                                <td class="py-3 px-4 text-slate-700 font-semibold">{{ $m->external_marks }}</td>
                                <td class="py-3 px-4 font-black text-blue-700">{{ $m->total_marks }}</td>
                                <td class="py-3 px-4 text-right font-black text-emerald-600">{{ $m->grade }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-slate-400">No marks recorded for this course yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB 4: ASSIGNMENTS -->
    <div x-show="activeTab === 'assignments'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2">Pending & Submitted Assignments</h3>
            <p class="text-xs text-slate-500">Track submission deadlines, requirements, and faculty feedback.</p>
        </div>
    </div>

    <!-- TAB 5: RESOURCES -->
    <div x-show="activeTab === 'resources'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2">Resource Download Center</h3>
            <p class="text-xs text-slate-500">Lecture slides, lab code, syllabus PDF, and recommended reference books.</p>
        </div>
    </div>

    <!-- TAB 6: ANNOUNCEMENTS -->
    <div x-show="activeTab === 'announcements'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2">Course Announcements</h3>
            <p class="text-xs text-slate-500">Official updates from faculty coordinator regarding exam timetables and lab submissions.</p>
        </div>
    </div>

    <!-- TAB 7: ANALYTICS -->
    <div x-show="activeTab === 'analytics'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2">AI Subject Intelligence</h3>
            <p class="text-xs text-slate-500">Personalized study plan generated based on your attendance and assessment scores.</p>
        </div>
    </div>

</div>
@endsection
