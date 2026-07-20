@extends('layouts.app')

@section('title', 'My Marks & Grade Analytics')

@section('content')
<div x-data="{ 
    searchTerm: '',
    targetGrade: 'A',
    neededScore: 42
}" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-square-poll-vertical"></i>
                <span>Academic Evaluation & Grading</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Marks & Grade Analytics Center
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Subject-wise internal & external score breakdown, CGPA growth calculator, and AI grade predictor.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <button type="button" onclick="window.print()" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-file-export"></i> Export Grade Sheet
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
                <span>Current CGPA</span>
                <i class="fas fa-graduation-cap text-blue-600"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">3.82 <span class="text-xs font-normal text-slate-400">/ 4.0</span></div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; First Class Distinction</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Average Score</span>
                <i class="fas fa-calculator text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">78.5 <span class="text-xs font-normal text-slate-400">/ 100</span></div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">Across all assessments</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Highest Score</span>
                <i class="fas fa-trophy text-amber-500"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">92.0 <span class="text-xs font-normal text-slate-400">/ 100</span></div>
            <div class="text-[11px] text-amber-700 font-bold mt-1">Web Development (A+)</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Internal Average</span>
                <i class="fas fa-pen-to-square text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">41.5 <span class="text-xs font-normal text-slate-400">/ 50</span></div>
            <div class="text-[11px] text-purple-700 font-medium mt-1">83% Internal Standing</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>External Average</span>
                <i class="fas fa-chart-line text-indigo-500"></i>
            </div>
            <div class="text-2xl font-black text-indigo-600 mt-1">44.0 <span class="text-xs font-normal text-slate-400">/ 50</span></div>
            <div class="text-[11px] text-indigo-700 font-medium mt-1">88% External Standing</div>
        </div>
    </div>

    <!-- AI GRADE CALCULATOR & TARGET GOAL CARD -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- AI Calculator Box -->
        <div class="lg:col-span-2 bg-gradient-to-r from-slate-900 via-purple-950 to-slate-900 text-white rounded-2xl p-6 shadow-xs flex flex-col justify-between border border-purple-900">
            <div>
                <div class="flex items-center justify-between text-xs font-extrabold uppercase tracking-wider text-purple-300 mb-2">
                    <span>AI Grade Target Predictor</span>
                    <i class="fas fa-wand-magic-sparkles text-amber-300"></i>
                </div>
                <h3 class="text-lg font-black text-white tracking-tight">
                    "What marks do I need for Grade A in Data Structures?"
                </h3>
                <p class="text-xs text-purple-100 font-medium leading-relaxed mt-1">
                    Your current internal score is 38/50. To achieve a final Grade A (80+ total score), you need to score at least <strong>42 out of 50</strong> in the upcoming semester external exam.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                    <div class="p-3 bg-purple-900/60 rounded-xl border border-purple-700 text-xs">
                        <div class="text-purple-300 font-bold uppercase text-[10px]">Target 3.90 CGPA</div>
                        <div class="text-sm font-extrabold text-emerald-400 mt-0.5">Score 85+ in all 4 subjects</div>
                    </div>

                    <div class="p-3 bg-purple-900/60 rounded-xl border border-purple-700 text-xs">
                        <div class="text-purple-300 font-bold uppercase text-[10px]">Highest Attainable GPA</div>
                        <div class="text-sm font-extrabold text-amber-300 mt-0.5">4.00 (Grade A in remaining finals)</div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-purple-800/60 flex items-center justify-between text-xs">
                <span class="text-purple-200 font-semibold">Prediction Model Confidence: 99.1%</span>
                <a href="{{ route('student.ai') }}" class="px-3.5 py-1.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold transition flex items-center gap-1.5">
                    <i class="fas fa-brain text-xs"></i> Run Custom AI Prediction
                </a>
            </div>
        </div>

        <!-- Grade Scale Reference Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-3 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fas fa-award text-amber-500"></i> Institutional Grading Scale
                </h4>
                
                <div class="space-y-2 text-xs">
                    <div class="flex items-center justify-between p-2 rounded-lg bg-emerald-50 text-emerald-900 font-bold">
                        <span>Grade A+ (80 - 100 Marks)</span>
                        <span class="text-emerald-700">4.0 GPA Point</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg bg-blue-50 text-blue-900 font-bold">
                        <span>Grade B (70 - 79 Marks)</span>
                        <span class="text-blue-700">3.0 GPA Point</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg bg-purple-50 text-purple-900 font-bold">
                        <span>Grade C (60 - 69 Marks)</span>
                        <span class="text-purple-700">2.0 GPA Point</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg bg-amber-50 text-amber-900 font-bold">
                        <span>Grade D (50 - 59 Marks)</span>
                        <span class="text-amber-700">1.0 GPA Point</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <span class="text-[11px] text-slate-400 font-medium">Minimum Passing Threshold: 40 Marks</span>
            </div>
        </div>
    </div>

    <!-- CHARTS GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart 1: Subject Score Comparison -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-blue-600"></i> Subject Marks Breakdown
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Internal (/50) + External (/50)</span>
            </div>
            <div class="h-64">
                <canvas id="studentMarksComparisonChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: CGPA Growth Trend -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-line text-emerald-600"></i> CGPA Semester Growth Trend
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Semesters 1 - 4</span>
            </div>
            <div class="h-64">
                <canvas id="studentCgpaGrowthChart"></canvas>
            </div>
        </div>
    </div>

    <!-- MARKS TABLE LOG -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4 pb-3 border-b border-slate-100">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                <i class="fas fa-table text-blue-600"></i> Academic Grade Sheet Records
            </h3>

            <div class="relative w-full sm:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" x-model="searchTerm" placeholder="Filter by course name..." class="w-full pl-8 pr-3 py-2 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
            </div>
        </div>

        <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
            <table class="table w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Course Title</th>
                        <th class="py-3 px-4">Assessment Type</th>
                        <th class="py-3 px-4 text-center">Internal Score (/50)</th>
                        <th class="py-3 px-4 text-center">External Score (/50)</th>
                        <th class="py-3 px-4 text-center">Total Score (/100)</th>
                        <th class="py-3 px-4 text-right">Grade & Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($marks as $m)
                        <tr class="hover:bg-slate-50/80 transition" x-show="searchTerm === '' || '{{ strtolower($m->course->course_name ?? '') }}'.includes(searchTerm.toLowerCase())">
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $m->course->course_name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-slate-600 font-medium">{{ ucfirst($m->assessment_type) }} Exam</td>
                            <td class="py-3 px-4 text-center font-semibold text-slate-800">{{ $m->internal_marks }}</td>
                            <td class="py-3 px-4 text-center font-semibold text-slate-800">{{ $m->external_marks }}</td>
                            <td class="py-3 px-4 text-center font-black text-blue-700">{{ $m->total_marks }} / 100</td>
                            <td class="py-3 px-4 text-right">
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-extrabold border border-emerald-100">
                                    Grade {{ $m->grade }} &bull; Passed
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-400">No grade records published yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $marks->links() }}
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const compCtx = document.getElementById('studentMarksComparisonChart');
    if (compCtx && typeof Chart !== 'undefined') {
        new Chart(compCtx, {
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

    const growthCtx = document.getElementById('studentCgpaGrowthChart');
    if (growthCtx && typeof Chart !== 'undefined') {
        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4 (Current)'],
                datasets: [{
                    label: 'Semester GPA',
                    data: [3.65, 3.72, 3.78, 3.82],
                    borderColor: '#7c3aed',
                    backgroundColor: 'rgba(124, 58, 237, 0.1)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { min: 3.0, max: 4.0, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }
});
</script>
@endsection
