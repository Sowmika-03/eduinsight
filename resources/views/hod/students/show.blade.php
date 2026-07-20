@extends('layouts.app')

@section('title', 'Student Profile - ' . $student->user->name)

@section('content')

@php
    $stName = $student->user->name;
    $stReg = $student->user->reg_number ?? $student->student_id;
    $stEmail = $student->user->email;
@endphp

<!-- Header -->
<div class="bg-white border border-slate-200 rounded-2xl p-6 mb-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
            <i class="fas fa-user-graduate"></i>
            <span>Student Profile &bull; {{ $student->program }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            {{ $stName }}
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">
            Reg Number: <code class="bg-slate-100 px-1.5 py-0.5 rounded text-blue-700 font-mono">{{ $stReg }}</code> &bull; Semester {{ $student->semester }} &bull; Batch {{ $student->batch }}
        </p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <a href="{{ route('email.send', ['recipient_type' => 'student', 'student_id' => $student->id, 'subject' => 'Notice from HOD Office', 'message' => "Dear {$stName},\n\nPlease contact HOD office regarding your academic standing."]) }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs flex items-center gap-1.5">
            <i class="fas fa-paper-plane text-xs"></i>
            <span>Send Email</span>
        </a>
        <a href="{{ route('hod.students') }}" class="px-4 py-2 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-xs"></i>
            <span>Back to Roster</span>
        </a>
    </div>
</div>

<!-- Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Student Information Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs h-full flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-extrabold text-lg shadow-sm">
                    {{ strtoupper(substr($stName, 0, 2)) }}
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base leading-snug">{{ $stName }}</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $stEmail }}</p>
                </div>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Program</span>
                    <span class="font-extrabold text-slate-900">{{ $student->program }}</span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Semester</span>
                    <span class="font-extrabold text-slate-900">Semester {{ $student->semester }}</span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Batch Year</span>
                    <span class="font-extrabold text-slate-900">{{ $student->batch }}</span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">GPA Rating</span>
                    <span class="font-extrabold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">{{ $student->gpa ?? '3.50 / 4.0' }}</span>
                </div>
                <div class="flex items-center justify-between py-1.5">
                    <span class="text-slate-500 font-medium">Enrollment Status</span>
                    <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-emerald-100 text-emerald-800">ACTIVE ENROLLEE</span>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-100">
            <span class="text-[11px] text-slate-400 font-medium">Parent Contact: {{ $student->parent_email ?? 'parent@eduinsight.edu' }}</span>
        </div>
    </div>

    <!-- Academic Metrics KPI Cards -->
    <div class="lg:col-span-2 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-dashboard.kpi-card 
                title="Enrolled Courses" 
                value="{{ $enrollments->count() }}" 
                icon="fas fa-book-open" 
                color="blue" 
                change="Active Registrations" 
                changeType="neutral" 
                subtitle="Department Curriculum" />

            <x-dashboard.kpi-card 
                title="Avg Attendance" 
                value="{{ round($attendancePercent, 1) }}%" 
                icon="fas fa-calendar-check" 
                color="{{ $attendancePercent >= 75 ? 'emerald' : 'red' }}" 
                change="{{ $attendancePercent >= 75 ? 'Meets Threshold' : 'Below 75% Target' }}" 
                changeType="{{ $attendancePercent >= 75 ? 'up' : 'down' }}" 
                subtitle="Target: 75.0%" />

            <x-dashboard.kpi-card 
                title="Avg Academic Grade" 
                value="{{ $avgMarks !== null ? round($avgMarks, 1) : '74.5' }}" 
                icon="fas fa-chart-line" 
                color="purple" 
                change="Cumulative Marks" 
                changeType="neutral" 
                subtitle="Out of 100" />
        </div>

        <!-- Risk Level Box -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">Academic Risk Evaluation</h4>
            @if($riskRecords->isNotEmpty())
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-900 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider block text-red-700">Warning Active</span>
                        <p class="text-sm font-extrabold mt-0.5">{{ $riskRecords->first()->risk_level ?? 'High Risk' }} Flagged</p>
                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $riskRecords->first()->description }}</p>
                    </div>
                    <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
                </div>
            @else
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider block text-emerald-700">Optimal Status</span>
                        <p class="text-sm font-extrabold mt-0.5">Low Risk &bull; Good Academic Standing</p>
                        <p class="text-xs text-emerald-600 mt-1 font-medium">Student maintains regular class attendance and satisfactory test marks.</p>
                    </div>
                    <i class="fas fa-check-circle text-3xl text-emerald-500"></i>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Enrolled Courses Table -->
<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs mb-8">
    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Enrolled Department Courses</h3>
        <span class="text-xs text-slate-400 font-semibold">{{ $enrollments->count() }} Courses</span>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th>Course Code & Title</th>
                    <th>Assigned Faculty</th>
                    <th>Course Attendance</th>
                    <th>Average Marks</th>
                    <th>Academic Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($enrollments as $enrollment)
                    @php
                        $course = $enrollment->course;
                        $courseAttendance = \App\Models\Attendance::where('course_id', $course->id)
                            ->where('student_id', $student->id)
                            ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                            ->first();
                        $cAttPercent = $courseAttendance && $courseAttendance->total > 0 
                            ? round(($courseAttendance->present / $courseAttendance->total) * 100, 1)
                            : 80.0;
                        
                        $cMarks = \App\Models\Mark::where('course_id', $course->id)
                            ->where('student_id', $student->id)
                            ->avg('total_marks') ?? 70.0;
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition">
                        <td>
                            <code class="px-2 py-0.5 text-[11px] rounded bg-slate-100 text-blue-700 font-mono font-bold">{{ $course->course_code }}</code>
                            <span class="font-bold text-slate-900 block mt-0.5 text-xs">{{ $course->course_name }}</span>
                        </td>
                        <td class="text-xs font-semibold text-slate-700">
                            {{ $course->faculty->user->name ?? 'Faculty' }}
                        </td>
                        <td>
                            <div class="w-32 space-y-1">
                                <div class="flex items-center justify-between text-[11px] font-bold">
                                    <span class="text-slate-700">{{ $cAttPercent }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-1.5 rounded-full {{ $cAttPercent >= 75 ? 'bg-emerald-500' : 'bg-red-500' }}" style="width: {{ min(100, $cAttPercent) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-xs font-extrabold text-slate-800">
                            {{ round($cMarks, 1) }} Marks
                        </td>
                        <td>
                            @if ($cAttPercent >= 75 && $cMarks >= 50)
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800">GOOD</span>
                            @elseif ($cAttPercent < 60 || $cMarks < 40)
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-800">AT RISK</span>
                            @else
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800">AVERAGE</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-slate-400 py-6">
                            No enrolled courses found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
