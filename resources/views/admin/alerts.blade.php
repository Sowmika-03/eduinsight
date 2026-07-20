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

<!-- Enterprise System Alerts Filter Bar -->
<form method="GET" action="{{ route('admin.alerts') }}" class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 mb-6 shadow-xs" x-data="{ selectedProgram: '{{ request('program') }}', selectedBranch: '{{ request('branch') }}' }">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-3 pb-3 border-b border-slate-100">
        <div class="flex items-center gap-2">
            <i class="fas fa-filter text-blue-600 text-sm"></i>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">System Warning Alerts Filter</h4>
        </div>
        <span class="text-[11px] text-slate-400 font-medium">Enterprise Filter &bull; Branch visible only for B.Tech</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:flex lg:flex-wrap items-end gap-3">
        <!-- 🔍 Search -->
        <div class="flex-1 min-w-[180px]">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Search</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search alert message, student..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" onkeydown="if(event.key==='Enter'){this.form.submit();}">
            </div>
        </div>

        <!-- Severity Dropdown -->
        <div class="w-full sm:w-auto min-w-[130px]">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Severity</label>
            <select name="severity" onchange="this.form.submit()" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <option value="">All Severities</option>
                <option value="high" {{ request('severity') === 'high' ? 'selected' : '' }}>High Severity</option>
                <option value="medium" {{ request('severity') === 'medium' ? 'selected' : '' }}>Medium Severity</option>
                <option value="low" {{ request('severity') === 'low' ? 'selected' : '' }}>Low Severity</option>
            </select>
        </div>

        <!-- Program Dropdown -->
        <div class="w-full sm:w-auto min-w-[140px]">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Program</label>
            <select name="program" x-model="selectedProgram" @change="if(selectedProgram !== 'B.Tech') { selectedBranch = ''; }; $el.form.submit()" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <option value="">All Programs</option>
                <option value="B.Tech" {{ request('program') === 'B.Tech' ? 'selected' : '' }}>B.Tech</option>
                <option value="MCA" {{ request('program') === 'MCA' ? 'selected' : '' }}>MCA</option>
                <option value="MBA" {{ request('program') === 'MBA' ? 'selected' : '' }}>MBA</option>
            </select>
        </div>

        <!-- Branch Dropdown (Visible ONLY for B.Tech) -->
        <div x-show="selectedProgram === 'B.Tech'" x-cloak class="w-full sm:w-auto min-w-[130px]">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Branch</label>
            <select name="branch" x-model="selectedBranch" @change="$el.form.submit()" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <option value="">All Branches</option>
                <option value="CSE" {{ request('branch') === 'CSE' ? 'selected' : '' }}>CSE</option>
                <option value="IT" {{ request('branch') === 'IT' ? 'selected' : '' }}>IT</option>
            </select>
        </div>

        <!-- Semester Dropdown -->
        <div class="w-full sm:w-auto min-w-[130px]">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Semester</label>
            <select name="semester" onchange="this.form.submit()" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <option value="">All Semesters</option>
                @for($i=1; $i<=8; $i++)
                    <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                @endfor
            </select>
        </div>

        <!-- Status Dropdown -->
        <div class="w-full sm:w-auto min-w-[130px]">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Status</label>
            <select name="status" onchange="this.form.submit()" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>

        <!-- Reset Button -->
        <div class="w-full sm:w-auto">
            <a href="{{ route('admin.alerts') }}" class="w-full sm:w-auto px-4 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition border border-slate-200 flex items-center justify-center gap-1.5">
                <i class="fas fa-undo text-[10px]"></i> Reset
            </a>
        </div>
    </div>
</form>

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
