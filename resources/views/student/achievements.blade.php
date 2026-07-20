@extends('layouts.app')

@section('title', 'Digital Achievements & Badges')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">
                <i class="fas fa-award"></i>
                <span>Gamified Academic Honors</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Digital Achievements & Honor Badges
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Earn digital badges for perfect attendance, top academic scores, AI exploration, and consistent semester growth.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- BADGES GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Badge 1: Top Performer -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center font-black text-2xl shrink-0">
                <i class="fas fa-trophy"></i>
            </div>
            <div>
                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-amber-50 text-amber-700 uppercase">Unlocked</span>
                <h3 class="text-sm font-black text-slate-900 mt-1">Top Performer Badge</h3>
                <p class="text-xs text-slate-500 font-medium mt-1">Achieved CGPA &gt; 3.75 across all active semesters.</p>
            </div>
        </div>

        <!-- Badge 2: Attendance Champion -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-black text-2xl shrink-0">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-emerald-50 text-emerald-700 uppercase">Unlocked</span>
                <h3 class="text-sm font-black text-slate-900 mt-1">Attendance Champion</h3>
                <p class="text-xs text-slate-500 font-medium mt-1">Maintained attendance above 85% requirement.</p>
            </div>
        </div>

        <!-- Badge 3: AI Explorer -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center font-black text-2xl shrink-0">
                <i class="fas fa-brain"></i>
            </div>
            <div>
                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-purple-50 text-purple-700 uppercase">Unlocked</span>
                <h3 class="text-sm font-black text-slate-900 mt-1">AI Explorer Badge</h3>
                <p class="text-xs text-slate-500 font-medium mt-1">Executed 10+ natural language AI queries.</p>
            </div>
        </div>

        <!-- Badge 4: Course Completion -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center font-black text-2xl shrink-0">
                <i class="fas fa-book-open"></i>
            </div>
            <div>
                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-blue-50 text-blue-700 uppercase">Unlocked</span>
                <h3 class="text-sm font-black text-slate-900 mt-1">Course Scholar</h3>
                <p class="text-xs text-slate-500 font-medium mt-1">Completed 12 core computer science courses.</p>
            </div>
        </div>

        <!-- Badge 5: Improved Student -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-2xl shrink-0">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-indigo-50 text-indigo-700 uppercase">Unlocked</span>
                <h3 class="text-sm font-black text-slate-900 mt-1">Consistent Growth</h3>
                <p class="text-xs text-slate-500 font-medium mt-1">Increased CGPA for 3 consecutive terms.</p>
            </div>
        </div>

        <!-- Badge 6: Perfect Score (Locked) -->
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 shadow-xs flex items-start gap-4 opacity-60">
            <div class="w-14 h-14 rounded-2xl bg-slate-200 text-slate-500 flex items-center justify-center font-black text-2xl shrink-0">
                <i class="fas fa-award"></i>
            </div>
            <div>
                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-slate-200 text-slate-600 uppercase">Locked</span>
                <h3 class="text-sm font-black text-slate-900 mt-1">100% Perfect Exam Score</h3>
                <p class="text-xs text-slate-500 font-medium mt-1">Score 100/100 in any semester final examination.</p>
            </div>
        </div>
    </div>

</div>
@endsection
