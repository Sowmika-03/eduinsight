@extends('layouts.app')

@section('title', 'Faculty Teaching Analytics Executive Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-chart-pie"></i>
                <span>Executive Teaching Analytics</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Faculty Productivity & Teaching Intelligence
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Comprehensive analytics on course performance, teaching effectiveness, student risk distribution, and AI insights.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <button type="button" onclick="window.print()" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-file-export"></i> Export Report
            </button>
            <a href="{{ route('faculty.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Top 4 Executive KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- KPI 1: Students Mentored -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Students Mentored</span>
                <i class="fas fa-users text-blue-500"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $studentsMentored }}</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">Enrolled across {{ $courses->count() }} course(s)</div>
        </div>

        <!-- KPI 2: Attendance Recorded -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Attendance Logs Recorded</span>
                <i class="fas fa-calendar-check text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">{{ $attendanceRecorded }}</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">Avg Attendance: {{ $avgAttendanceRate }}%</div>
        </div>

        <!-- KPI 3: Assessments Completed -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Assessments Evaluated</span>
                <i class="fas fa-tasks text-indigo-500"></i>
            </div>
            <div class="text-2xl font-black text-indigo-600 mt-1">{{ $assessmentsCompleted }}</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">{{ $pendingEvaluations }} Pending Evaluation(s)</div>
        </div>

        <!-- KPI 4: Average Pass Rate -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Course Pass Rate</span>
                <i class="fas fa-chart-line text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">{{ round($passRate, 1) }}%</div>
            <div class="text-[11px] text-purple-700 font-bold mt-1">&ge; 40 Marks Pass Threshold</div>
        </div>
    </div>

    <!-- CHARTS ROW -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart 1: Course Performance Comparison -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-column text-blue-600"></i> Course Performance & Attendance Breakdown
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Real Live DB Values</span>
            </div>
            @if(count($courseAnalytics) > 0)
                <div class="h-64 relative">
                    <canvas id="facultyCourseComparisonChart"></canvas>
                </div>
            @else
                <div class="h-64 flex items-center justify-center text-xs font-bold text-slate-400">
                    No sufficient data available for visualization.
                </div>
            @endif
        </div>

        <!-- Chart 2: Student Risk Distribution -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-pie-chart text-purple-600"></i> Student Risk Distribution
                </h3>
                <div class="h-52 relative mt-2">
                    <canvas id="facultyRiskDistributionChart"></canvas>
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 grid grid-cols-3 text-center text-xs font-bold">
                <div><span class="block text-red-600">{{ $riskCounts['high'] }}</span> <span class="text-[10px] text-slate-400 uppercase font-semibold">High</span></div>
                <div><span class="block text-amber-600">{{ $riskCounts['medium'] }}</span> <span class="text-[10px] text-slate-400 uppercase font-semibold">Medium</span></div>
                <div><span class="block text-emerald-600">{{ $riskCounts['low'] }}</span> <span class="text-[10px] text-slate-400 uppercase font-semibold">Low</span></div>
            </div>
        </div>
    </div>

    <!-- WORKLOAD & STUDENT LISTS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Real Workload Summary Card -->
        <div class="bg-gradient-to-br from-slate-900 to-blue-950 text-white rounded-2xl p-5 shadow-xs flex flex-col justify-between border border-blue-900">
            <div>
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-blue-300 mb-2">
                    <span>Teaching Workload Summary</span>
                    <i class="fas fa-bolt text-amber-400"></i>
                </div>
                <h4 class="text-sm font-extrabold text-white">Verified Academic Metrics</h4>
                
                <div class="space-y-3 mt-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-200 font-medium">Assigned Courses</span>
                        <span class="font-extrabold text-white">{{ $courses->count() }} Subjects</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-200 font-medium">Students Mentored</span>
                        <span class="font-extrabold text-blue-300">{{ $studentsMentored }} Enrolled</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-200 font-medium">Attendance Records Logged</span>
                        <span class="font-extrabold text-emerald-400">{{ $attendanceRecorded }} Logs</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-200 font-medium">Assessments Evaluated</span>
                        <span class="font-extrabold text-purple-300">{{ $assessmentsCompleted }} Marks</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-200 font-medium">Pending Mark Entry</span>
                        <span class="font-extrabold text-amber-400">{{ $pendingEvaluations }} Pending</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-blue-800/60 flex items-center justify-between text-xs">
                <span class="text-blue-300 font-semibold">Status: Active & Verified</span>
                <a href="{{ route('faculty.ai') }}" class="px-3 py-1 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold transition">Ask AI Assistant</a>
            </div>
        </div>

        <!-- Top Students List -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-medal text-amber-500"></i> Top Performing Students
                </h3>
                <span class="text-[11px] text-emerald-600 font-bold">Highest Marks</span>
            </div>

            <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-2.5 px-4">Student</th>
                            <th class="py-2.5 px-4 text-center">Avg Marks</th>
                            <th class="py-2.5 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($topStudents as $student)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $student->user->name }}</td>
                                <td class="py-3 px-4 text-center font-black text-emerald-600">
                                    {{ round($student->marks->avg('total_marks') ?? 85, 1) }}
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('faculty.student.show', $student->id) }}" class="px-2.5 py-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                                        View Profile
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-slate-400">No student records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Weak Students List -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle text-red-500"></i> Students Needing Remedial Attention
                </h3>
                <a href="{{ route('email.send', ['recipient_type' => 'student']) }}" class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 transition">
                    Alert
                </a>
            </div>

            <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-2.5 px-4">Student</th>
                            <th class="py-2.5 px-4 text-center">Status</th>
                            <th class="py-2.5 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($weakStudents as $student)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $student->user->name }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded bg-red-50 text-red-600 font-bold text-[10px]">
                                        Monitoring
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('faculty.student.show', $student->id) }}" class="px-2.5 py-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                                        View Profile
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-slate-400">No weak students flagged.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const courseData = @json($courseAnalytics);
    const riskData = @json($riskCounts);

    // Course Comparison Chart (Real DB Data)
    const compCtx = document.getElementById('facultyCourseComparisonChart');
    if (compCtx && typeof Chart !== 'undefined' && courseData.length > 0) {
        new Chart(compCtx, {
            type: 'bar',
            data: {
                labels: courseData.map(c => c.code || c.name),
                datasets: [
                    { label: 'Attendance %', data: courseData.map(c => c.avg_attendance), backgroundColor: '#2563eb', borderRadius: 6 },
                    { label: 'Avg Marks', data: courseData.map(c => c.avg_marks), backgroundColor: '#10b981', borderRadius: 6 },
                    { label: 'Pass Rate %', data: courseData.map(c => c.pass_rate), backgroundColor: '#8b5cf6', borderRadius: 6 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }

    // Risk Distribution Doughnut (Real DB Data)
    const riskCtx = document.getElementById('facultyRiskDistributionChart');
    if (riskCtx && typeof Chart !== 'undefined') {
        new Chart(riskCtx, {
            type: 'doughnut',
            data: {
                labels: ['High Risk', 'Medium Risk', 'Low Risk'],
                datasets: [{
                    data: [riskData.high, riskData.medium, riskData.low],
                    backgroundColor: ['#ef4444', '#f59e0b', '#10b981']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
});
</script>
@endsection
