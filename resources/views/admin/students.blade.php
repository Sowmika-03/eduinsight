@extends('layouts.app')

@section('title', 'Student Records')

@section('content')

<x-dashboard.section-header 
    title="Enrolled Student Directory" 
    subtitle="Institutional records for 200 enrolled students across MCA, B.Tech CSE, IT, and MBA programs" 
    badge="200 Students">
    <x-slot:actions>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary text-xs">
            <i class="fas fa-arrow-left"></i> Back to Command Center
        </a>
    </x-slot:actions>
</x-dashboard.section-header>

<!-- Enterprise Student Directory Filter Bar -->
<form method="GET" action="{{ route('admin.students') }}" class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 mb-6 shadow-xs" x-data="{ selectedProgram: '{{ request('program') }}', selectedBranch: '{{ request('branch') }}' }">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-3 pb-3 border-b border-slate-100">
        <div class="flex items-center gap-2">
            <i class="fas fa-filter text-blue-600 text-sm"></i>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Student Directory Filter Bar</h4>
        </div>
        <span class="text-[11px] text-slate-400 font-medium">Enterprise Filter &bull; Branch visible only for B.Tech</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:flex lg:flex-wrap items-end gap-3">
        <!-- 🔍 Search Student -->
        <div class="flex-1 min-w-[180px]">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Search Student</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search student name, ID or email..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" onkeydown="if(event.key==='Enter'){this.form.submit();}">
            </div>
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

        <!-- Risk Dropdown -->
        <div class="w-full sm:w-auto min-w-[130px]">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Risk</label>
            <select name="risk" onchange="this.form.submit()" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <option value="">All Risks</option>
                <option value="High Risk" {{ request('risk') === 'High Risk' ? 'selected' : '' }}>High Risk</option>
                <option value="Medium Risk" {{ request('risk') === 'Medium Risk' ? 'selected' : '' }}>Medium Risk</option>
                <option value="Low Risk" {{ request('risk') === 'Low Risk' ? 'selected' : '' }}>Low Risk</option>
            </select>
        </div>

        <!-- Attendance Dropdown -->
        <div class="w-full sm:w-auto min-w-[140px]">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Attendance</label>
            <select name="attendance" onchange="this.form.submit()" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <option value="">All Attendance</option>
                <option value="75_above" {{ request('attendance') === '75_above' ? 'selected' : '' }}>&ge; 75% Attendance</option>
                <option value="75_below" {{ request('attendance') === '75_below' ? 'selected' : '' }}>&lt; 75% Attendance</option>
            </select>
        </div>

        <!-- Reset Button -->
        <div class="w-full sm:w-auto">
            <a href="{{ route('admin.students') }}" class="w-full sm:w-auto px-4 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition border border-slate-200 flex items-center justify-center gap-1.5">
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
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Email Address</th>
                    <th>Program & Branch</th>
                    <th>Semester</th>
                    <th>Overall Risk Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr class="hover:bg-slate-50/80 transition duration-150">
                        <!-- Student ID -->
                        <td>
                            <span class="font-mono text-xs font-bold text-slate-900 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                {{ $student->student_id }}
                            </span>
                        </td>

                        <!-- Name & Avatar -->
                        <td>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                </div>
                                <span class="font-bold text-slate-900 text-xs">{{ $student->user->name }}</span>
                            </div>
                        </td>

                        <!-- Email -->
                        <td class="text-xs text-slate-600 font-medium">
                            {{ $student->user->email }}
                        </td>

                        <!-- Program & Branch -->
                        <td>
                            <span class="text-xs font-semibold text-slate-800">{{ $student->program }}</span>
                            <span class="text-[11px] text-slate-500 font-medium block">Batch {{ $student->batch ?? $student->admission_year }}</span>
                        </td>

                        <!-- Semester -->
                        <td>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded bg-blue-50 text-blue-700 border border-blue-100">
                                Semester {{ $student->semester }}
                            </span>
                        </td>

                        <!-- Risk Status -->
                        <td>
                            @php
                                $maxRisk = $student->academicRisks->max('risk_level');
                            @endphp
                            @if($maxRisk === 'High Risk')
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-800 border border-red-200">HIGH RISK</span>
                            @elseif($maxRisk === 'Medium Risk')
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">MEDIUM RISK</span>
                            @else
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">LOW RISK</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="text-right">
                            <a href="{{ route('email.send', ['recipient_type' => 'student', 'student_id' => $student->id, 'subject' => 'Academic Notice - ' . $student->student_id]) }}" 
                               class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition border border-blue-100">
                                <i class="fas fa-paper-plane text-[10px]"></i> Send Email
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-slate-400 py-8">
                            No student records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>

@endsection
