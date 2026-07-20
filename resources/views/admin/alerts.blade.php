@extends('layouts.app')

@section('title', 'System Warning Alerts')

@section('content')

<x-dashboard.section-header 
    title="System Warning & Risk Alerts" 
    subtitle="Automated system alerts logged for attendance drops, low exam scores, and risk evaluations" 
    badge="Live Alerts">
    <x-slot:actions>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary text-xs">
            <i class="fas fa-arrow-left"></i> Back to Command Center
        </a>
    </x-slot:actions>
</x-dashboard.section-header>

<div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs mb-8">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Alert Type</th>
                    <th>Message</th>
                    <th>Severity</th>
                    <th>Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alerts as $alert)
                    @php
                        $studentUser = $alert->student?->user;
                        $studentName = $studentUser?->name ?? 'Student';
                        $courseCode = $alert->course?->course_code ?? 'Course';
                        
                        $emailShortcutUrl = route('email.send', [
                            'recipient_type' => 'student',
                            'student_id'     => $alert->student_id,
                            'subject'        => "Academic Alert Notice - {$courseCode}",
                            'message'        => "Dear Parent/Student,\n\nThis is an automated alert regarding {$studentName} in course {$courseCode}.\n\nAlert Message: {$alert->message}\nSeverity: " . ucfirst($alert->severity) . "\n\nPlease contact your department advisor for mentoring.\n\nRegards,\nEduInsight Platform Administrator"
                        ]);
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition duration-150">
                        <td>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($studentName, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block leading-tight">{{ $studentName }}</span>
                                    <span class="text-[11px] text-slate-400 font-mono leading-tight">{{ $alert->student?->student_id ?? '' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-xs font-bold text-slate-800 block">{{ $alert->course?->course_code ?? 'N/A' }}</span>
                            <span class="text-[11px] text-slate-500 font-medium">{{ $alert->course?->course_name ?? 'General' }}</span>
                        </td>
                        <td>
                            <span class="px-2.5 py-0.5 text-[10px] font-bold rounded bg-slate-100 text-slate-700 uppercase tracking-wider border border-slate-200">
                                {{ str_replace('_', ' ', $alert->alert_type) }}
                            </span>
                        </td>
                        <td class="text-xs text-slate-600 font-medium max-w-xs truncate">
                            {{ $alert->message }}
                        </td>
                        <td>
                            @if($alert->severity === 'high')
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-800 border border-red-200">HIGH SEVERITY</span>
                            @elseif($alert->severity === 'medium')
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">MEDIUM SEVERITY</span>
                            @else
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">LOW SEVERITY</span>
                            @endif
                        </td>
                        <td class="text-xs text-slate-500 font-medium">
                            {{ $alert->alert_date ? $alert->alert_date->format('M d, Y') : 'Recent' }}
                        </td>
                        <td class="text-right">
                            <a href="{{ $emailShortcutUrl }}" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition border border-blue-100">
                                <i class="fas fa-paper-plane text-[10px]"></i> Send Email
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-slate-400 py-8">
                            No warning alerts found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $alerts->links() }}
    </div>
</div>

@endsection
