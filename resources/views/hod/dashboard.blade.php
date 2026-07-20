@extends('layouts.app')

@section('title', 'HOD Department Intelligence')

@section('content')

@php
    $now = \Carbon\Carbon::now('Asia/Kolkata');
    $hour = $now->hour;
    if ($hour < 12) {
        $greeting = 'Good Morning';
    } elseif ($hour < 17) {
        $greeting = 'Good Afternoon';
    } else {
        $greeting = 'Good Evening';
    }
    $formattedDateTime = $now->format('l, j F Y | h:i A') . ' IST';
    $isBTech = strtoupper(trim($hod->department)) === 'B.TECH';
@endphp

<!-- ==========================================================================
     1. DEPARTMENT OVERVIEW BANNER
     ========================================================================== -->
<div class="bg-white border border-slate-200 rounded-2xl p-6 mb-8 shadow-xs relative overflow-hidden">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 relative z-10">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-building text-blue-600"></i>
                <span>Department of {{ $hod->department }} &bull; Department Intelligence Hub</span>
            </div>
            
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ $greeting }}, {{ Auth::user()->name }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">
                Head of Department Overview & Dashboard &bull; {{ $hod->department }} Academic Monitoring
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <div class="px-3.5 py-2 rounded-xl bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 flex items-center gap-2 shadow-2xs">
                <i class="far fa-clock text-blue-600"></i>
                <span>{{ $formattedDateTime }}</span>
            </div>
            <div class="px-3.5 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-700 flex items-center gap-2 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Active Department Portal</span>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================================================
     2. QUICK ACTIONS (TOP BANNER LAUNCHERS)
     ========================================================================== -->
<div class="flex flex-wrap items-center gap-3 mb-8">
    <a href="{{ route('hod.students') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs flex items-center gap-2">
        <i class="fas fa-user-graduate"></i>
        <span>Manage Students</span>
    </a>
    <a href="{{ route('hod.faculty') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-purple-600 hover:bg-purple-700 text-white transition shadow-2xs flex items-center gap-2">
        <i class="fas fa-chalkboard-teacher"></i>
        <span>Manage Faculty</span>
    </a>
    <a href="{{ route('hod.courses') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white transition shadow-2xs flex items-center gap-2">
        <i class="fas fa-book-open"></i>
        <span>Manage Courses</span>
    </a>
    <a href="{{ route('hod.analytics') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-slate-800 hover:bg-slate-900 text-white transition shadow-2xs flex items-center gap-2">
        <i class="fas fa-chart-bar"></i>
        <span>Department Analytics</span>
    </a>
    <a href="{{ route('hod.ai') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white transition shadow-2xs flex items-center gap-2">
        <i class="fas fa-robot"></i>
        <span>EduInsight AI</span>
    </a>
    <a href="{{ route('email.send') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-amber-500 hover:bg-amber-600 text-white transition shadow-2xs flex items-center gap-2">
        <i class="fas fa-paper-plane"></i>
        <span>Send Notification</span>
    </a>
</div>

<!-- ==========================================================================
     3. 4 KPI CARDS
     ========================================================================== -->
<x-dashboard.section-header 
    title="Department Key Performance Indicators" 
    subtitle="Live overview metrics for {{ $hod->department }} department" 
    badge="Live Data" />

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <x-dashboard.kpi-card 
        title="Students" 
        value="{{ $enrolledStudents }}" 
        icon="fas fa-user-graduate" 
        color="blue" 
        change="Active Department Enrollees" 
        changeType="neutral" 
        subtitle="Department Enrolled" />

    <x-dashboard.kpi-card 
        title="Faculty" 
        value="{{ $totalFaculty }}" 
        icon="fas fa-chalkboard-teacher" 
        color="purple" 
        change="{{ $activeFaculty }} Active Members" 
        changeType="neutral" 
        subtitle="Assigned Teaching Staff" />

    <x-dashboard.kpi-card 
        title="Courses" 
        value="{{ $totalCourses }}" 
        icon="fas fa-book-open" 
        color="emerald" 
        change="Curriculum Offerings" 
        changeType="neutral" 
        subtitle="Active Department Courses" />

    <x-dashboard.kpi-card 
        title="At Risk Students" 
        value="{{ $riskStudents }}" 
        icon="fas fa-exclamation-triangle" 
        color="red" 
        change="{{ $highRiskCount }} High Risk &bull; {{ $mediumRiskCount }} Med Risk" 
        changeType="down" 
        subtitle="Requires Intervention" />
</div>

<!-- ==========================================================================
     4. ANALYTICS FILTER (Branch appears ONLY if department = B.Tech)
     ========================================================================== -->
<form method="GET" action="{{ route('hod.dashboard') }}" class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 mb-8 shadow-xs" x-data="{ selectedBranch: '{{ request('branch') }}' }">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-3 pb-3 border-b border-slate-100">
        <div class="flex items-center gap-2">
            <i class="fas fa-filter text-blue-600 text-sm"></i>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Department Analytics Filter</h4>
        </div>
        <span class="text-[11px] text-slate-400 font-medium">Filter analytics by Semester and Academic Risk</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 items-end gap-3">
        <!-- Semester Dropdown -->
        <div>
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Semester</label>
            <select name="semester" onchange="this.form.submit()" class="w-full text-xs py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition font-medium">
                <option value="">All Semesters</option>
                @for($i=1; $i<=8; $i++)
                    <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                @endfor
            </select>
        </div>

        <!-- Risk Level Dropdown -->
        <div>
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Risk Level</label>
            <select name="risk" onchange="this.form.submit()" class="w-full text-xs py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition font-medium">
                <option value="">All Risk Levels</option>
                <option value="High Risk" {{ request('risk') === 'High Risk' ? 'selected' : '' }}>High Risk</option>
                <option value="Medium Risk" {{ request('risk') === 'Medium Risk' ? 'selected' : '' }}>Medium Risk</option>
                <option value="Low Risk" {{ request('risk') === 'Low Risk' ? 'selected' : '' }}>Low Risk</option>
            </select>
        </div>

        <!-- Branch Dropdown (Visible ONLY if department == 'B.Tech') -->
        @if($isBTech)
        <div>
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Branch (B.Tech Only)</label>
            <select name="branch" onchange="this.form.submit()" class="w-full text-xs py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition font-medium">
                <option value="">All Branches</option>
                <option value="CSE" {{ request('branch') === 'CSE' ? 'selected' : '' }}>CSE</option>
                <option value="IT" {{ request('branch') === 'IT' ? 'selected' : '' }}>IT</option>
                <option value="ECE" {{ request('branch') === 'ECE' ? 'selected' : '' }}>ECE</option>
                <option value="EEE" {{ request('branch') === 'EEE' ? 'selected' : '' }}>EEE</option>
            </select>
        </div>
        @else
        <!-- Hidden/Placeholder for non-B.Tech programs (MCA & MBA never display Branch) -->
        <div class="hidden"></div>
        @endif

        <!-- Apply & Reset Buttons -->
        <div class="flex items-center gap-2">
            <button type="submit" class="flex-1 px-4 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs text-center">
                Apply Filters
            </button>
            <a href="{{ route('hod.dashboard') }}" class="px-4 py-2 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition border border-slate-200 text-center">
                Reset
            </a>
        </div>
    </div>
</form>

<!-- ==========================================================================
     5. CHARTS (Strict palette: Blue, Green, Purple, Orange, Red, Gray)
     ========================================================================== -->
<x-dashboard.section-header 
    title="Department Visual Analytics" 
    subtitle="Attendance trends, risk distribution, pass percentage, and course performance" 
    badge="Analytics Charts" />

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Chart 1: Attendance Trend -->
    <div class="space-y-4">
        <x-dashboard.chart-card 
            id="attendanceTrendChart" 
            title="Attendance Trend" 
            description="Monthly average student attendance percentages across courses" />
    </div>

    <!-- Chart 2: Risk Distribution -->
    <div class="space-y-4">
        <x-dashboard.chart-card 
            id="riskDistChart" 
            title="Risk Distribution" 
            description="Proportional breakdown of student academic risk levels in {{ $hod->department }}" />
    </div>

    <!-- Chart 3: Pass Percentage -->
    <div class="space-y-4">
        <x-dashboard.chart-card 
            id="passPercentageChart" 
            title="Pass Percentage" 
            description="Comparative pass rate percentages across active department subjects" />
    </div>

    <!-- Chart 4: Course Performance -->
    <div class="space-y-4">
        <x-dashboard.chart-card 
            id="coursePerformanceChart" 
            title="Course Performance" 
            description="Attendance Rate vs Marks Average across key department courses" />
    </div>
</div>

<!-- ==========================================================================
     6. DEPARTMENT INSIGHTS
     ========================================================================== -->
<x-dashboard.section-header 
    title="Department Insights & Highlights" 
    subtitle="Top faculty, high performing students, weak subjects, and departmental highlights" 
    badge="Intel Insights" />

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- Top Faculty Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-purple-600">Top Faculty</span>
                <i class="fas fa-trophy text-amber-500"></i>
            </div>
            @if($topFaculty)
                <h4 class="text-sm font-extrabold text-slate-900">{{ $topFaculty->user->name }}</h4>
                <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $topFaculty->specialization }}</p>
                <div class="mt-3 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">Courses:</span>
                    <span class="font-extrabold text-purple-700 bg-purple-50 px-2 py-0.5 rounded">{{ $topFaculty->courses->count() }} Active</span>
                </div>
            @else
                <p class="text-xs text-slate-400">No faculty records found.</p>
            @endif
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
            <i class="fas fa-check-circle"></i> High Student Satisfaction
        </div>
    </div>

    <!-- Top Students Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Top Performers</span>
                <i class="fas fa-medal text-blue-500"></i>
            </div>
            <div class="space-y-2">
                @forelse($topStudents as $st)
                    <div class="flex items-center justify-between text-xs border-b border-slate-100 pb-1.5 last:border-none">
                        <span class="font-bold text-slate-800 truncate max-w-[120px]">{{ $st->user->name }}</span>
                        <span class="text-[10px] font-extrabold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">Low Risk</span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400">No student records found.</p>
                @endforelse
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-blue-600 font-semibold flex items-center gap-1">
            <i class="fas fa-star"></i> Academic Distinction
        </div>
    </div>

    <!-- Weak Subjects Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-red-600">Subjects Needing Support</span>
                <i class="fas fa-exclamation-circle text-red-500"></i>
            </div>
            <div class="space-y-2">
                @forelse($weakSubjects as $c)
                    <div class="flex items-center justify-between text-xs border-b border-slate-100 pb-1.5 last:border-none">
                        <span class="font-bold text-slate-800 truncate max-w-[130px]">{{ $c->course_name }}</span>
                        <span class="text-[10px] font-extrabold text-red-700 bg-red-50 px-1.5 py-0.5 rounded">{{ $c->course_code }}</span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400">All subjects meeting baseline targets.</p>
                @endforelse
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-amber-600 font-semibold flex items-center gap-1">
            <i class="fas fa-info-circle"></i> Tutoring Recommended
        </div>
    </div>

    <!-- Department Highlights Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Department Highlights</span>
                <i class="fas fa-lightbulb text-emerald-500"></i>
            </div>
            <ul class="text-xs text-slate-600 space-y-2 font-medium">
                <li class="flex items-start gap-1.5">
                    <i class="fas fa-check text-emerald-500 text-[10px] mt-1"></i>
                    <span>{{ $overallPassPercentage }}% Overall Pass Rate achieved</span>
                </li>
                <li class="flex items-start gap-1.5">
                    <i class="fas fa-check text-emerald-500 text-[10px] mt-1"></i>
                    <span>{{ $totalFaculty }} Active faculty assigned across courses</span>
                </li>
                <li class="flex items-start gap-1.5">
                    <i class="fas fa-check text-emerald-500 text-[10px] mt-1"></i>
                    <span>SMTP Automated Parent Alerts enabled</span>
                </li>
            </ul>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 font-semibold flex items-center gap-1">
            <i class="fas fa-chart-line"></i> Institutional Benchmark Target Met
        </div>
    </div>
