@extends('layouts.app')

@section('title', 'Student Alerts & Warnings')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-red-600 mb-1">
                <i class="fas fa-bell"></i>
                <span>Academic System Alerts</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                My Academic Alerts & Warnings
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Official alerts triggered by faculty or automated risk monitoring engines.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- ALERTS TABLE -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
            <table class="table w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Alert Type</th>
                        <th class="py-3 px-4">Course Name</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4 text-center">Severity</th>
                        <th class="py-3 px-4 text-right">Date Flagged</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($alerts as $alert)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-4 font-bold text-slate-900">{{ ucfirst(str_replace('_', ' ', $alert->alert_type)) }}</td>
                            <td class="py-3 px-4 font-mono font-bold text-blue-700">{{ $alert->course->course_name ?? 'General' }}</td>
                            <td class="py-3 px-4 text-slate-600 font-medium">{{ $alert->message ?? 'Academic monitoring alert.' }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-lg {{ $alert->severity === 'high' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700' }} font-extrabold">
                                    {{ ucfirst($alert->severity) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right font-mono text-slate-500">{{ $alert->alert_date ? $alert->alert_date->format('M d, Y') : 'Recent' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-emerald-600 font-bold">
                                <i class="fas fa-check-circle text-lg mr-1"></i> No active academic alerts logged on your profile.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $alerts->links() }}
        </div>
    </div>

</div>
@endsection
