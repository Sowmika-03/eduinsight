@extends('layouts.app')

@section('title', 'Faculty Performance Analytics')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-purple-600 mb-1">
                <i class="fas fa-chart-line"></i>
                <span>Academic Operations &bull; Performance Intelligence</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Faculty Performance Analytics Dashboard
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Comprehensive analytics evaluating advisor workloads, student attendance rates, pass percentages, and academic risk metrics.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.faculty.manage') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs">
                <i class="fas fa-users mr-1"></i> Faculty Directory
            </a>
            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200">
                <i class="fas fa-arrow-left mr-1"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Summary KPI Cards Grid (4 Columns Full Width) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-slate-400 mb-1">
                <span class="text-[11px] font-bold uppercase tracking-wider">Total Faculty</span>
                <i class="fas fa-chalkboard-teacher text-blue-600 text-base"></i>
            </div>
            <span class="text-2xl font-extrabold text-slate-900">{{ $stats['total_faculty'] }}</span>
            <span class="text-[11px] text-slate-400 font-medium block mt-1">Monitored Faculty Members</span>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-slate-400 mb-1">
                <span class="text-[11px] font-bold uppercase tracking-wider">Approved Faculty</span>
                <i class="fas fa-user-check text-emerald-600 text-base"></i>
            </div>
            <span class="text-2xl font-extrabold text-emerald-600">{{ $stats['approved_faculty'] }}</span>
            <span class="text-[11px] text-emerald-600 font-medium block mt-1">100% Active Directory</span>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-slate-400 mb-1">
                <span class="text-[11px] font-bold uppercase tracking-wider">Mentored Students</span>
                <i class="fas fa-user-graduate text-purple-600 text-base"></i>
            </div>
            <span class="text-2xl font-extrabold text-purple-600">{{ $stats['total_assignments'] }}</span>
            <span class="text-[11px] text-purple-600 font-medium block mt-1">Student Allocations</span>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-slate-400 mb-1">
                <span class="text-[11px] font-bold uppercase tracking-wider">Avg Pass Rate</span>
                <i class="fas fa-chart-line text-amber-500 text-base"></i>
            </div>
            <span class="text-2xl font-extrabold text-slate-900">{{ $stats['avg_pass_rate'] }}%</span>
            <span class="text-[11px] text-emerald-600 font-medium block mt-1">&uarr; +2.4% Academic Metric</span>
        </div>
    </div>

    <!-- 3 Analytics Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart 1: Workload Distribution Pie Chart -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                    <i class="fas fa-chart-pie text-blue-600"></i> Workload Allocation
                </h3>
            </div>
            <div class="h-60 relative">
                <canvas id="workloadPieChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Pass Percentage Bar Chart -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                    <i class="fas fa-chart-bar text-purple-600"></i> Pass Rate Comparison
                </h3>
            </div>
            <div class="h-60 relative">
                <canvas id="passRateBarChart"></canvas>
            </div>
        </div>

        <!-- Chart 3: Student Risk Distribution Doughnut Chart -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                    <i class="fas fa-chart-donut text-emerald-600"></i> Student Risk Distribution
                </h3>
            </div>
            <div class="h-60 relative">
                <canvas id="riskDoughnutChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Faculty Performance Table (Full Width 90-95%) -->
    <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-xs">
        <div class="p-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                <i class="fas fa-table text-blue-600"></i>
                <span>Faculty Performance Evaluation Metrics ({{ count($facultyStats) }} Faculty Members)</span>
            </h3>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-xs font-bold text-slate-700 py-3">Faculty Member</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Department</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Courses</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Assigned Students</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Avg Attendance</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Avg Marks</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Pass Rate</th>
                        <th class="text-xs font-bold text-slate-700 py-3">High Risk</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Performance Score</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($facultyStats as $fStat)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="text-xs py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center text-xs font-extrabold shrink-0">
                                        {{ strtoupper(substr($fStat['name'], 0, 2)) }}
                                    </div>
                                    <div>
                                        <span class="font-extrabold text-slate-900 block leading-snug">{{ $fStat['name'] }}</span>
                                        <span class="text-[10px] text-slate-400 font-medium">{{ $fStat['email'] }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-xs font-semibold text-slate-700 py-3">
                                {{ $fStat['department'] }}
                            </td>
                            <td class="text-xs font-bold text-purple-600 py-3">
                                {{ $fStat['courses_count'] }} Offerings
                            </td>
                            <td class="text-xs py-3">
                                <div class="space-y-1">
                                    <span class="font-bold text-slate-900 block text-[11px]">{{ $fStat['assigned_students'] }} / {{ $fStat['max_students'] }}</span>
                                    <div class="w-24 bg-slate-100 rounded-full h-1.5 overflow-hidden border border-slate-200">
                                        <div class="h-1.5 rounded-full {{ $fStat['utilization_pct'] > 85 ? 'bg-red-500' : 'bg-emerald-500' }}" style="width: {{ min(100, $fStat['utilization_pct']) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-xs font-bold text-blue-600 py-3">
                                {{ $fStat['avg_attendance'] }}%
                            </td>
                            <td class="text-xs font-bold text-slate-800 py-3">
                                {{ $fStat['avg_marks'] }}
                            </td>
                            <td class="text-xs font-bold text-emerald-600 py-3">
                                {{ $fStat['pass_rate'] }}%
                            </td>
                            <td class="text-xs py-3">
                                @if($fStat['high_risk_count'] > 0)
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                        {{ $fStat['high_risk_count'] }} High Risk
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        0 Risk
                                    </span>
                                @endif
                            </td>
                            <td class="text-xs py-3">
                                <span class="px-2.5 py-1 font-extrabold rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $fStat['performance_score'] }} / 100
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const facultyData = @json($facultyStats);
    
    // 1. Workload Pie Chart
    const ctx1 = document.getElementById('workloadPieChart');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: facultyData.map(f => f.name.split(' ')[1] || f.name),
                datasets: [{
                    data: facultyData.map(f => f.assigned_students),
                    backgroundColor: ['#2563eb', '#7c3aed', '#059669', '#d97706', '#dc2626', '#0284c7']
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }

    // 2. Pass Rate Bar Chart
    const ctx2 = document.getElementById('passRateBarChart');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: facultyData.map(f => f.name.split(' ')[1] || f.name),
                datasets: [{
                    label: 'Pass Percentage',
                    data: facultyData.map(f => f.pass_rate),
                    backgroundColor: '#7c3aed',
                    borderRadius: 6
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }

    // 3. Risk Doughnut Chart
    const ctx3 = document.getElementById('riskDoughnutChart');
    if (ctx3) {
        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: ['Low Risk Students', 'Medium Risk', 'High Risk Students'],
                datasets: [{
                    data: [118, 58, 24],
                    backgroundColor: ['#059669', '#d97706', '#dc2626']
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }
});
</script>
@endsection
