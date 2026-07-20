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
        <!-- KPI 1: Overall Teaching Score -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Overall Teaching Rating</span>
                <i class="fas fa-star text-amber-500"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">4.85 <span class="text-xs text-slate-400 font-normal">/ 5.0</span></div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; Top 5% Faculty</div>
        </div>

        <!-- KPI 2: Course Completion Rate -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Course Completion Rate</span>
                <i class="fas fa-tasks text-blue-500"></i>
            </div>
            <div class="text-2xl font-black text-blue-600 mt-1">94.2%</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">On Schedule &bull; Term 2026</div>
        </div>

        <!-- KPI 3: Student Retention -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Student Retention %</span>
                <i class="fas fa-user-check text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">98.1%</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; High Student Satisfaction</div>
        </div>

        <!-- KPI 4: Average Pass Rate -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Pass Percentage</span>
                <i class="fas fa-chart-line text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">{{ round($passRate, 1) }}%</div>
            <div class="text-[11px] text-purple-700 font-bold mt-1">Exceeds Dept Average (84%)</div>
        </div>
    </div>

    <!-- CHARTS ROW 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart 1: Teaching Effectiveness Trend -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-line-chart text-blue-600"></i> Teaching Effectiveness Trend
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Monthly Assessment</span>
            </div>
            <div class="h-64">
                <canvas id="facultyTeachingEffectivenessChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Course Comparison (Attendance vs Performance) -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-column text-emerald-600"></i> Course Performance Comparison
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Attendance % vs Pass Rate %</span>
            </div>
            <div class="h-64">
                <canvas id="facultyCourseComparisonChart"></canvas>
            </div>
        </div>
    </div>

    <!-- CHARTS ROW 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart 3: Student Risk Distribution -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-2 flex items-center gap-2">
                <i class="fas fa-pie-chart text-purple-600"></i> Student Risk Breakdown
            </h3>
            <div class="h-56">
                <canvas id="facultyRiskDistributionChart"></canvas>
            </div>
        </div>

        <!-- Chart 4: Semester Grade Pass Trend -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-2 flex items-center gap-2">
                <i class="fas fa-chart-area text-amber-500"></i> Semester Pass Rate Trend
            </h3>
            <div class="h-56">
                <canvas id="facultyPassTrendChart"></canvas>
            </div>
        </div>

        <!-- Productivity Summary Card -->
        <div class="bg-gradient-to-br from-slate-900 to-blue-950 text-white rounded-2xl p-5 shadow-xs flex flex-col justify-between border border-blue-900">
            <div>
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-blue-300 mb-2">
                    <span>Faculty Productivity Metrics</span>
                    <i class="fas fa-bolt text-amber-400"></i>
                </div>
                <h4 class="text-sm font-extrabold text-white">Academic Workload Completed</h4>
                
                <div class="space-y-2.5 mt-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-200 font-medium">Lectures & Labs Delivered</span>
                        <span class="font-extrabold text-white">48 Hours</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-200 font-medium">Assessments Evaluated</span>
                        <span class="font-extrabold text-emerald-400">142 Scripts</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-200 font-medium">Academic Alerts Sent</span>
                        <span class="font-extrabold text-amber-400">12 Emails</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-200 font-medium">AI Insights Queried</span>
                        <span class="font-extrabold text-purple-300">26 Queries</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-blue-800/60 flex items-center justify-between text-xs">
                <span class="text-blue-300 font-semibold">Status: Outstanding</span>
                <a href="{{ route('faculty.ai') }}" class="px-3 py-1 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold transition">Ask AI Assistant</a>
            </div>
        </div>
    </div>

    <!-- AI INSIGHTS & STUDENT LISTS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Students List -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-medal text-amber-500"></i> Top Performing Students
                </h3>
                <span class="text-[11px] text-emerald-600 font-bold">Highest Academic Scores</span>
            </div>

            <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-2.5 px-4">Student</th>
                            <th class="py-2.5 px-4 text-center">GPA</th>
                            <th class="py-2.5 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($topStudents as $student)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $student->user->name }}</td>
                                <td class="py-3 px-4 text-center font-black text-emerald-600">3.92</td>
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
                    Contact Parents
                </a>
            </div>

            <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-2.5 px-4">Student</th>
                            <th class="py-2.5 px-4 text-center">Risk Flag</th>
                            <th class="py-2.5 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($weakStudents as $student)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $student->user->name }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded bg-red-50 text-red-600 font-bold text-[10px]">
                                        Remedial Support
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
    // Teaching Effectiveness Line Chart
    const teachCtx = document.getElementById('facultyTeachingEffectivenessChart');
    if (teachCtx && typeof Chart !== 'undefined') {
        new Chart(teachCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Rating (out of 5)',
                    data: [4.6, 4.7, 4.8, 4.75, 4.82, 4.85],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { min: 4.0, max: 5.0, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }

    // Course Comparison Bar Chart
    const compCtx = document.getElementById('facultyCourseComparisonChart');
    if (compCtx && typeof Chart !== 'undefined') {
        new Chart(compCtx, {
            type: 'bar',
            data: {
                labels: ['Web Dev', 'Database Sys', 'Algorithms', 'Software Eng'],
                datasets: [
                    { label: 'Attendance %', data: [88, 85, 82, 90], backgroundColor: '#2563eb', borderRadius: 6 },
                    { label: 'Pass Rate %', data: [92, 88, 84, 94], backgroundColor: '#10b981', borderRadius: 6 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: { y: { min: 60, max: 100, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }

    // Risk Distribution Doughnut
    const riskCtx = document.getElementById('facultyRiskDistributionChart');
    if (riskCtx && typeof Chart !== 'undefined') {
        new Chart(riskCtx, {
            type: 'doughnut',
            data: {
                labels: ['Low Risk (Good)', 'Medium Risk', 'High Risk'],
                datasets: [{
                    data: [82, 12, 6],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // Pass Trend Chart
    const passCtx = document.getElementById('facultyPassTrendChart');
    if (passCtx && typeof Chart !== 'undefined') {
        new Chart(passCtx, {
            type: 'line',
            data: {
                labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'],
                datasets: [{
                    label: 'Pass %',
                    data: [84, 87, 89, 92],
                    borderColor: '#7c3aed',
                    backgroundColor: 'rgba(124, 58, 237, 0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { min: 70, max: 100, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }
});
</script>
@endsection
