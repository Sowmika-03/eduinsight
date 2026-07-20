@extends('layouts.app')

@section('title', 'Student Performance Analytics Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-chart-column"></i>
                <span>Academic Growth & Progress</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Student Performance Analytics
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Longitudinal CGPA growth, attendance-performance correlation, subject strength matrix, and AI progress summary.
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

    <!-- Top 4 KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Cumulative CGPA</span>
                <i class="fas fa-chart-line text-blue-600"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">3.82 / 4.0</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; Consistent Semester Growth</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Credits Completed</span>
                <i class="fas fa-award text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">48 / 64 Credits</div>
            <div class="text-[11px] text-purple-700 font-medium mt-1">75% Degree Completed</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Highest Subject Score</span>
                <i class="fas fa-trophy text-amber-500"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">92.0 / 100</div>
            <div class="text-[11px] text-amber-700 font-bold mt-1">Web Development</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Attendance vs GPA Rating</span>
                <i class="fas fa-bolt text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">Optimal</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">Strong Positive Correlation</div>
        </div>
    </div>

    <!-- CHARTS ROW 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart 1: CGPA Growth Timeline -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-line text-blue-600"></i> Longitudinal CGPA Growth
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Semester 1 to 4</span>
            </div>
            <div class="h-64">
                <canvas id="performanceCgpaTrendChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Attendance vs GPA Correlation -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-column text-emerald-600"></i> Attendance % vs Subject Marks
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Correlation Matrix</span>
            </div>
            <div class="h-64">
                <canvas id="performanceCorrelationChart"></canvas>
            </div>
        </div>
    </div>

    <!-- STRENGTHS, WEAKNESSES & AI SUMMARY ROW -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Subject Strength & Weakness Cards -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-list-check text-purple-600"></i> Subject Strength & Weakness Matrix
            </h3>

            <div class="space-y-3">
                <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200/80">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-900">Web Development (CSE-401)</span>
                        <span class="text-xs font-black text-emerald-700">92/100 (Grade A+)</span>
                    </div>
                    <div class="text-[11px] text-emerald-700 font-medium mt-1">Strength: Exceptional practical lab output & continuous assessment.</div>
                </div>

                <div class="p-3.5 rounded-xl bg-blue-50 border border-blue-200/80">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-900">Software Engineering (CSE-404)</span>
                        <span class="text-xs font-black text-blue-700">85/100 (Grade A)</span>
                    </div>
                    <div class="text-[11px] text-blue-700 font-medium mt-1">Strength: Solid understanding of agile methodology & architecture.</div>
                </div>

                <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200/80">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-900">Data Structures (CSE-402)</span>
                        <span class="text-xs font-black text-amber-700">68/100 (Grade B)</span>
                    </div>
                    <div class="text-[11px] text-amber-700 font-medium mt-1">Focus Area: Requires additional practice in tree & graph algorithm problems.</div>
                </div>
            </div>
        </div>

        <!-- AI Executive Summary Banner -->
        <div class="bg-gradient-to-br from-purple-950 to-slate-900 text-white rounded-2xl p-6 shadow-xs flex flex-col justify-between border border-purple-900">
            <div>
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-purple-300 mb-2">
                    <span>EduInsight AI Performance Summary</span>
                    <i class="fas fa-lightbulb text-amber-300"></i>
                </div>
                <h4 class="text-base font-extrabold text-white">Consistent High Academic Standing</h4>
                <p class="text-xs text-purple-100/90 leading-relaxed font-medium mt-2">
                    Your longitudinal performance shows an upward trajectory from 3.65 CGPA in Semester 1 to 3.82 CGPA in Semester 4. Maintaining your current study habits will position you eligible for Placement Campus Selection with Distinction honors!
                </p>
            </div>

            <div class="mt-4 pt-3 border-t border-purple-800/60 flex items-center justify-between text-xs">
                <span class="text-purple-300 font-semibold">Status: Distinction Standing</span>
                <a href="{{ route('student.goals') }}" class="px-3.5 py-1.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold transition flex items-center gap-1.5">
                    <i class="fas fa-bullseye text-xs"></i> View Placement Goals
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cgpaCtx = document.getElementById('performanceCgpaTrendChart');
    if (cgpaCtx && typeof Chart !== 'undefined') {
        new Chart(cgpaCtx, {
            type: 'line',
            data: {
                labels: ['Semester 1', 'Semester 2', 'Semester 3', 'Semester 4'],
                datasets: [{
                    label: 'CGPA',
                    data: [3.65, 3.72, 3.78, 3.82],
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
                scales: { y: { min: 3.0, max: 4.0, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }

    const corrCtx = document.getElementById('performanceCorrelationChart');
    if (corrCtx && typeof Chart !== 'undefined') {
        new Chart(corrCtx, {
            type: 'bar',
            data: {
                labels: ['Web Dev', 'Database Sys', 'Algorithms', 'Software Eng'],
                datasets: [
                    { label: 'Attendance %', data: [92, 86, 78, 88], backgroundColor: '#2563eb', borderRadius: 6 },
                    { label: 'Total Score /100', data: [92, 82, 68, 85], backgroundColor: '#10b981', borderRadius: 6 }
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
