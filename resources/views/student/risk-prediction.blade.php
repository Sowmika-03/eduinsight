@extends('layouts.app')

@section('title', 'Student Risk Analysis & Academic Standing')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">
                <i class="fas fa-triangle-exclamation"></i>
                <span>Academic Risk Monitoring Engine</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Personal Academic Risk Analysis
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                ML-powered failure probability assessment, attendance risk thresholds, and proactive academic intervention recommendations.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- TRAFFIC LIGHT STATUS & TOP KPIS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- KPI 1: Overall Risk Score -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Personal Risk Score</span>
                <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm" title="Low Risk Standing"></span>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">Low Risk (4%)</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">Safe Academic Standing</div>
        </div>

        <!-- KPI 2: Attendance Risk -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Attendance Risk</span>
                <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm"></span>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">86.4% <span class="text-xs font-normal text-slate-400">/ 75%</span></div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">+11.4% Buffer Above Threshold</div>
        </div>

        <!-- KPI 3: Academic Marks Risk -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Academic Score Risk</span>
                <span class="w-3 h-3 rounded-full bg-amber-500 shadow-sm"></span>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">Minor Focus</div>
            <div class="text-[11px] text-amber-700 font-bold mt-1">1 Subject Needing Focus</div>
        </div>

        <!-- KPI 4: Failure Probability -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Failure Probability</span>
                <i class="fas fa-shield text-blue-500"></i>
            </div>
            <div class="text-2xl font-black text-blue-600 mt-1">1.2%</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">Negligible Failure Risk</div>
        </div>
    </div>

    <!-- AI EXPLANATION & ACTION ADVISORY -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- AI Explanation Card -->
        <div class="lg:col-span-2 bg-slate-900 bg-linear-to-r from-slate-900 via-amber-950 to-slate-900 text-white rounded-2xl p-6 shadow-xs flex flex-col justify-between border border-amber-900" style="background: linear-gradient(to right, #0f172a, #451a03, #0f172a);">
            <div>
                <div class="flex items-center justify-between text-xs font-extrabold uppercase tracking-wider text-amber-300 mb-2">
                    <span>EduInsight AI Risk Advisory</span>
                    <i class="fas fa-robot text-amber-300"></i>
                </div>
                <h3 class="text-lg font-black text-white tracking-tight">
                    Academic Standing: Satisfactory with Minor Attention Required
                </h3>
                <p class="text-xs text-amber-100 font-medium leading-relaxed mt-2">
                    The predictive ML model evaluates your profile at <strong>4% Low Risk</strong>. Your overall attendance and marks across 3 of 4 subjects are well above university standards. Only <strong>Data Structures (68/100)</strong> presents a minor score gap requiring practice before finals.
                </p>
            </div>

            <div class="mt-4 pt-3 border-t border-amber-800/60 flex items-center justify-between text-xs">
                <span class="text-amber-200 font-semibold">Intervention Required: No</span>
                <a href="{{ route('student.ai') }}" class="px-3.5 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-bold transition flex items-center gap-1.5">
                    <i class="fas fa-brain text-xs"></i> Ask AI Assistant
                </a>
            </div>
        </div>

        <!-- Faculty Advisor Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-3 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fas fa-user-tie text-blue-600"></i> Assigned Faculty Advisor
                </h4>
                <div class="text-sm font-extrabold text-slate-900">Dr. Bala Murali Krishna</div>
                <div class="text-xs text-slate-500 mt-0.5">Professor & Senior Academic Counselor</div>
                <p class="text-xs text-slate-600 font-medium mt-3 leading-relaxed">
                    "Maintain current momentum. Feel free to drop by during office hours for guidance on your academic path."
                </p>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <a href="mailto:drbalamuralikrishna@gmail.com" class="px-3.5 py-1.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-xs transition inline-flex items-center gap-1.5">
                    <i class="fas fa-envelope text-xs"></i> Contact Advisor
                </a>
            </div>
        </div>
    </div>

    <!-- RISK RECORDS LOG TABLE -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                <i class="fas fa-list-check text-slate-800"></i> Academic Risk Flags Log
            </h3>
            <span class="text-[11px] text-slate-400 font-medium">Historical Records</span>
        </div>

        <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
            <table class="table w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Risk Category</th>
                        <th class="py-3 px-4">Course Affected</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4 text-center">Severity Level</th>
                        <th class="py-3 px-4 text-right">Date Flagged</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($risks as $risk)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-4 font-bold text-slate-900">{{ ucfirst(str_replace('_', ' ', $risk->risk_type)) }}</td>
                            <td class="py-3 px-4 font-mono font-bold text-blue-700">{{ $risk->course->course_code ?? 'All Courses' }}</td>
                            <td class="py-3 px-4 text-slate-600 font-medium">{{ $risk->description }}</td>
                            <td class="py-3 px-4 text-center">
                                @if($risk->risk_level === 'High Risk')
                                    <span class="px-2.5 py-1 rounded-lg bg-red-50 text-red-700 font-extrabold border border-red-100">High Risk</span>
                                @elseif($risk->risk_level === 'Medium Risk')
                                    <span class="px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 font-extrabold border border-amber-100">Medium Risk</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-extrabold border border-emerald-100">Low Risk</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right font-mono text-slate-500">{{ $risk->created_at ? $risk->created_at->format('M d, Y') : 'Recent' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-emerald-600 font-bold">
                                <i class="fas fa-check-circle text-lg mr-1"></i> No academic risk alerts flagged on your profile!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
