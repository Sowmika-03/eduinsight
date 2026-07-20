@extends('layouts.app')

@section('title', 'Faculty Performance Analytics')

@section('content')
<div class="space-y-6" x-data="{ selectedFaculty: null, modalOpen: false }">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-chart-bar"></i>
                <span>Academic Operations &bull; Executive Intelligence</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Faculty Performance Analytics
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Overview of workload, student outcomes, attendance and teaching effectiveness.
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

    <!-- 4 KPI Cards Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- KPI 1: Total Faculty -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-slate-400 mb-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Faculty</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <span class="text-2xl font-extrabold text-slate-900">{{ $stats['total_faculty'] }}</span>
            <span class="text-[11px] text-slate-400 font-medium block mt-1">100% Active Faculty</span>
        </div>

        <!-- KPI 2: Average Pass % -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-slate-400 mb-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Average Pass %</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <span class="text-2xl font-extrabold text-emerald-600">{{ $stats['avg_pass_rate'] }}%</span>
            <span class="text-[11px] text-emerald-600 font-medium block mt-1">&uarr; +2.4% vs Baseline</span>
        </div>

        <!-- KPI 3: Average Attendance % -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-slate-400 mb-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Average Attendance</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
            <span class="text-2xl font-extrabold text-blue-600">{{ $stats['avg_attendance'] }}%</span>
            <span class="text-[11px] text-blue-600 font-medium block mt-1">Target: 75.0% Baseline</span>
        </div>

        <!-- KPI 4: High Performing Faculty -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-slate-400 mb-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">High Performing</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xs">
                    <i class="fas fa-award"></i>
                </div>
            </div>
            <span class="text-2xl font-extrabold text-purple-600">{{ $stats['high_performing_count'] }} <span class="text-xs text-slate-400 font-normal">/ {{ $stats['total_faculty'] }}</span></span>
            <span class="text-[11px] text-purple-600 font-medium block mt-1">Score &ge; 80 / 100</span>
        </div>
    </div>

    <!-- 4 Analytics Charts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Chart 1: Faculty Pass Percentage (Bar Chart) -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-2">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                        <i class="fas fa-chart-bar text-emerald-600"></i> Faculty Pass Percentage
                    </h3>
                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">Average pass percentage achieved across assigned student sections</p>
                </div>
            </div>
            <div class="h-60 relative">
                <canvas id="passRateBarChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Faculty Workload Distribution (Horizontal Bar Chart) -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-2">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                        <i class="fas fa-align-left text-blue-600"></i> Faculty Workload Distribution
                    </h3>
                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">Number of assigned student mentees per faculty advisor</p>
                </div>
            </div>
            <div class="h-60 relative">
                <canvas id="workloadBarChart"></canvas>
            </div>
        </div>

        <!-- Chart 3: Student Risk under Faculty (Donut Chart) -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-2">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                        <i class="fas fa-shield-alt text-amber-500"></i> Student Risk under Faculty
                    </h3>
                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">Overall risk breakdown of students allocated to faculty advisors</p>
                </div>
            </div>
            <div class="h-60 relative">
                <canvas id="riskDoughnutChart"></canvas>
            </div>
        </div>

        <!-- Chart 4: Faculty Performance Score (Radar Chart) -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-2">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                        <i class="fas fa-sparkles text-purple-600"></i> Faculty Performance Score
                    </h3>
                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">Composite evaluation score calculated from attendance, pass rate, and risk control</p>
                </div>
            </div>
            <div class="h-60 relative">
                <canvas id="performanceRadarChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Faculty Performance Table -->
    <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-xs">
        <div class="p-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-table text-blue-600"></i>
                    <span>Faculty Performance Evaluation Directory ({{ count($facultyStats) }} Faculty Members)</span>
                </h3>
                <p class="text-[11px] text-slate-500 font-medium mt-0.5">Click any faculty row to view detailed performance profile and student breakdown</p>
            </div>
        </div>

        <div class="table-responsive max-h-[500px] overflow-y-auto">
            <table class="table mb-0 w-full">
                <thead class="bg-slate-50 border-b border-slate-200 sticky top-0 z-10">
                    <tr>
                        <th class="text-xs font-bold text-slate-700 py-3">Faculty</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Department</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Subjects</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Students</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Attendance</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Pass %</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Risk</th>
                        <th class="text-xs font-bold text-slate-700 py-3">Performance Score</th>
                        <th class="text-xs font-bold text-slate-700 py-3 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($facultyStats as $fStat)
                        @php
                            $score = $fStat['performance_score'];
                            if ($score >= 85) {
                                $badgeBg = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                                $badgeText = 'Excellent';
                            } elseif ($score >= 75) {
                                $badgeBg = 'bg-blue-100 text-blue-800 border-blue-200';
                                $badgeText = 'Good';
                            } elseif ($score >= 65) {
                                $badgeBg = 'bg-amber-100 text-amber-800 border-amber-200';
                                $badgeText = 'Average';
                            } else {
                                $badgeBg = 'bg-red-100 text-red-800 border-red-200';
                                $badgeText = 'Needs Attention';
                            }
                        @endphp
                        <tr @click="selectedFaculty = {{ json_encode($fStat) }}; modalOpen = true" class="hover:bg-blue-50/50 transition cursor-pointer">
                            <td class="text-xs py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-extrabold shrink-0">
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
                                {{ $fStat['courses_count'] }} Courses
                            </td>
                            <td class="text-xs py-3">
                                <div class="space-y-1">
                                    <span class="font-bold text-slate-900 block text-[11px]">{{ $fStat['assigned_students'] }} / {{ $fStat['max_students'] }}</span>
                                    <div class="w-20 bg-slate-100 rounded-full h-1.5 overflow-hidden border border-slate-200">
                                        <div class="h-1.5 rounded-full {{ $fStat['utilization_pct'] > 85 ? 'bg-amber-500' : 'bg-blue-600' }}" style="width: {{ min(100, $fStat['utilization_pct']) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-xs font-bold text-blue-600 py-3">
                                {{ $fStat['avg_attendance'] }}%
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
                                <span class="px-2.5 py-1 font-extrabold rounded-lg bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $fStat['performance_score'] }} / 100
                                </span>
                            </td>
                            <td class="text-xs py-3 text-right">
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full border {{ $badgeBg }}">
                                    {{ $badgeText }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Faculty Detail Panel Modal -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div @click.outside="modalOpen = false" class="bg-white border border-slate-200 rounded-2xl shadow-xl max-w-2xl w-full p-6 space-y-5 max-h-[90vh] overflow-y-auto">
            <template x-if="selectedFaculty">
                <div class="space-y-5">
                    <!-- Modal Header -->
                    <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-sm font-extrabold shadow-sm">
                                <span x-text="selectedFaculty.name.substring(0, 2).toUpperCase()"></span>
                            </div>
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 leading-snug" x-text="selectedFaculty.name"></h3>
                                <p class="text-xs text-slate-500 font-semibold mt-0.5">
                                    <span x-text="selectedFaculty.department"></span> &bull; <span x-text="selectedFaculty.specialization"></span>
                                </p>
                                <span class="text-[11px] text-slate-400 font-medium block mt-0.5" x-text="selectedFaculty.email"></span>
                            </div>
                        </div>
                        <button @click="modalOpen = false" type="button" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100">
                            <i class="fas fa-times text-base"></i>
                        </button>
                    </div>

                    <!-- Faculty Metrics Summary Cards -->
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-blue-50/80 border border-blue-100 rounded-xl p-3 text-center">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider block">Pass Rate</span>
                            <span class="text-xl font-extrabold text-blue-900" x-text="selectedFaculty.pass_rate + '%'"></span>
                        </div>
                        <div class="bg-emerald-50/80 border border-emerald-100 rounded-xl p-3 text-center">
                            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider block">Avg Attendance</span>
                            <span class="text-xl font-extrabold text-emerald-900" x-text="selectedFaculty.avg_attendance + '%'"></span>
                        </div>
                        <div class="bg-purple-50/80 border border-purple-100 rounded-xl p-3 text-center">
                            <span class="text-[10px] font-bold text-purple-600 uppercase tracking-wider block">Perf Score</span>
                            <span class="text-xl font-extrabold text-purple-900" x-text="selectedFaculty.performance_score + ' / 100'"></span>
                        </div>
                    </div>

                    <!-- Teaching Overview & Details -->
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-2.5">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-slate-200 pb-2">Academic Overview</h4>
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-slate-400 block font-medium">Assigned Mentees</span>
                                <span class="font-extrabold text-slate-800" x-text="selectedFaculty.assigned_students + ' / ' + selectedFaculty.max_students + ' Students'"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block font-medium">Course Offerings</span>
                                <span class="font-extrabold text-slate-800" x-text="selectedFaculty.courses_count + ' Active Courses'"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block font-medium">High Risk Students</span>
                                <span class="font-extrabold text-red-600" x-text="selectedFaculty.high_risk_count + ' High Risk'"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block font-medium">Capacity Utilization</span>
                                <span class="font-extrabold text-slate-800" x-text="selectedFaculty.utilization_pct + '%'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- AI Recommendations for Faculty -->
                    <div class="p-4 bg-amber-50/80 border border-amber-200 rounded-xl text-xs space-y-1.5">
                        <div class="flex items-center gap-1.5 font-bold text-amber-900 uppercase tracking-wider">
                            <i class="fas fa-sparkles text-amber-600"></i>
                            <span>AI Performance Recommendations</span>
                        </div>
                        <p class="text-amber-800 font-medium leading-relaxed">
                            Maintain bi-weekly attendance tracking and schedule targeted tutorial sessions for low exam mark subjects.
                        </p>
                    </div>

                    <!-- Action Footer -->
                    <div class="flex items-center justify-end gap-2 pt-2">
                        <a :href="'/admin/faculty/' + selectedFaculty.id + '/assign-students'" class="px-4 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs">
                            <i class="fas fa-user-plus mr-1"></i> Manage Student Allocation
                        </a>
                        <button @click="modalOpen = false" type="button" class="px-4 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                            Close
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const facultyData = @json($facultyStats);
    const labels = facultyData.map(f => f.name.split(' ').pop() || f.name);

    // Chart 1: Faculty Pass Percentage (Bar Chart)
    const ctx1 = document.getElementById('passRateBarChart');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pass Percentage %',
                    data: facultyData.map(f => f.pass_rate),
                    backgroundColor: '#059669',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 100 } }
            }
        });
    }

    // Chart 2: Faculty Workload Distribution (Horizontal Bar Chart)
    const ctx2 = document.getElementById('workloadBarChart');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Assigned Students',
                    data: facultyData.map(f => f.assigned_students),
                    backgroundColor: '#2563eb',
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    }

    // Chart 3: Student Risk under Faculty (Donut Chart)
    const ctx3 = document.getElementById('riskDoughnutChart');
    if (ctx3) {
        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: ['Low Risk (118)', 'Medium Risk (58)', 'High Risk (24)'],
                datasets: [{
                    data: [118, 58, 24],
                    backgroundColor: ['#059669', '#d97706', '#dc2626']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // Chart 4: Faculty Performance Score (Line/Radar Chart)
    const ctx4 = document.getElementById('performanceRadarChart');
    if (ctx4) {
        new Chart(ctx4, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Performance Score / 100',
                    data: facultyData.map(f => f.performance_score),
                    borderColor: '#7c3aed',
                    backgroundColor: 'rgba(124, 58, 237, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#7c3aed',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 100 } }
            }
        });
    }
});
</script>
@endsection
