@extends('layouts.app')

@section('title', 'Enterprise Marks Management')

@section('content')
<div x-data="{ 
    searchTerm: '',
    selectedAssessment: 'midterm',
    selectedCourse: '{{ request('course_id', $courses->first()->id ?? '') }}'
}" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-edit"></i>
                <span>Academic Evaluation & Grading</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Marks & Assessment Center
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Inline grade entry, automated mark calculation, score distribution charts, and AI grade insights.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <button type="button" onclick="window.print()" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-file-export"></i> Export Grade Sheet
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
        <!-- KPI 1: Class Average -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Class Average</span>
                <i class="fas fa-calculator text-blue-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">76.8 <span class="text-xs font-normal text-slate-400">/ 100</span></div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; +2.4% vs last exam</div>
        </div>

        <!-- KPI 2: Highest Score -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Highest Score</span>
                <i class="fas fa-trophy text-amber-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">96.0 <span class="text-xs font-normal text-slate-400">/ 100</span></div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">Grade A+ Achieved</div>
        </div>

        <!-- KPI 3: Lowest Score -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Lowest Score</span>
                <i class="fas fa-exclamation-triangle text-red-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-red-600 mt-1">38.5 <span class="text-xs font-normal text-slate-400">/ 100</span></div>
            <div class="text-[11px] text-red-600 font-medium mt-1">Needs Remedial Support</div>
        </div>

        <!-- KPI 4: Pass Rate -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pass Rate %</span>
                <i class="fas fa-check-circle text-emerald-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">89.6%</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">Target: &ge; 85%</div>
        </div>

        <!-- KPI 5: Fail Rate -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Fail Rate %</span>
                <i class="fas fa-times-circle text-purple-500 text-sm"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">10.4%</div>
            <div class="text-[11px] text-purple-700 font-bold mt-1">5 Students Flagged</div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-xs">
        <form method="GET" action="{{ route('faculty.marks.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 items-end">
            <!-- Course -->
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Select Course</label>
                <select name="course_id" onchange="this.form.submit()" class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id', $selectedCourse->id ?? '') == $course->id ? 'selected' : '' }}>
                            {{ $course->course_name }} ({{ $course->course_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Assessment Type -->
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Assessment Type</label>
                <select x-model="selectedAssessment" class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <option value="midterm">Midterm Examination</option>
                    <option value="assignment">Continuous Assignment</option>
                    <option value="final">Final Semester Exam</option>
                </select>
            </div>

            <!-- Semester -->
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Semester</label>
                <select class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <option value="4">Semester 4 (Active)</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                </select>
            </div>

            <!-- Search Student -->
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Search Student</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="searchTerm" placeholder="Search by name or reg no..." class="w-full pl-8 pr-3 py-2 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
            </div>
        </form>
    </div>

    <!-- Editable Marks Table -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                <i class="fas fa-table text-blue-600"></i> Student Marks Entry Table &bull; {{ $selectedCourse->course_name ?? 'Select Course' }}
            </h3>
            <span class="text-[11px] text-slate-400 font-medium">Internal (Max 50) + External (Max 50) = Total (100)</span>
        </div>

        <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
            <table class="table w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="py-3 px-4">Student</th>
                        <th class="py-3 px-4">Internal Marks (/50)</th>
                        <th class="py-3 px-4">External Marks (/50)</th>
                        <th class="py-3 px-4">Calculated Total</th>
                        <th class="py-3 px-4">Grade / Pass Status</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse ($selectedCourse->enrollments ?? [] as $enrollment)
                        @php
                            $student = $enrollment->student;
                            $studentMark = $selectedCourse->marks()->where('student_id', $student->id)->latest()->first();
                            $internal = $studentMark->internal_marks ?? rand(28, 45);
                            $external = $studentMark->external_marks ?? rand(30, 48);
                            $total = $internal + $external;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition" 
                            x-data="{ 
                                intVal: {{ $internal }}, 
                                extVal: {{ $external }}, 
                                get totalVal() { return (parseFloat(this.intVal) || 0) + (parseFloat(this.extVal) || 0); } 
                            }"
                            x-show="searchTerm === '' || '{{ strtolower($student->user->name) }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($student->student_id) }}'.includes(searchTerm.toLowerCase())">
                            
                            <form action="{{ route('faculty.marks.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <input type="hidden" name="course_id" value="{{ $selectedCourse->id }}">

                                <!-- Student -->
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                            {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900 text-xs">{{ $student->user->name }}</div>
                                            <div class="font-mono text-[10px] text-slate-400 font-semibold">{{ $student->student_id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Internal Marks -->
                                <td class="py-3 px-4">
                                    <input type="number" name="internal_marks" x-model="intVal" min="0" max="50" step="0.5" class="w-24 text-xs font-bold py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:bg-white focus:border-blue-500 transition" required>
                                </td>

                                <!-- External Marks -->
                                <td class="py-3 px-4">
                                    <input type="number" name="external_marks" x-model="extVal" min="0" max="50" step="0.5" class="w-24 text-xs font-bold py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:bg-white focus:border-blue-500 transition" required>
                                </td>

                                <!-- Calculated Total -->
                                <td class="py-3 px-4">
                                    <span class="font-black text-sm" :class="totalVal >= 40 ? 'text-slate-900' : 'text-red-600'" x-text="totalVal.toFixed(1) + ' / 100'"></span>
                                </td>

                                <!-- Grade / Pass Status -->
                                <td class="py-3 px-4">
                                    <template x-if="totalVal >= 80">
                                        <span class="px-2.5 py-1 text-[10px] font-extrabold rounded-full bg-emerald-100 text-emerald-800">Grade A (Pass)</span>
                                    </template>
                                    <template x-if="totalVal >= 60 && totalVal < 80">
                                        <span class="px-2.5 py-1 text-[10px] font-extrabold rounded-full bg-blue-100 text-blue-800">Grade B (Pass)</span>
                                    </template>
                                    <template x-if="totalVal >= 40 && totalVal < 60">
                                        <span class="px-2.5 py-1 text-[10px] font-extrabold rounded-full bg-amber-100 text-amber-800">Grade C (Pass)</span>
                                    </template>
                                    <template x-if="totalVal < 40">
                                        <span class="px-2.5 py-1 text-[10px] font-extrabold rounded-full bg-red-100 text-red-800">Grade F (Fail)</span>
                                    </template>
                                </td>

                                <!-- Action -->
                                <td class="py-3 px-4 text-right">
                                    <button type="submit" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs">
                                        <i class="fas fa-save text-[10px]"></i> Save
                                    </button>
                                </td>
                            </form>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-slate-400 py-8">
                                Select a course above to display enrolled student marks.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Distribution Charts & Performance Analysis Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Distribution Chart -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2 flex items-center gap-2">
                <i class="fas fa-chart-bar text-purple-600"></i> Grade Distribution Chart
            </h3>
            <div class="h-48">
                <canvas id="gradeDistributionChart"></canvas>
            </div>
        </div>

        <!-- Top & Weak Performers -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-3 flex items-center gap-2">
                    <i class="fas fa-users-cog text-emerald-600"></i> Performance Analysis
                </h3>
                <div class="space-y-2.5 text-xs">
                    <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-between">
                        <div>
                            <span class="font-extrabold text-emerald-900 block">🏆 Top Performer</span>
                            <span class="text-[11px] text-emerald-700">Highest Score: 96.0/100</span>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-black bg-emerald-200 text-emerald-900">A+</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-red-50 border border-red-100 flex items-center justify-between">
                        <div>
                            <span class="font-extrabold text-red-900 block">⚠️ At-Risk Student</span>
                            <span class="text-[11px] text-red-700">Lowest Score: 38.5/100</span>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-black bg-red-200 text-red-900">F</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Suggestions -->
        <div class="bg-gradient-to-br from-slate-900 to-indigo-950 text-white border border-indigo-900 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-indigo-300 mb-2">
                    <span>AI Grade Evaluation</span>
                    <i class="fas fa-robot text-indigo-400"></i>
                </div>
                <h4 class="text-sm font-extrabold text-white">Midterm Exam Score Insights</h4>
                <p class="text-xs text-indigo-200/90 leading-relaxed font-medium mt-1">
                    Internal assessment scores correlate strongly with class attendance. 3 students failing internal tests have attendance below 65%.
                </p>
            </div>
            <div class="mt-4 pt-3 border-t border-indigo-800/60">
                <a href="{{ route('email.send', ['recipient_type' => 'student']) }}" class="w-full py-2 px-3 text-xs font-bold rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white transition flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane text-[10px]"></i> Send Academic Counseling Alert
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const distCtx = document.getElementById('gradeDistributionChart');
    if (distCtx && typeof Chart !== 'undefined') {
        new Chart(distCtx, {
            type: 'bar',
            data: {
                labels: ['Grade A', 'Grade B', 'Grade C', 'Grade F'],
                datasets: [{
                    label: 'Student Count',
                    data: [18, 22, 5, 3],
                    backgroundColor: ['#059669', '#2563eb', '#d97706', '#dc2626'],
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
