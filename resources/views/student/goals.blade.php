@extends('layouts.app')

@section('title', 'Academic Goals & Placement Targets')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-purple-600 mb-1">
                <i class="fas fa-bullseye"></i>
                <span>Personal Career & Academic Planning</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Academic Goals & Target Tracking
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Set CGPA benchmarks, track attendance targets, placement eligibility milestones, and AI progress monitoring.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- GOALS PROGRESS BARS & CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Goal 1: Target CGPA -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase text-slate-800 tracking-wider">Target CGPA Milestone</span>
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-black">95% Completed</span>
            </div>
            
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900">3.82 CGPA</span>
                <span class="text-xs font-bold text-slate-400">Target: 3.90 CGPA</span>
            </div>

            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500 rounded-full" style="width: 95%"></div>
            </div>

            <p class="text-xs text-slate-500 font-medium">
                You need <strong>42+ marks</strong> in remaining external exams to hit your 3.90 Target!
            </p>
        </div>

        <!-- Goal 2: Target Attendance -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase text-slate-800 tracking-wider">Target Attendance Percentage</span>
                <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-xs font-black">96% Completed</span>
            </div>
            
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900">86.4% Attendance</span>
                <span class="text-xs font-bold text-slate-400">Target: 90.0%</span>
            </div>

            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-blue-600 rounded-full" style="width: 96%"></div>
            </div>

            <p class="text-xs text-slate-500 font-medium">
                Attend next <strong>8 sessions continuously</strong> without missing to reach 90%!
            </p>
        </div>

        <!-- Goal 3: Campus Placement Eligibility -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase text-slate-800 tracking-wider">Campus Placement Qualification</span>
                <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 text-xs font-black">100% Qualified</span>
            </div>
            
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-purple-600">Eligible (Tier-1)</span>
                <span class="text-xs font-bold text-slate-400">Min: 3.20 CGPA</span>
            </div>

            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-purple-600 rounded-full" style="width: 100%"></div>
            </div>

            <p class="text-xs text-slate-500 font-medium">
                You meet all placement criteria (No active backlogs, CGPA &gt; 3.20, Attendance &gt; 75%).
            </p>
        </div>

        <!-- Goal 4: Academic Honors & Distinction -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase text-slate-800 tracking-wider">First Class with Distinction</span>
                <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-xs font-black">On Track</span>
            </div>
            
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-amber-600">Distinction Honors</span>
                <span class="text-xs font-bold text-slate-400">Min: 3.75 CGPA</span>
            </div>

            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-amber-500 rounded-full" style="width: 98%"></div>
            </div>

            <p class="text-xs text-slate-500 font-medium">
                Maintain your current standing into Semester 5 to secure Distinction graduation status.
            </p>
        </div>
    </div>

</div>
@endsection
