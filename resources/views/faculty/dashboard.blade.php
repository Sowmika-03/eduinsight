@extends('layouts.app')

@section('title', 'Faculty Teaching Intelligence Workspace')

@section('content')
<div class="space-y-6">

    <!-- TOP GREETING BANNER -->
    <div class="bg-slate-900 bg-linear-to-r from-slate-900 via-blue-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-blue-900/50" style="background: linear-gradient(to right, #0f172a, #0b1329, #0f172a);">
        <!-- Subtle Decorative Background Pattern -->
        <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-40 -top-10 w-60 h-60 bg-purple-600/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex flex-wrap items-center gap-2 text-xs font-extrabold uppercase tracking-widest text-blue-400">
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-500/20 border border-blue-400/30">
                        <i class="fas fa-chalkboard-user text-blue-300 mr-1"></i> Teaching Intelligence Workspace
                    </span>
                    <span>&bull;</span>
                    <span class="text-slate-300 font-mono">{{ date('l, F j, Y') }}</span>
                </div>
                
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    @php
                        $hour = date('H');
                        $greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
                    @endphp
                    {{ $greeting }}, {{ Auth::user()->name }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-300 font-medium">
                    <span class="flex items-center gap-1.5 bg-slate-800/80 px-3 py-1 rounded-xl border border-slate-700">
                        <i class="fas fa-building text-blue-400"></i>
                        {{ $faculty->department ?? 'CSE Department' }}
                    </span>
                    <span class="flex items-center gap-1.5 bg-slate-800/80 px-3 py-1 rounded-xl border border-slate-700">
                        <i class="fas fa-user-tie text-purple-400"></i>
                        Senior Associate Professor
                    </span>
                    <span class="flex items-center gap-1.5 bg-slate-800/80 px-3 py-1 rounded-xl border border-slate-700">
                        <i class="fas fa-calendar-alt text-emerald-400"></i>
                        @php
                            $semesters = $courses->pluck('semester')->unique()->sort()->implode(', ');
                        @endphp
                        SEM {{ $semesters ?: '4' }} &bull; {{ date('Y') }} Academic Term
                    </span>
                    <span class="flex items-center gap-1.5 bg-emerald-500/20 text-emerald-300 px-3 py-1 rounded-xl border border-emerald-500/30 font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        Live Session Active
                    </span>
                </div>
            </div>

            <!-- Quick Action Buttons Header -->
            <div class="flex flex-wrap items-center gap-2 shrink-0">
                <a href="{{ route('faculty.attendance') }}" class="px-4 py-2.5 text-xs font-extrabold rounded-xl bg-blue-600 hover:bg-blue-500 text-white transition shadow-lg flex items-center gap-2">
                    <i class="fas fa-clipboard-check"></i> Take Attendance
                </a>
                <a href="{{ route('faculty.marks') }}" class="px-4 py-2.5 text-xs font-extrabold rounded-xl bg-white/10 hover:bg-white/20 text-white transition border border-white/20 flex items-center gap-2">
                    <i class="fas fa-edit"></i> Manage Marks
                </a>
                <a href="{{ route('faculty.ai') }}" class="px-4 py-2.5 text-xs font-extrabold rounded-xl bg-purple-600 hover:bg-purple-500 text-white transition shadow-lg flex items-center gap-2">
                    <i class="fas fa-robot text-amber-300"></i> Ask AI
                </a>
            </div>
        </div>
    </div>

    <!-- QUICK ACTION PANEL -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
        <div class="flex items-center justify-between mb-3 px-1">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Quick Command Bar</span>
            <span class="text-[11px] text-slate-400 font-medium">Shortcut Navigation</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <a href="{{ route('faculty.attendance') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/80 hover:border-blue-200 text-slate-700 hover:text-blue-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <span class="text-xs font-bold">Take Attendance</span>
            </a>

            <a href="{{ route('faculty.marks') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/80 hover:border-emerald-200 text-slate-700 hover:text-emerald-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-pen-to-square"></i>
                </div>
                <span class="text-xs font-bold">Manage Marks</span>
            </a>

            <a href="{{ route('faculty.courses') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-200 text-slate-700 hover:text-purple-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-book-open"></i>
                </div>
                <span class="text-xs font-bold">My Courses</span>
            </a>

            <a href="{{ route('email.send') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-amber-50 border border-slate-200/80 hover:border-amber-200 text-slate-700 hover:text-amber-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <span class="text-xs font-bold">Send Alert</span>
            </a>

            <a href="{{ route('faculty.ai') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-indigo-50 border border-slate-200/80 hover:border-indigo-200 text-slate-700 hover:text-indigo-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-robot"></i>
                </div>
                <span class="text-xs font-bold">EduInsight AI</span>
            </a>

            <a href="{{ route('faculty.analytics') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-rose-50 border border-slate-200/80 hover:border-rose-200 text-slate-700 hover:text-rose-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <span class="text-xs font-bold">Teaching Analytics</span>
            </a>
        </div>
    </div>

    <!-- TOP 6 KPI CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
        <!-- KPI 1: Assigned Courses -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Assigned Courses</span>
                <i class="fas fa-book text-blue-600 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $courses->count() }}</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">Theory & Lab Sessions</div>
        </div>

        <!-- KPI 2: Students Teaching -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Students Teaching</span>
                <i class="fas fa-users text-emerald-600 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">{{ $totalStudents }}</div>
            <div class="text-[11px] text-emerald-700 font-medium mt-1">Enrolled Roster</div>
        </div>

        <!-- KPI 3: Average Attendance -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Average Attendance</span>
                <i class="fas fa-chart-line text-blue-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ round($avgAttendance, 1) }}%</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; +1.4% vs last month</div>
        </div>

        <!-- KPI 4: Average Pass Rate -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Avg Pass Rate</span>
                <i class="fas fa-check-circle text-amber-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">{{ round($overallPassPercentage, 1) }}%</div>
            <div class="text-[11px] text-amber-700 font-bold mt-1">&ge; 40 Marks Threshold</div>
        </div>

        <!-- KPI 5: Students at Risk -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Students at Risk</span>
                <i class="fas fa-exclamation-triangle text-red-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-red-600 mt-1">{{ $atRiskCount }}</div>
            <div class="text-[11px] text-red-600 font-bold mt-1">Intervention Needed</div>
        </div>

        <!-- KPI 6: Pending Evaluations -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Pending Marks</span>
                <i class="fas fa-clock text-purple-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">{{ $pendingEvaluations }}</div>
            <div class="text-[11px] text-purple-700 font-medium mt-1">Grade Submission Due</div>
        </div>
    </div>

    <!-- SCHEDULE & NOTIFICATIONS ROW -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Today's Schedule Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                        <i class="fas fa-calendar-day text-blue-600"></i> Today's Teaching Schedule
                    </h3>
                    <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold">3 Classes</span>
                </div>
                
                <div class="space-y-3">
                    @forelse($courses->take(3) as $idx => $c)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs">
                                    0{{ $idx + 1 }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">{{ $c->course_name }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono">{{ $c->course_code }} &bull; Hall {{ 101 + $idx }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-extrabold text-blue-700">{{ 9 + ($idx * 2) }}:00 AM</span>
                                <div class="text-[10px] text-emerald-600 font-bold">Confirmed</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs font-medium">No classes scheduled for today.</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <a href="{{ route('faculty.courses') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">View Full Timetable &rarr;</a>
            </div>
        </div>

        <!-- Assigned Courses Table -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-book text-blue-600"></i> Assigned Academic Courses Overview
                </h3>
                <a href="{{ route('faculty.courses') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">View All Courses &rarr;</a>
            </div>

            <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-2.5 px-4">Course Code</th>
                            <th class="py-2.5 px-4">Course Title</th>
                            <th class="py-2.5 px-4">Semester</th>
                            <th class="py-2.5 px-4 text-center">Enrolled</th>
                            <th class="py-2.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($courses as $course)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 font-mono font-bold text-blue-700">{{ $course->course_code }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $course->course_name }}</td>
                                <td class="py-3 px-4 text-slate-600">Semester {{ $course->semester }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 font-extrabold border border-blue-100">
                                        {{ $course->enrollments->count() }} Students
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right space-x-1">
                                    <a href="{{ route('faculty.course.show', $course->id) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">
                                        <i class="fas fa-eye text-xs"></i> View
                                    </a>
                                    <a href="{{ route('faculty.attendance', ['course_id' => $course->id]) }}" class="px-2.5 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold transition">
                                        <i class="fas fa-check text-xs"></i> Attendance
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-slate-400">
                                    No courses currently assigned to your profile.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CHARTS GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Attendance Trend Chart -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-line text-blue-600"></i> Class Attendance Trend
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Weekly Average %</span>
            </div>
            <div class="h-64">
                <canvas id="facultyDashboardAttendanceChart"></canvas>
            </div>
        </div>

        <!-- Grade Performance Distribution Chart -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-emerald-600"></i> Grade & Performance Distribution
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Midterm & Final Marks</span>
            </div>
            <div class="h-64">
                <canvas id="facultyDashboardPerformanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- INSIGHTS & LOW ATTENDANCE / ALERTS ROW -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Low Attendance Intervention Table -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-amber-500"></i> Students Needing Intervention (&lt; 60%)
                </h3>
                <a href="{{ route('email.send', ['recipient_type' => 'low_attendance']) }}" class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 transition">
                    Send Warnings
                </a>
            </div>

            <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-2.5 px-4">Student Name</th>
                            <th class="py-2.5 px-4">Email</th>
                            <th class="py-2.5 px-4 text-center">Attendance Status</th>
                            <th class="py-2.5 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($lowAttendanceStudents as $student)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $student->user->name }}</td>
                                <td class="py-3 px-4 text-slate-500">{{ $student->user->email }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded bg-red-50 text-red-600 font-extrabold border border-red-100">
                                        Critically Low (&lt; 60%)
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('faculty.student.show', $student->id) }}" class="px-2.5 py-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">
                                        Profile
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-emerald-600 font-bold">
                                    <i class="fas fa-check-circle mr-1"></i> All enrolled students meet attendance requirements!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Alerts & AI Recommendations -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between space-y-4">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                        <i class="fas fa-bell text-red-500"></i> Recent Student Academic Alerts
                    </h3>
                    <span class="text-[11px] text-slate-400 font-medium">Live Feed</span>
                </div>

                <div class="space-y-2.5 max-h-48 overflow-y-auto pr-1">
                    @forelse($recentAlerts as $alert)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full {{ $alert->severity === 'high' ? 'bg-red-500' : 'bg-amber-500' }}"></span>
                                <div>
                                    <span class="font-bold text-slate-900">{{ $alert->student->user->name ?? 'Student' }}</span>
                                    <span class="text-slate-400 text-[10px] ml-1">&bull; {{ $alert->course->course_code ?? 'Course' }}</span>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded {{ $alert->alert_type === 'low_attendance' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700' }}">
                                {{ ucfirst(str_replace('_', ' ', $alert->alert_type)) }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs font-medium">No recent alerts recorded.</div>
                    @endforelse
                </div>
            </div>

            <!-- AI Recommendation Banner -->
            <div class="bg-purple-900 bg-linear-to-r from-purple-900 to-indigo-900 text-white rounded-xl p-4 shadow-xs" style="background: linear-gradient(to right, #581c87, #312e81);">
                <div class="flex items-center gap-2 text-xs font-bold text-purple-300 uppercase mb-1">
                    <i class="fas fa-lightbulb text-amber-300"></i> AI Academic Recommendation
                </div>
                <p class="text-xs text-purple-100 font-medium leading-relaxed">
                    Schedule a 15-minute tutorial session for Midterm weak topics before next Monday's exam. 4 students show score drop patterns in Data Structures.
                </p>
            </div>
        </div>
    </div>

    <!-- BOTTOM QUICK LAUNCH CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
        <a href="{{ route('faculty.attendance') }}" class="p-4 bg-white border border-slate-200 rounded-2xl hover:border-blue-500 transition shadow-xs group">
            <div class="text-blue-600 text-xl mb-2 group-hover:scale-110 transition"><i class="fas fa-calendar-check"></i></div>
            <div class="text-xs font-extrabold text-slate-900">Attendance Center</div>
            <div class="text-[10px] text-slate-400 font-medium mt-0.5">Single-pass batch entry</div>
        </a>

        <a href="{{ route('faculty.marks') }}" class="p-4 bg-white border border-slate-200 rounded-2xl hover:border-emerald-500 transition shadow-xs group">
            <div class="text-emerald-600 text-xl mb-2 group-hover:scale-110 transition"><i class="fas fa-edit"></i></div>
            <div class="text-xs font-extrabold text-slate-900">Marks Management</div>
            <div class="text-[10px] text-slate-400 font-medium mt-0.5">Inline grade calculator</div>
        </a>

        <a href="{{ route('faculty.analytics') }}" class="p-4 bg-white border border-slate-200 rounded-2xl hover:border-purple-500 transition shadow-xs group">
            <div class="text-purple-600 text-xl mb-2 group-hover:scale-110 transition"><i class="fas fa-chart-pie"></i></div>
            <div class="text-xs font-extrabold text-slate-900">Teaching Analytics</div>
            <div class="text-[10px] text-slate-400 font-medium mt-0.5">Executive dashboards</div>
        </a>

        <a href="{{ route('email.send') }}" class="p-4 bg-white border border-slate-200 rounded-2xl hover:border-amber-500 transition shadow-xs group">
            <div class="text-amber-600 text-xl mb-2 group-hover:scale-110 transition"><i class="fas fa-paper-plane"></i></div>
            <div class="text-xs font-extrabold text-slate-900">Notifications</div>
            <div class="text-[10px] text-slate-400 font-medium mt-0.5">Parent & student emails</div>
        </a>

        <a href="{{ route('email.history') }}" class="p-4 bg-white border border-slate-200 rounded-2xl hover:border-indigo-500 transition shadow-xs group">
            <div class="text-indigo-600 text-xl mb-2 group-hover:scale-110 transition"><i class="fas fa-history"></i></div>
            <div class="text-xs font-extrabold text-slate-900">Email Logs</div>
            <div class="text-[10px] text-slate-400 font-medium mt-0.5">Delivery audit trail</div>
        </a>

        <a href="{{ route('faculty.ai') }}" class="p-4 bg-white border border-slate-200 rounded-2xl hover:border-purple-600 transition shadow-xs group">
            <div class="text-purple-600 text-xl mb-2 group-hover:scale-110 transition"><i class="fas fa-robot"></i></div>
            <div class="text-xs font-extrabold text-slate-900">EduInsight AI</div>
            <div class="text-[10px] text-slate-400 font-medium mt-0.5">Natural language query</div>
        </a>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Attendance Trend Chart
    const attCtx = document.getElementById('facultyDashboardAttendanceChart');
    if (attCtx && typeof Chart !== 'undefined') {
        new Chart(attCtx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
                datasets: [{
                    label: 'Attendance %',
                    data: [82, 85, 84, 88, 86, 89],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { min: 60, max: 100, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }

    // Performance Distribution Chart
    const perfCtx = document.getElementById('facultyDashboardPerformanceChart');
    if (perfCtx && typeof Chart !== 'undefined') {
        new Chart(perfCtx, {
            type: 'bar',
            data: {
                labels: ['Grade A', 'Grade B', 'Grade C', 'Grade D', 'Grade F'],
                datasets: [{
                    label: 'Number of Students',
                    data: [18, 24, 12, 5, 2],
                    backgroundColor: ['#10b981', '#2563eb', '#7c3aed', '#f59e0b', '#ef4444'],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }
});
</script>
@endsection
