@extends('layouts.app')

@section('title', 'Enterprise Attendance Management')

@section('content')
<div x-data="{ 
    selectedCourse: '{{ request('course_id', $courses->first()->id ?? '') }}',
    selectedStatus: {},
    searchTerm: '',
    markAll(status) {
        document.querySelectorAll('.attendance-status-select').forEach(el => {
            el.value = status;
            el.dispatchEvent(new Event('change'));
        });
    }
}" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-clipboard-check"></i>
                <span>Enterprise Academic Operations</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Batch Attendance System
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Single-pass batch recording, attendance analytics, low attendance alerts, and AI insights.
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

    @if (session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <i class="fas fa-check-circle text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Top 5 KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- KPI 1: Attendance % -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Attendance %</span>
                <i class="fas fa-chart-pie text-blue-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">84.5%</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; +1.8% vs last week</div>
        </div>

        <!-- KPI 2: Present Today -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Present Today</span>
                <i class="fas fa-user-check text-emerald-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">42</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">Out of 48 enrolled</div>
        </div>

        <!-- KPI 3: Absent Today -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Absent Today</span>
                <i class="fas fa-user-times text-red-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-red-600 mt-1">4</div>
            <div class="text-[11px] text-red-600 font-medium mt-1">Unexcused Absences</div>
        </div>

        <!-- KPI 4: Late -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Late Arrived</span>
                <i class="fas fa-clock text-amber-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">2</div>
            <div class="text-[11px] text-amber-700 font-medium mt-1">&lt; 15 mins late</div>
        </div>

        <!-- KPI 5: Low Attendance Students -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Low Attendance</span>
                <i class="fas fa-exclamation-circle text-purple-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">5</div>
            <div class="text-[11px] text-purple-700 font-bold mt-1">&lt; 75% threshold</div>
        </div>
    </div>

    <!-- Batch Attendance Entry Form (Single Unified Form) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs">
        <form method="POST" action="{{ route('faculty.attendance.store') }}">
            @csrf

            <!-- Filter Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 mb-6 pb-4 border-b border-slate-100 items-end">
                <!-- Course -->
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Select Course</label>
                    <select name="course_id" x-model="selectedCourse" class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_name }} ({{ $course->course_code }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Semester -->
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Semester</label>
                    <select class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <option value="4">Semester 4 (Current)</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                        <option value="3">Semester 3</option>
                    </select>
                </div>

                <!-- Section -->
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Section</label>
                    <select class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                        <option value="A">Section A</option>
                        <option value="B">Section B</option>
                        <option value="C">Section C</option>
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Session Date</label>
                    <input type="date" name="attendance_date" value="{{ date('Y-m-d') }}" class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>

                <!-- Search Student -->
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Search Student</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" x-model="searchTerm" placeholder="Filter student list..." class="w-full pl-8 pr-3 py-2 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    </div>
                </div>
            </div>

            <!-- Bulk Actions Bar -->
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4 bg-slate-50/80 p-3 rounded-xl border border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Bulk Controls:</span>
                    <button type="button" @click="markAll('present')" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-800 border border-emerald-200 transition">
                        <i class="fas fa-check-double text-[10px]"></i> Mark All Present
                    </button>
                    <button type="button" @click="markAll('absent')" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-red-100 hover:bg-red-200 text-red-800 border border-red-200 transition">
                        <i class="fas fa-times text-[10px]"></i> Mark All Absent
                    </button>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-5 py-2 text-xs font-extrabold rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow-2xs transition flex items-center gap-2">
                        <i class="fas fa-save text-xs"></i> Save Batch Attendance
                    </button>
                </div>
            </div>

            <!-- Batch Attendance Table -->
            <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden mb-4">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                            <th class="py-3 px-4">Student Info</th>
                            <th class="py-3 px-4 text-center">Attendance Status</th>
                            <th class="py-3 px-4">Remarks / Medical Note</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @php
                            // Gather students from current course if available or fetch active students
                            $activeCourse = $courses->firstWhere('id', request('course_id', $courses->first()->id ?? 0));
                            $enrolledList = $activeCourse ? $activeCourse->enrollments : collect();
                        @endphp

                        @forelse($enrolledList as $index => $enrollment)
                            @php $student = $enrollment->student; @endphp
                            <tr class="hover:bg-slate-50/80 transition" x-show="searchTerm === '' || '{{ strtolower($student->user->name) }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($student->student_id) }}'.includes(searchTerm.toLowerCase())">
                                <td class="py-3 px-4">
                                    <input type="hidden" name="students[{{ $index }}][student_id]" value="{{ $student->id }}">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold">
                                            {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900 text-xs">{{ $student->user->name }}</div>
                                            <div class="font-mono text-[10px] text-slate-400 font-semibold">{{ $student->student_id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-3 px-4 text-center">
                                    <select name="students[{{ $index }}][status]" class="attendance-status-select text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-200 bg-white focus:ring-1 focus:ring-blue-500">
                                        <option value="present" selected>Present</option>
                                        <option value="absent">Absent</option>
                                        <option value="late">Late</option>
                                        <option value="medical">Medical</option>
                                        <option value="leave">On Leave</option>
                                    </select>
                                </td>

                                <td class="py-3 px-4">
                                    <input type="text" name="students[{{ $index }}][remarks]" placeholder="Add optional remark..." class="w-full text-xs py-1 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 transition">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-8 text-slate-400">
                                    Select a course above to load student batch roster.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- Analytics & Attendance History Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Attendance Trend Chart -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2 flex items-center gap-2">
                <i class="fas fa-chart-line text-blue-600"></i> Attendance Trend Chart
            </h3>
            <div class="h-48">
                <canvas id="facultyAttendanceTrendChart"></canvas>
            </div>
        </div>

        <!-- Daily Attendance Bar Chart -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2 flex items-center gap-2">
                <i class="fas fa-chart-bar text-emerald-600"></i> Daily Present Count
            </h3>
            <div class="h-48">
                <canvas id="facultyDailyAttendanceChart"></canvas>
            </div>
        </div>

        <!-- AI Suggestions & Alerts -->
        <div class="bg-gradient-to-br from-slate-900 to-blue-950 text-white border border-blue-900 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-blue-300 mb-2">
                    <span>AI Attendance Insight</span>
                    <i class="fas fa-lightbulb text-amber-400"></i>
                </div>
                <h4 class="text-sm font-extrabold text-white">Friday Afternoon Absences Detected</h4>
                <p class="text-xs text-blue-200/90 leading-relaxed font-medium mt-1">
                    Student attendance drops by 14% during Friday afternoon sessions. Consider rescheduling lab sessions to Tuesday mornings.
                </p>
            </div>
            <div class="mt-4 pt-3 border-t border-blue-800/60 flex items-center justify-between text-[11px]">
                <span class="text-blue-300 font-semibold">5 Students &lt; 75%</span>
                <a href="{{ route('email.send', ['recipient_type' => 'low_attendance']) }}" class="px-2.5 py-1 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold transition">Notify Parents</a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Attendance Trend Chart
    const trendCtx = document.getElementById('facultyAttendanceTrendChart');
    if (trendCtx && typeof Chart !== 'undefined') {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                datasets: [{
                    label: 'Attendance %',
                    data: [88, 85, 90, 82, 78],
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

    // Daily Attendance Bar Chart
    const dailyCtx = document.getElementById('facultyDailyAttendanceChart');
    if (dailyCtx && typeof Chart !== 'undefined') {
        new Chart(dailyCtx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                datasets: [{
                    label: 'Present Students',
                    data: [42, 40, 43, 39, 37],
                    backgroundColor: '#059669',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 50, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }
});
</script>
@endsection
