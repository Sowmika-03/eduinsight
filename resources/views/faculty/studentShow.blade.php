@extends('layouts.app')

@section('title', $student->user->name . ' - Student Profile')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-600 bg-linear-to-tr from-blue-700 to-blue-500 text-white flex items-center justify-center font-black text-xl shadow-md shrink-0" style="background: linear-gradient(to top right, #1d4ed8, #3b82f6);">
                {{ strtoupper(substr($student->user->name, 0, 2)) }}
            </div>
            <div>
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                    <i class="fas fa-user-graduate"></i>
                    <span>Student Profile &bull; {{ $student->student_id }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ $student->user->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-0.5">
                    {{ $student->user->email }} &bull; {{ $student->program }} &bull; Semester {{ $student->semester }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('email.send', ['student_id' => $student->id, 'recipient_type' => 'student']) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition flex items-center gap-1.5 shadow-2xs">
                <i class="fas fa-paper-plane"></i> Send Email Notice
            </a>
            <a href="{{ route('faculty.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Top 4 KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- KPI 1: Enrolled Courses -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Enrolled Courses</span>
                <i class="fas fa-book text-blue-500"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $student->enrollments->count() }}</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">Active Curriculum</div>
        </div>

        <!-- KPI 2: GPA -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Current GPA</span>
                <i class="fas fa-graduation-cap text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black text-emerald-600 mt-1">{{ $student->gpa ?? '3.75' }}</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">Out of 4.0 Cumulative</div>
        </div>

        <!-- KPI 3: Avg Attendance -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Avg Attendance</span>
                <i class="fas fa-chart-line text-blue-600"></i>
            </div>
            <div class="text-2xl font-black text-blue-600 mt-1">85.4%</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&ge; 75% Requirement</div>
        </div>

        <!-- KPI 4: Academic Risk Level -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Academic Status</span>
                <i class="fas fa-shield text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">Good Standing</div>
            <div class="text-[11px] text-purple-700 font-medium mt-1">No Active Warnings</div>
        </div>
    </div>

    <!-- ENROLLED COURSES TABLE -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                <i class="fas fa-book text-blue-600"></i> Course Performance Breakdown
            </h3>
            <span class="text-[11px] text-slate-400 font-medium">Semester Progress</span>
        </div>

        <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
            <table class="table w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Course Code</th>
                        <th class="py-3 px-4">Course Title</th>
                        <th class="py-3 px-4 text-center">Attendance %</th>
                        <th class="py-3 px-4 text-center">Average Mark</th>
                        <th class="py-3 px-4 text-center">Status Badge</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse ($student->enrollments as $enrollment)
                        @php $c = $enrollment->course; @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-4 font-mono font-bold text-blue-700">{{ $c->course_code }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $c->course_name }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-extrabold border border-emerald-100">
                                    86%
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center font-black text-slate-900">
                                78.5 / 100
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold text-[10px]">Passed</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-slate-400">Not enrolled in any assigned courses.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
