@extends('layouts.app')

@section('title', 'Faculty Profile - ' . $faculty->user->name)

@section('content')

@php
    $facName = $faculty->user->name;
    $facEmpId = $faculty->employee_id;
    $facEmail = $faculty->user->email;
@endphp

<!-- Header -->
<div class="bg-white border border-slate-200 rounded-2xl p-6 mb-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-purple-600 mb-1">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Faculty Profile &bull; {{ $faculty->department }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            {{ $facName }}
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">
            Employee ID: <code class="bg-slate-100 px-1.5 py-0.5 rounded text-purple-700 font-mono">{{ $facEmpId }}</code> &bull; {{ $faculty->specialization }} &bull; {{ $faculty->experience_years }} Years Experience
        </p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <a href="{{ route('email.send', ['recipient_type' => 'student', 'subject' => 'HOD Department Notice', 'message' => "Dear {$facName},\n\nPlease contact HOD office regarding course allocations."]) }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-purple-600 hover:bg-purple-700 text-white transition shadow-2xs flex items-center gap-1.5">
            <i class="fas fa-paper-plane text-xs"></i>
            <span>Contact Faculty</span>
        </a>
        <a href="{{ route('hod.faculty') }}" class="px-4 py-2 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-xs"></i>
            <span>Back to Faculty</span>
        </a>
    </div>
</div>

<!-- Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Faculty Profile Info Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs h-full flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-purple-700 text-white flex items-center justify-center font-extrabold text-lg shadow-sm">
                    {{ strtoupper(substr($facName, 0, 2)) }}
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base leading-snug">{{ $facName }}</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $facEmail }}</p>
                </div>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Department</span>
                    <span class="font-extrabold text-slate-900">{{ $faculty->department }}</span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Specialization</span>
                    <span class="font-extrabold text-slate-900">{{ $faculty->specialization }}</span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Qualification</span>
                    <span class="font-extrabold text-slate-900">{{ $faculty->qualification }}</span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Experience</span>
                    <span class="font-extrabold text-slate-900">{{ $faculty->experience_years }} Years</span>
                </div>
                <div class="flex items-center justify-between py-1.5">
                    <span class="text-slate-500 font-medium">Status</span>
                    <span class="px-2.5 py-0.5 text-[10px] font-extrabold rounded-full bg-emerald-100 text-emerald-800 uppercase">
                        {{ $faculty->approval_status }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-100">
            <span class="text-[11px] text-slate-400 font-medium">Phone: {{ $faculty->user->phone ?? '+91 98765 43210' }}</span>
        </div>
    </div>

    <!-- Teaching Metrics KPI Cards -->
    <div class="lg:col-span-2 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-dashboard.kpi-card 
                title="Active Courses" 
                value="{{ $totalCourses }}" 
                icon="fas fa-book-open" 
                color="purple" 
                change="Assigned Workload" 
                changeType="neutral" 
                subtitle="Department Offerings" />

            <x-dashboard.kpi-card 
                title="Total Enrolled Students" 
                value="{{ $totalStudents }}" 
                icon="fas fa-users" 
                color="blue" 
                change="Student Reach" 
                changeType="neutral" 
                subtitle="Across All Courses" />

            <x-dashboard.kpi-card 
                title="Avg Class Attendance" 
                value="{{ round($attendancePercent, 1) }}%" 
                icon="fas fa-calendar-check" 
                color="emerald" 
                change="Student Class Rate" 
                changeType="up" 
                subtitle="Target: 75.0%" />
        </div>

        <!-- Performance Summary Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">Teaching Performance Evaluation</h4>
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider block text-emerald-700">High Performing Staff</span>
                    <p class="text-sm font-extrabold mt-0.5">Satisfactory Course Completion & High Attendance</p>
                    <p class="text-xs text-emerald-600 mt-1 font-medium">Faculty maintains strong student engagement across all assigned course modules.</p>
                </div>
                <i class="fas fa-award text-3xl text-emerald-500"></i>
            </div>
        </div>
    </div>
</div>

<!-- Courses Taught Table -->
<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs mb-8">
    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Assigned Department Courses</h3>
        <span class="text-xs text-slate-400 font-semibold">{{ $courses->total() }} Courses</span>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th>Course Code & Title</th>
                    <th>Credits</th>
                    <th>Enrolled Students</th>
                    <th>Semester</th>
                    <th>Total Classes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($courses as $course)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td>
                            <code class="px-2 py-0.5 text-[11px] rounded bg-slate-100 text-purple-700 font-mono font-bold">{{ $course->course_code }}</code>
                            <span class="font-bold text-slate-900 block mt-0.5 text-xs">{{ $course->course_name }}</span>
                        </td>
                        <td>
                            <span class="px-2 py-0.5 text-xs font-extrabold rounded bg-slate-100 text-slate-700">{{ $course->credits }} Credits</span>
                        </td>
                        <td>
                            <span class="px-2.5 py-0.5 text-xs font-extrabold rounded-full bg-blue-50 text-blue-700">{{ $course->enrollments()->count() }} Enrolled</span>
                        </td>
                        <td class="text-xs text-slate-700 font-semibold">
                            Semester {{ $course->semester }}
                        </td>
                        <td class="text-xs text-slate-500 font-medium">
                            {{ $course->total_classes ?? 45 }} Sessions
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-slate-400 py-6">
                            No courses assigned to this faculty member.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-slate-200 bg-slate-50/50">
        {{ $courses->links() }}
    </div>
</div>

@endsection
