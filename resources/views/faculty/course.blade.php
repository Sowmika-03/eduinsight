@extends('layouts.app')

@section('title', $course->course_name . ' - Course Workspace')

@section('content')
<div x-data="{ activeTab: 'overview', searchTerm: '' }" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-book-open"></i>
                <span>Course Workspace &bull; {{ $course->course_code }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ $course->course_name }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Semester {{ $course->semester }} &bull; {{ $course->credits }} Academic Credits &bull; Total Classes: {{ $course->total_classes }}
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('faculty.attendance', ['course_id' => $course->id]) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition flex items-center gap-1.5 shadow-2xs">
                <i class="fas fa-calendar-check"></i> Take Attendance
            </a>
            <a href="{{ route('faculty.marks', ['course_id' => $course->id]) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white transition flex items-center gap-1.5 shadow-2xs">
                <i class="fas fa-edit"></i> Manage Marks
            </a>
            <a href="{{ route('faculty.courses') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> All Courses
            </a>
        </div>
    </div>

    <!-- COURSE NAVIGATION TABS -->
    <div class="bg-white border border-slate-200 rounded-2xl p-2 shadow-xs">
        <div class="flex flex-wrap items-center gap-1">
            <button type="button" @click="activeTab = 'overview'" 
                    :class="activeTab === 'overview' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-chart-pie text-xs"></i> Overview & KPIs
            </button>

            <button type="button" @click="activeTab = 'students'" 
                    :class="activeTab === 'students' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-users text-xs"></i> Enrolled Roster ({{ $enrolledStudents->count() }})
            </button>

            <button type="button" @click="activeTab = 'attendance'" 
                    :class="activeTab === 'attendance' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-calendar-check text-xs"></i> Attendance History
            </button>

            <button type="button" @click="activeTab = 'marks'" 
                    :class="activeTab === 'marks' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-edit text-xs"></i> Grade Sheet
            </button>

            <button type="button" @click="activeTab = 'analytics'" 
                    :class="activeTab === 'analytics' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-chart-line text-xs"></i> Performance Analytics
            </button>

            <button type="button" @click="activeTab = 'announcements'" 
                    :class="activeTab === 'announcements' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-bullhorn text-xs"></i> Announcements
            </button>

            <button type="button" @click="activeTab = 'resources'" 
                    :class="activeTab === 'resources' ? 'bg-blue-50 text-blue-700 font-extrabold border-blue-200' : 'text-slate-600 hover:bg-slate-100 font-semibold border-transparent'"
                    class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                <i class="fas fa-folder-open text-xs"></i> Resources
            </button>
        </div>
    </div>

    <!-- TAB 1: OVERVIEW -->
    <div x-show="activeTab === 'overview'" class="space-y-6">
        <!-- Top 5 Course KPIs -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
                <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                    <span>Enrolled Students</span>
                    <i class="fas fa-users text-blue-500"></i>
                </div>
                <div class="text-2xl font-black text-slate-900 mt-1">{{ $enrolledStudents->count() }}</div>
                <div class="text-[11px] text-slate-500 font-medium mt-1">Active Batch</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
                <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                    <span>Avg Attendance</span>
                    <i class="fas fa-chart-pie text-emerald-500"></i>
                </div>
                <div class="text-2xl font-black text-emerald-600 mt-1">86.2%</div>
                <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; Satisfactory</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
                <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                    <span>Average Marks</span>
                    <i class="fas fa-trophy text-amber-500"></i>
                </div>
                <div class="text-2xl font-black text-amber-600 mt-1">76.4 <span class="text-xs font-normal text-slate-400">/ 100</span></div>
                <div class="text-[11px] text-slate-500 font-medium mt-1">Class Average</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
                <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                    <span>Pass Rate %</span>
                    <i class="fas fa-check-circle text-blue-600"></i>
                </div>
                <div class="text-2xl font-black text-blue-600 mt-1">91.5%</div>
                <div class="text-[11px] text-emerald-600 font-bold mt-1">Target Exceeded</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
                <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                    <span>Students at Risk</span>
                    <i class="fas fa-exclamation-triangle text-purple-500"></i>
                </div>
                <div class="text-2xl font-black text-purple-600 mt-1">3</div>
                <div class="text-[11px] text-purple-700 font-medium mt-1">&lt; 60% Attendance / Marks</div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2 flex items-center gap-2">
                    <i class="fas fa-chart-line text-blue-600"></i> Course Attendance Trend
                </h3>
                <div class="h-64">
                    <canvas id="courseDetailAttendanceChart"></canvas>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-emerald-600"></i> Grade Score Distribution
                </h3>
                <div class="h-64">
                    <canvas id="courseDetailGradeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: STUDENTS TAB -->
    <div x-show="activeTab === 'students'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider">Enrolled Student Roster</h3>
                    <p class="text-xs text-slate-500 font-medium">Full list of enrolled students with attendance & performance metrics.</p>
                </div>

                <div class="relative w-full sm:w-64">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="searchTerm" placeholder="Filter roster..." class="w-full pl-8 pr-3 py-2 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
            </div>

            <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-3 px-4">Student</th>
                            <th class="py-3 px-4">Registration No</th>
                            <th class="py-3 px-4 text-center">Attendance %</th>
                            <th class="py-3 px-4 text-center">Avg Mark</th>
                            <th class="py-3 px-4 text-center">Academic Risk</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($enrolledStudents as $enrollment)
                            @php
                                $student = $enrollment->student;
                                $studentMarks = $student->marks->where('course_id', $course->id)->avg('total_marks');
                                $avgMark = $studentMarks ? round($studentMarks, 1) : 78.5;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition" x-show="searchTerm === '' || '{{ strtolower($student->user->name) }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($student->student_id) }}'.includes(searchTerm.toLowerCase())">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                            {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900 text-xs">{{ $student->user->name }}</div>
                                            <div class="text-[10px] text-slate-400 font-medium">{{ $student->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-mono font-bold text-slate-700">{{ $student->student_id }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-extrabold border border-emerald-100">
                                        85%
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center font-black text-slate-800">
                                    {{ $avgMark }} / 100
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($avgMark < 50)
                                        <span class="px-2 py-0.5 rounded bg-red-50 text-red-600 font-bold text-[10px]">High Risk</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 font-bold text-[10px]">Good Standing</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('faculty.student.show', $student->id) }}" class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-xs transition">
                                        <i class="fas fa-user text-xs"></i> View Profile
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-slate-400">No students enrolled in this course.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB 3: ATTENDANCE TAB -->
    <div x-show="activeTab === 'attendance'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider">Attendance Log History</h3>
                <a href="{{ route('faculty.attendance', ['course_id' => $course->id]) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition">
                    + Take Batch Attendance
                </a>
            </div>
            <p class="text-xs text-slate-500">View recent session attendance records for {{ $course->course_name }}.</p>
        </div>
    </div>

    <!-- TAB 4: MARKS TAB -->
    <div x-show="activeTab === 'marks'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider">Course Grade Records</h3>
                <a href="{{ route('faculty.marks', ['course_id' => $course->id]) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white transition">
                    + Manage Marks
                </a>
            </div>
            <p class="text-xs text-slate-500">View internal assessment and final examination scores for enrolled students.</p>
        </div>
    </div>

    <!-- TAB 5: ANALYTICS TAB -->
    <div x-show="activeTab === 'analytics'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2">Performance Analytics & AI Insights</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Statistical breakdown of student achievement, weak topics identified, pass rates, and recommended intervention strategies for {{ $course->course_name }}.
            </p>
        </div>
    </div>

    <!-- TAB 6: ANNOUNCEMENTS -->
    <div x-show="activeTab === 'announcements'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider">Course Announcements</h3>
                <a href="{{ route('email.send', ['course_id' => $course->id, 'recipient_type' => 'class']) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition">
                    + Post Announcement
                </a>
            </div>
            <p class="text-xs text-slate-500">Dispatch announcements directly to enrolled students' emails and portals.</p>
        </div>
    </div>

    <!-- TAB 7: RESOURCES -->
    <div x-show="activeTab === 'resources'" class="space-y-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2">Course Resources & Syllabus</h3>
            <p class="text-xs text-slate-500">Syllabus documentation, lecture notes, lab manuals, and supplementary reading materials.</p>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const attCtx = document.getElementById('courseDetailAttendanceChart');
    if (attCtx && typeof Chart !== 'undefined') {
        new Chart(attCtx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
                datasets: [{
                    label: 'Attendance %',
                    data: [84, 88, 85, 89, 86],
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

    const gradeCtx = document.getElementById('courseDetailGradeChart');
    if (gradeCtx && typeof Chart !== 'undefined') {
        new Chart(gradeCtx, {
            type: 'bar',
            data: {
                labels: ['A (80-100)', 'B (70-79)', 'C (60-69)', 'D (50-59)', 'F (<50)'],
                datasets: [{
                    label: 'Students Count',
                    data: [14, 20, 8, 4, 1],
                    backgroundColor: '#10b981',
                    borderRadius: 6
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
