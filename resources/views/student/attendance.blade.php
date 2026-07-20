@extends('layouts.app')

@section('title', 'My Attendance Intelligence & Forecast')

@section('content')
<div x-data="{ 
    searchTerm: '',
    selectedFilter: 'all'
}" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-calendar-check"></i>
                <span>Attendance Analytics Gateway</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                My Attendance Intelligence & Forecast
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Real-time attendance tracking, subject-wise breakdown, eligibility forecaster, and faculty remarks.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <button type="button" onclick="window.print()" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-file-export"></i> Export Report
            </button>
            <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Top 5 KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Overall Attendance</span>
                <i class="fas fa-chart-pie text-blue-600"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">86.4%</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; Eligible for Exams</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Sessions Attended</span>
                <i class="fas fa-user-check text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">42 / 48</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">Total Sessions Conducted</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Absences Logged</span>
                <i class="fas fa-user-xmark text-red-500"></i>
            </div>
            <div class="text-2xl font-black text-red-600 mt-1">6 Sessions</div>
            <div class="text-[11px] text-red-600 font-medium mt-1">Unexcused Absences</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Mandatory Threshold</span>
                <i class="fas fa-shield text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">75.0%</div>
            <div class="text-[11px] text-purple-700 font-medium mt-1">University Requirement</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Allowed Bunks Left</span>
                <i class="fas fa-clock text-amber-500"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">5 Sessions</div>
            <div class="text-[11px] text-amber-700 font-bold mt-1">Safe Buffer Remaining</div>
        </div>
    </div>

    <!-- ATTENDANCE FORECASTER WIDGET & AI ADVISORY -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Forecaster Calculator Card -->
        <div class="lg:col-span-2 bg-gradient-to-r from-blue-900 to-slate-900 text-white rounded-2xl p-6 shadow-xs flex flex-col justify-between border border-blue-800">
            <div>
                <div class="flex items-center justify-between text-xs font-extrabold uppercase tracking-wider text-blue-300 mb-2">
                    <span>Smart Attendance Forecaster</span>
                    <i class="fas fa-calculator text-amber-300"></i>
                </div>
                <h3 class="text-lg font-black text-white tracking-tight">
                    Attendance Forecast: Safe Buffer Available
                </h3>
                <p class="text-xs text-blue-100 font-medium leading-relaxed mt-1">
                    You currently have an attendance standing of <strong>86.4%</strong>. You can miss up to <strong>5 remaining sessions</strong> across your courses while staying strictly above the mandatory 75% threshold.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                    <div class="p-3 bg-blue-950/80 rounded-xl border border-blue-800 text-xs">
                        <div class="text-blue-300 font-bold uppercase text-[10px]">To Reach 90% Target</div>
                        <div class="text-sm font-extrabold text-emerald-400 mt-0.5">Attend next 8 classes continuously</div>
                    </div>

                    <div class="p-3 bg-blue-950/80 rounded-xl border border-blue-800 text-xs">
                        <div class="text-blue-300 font-bold uppercase text-[10px]">Minimum Required Attendance</div>
                        <div class="text-sm font-extrabold text-amber-300 mt-0.5">Maintain at least 36 out of 48 classes</div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-blue-800/60 flex items-center justify-between text-xs">
                <span class="text-blue-200 font-semibold">Eligibility Status: Confirmed</span>
                <a href="{{ route('student.ai') }}" class="px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold transition flex items-center gap-1.5">
                    <i class="fas fa-brain text-xs"></i> Calculate Custom Scenario
                </a>
            </div>
        </div>

        <!-- AI Attendance Advice -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                        <i class="fas fa-lightbulb text-amber-500"></i> AI Attendance Insight
                    </h4>
                    <span class="text-[10px] bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded">Optimal</span>
                </div>
                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                    Your attendance is strongest in <strong>Web Development (92%)</strong> and lowest in <strong>Data Structures (78%)</strong>. Focus on attending all Data Structures sessions to prevent falling near the 75% boundary.
                </p>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <a href="{{ route('student.courses') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">View Subject Schedule &rarr;</a>
            </div>
        </div>
    </div>

    <!-- CHARTS GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart 1: Monthly Attendance Trend -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-line text-blue-600"></i> Monthly Attendance Progress
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Term 2026</span>
            </div>
            <div class="h-64">
                <canvas id="studentAttendanceTrendChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Subject Attendance Comparison -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-emerald-600"></i> Attendance % by Subject
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Comparison vs 75% Limit</span>
            </div>
            <div class="h-64">
                <canvas id="studentSubjectAttendanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- DETAILED ATTENDANCE LOG TABLE -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4 pb-3 border-b border-slate-100">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                <i class="fas fa-list-check text-blue-600"></i> Attendance Records Log
            </h3>

            <div class="relative w-full sm:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" x-model="searchTerm" placeholder="Filter by date or course..." class="w-full pl-8 pr-3 py-2 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
            </div>
        </div>

        <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
            <table class="table w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Course Name</th>
                        <th class="py-3 px-4">Course Code</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4">Faculty Remarks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($attendance as $att)
                        <tr class="hover:bg-slate-50/80 transition" x-show="searchTerm === '' || '{{ strtolower($att->course->course_name ?? '') }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($att->course->course_code ?? '') }}'.includes(searchTerm.toLowerCase())">
                            <td class="py-3 px-4 font-mono font-bold text-slate-900">{{ $att->attendance_date->format('M d, Y') }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $att->course->course_name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 font-mono text-blue-700 font-bold">{{ $att->course->course_code ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-center">
                                @if($att->status === 'present')
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-extrabold border border-emerald-100">
                                        <i class="fas fa-check text-[10px] mr-1"></i> Present
                                    </span>
                                @elseif($att->status === 'late')
                                    <span class="px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 font-extrabold border border-amber-100">
                                        <i class="fas fa-clock text-[10px] mr-1"></i> Late
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-lg bg-red-50 text-red-700 font-extrabold border border-red-100">
                                        <i class="fas fa-times text-[10px] mr-1"></i> Absent
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-slate-500 font-medium">{{ $att->remarks ?? 'Regular Lecture Session' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-slate-400">No attendance logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $attendance->links() }}
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const trendCtx = document.getElementById('studentAttendanceTrendChart');
    if (trendCtx && typeof Chart !== 'undefined') {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Attendance %',
                    data: [82, 85, 84, 88, 86, 88],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.3
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

    const subCtx = document.getElementById('studentSubjectAttendanceChart');
    if (subCtx && typeof Chart !== 'undefined') {
        new Chart(subCtx, {
            type: 'bar',
            data: {
                labels: ['Web Dev', 'Database Sys', 'Algorithms', 'Software Eng'],
                datasets: [
                    { label: 'My Attendance %', data: [92, 86, 78, 88], backgroundColor: '#10b981', borderRadius: 6 },
                    { label: 'Requirement (75%)', data: [75, 75, 75, 75], backgroundColor: '#e2e8f0', borderRadius: 6 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: { y: { min: 50, max: 100, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }
});
</script>
@endsection