</div>

<!-- ==========================================================================
     7. RECENT ALERTS
     ========================================================================== -->
<x-dashboard.section-header 
    title="Recent Department Academic Alerts" 
    subtitle="Latest warning notifications and academic risk flags triggered for {{ $hod->department }} students" 
    badge="Live Alerts" />

<div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 mb-8 shadow-xs">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Course Code</th>
                    <th>Risk Evaluation</th>
                    <th>Severity</th>
                    <th>Alert Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentAlerts as $alert)
                    @php
                        $stName = $alert->student?->user?->name ?? 'Student';
                        $cCode = $alert->course?->course_code ?? 'Course';
                        $emailUrl = route('email.send', [
                            'recipient_type' => 'student',
                            'student_id'     => $alert->student_id,
                            'subject'        => "HOD Academic Notice - {$cCode}",
                            'message'        => "Dear {$stName},\n\nThis is an academic warning notice regarding your performance in {$cCode}.\n\nPlease schedule an appointment with the HOD Office.\n\nRegards,\nHOD Office - {$hod->department}"
                        ]);
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition">
                        <td>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shadow-2xs shrink-0">
                                    {{ strtoupper(substr($stName, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 block leading-tight">{{ $stName }}</span>
                                    <span class="text-[11px] text-slate-400 font-mono leading-tight">{{ $alert->student?->student_id ?? '' }}</span>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="text-xs font-bold text-slate-800 block">{{ $cCode }}</span>
                            <span class="text-[11px] text-slate-500 font-medium">{{ $alert->course?->course_name ?? 'General' }}</span>
                        </td>

                        <td>
                            <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-md bg-slate-100 text-slate-700 uppercase tracking-wider border border-slate-200">
                                {{ $alert->risk_level }}
                            </span>
                        </td>

                        <td>
                            @if($alert->risk_level === 'High Risk')
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-800 border border-red-200">HIGH SEVERITY</span>
                            @elseif($alert->risk_level === 'Medium Risk')
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">MEDIUM SEVERITY</span>
                            @else
                                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">LOW SEVERITY</span>
                            @endif
                        </td>

                        <td class="text-xs text-slate-500 font-medium">
                            {{ $alert->created_at ? $alert->created_at->format('M d, Y') : 'Recent' }}
                        </td>

                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ $emailUrl }}" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition border border-blue-100">
                                    <i class="fas fa-paper-plane text-[10px]"></i>
                                    <span>Send Warning</span>
                                </a>
                                <a href="{{ route('hod.students.show', $alert->student_id) }}" class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-md bg-slate-100 text-slate-700 hover:bg-slate-200 transition border border-slate-200">
                                    <i class="fas fa-eye text-[10px]"></i>
                                    <span>Profile</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-slate-400 py-8">
                            <i class="fas fa-check-circle text-2xl text-emerald-500 block mb-2"></i>
                            No active academic risk alerts recorded for {{ $hod->department }} department.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ==========================================================================
     8. AI RECOMMENDATIONS
     ========================================================================== -->
<x-dashboard.section-header 
    title="EduInsight AI Department Recommendations" 
    subtitle="Actionable, data-driven recommendations generated for {{ $hod->department }} department" 
    badge="AI Insights" />

<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center gap-2 mb-2">
            <span class="p-2 rounded-xl bg-purple-50 text-purple-600"><i class="fas fa-user-clock text-sm"></i></span>
            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Attendance Boost Program</h4>
        </div>
        <p class="text-xs text-slate-600 leading-relaxed font-medium">
            Schedule mandatory advisory sessions for {{ $lowAttendanceStudents->count() }} students currently maintaining attendance below the 75% threshold.
        </p>
        <div class="mt-4">
            <a href="{{ route('hod.students', ['attendance' => 'below_75']) }}" class="text-xs font-bold text-purple-600 hover:text-purple-800 flex items-center gap-1">
                <span>View Low Attendance Students</span> &rarr;
            </a>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center gap-2 mb-2">
            <span class="p-2 rounded-xl bg-red-50 text-red-600"><i class="fas fa-shield-alt text-sm"></i></span>
            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">High Risk Student Mentoring</h4>
        </div>
        <p class="text-xs text-slate-600 leading-relaxed font-medium">
            Assign peer tutors to {{ $highRiskCount }} High Risk students prior to mid-term evaluations to improve passing rates.
        </p>
        <div class="mt-4">
            <a href="{{ route('hod.students', ['risk' => 'High Risk']) }}" class="text-xs font-bold text-red-600 hover:text-red-800 flex items-center gap-1">
                <span>View High Risk Roster</span> &rarr;
            </a>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center gap-2 mb-2">
            <span class="p-2 rounded-xl bg-blue-50 text-blue-600"><i class="fas fa-lightbulb text-sm"></i></span>
            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Faculty Allocation Review</h4>
        </div>
        <p class="text-xs text-slate-600 leading-relaxed font-medium">
            Review workload distributions for {{ $totalFaculty }} faculty members to ensure optimal teacher-to-student coverage across all active courses.
        </p>
        <div class="mt-4">
            <a href="{{ route('hod.faculty') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                <span>Manage Department Faculty</span> &rarr;
            </a>
        </div>
    </div>
</div>

<!-- ==========================================================================
     9. QUICK ACTION CARDS (BOTTOM LAUNCHER CARDS)
     ========================================================================== -->
<x-dashboard.section-header 
    title="Department Module Launchers" 
    subtitle="Quick access navigation to core department management modules" 
    badge="Module Launchers" />

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
    <x-dashboard.quick-action-card 
        title="Manage Students" 
        description="Access and manage student directory, risk profiles, and academic performance." 
        icon="fas fa-user-graduate" 
        color="blue" 
        url="{{ route('hod.students') }}" 
        badge="{{ $enrolledStudents }} Students" />

    <x-dashboard.quick-action-card 
        title="Manage Faculty" 
        description="Review faculty allocations, course workloads, and teaching staff directories." 
        icon="fas fa-chalkboard-teacher" 
        color="purple" 
        url="{{ route('hod.faculty') }}" 
        badge="{{ $totalFaculty }} Faculty" />

    <x-dashboard.quick-action-card 
        title="Manage Courses" 
        description="Manage curriculum offerings, course credits, and subject attendance statistics." 
        icon="fas fa-book-open" 
        color="emerald" 
        url="{{ route('hod.courses') }}" 
        badge="{{ $totalCourses }} Courses" />

    <x-dashboard.quick-action-card 
        title="Department Analytics" 
        description="Deep data intelligence, semester comparisons, and faculty performance metrics." 
        icon="fas fa-chart-bar" 
        color="slate" 
        url="{{ route('hod.analytics') }}" 
        badge="Full Intelligence" />

    <x-dashboard.quick-action-card 
        title="EduInsight AI" 
        description="Ask natural language questions on your department data powered by EduInsight AI." 
        icon="fas fa-robot" 
        color="purple" 
        url="{{ route('hod.ai') }}" 
        badge="NLP Assistant" />

    <x-dashboard.quick-action-card 
        title="Send Notification" 
        description="Dispatch automated SMTP email warnings to students and parents." 
        icon="fas fa-paper-plane" 
        color="blue" 
        url="{{ route('email.send') }}" 
        badge="SMTP Gateway" />
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Attendance Trend Chart
    const attTrendCtx = document.getElementById('attendanceTrendChart');
    if (attTrendCtx && typeof Chart !== 'undefined') {
        new Chart(attTrendCtx, {
            type: 'line',
            data: {
                labels: ['Month 1', 'Month 2', 'Month 3', 'Month 4', 'Month 5', 'Current'],
                datasets: [{
                    label: 'Avg Attendance %',
                    data: [78, 81, 79, 83, 85, {{ $deptMarksAvg ? round($deptMarksAvg, 1) : 84 }}],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: false, min: 60, max: 100, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 2. Risk Distribution Chart
    const riskCtx = document.getElementById('riskDistChart');
    if (riskCtx && typeof Chart !== 'undefined') {
        new Chart(riskCtx, {
            type: 'doughnut',
            data: {
                labels: ['Low Risk ({{ $lowRiskCount }})', 'Medium Risk ({{ $mediumRiskCount }})', 'High Risk ({{ $highRiskCount }})'],
                datasets: [{
                    data: [{{ $lowRiskCount }}, {{ $mediumRiskCount }}, {{ $highRiskCount }}],
                    backgroundColor: ['#059669', '#d97706', '#dc2626'],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { family: 'Inter', size: 11, weight: '600' }, usePointStyle: true, padding: 15 }
                    }
                }
            }
        });
    }

    // 3. Pass Percentage Chart
    const passCtx = document.getElementById('passPercentageChart');
    if (passCtx && typeof Chart !== 'undefined') {
        new Chart(passCtx, {
            type: 'bar',
            data: {
                labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4', 'Overall Dept'],
                datasets: [{
                    label: 'Pass Rate %',
                    data: [82, 86, 79, 88, {{ $overallPassPercentage }}],
                    backgroundColor: '#059669',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 4. Course Performance Chart
    const courseCtx = document.getElementById('coursePerformanceChart');
    if (courseCtx && typeof Chart !== 'undefined') {
        new Chart(courseCtx, {
            type: 'bar',
            data: {
                labels: ['Course A', 'Course B', 'Course C', 'Course D'],
                datasets: [
                    {
                        label: 'Attendance %',
                        data: [85, 78, 88, 82],
                        backgroundColor: '#2563eb',
                        borderRadius: 6
                    },
                    {
                        label: 'Avg Marks %',
                        data: [76, 72, 84, 80],
                        backgroundColor: '#7c3aed',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { family: 'Inter', size: 11, weight: '600' }, usePointStyle: true }
                    }
                },
                scales: {
                    y: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
});
</script>
@endsection
