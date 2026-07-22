@extends('layouts.app')

@section('title', 'Personal Academic Intelligence Workspace')

@section('content')
<div class="space-y-6">

    <!-- TOP GREETING BANNER -->
    <div class="bg-slate-900 bg-linear-to-r from-slate-900 via-blue-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-blue-900/50" style="background: linear-gradient(to right, #0f172a, #0b1329, #0f172a);">
        <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-40 -top-10 w-60 h-60 bg-purple-600/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex flex-wrap items-center gap-2 text-xs font-extrabold uppercase tracking-widest text-blue-400">
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-500/20 border border-blue-400/30">
                        <i class="fas fa-graduation-cap text-blue-300 mr-1"></i> Student Intelligence Workspace
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
                
                <div class="flex flex-wrap items-center gap-2.5 text-xs text-slate-300 font-medium">
                    <span class="flex items-center gap-1.5 bg-slate-800/80 px-3 py-1 rounded-xl border border-slate-700">
                        <i class="fas fa-id-card text-blue-400"></i> {{ $student->student_id ?? 'STU-2026' }}
                    </span>
                    <span class="flex items-center gap-1.5 bg-slate-800/80 px-3 py-1 rounded-xl border border-slate-700">
                        <i class="fas fa-building text-purple-400"></i> {{ $student->program ?? 'B.Tech CSE' }}
                    </span>
                    <span class="flex items-center gap-1.5 bg-slate-800/80 px-3 py-1 rounded-xl border border-slate-700">
                        <i class="fas fa-user-tie text-amber-400"></i> Advisor: Dr. Bala Murali Krishna
                    </span>
                    @php
                        $status = $overallPerformance['status'] ?? 'Good Standing';
                        $statusClass = match($status) {
                            'Excellent' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
                            'Good Standing' => 'bg-blue-500/20 text-blue-300 border-blue-500/30',
                            'Satisfactory' => 'bg-amber-500/20 text-amber-300 border-amber-500/30',
                            'Needs Improvement' => 'bg-red-500/20 text-red-300 border-red-500/30',
                            default => 'bg-blue-500/20 text-blue-300 border-blue-500/30',
                        };
                        $pingClass = match($status) {
                            'Excellent' => 'bg-emerald-400',
                            'Good Standing' => 'bg-blue-400',
                            'Satisfactory' => 'bg-amber-400',
                            'Needs Improvement' => 'bg-red-400',
                            default => 'bg-blue-400',
                        };
                    @endphp
                    <span class="flex items-center gap-1.5 px-3 py-1 rounded-xl border font-bold {{ $statusClass }}">
                        <span class="w-2 h-2 rounded-full animate-ping {{ $pingClass }}"></span>
                        Academic Status: {{ $status }}
                    </span>
                </div>
            </div>

            <!-- Quick Action Toolbar Header -->
            <div class="flex flex-wrap items-center gap-2 shrink-0">
                <a href="{{ route('student.attendance') }}" class="px-4 py-2.5 text-xs font-extrabold rounded-xl bg-blue-600 hover:bg-blue-500 text-white transition shadow-lg flex items-center gap-2">
                    <i class="fas fa-calendar-check"></i> View Attendance
                </a>
                <a href="{{ route('student.marks') }}" class="px-4 py-2.5 text-xs font-extrabold rounded-xl bg-white/10 hover:bg-white/20 text-white transition border border-white/20 flex items-center gap-2">
                    <i class="fas fa-square-poll-vertical"></i> View Marks
                </a>
                <a href="{{ route('student.ai') }}" class="px-4 py-2.5 text-xs font-extrabold rounded-xl bg-purple-600 hover:bg-purple-500 text-white transition shadow-lg flex items-center gap-2">
                    <i class="fas fa-brain text-amber-300"></i> Ask AI
                </a>
            </div>
        </div>
    </div>

    <!-- QUICK ACTION TOOLBAR -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
        <div class="flex items-center justify-between mb-3 px-1">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Student Command Center</span>
            <span class="text-[11px] text-slate-400 font-medium">Quick Workspace Navigation</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <a href="{{ route('student.attendance') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/80 hover:border-blue-200 text-slate-700 hover:text-blue-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <span class="text-xs font-bold">Attendance</span>
            </a>

            <a href="{{ route('student.marks') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/80 hover:border-emerald-200 text-slate-700 hover:text-emerald-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-square-poll-vertical"></i>
                </div>
                <span class="text-xs font-bold">Marks & Grades</span>
            </a>

            <a href="{{ route('student.courses') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-200 text-slate-700 hover:text-purple-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-book-open"></i>
                </div>
                <span class="text-xs font-bold">My Courses</span>
            </a>

            <a href="{{ route('student.performance') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-indigo-50 border border-slate-200/80 hover:border-indigo-200 text-slate-700 hover:text-indigo-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-chart-column"></i>
                </div>
                <span class="text-xs font-bold">Analytics</span>
            </a>

            <a href="{{ route('student.ai') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-200 text-slate-700 hover:text-purple-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-brain"></i>
                </div>
                <span class="text-xs font-bold">EduInsight AI</span>
            </a>

            <a href="{{ route('student.resources') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-amber-50 border border-slate-200/80 hover:border-amber-200 text-slate-700 hover:text-amber-700 transition text-center group flex flex-col items-center gap-1.5">
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                    <i class="fas fa-folder-open"></i>
                </div>
                <span class="text-xs font-bold">Resources</span>
            </a>
        </div>
    </div>

    <!-- TOP 8 KPI CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- KPI 1: Cumulative GPA -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Cumulative CGPA</span>
                <i class="fas fa-graduation-cap text-blue-600"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $cgpa }} <span class="text-xs text-slate-400 font-normal">/ 4.0</span></div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; Top 10% Batch Standings</div>
        </div>

        <!-- KPI 2: Current Term GPA -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Term GPA Forecast</span>
                <i class="fas fa-star text-amber-500"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">{{ $currentGpa }} <span class="text-xs text-slate-400 font-normal">/ 4.0</span></div>
            <div class="text-[11px] text-amber-700 font-bold mt-1">Grade A Target On Track</div>
        </div>

        <!-- KPI 3: Overall Attendance -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Overall Attendance</span>
                <i class="fas fa-calendar-check text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">{{ $attendancePercent }}%</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&ge; 75% Requirement Met</div>
        </div>

        <!-- KPI 4: Credits Earned -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Credits Earned</span>
                <i class="fas fa-award text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">48 <span class="text-xs text-slate-400 font-normal">/ 64 Total</span></div>
            <div class="text-[11px] text-purple-700 font-medium mt-1">16 Credits Remaining</div>
        </div>
    </div>

    <!-- SCHEDULE, ANNOUNCEMENTS & RECENT MARKS ROW -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Today's Schedule -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                        <i class="fas fa-calendar-day text-blue-600"></i> Today's Class Schedule
                    </h3>
                    <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold">3 Sessions</span>
                </div>

                <div class="space-y-3">
                    @forelse($enrolledCourses->take(3) as $idx => $e)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs">
                                    0{{ $idx + 1 }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">{{ $e->course->course_name }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono">{{ $e->course->course_code }} &bull; Hall {{ 101 + $idx }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-extrabold text-blue-700">{{ 9 + ($idx * 2) }}:00 AM</span>
                                <div class="text-[10px] text-emerald-600 font-bold">Attended</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs font-medium">No classes scheduled for today.</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <a href="{{ route('student.courses') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">View Full Schedule &rarr;</a>
            </div>
        </div>

        <!-- Enrolled Courses Table -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-book-open text-blue-600"></i> Active Course Roster & Performance
                </h3>
                <a href="{{ route('student.courses') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">View All Courses &rarr;</a>
            </div>

            <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-2.5 px-4">Course Code</th>
                            <th class="py-2.5 px-4">Course Title</th>
                            <th class="py-2.5 px-4">Faculty</th>
                            <th class="py-2.5 px-4 text-center">Attendance</th>
                            <th class="py-2.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($enrolledCourses as $enrollment)
                            @php $c = $enrollment->course; @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 font-mono font-bold text-blue-700">{{ $c->course_code }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $c->course_name }}</td>
                                <td class="py-3 px-4 text-slate-600 font-medium">{{ $c->faculty->user->name ?? 'Faculty' }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-extrabold border border-emerald-100">
                                        86%
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right space-x-1">
                                    <a href="{{ route('student.course.show', $c->id) }}" class="px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold transition">
                                        <i class="fas fa-eye text-xs"></i> Workspace
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-slate-400">No active course enrollments.</td>
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
                    <i class="fas fa-chart-line text-blue-600"></i> Personal Attendance Trend
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Weekly Attendance %</span>
            </div>
            <div class="h-64">
                <canvas id="studentDashboardAttendanceChart"></canvas>
            </div>
        </div>

        <!-- Grade Distribution Chart -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-emerald-600"></i> Subject Marks Breakdown
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Internal & External Marks</span>
            </div>
            <div class="h-64">
                <canvas id="studentDashboardPerformanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- QUICK INSIGHTS & AI RECOMMENDATIONS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Subject Performance Quick Insights -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-bullseye text-purple-600"></i> Academic Strengths & Focus Areas
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Personal Analytics</span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200/80">
                    <div class="text-[10px] font-extrabold uppercase text-emerald-700 tracking-wider mb-1 flex items-center gap-1">
                        <i class="fas fa-trophy"></i> Best Subject
                    </div>
                    <div class="text-sm font-black text-slate-900">Web Development</div>
                    <div class="text-xs text-emerald-700 font-bold mt-0.5">Score: 92/100 (Grade A)</div>
                </div>

                <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200/80">
                    <div class="text-[10px] font-extrabold uppercase text-amber-700 tracking-wider mb-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-triangle"></i> Weakest Subject
                    </div>
                    <div class="text-sm font-black text-slate-900">Data Structures</div>
                    <div class="text-xs text-amber-700 font-bold mt-0.5">Score: 68/100 (Needs Focus)</div>
                </div>
            </div>

            <div class="mt-4 p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 leading-relaxed">
                <span class="font-bold text-slate-900">Faculty Advisory Note:</span> Maintain current attendance in Data Structures lab. You need 6 more marks in the final exam to secure an A grade!
            </div>
        </div>

        <!-- AI Recommendations Card -->
        <div class="bg-purple-950 bg-linear-to-br from-purple-950 to-slate-900 text-white rounded-2xl p-5 shadow-xs flex flex-col justify-between border border-purple-900" style="background: linear-gradient(to bottom right, #3b0764, #0f172a);">
            <div>
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-purple-300 mb-2">
                    <span>EduInsight AI Personal Recommendations</span>
                    <i class="fas fa-lightbulb text-amber-300"></i>
                </div>
                <h4 class="text-sm font-extrabold text-white">Optimal Path to 3.90 CGPA Target</h4>
                <p class="text-xs text-purple-100/90 leading-relaxed font-medium mt-2">
                    To raise your GPA from 3.75 to 3.90 this term, score at least 42/50 in the upcoming External Examination for Data Structures and maintain 100% attendance in your Friday lab sessions.
                </p>
            </div>

            <div class="mt-4 pt-3 border-t border-purple-800/60 flex items-center justify-between text-xs">
                <span class="text-purple-300 font-semibold">Risk Level: Low (4%)</span>
                <a href="{{ route('student.ai') }}" class="px-3.5 py-1.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold transition flex items-center gap-1.5">
                    <i class="fas fa-brain text-xs"></i> Ask AI Assistant
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Attendance Trend Line Chart
    const attCtx = document.getElementById('studentDashboardAttendanceChart');
    if (attCtx && typeof Chart !== 'undefined') {
        new Chart(attCtx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
                datasets: [{
                    label: 'Attendance %',
                    data: [84, 88, 85, 89, 86, 88],
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

    // Performance Breakdown Bar Chart
    const perfCtx = document.getElementById('studentDashboardPerformanceChart');
    if (perfCtx && typeof Chart !== 'undefined') {
        new Chart(perfCtx, {
            type: 'bar',
            data: {
                labels: ['Web Dev', 'Database Sys', 'Algorithms', 'Software Eng'],
                datasets: [
                    { label: 'Internal (/50)', data: [44, 40, 38, 42], backgroundColor: '#2563eb', borderRadius: 6 },
                    { label: 'External (/50)', data: [48, 42, 38, 45], backgroundColor: '#10b981', borderRadius: 6 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: { y: { max: 50, beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }
});
</script>
@endsection
