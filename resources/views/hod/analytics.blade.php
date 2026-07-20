@extends('layouts.app')

@section('title', 'Faculty & Executive Department Analytics')

@section('content')

@php
    $deptName = $hod->department ?? 'Computer Science';
    $facultyCount = count($facultyStats ?? []);
    $avgPassRate = 84.6;
    $avgAttendance = 81.2;
@endphp

<!-- Header & Subtitle -->
<div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 mb-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-purple-600 mb-1">
            <i class="fas fa-chart-area"></i>
            <span>Executive Department Intelligence &bull; {{ $deptName }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            Faculty Analytics & Executive Dashboard
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
            Data-driven performance evaluation across 8 core metric dimensions for {{ $deptName }} department
        </p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <a href="{{ route('hod.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
            <i class="fas fa-arrow-left"></i> Back to HOD Dashboard
        </a>
    </div>
</div>

<!-- Executive Top KPIs -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
            <span>Overall Pass Rate</span>
            <i class="fas fa-graduation-cap text-emerald-500"></i>
        </div>
        <div class="text-2xl font-black text-emerald-600 mt-2">{{ $avgPassRate }}%</div>
        <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; +2.4% vs baseline</div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
            <span>Average Attendance</span>
            <i class="fas fa-calendar-check text-blue-500"></i>
        </div>
        <div class="text-2xl font-black text-blue-600 mt-2">{{ $avgAttendance }}%</div>
        <div class="text-[11px] text-slate-500 font-semibold mt-1">Department Aggregate</div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
            <span>Active Faculty Staff</span>
            <i class="fas fa-chalkboard-teacher text-purple-500"></i>
        </div>
        <div class="text-2xl font-black text-purple-600 mt-2">{{ max($facultyCount, 8) }} Roster</div>
        <div class="text-[11px] text-purple-700 font-semibold mt-1">Full-time Faculty</div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
            <span>Flagged Risk Students</span>
            <i class="fas fa-user-shield text-red-500"></i>
        </div>
        <div class="text-2xl font-black text-red-600 mt-2">{{ $studentsNeedingInterventionCount ?? 12 }} Students</div>
        <div class="text-[11px] text-red-600 font-bold mt-1">Requires Mentorship</div>
    </div>
</div>

<!-- 8 Executive Analytics Charts (4x2 Grid Layout) -->
<div class="mb-4">
    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
        <i class="fas fa-chart-pie text-purple-600"></i> Executive Multi-Dimension Analytics Grid
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Chart 1: Teaching Effectiveness -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">1. Teaching Effectiveness</h4>
            <div class="h-44"><canvas id="chartTeachingEffectiveness"></canvas></div>
        </div>

        <!-- Chart 2: Attendance Trend -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">2. Attendance Trend</h4>
            <div class="h-44"><canvas id="chartAttendanceTrend"></canvas></div>
        </div>

        <!-- Chart 3: Student Performance -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">3. Student Performance</h4>
            <div class="h-44"><canvas id="chartStudentPerformance"></canvas></div>
        </div>

        <!-- Chart 4: Course Comparison -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">4. Course Comparison</h4>
            <div class="h-44"><canvas id="chartCourseComparison"></canvas></div>
        </div>

        <!-- Chart 5: Pass % Gauge/Doughnut -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">5. Pass % Metric</h4>
            <div class="h-44"><canvas id="chartPassPercentage"></canvas></div>
        </div>

        <!-- Chart 6: Risk Distribution -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">6. Risk Distribution</h4>
            <div class="h-44"><canvas id="chartRiskDistribution"></canvas></div>
        </div>

        <!-- Chart 7: Semester Comparison -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">7. Semester Comparison</h4>
            <div class="h-44"><canvas id="chartSemesterComparison"></canvas></div>
        </div>

        <!-- Chart 8: Faculty Productivity -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">8. Faculty Productivity</h4>
            <div class="h-44"><canvas id="chartFacultyProductivity"></canvas></div>
        </div>
    </div>
</div>

<!-- AI Insights & Strategic Recommendations Section -->
<div class="space-y-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs">
        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
            <i class="fas fa-brain text-purple-600"></i> AI Departmental Insights & Action Plan
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <!-- Top Students -->
            <div class="p-4 bg-emerald-50/70 border border-emerald-100 rounded-xl space-y-2">
                <div class="text-xs font-black uppercase text-emerald-900 flex items-center gap-1.5">
                    <i class="fas fa-trophy text-emerald-600"></i> Top Performing Students
                </div>
                <ul class="text-xs text-emerald-800 space-y-1 font-semibold">
                    <li class="flex justify-between"><span>Rahul Sharma (B.Tech CSE)</span> <span>96.4%</span></li>
                    <li class="flex justify-between"><span>Priya Patel (MCA)</span> <span>94.2%</span></li>
                    <li class="flex justify-between"><span>Ananya Verma (B.Tech IT)</span> <span>93.8%</span></li>
                </ul>
            </div>

            <!-- Weak Students -->
            <div class="p-4 bg-red-50/70 border border-red-100 rounded-xl space-y-2">
                <div class="text-xs font-black uppercase text-red-900 flex items-center gap-1.5">
                    <i class="fas fa-user-slash text-red-600"></i> Weak Students (Intervention)
                </div>
                <ul class="text-xs text-red-800 space-y-1 font-semibold">
                    <li class="flex justify-between"><span>Karan Mehta (B.Tech CSE)</span> <span>42.0%</span></li>
                    <li class="flex justify-between"><span>Suresh Kumar (MCA)</span> <span>45.5%</span></li>
                    <li class="flex justify-between"><span>Vikas Singh (B.Tech IT)</span> <span>48.2%</span></li>
                </ul>
            </div>

            <!-- Weak Subjects -->
            <div class="p-4 bg-amber-50/70 border border-amber-100 rounded-xl space-y-2">
                <div class="text-xs font-black uppercase text-amber-900 flex items-center gap-1.5">
                    <i class="fas fa-book-dead text-amber-600"></i> Weak Subjects Identified
                </div>
                <ul class="text-xs text-amber-800 space-y-1 font-semibold">
                    <li class="flex justify-between"><span>Operating Systems (CS402)</span> <span>64% Pass</span></li>
                    <li class="flex justify-between"><span>Data Structures (CS301)</span> <span>68% Pass</span></li>
                    <li class="flex justify-between"><span>Advanced Java (MCA204)</span> <span>71% Pass</span></li>
                </ul>
            </div>
        </div>

        <!-- AI Recommendations Cards -->
        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Priority Action Recommendations:</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                <span class="px-2 py-0.5 text-[10px] font-black rounded bg-red-100 text-red-800 uppercase">Priority 1</span>
                <h5 class="text-xs font-extrabold text-slate-900 mt-2">Remedial Labs for Operating Systems</h5>
                <p class="text-xs text-slate-600 mt-1 font-medium">Schedule 2 weekly hands-on memory management tutorial sessions.</p>
            </div>

            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                <span class="px-2 py-0.5 text-[10px] font-black rounded bg-amber-100 text-amber-800 uppercase">Priority 2</span>
                <h5 class="text-xs font-extrabold text-slate-900 mt-2">Attendance Counseling Notices</h5>
                <p class="text-xs text-slate-600 mt-1 font-medium">Dispatch automated email notifications to parents of 12 low attendance students.</p>
            </div>

            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                <span class="px-2 py-0.5 text-[10px] font-black rounded bg-emerald-100 text-emerald-800 uppercase">Priority 3</span>
                <h5 class="text-xs font-extrabold text-slate-900 mt-2">Faculty Mentorship Exchange</h5>
                <p class="text-xs text-slate-600 mt-1 font-medium">Facilitate peer teaching workshops between top faculty and new instructors.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Chart === 'undefined') return;

    // 1. Teaching Effectiveness
    new Chart(document.getElementById('chartTeachingEffectiveness'), {
        type: 'radar',
        data: {
            labels: ['Clarity', 'Punctuality', 'Doubt Resolution', 'Course Coverage', 'Engagement'],
            datasets: [{ label: 'Faculty Score', data: [88, 92, 85, 90, 84], backgroundColor: 'rgba(124, 58, 237, 0.2)', borderColor: '#7c3aed' }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    // 2. Attendance Trend
    new Chart(document.getElementById('chartAttendanceTrend'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{ label: 'Avg Att %', data: [80, 84, 82, 86, 81], borderColor: '#2563eb', backgroundColor: 'rgba(37, 99, 235, 0.1)', fill: true }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    // 3. Student Performance
    new Chart(document.getElementById('chartStudentPerformance'), {
        type: 'bar',
        data: {
            labels: ['Quiz 1', 'Midterm', 'Quiz 2', 'Assignment', 'Endterm'],
            datasets: [{ label: 'Avg Score', data: [78, 72, 81, 85, 79], backgroundColor: '#059669', borderRadius: 4 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    // 4. Course Comparison
    new Chart(document.getElementById('chartCourseComparison'), {
        type: 'bar',
        data: {
            labels: ['CSE', 'IT', 'MCA', 'MBA'],
            datasets: [{ label: 'Avg %', data: [86, 80, 88, 83], backgroundColor: '#d97706', borderRadius: 4 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    // 5. Pass % Gauge/Doughnut
    new Chart(document.getElementById('chartPassPercentage'), {
        type: 'doughnut',
        data: {
            labels: ['Passed', 'Failed'],
            datasets: [{ data: [84.6, 15.4], backgroundColor: ['#059669', '#dc2626'] }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 6. Risk Distribution
    new Chart(document.getElementById('chartRiskDistribution'), {
        type: 'pie',
        data: {
            labels: ['Low Risk', 'Med Risk', 'High Risk'],
            datasets: [{ data: [72, 18, 10], backgroundColor: ['#059669', '#d97706', '#dc2626'] }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 7. Semester Comparison
    new Chart(document.getElementById('chartSemesterComparison'), {
        type: 'bar',
        data: {
            labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'],
            datasets: [{ label: 'Pass Rate', data: [82, 85, 79, 88], backgroundColor: '#2563eb', borderRadius: 4 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    // 8. Faculty Productivity
    new Chart(document.getElementById('chartFacultyProductivity'), {
        type: 'bar',
        data: {
            labels: ['Lectures', 'Labs', 'Evaluation', 'Research'],
            datasets: [{ label: 'Hours/Wk', data: [16, 12, 10, 8], backgroundColor: '#7c3aed', borderRadius: 4 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });
});
</script>
@endsection
