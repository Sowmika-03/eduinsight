@extends('layouts.app')

@section('title', 'Student Directory')

@section('content')

<!-- Header & Subtitle -->
<div class="bg-white border border-slate-200 rounded-2xl p-6 mb-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
            <i class="fas fa-user-graduate"></i>
            <span>Department Roster &bull; {{ $hod->department }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            Department Student Directory
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">
            Monitor academic progress, attendance percentage, and risk evaluations for students in {{ $hod->department }}
        </p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <a href="{{ route('hod.dashboard') }}" class="px-4 py-2 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-[10px]"></i>
            <span>Back to Dashboard</span>
        </a>
    </div>
</div>

<!-- 4 KPI Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <x-dashboard.kpi-card 
        title="Total Students" 
        value="{{ $totalStudentsCount }}" 
        icon="fas fa-users" 
        color="blue" 
        change="Enrolled Department Students" 
        changeType="neutral" 
        subtitle="{{ $hod->department }} Department" />

    <x-dashboard.kpi-card 
        title="Low Risk" 
        value="{{ $lowRiskCount }}" 
        icon="fas fa-check-circle" 
        color="emerald" 
        change="{{ $totalStudentsCount > 0 ? round(($lowRiskCount / $totalStudentsCount) * 100, 1) : 0 }}% of Students" 
        changeType="up" 
        subtitle="Good Attendance & Marks" />

    <x-dashboard.kpi-card 
        title="Medium Risk" 
        value="{{ $mediumRiskCount }}" 
        icon="fas fa-exclamation-triangle" 
        color="amber" 
        change="{{ $totalStudentsCount > 0 ? round(($mediumRiskCount / $totalStudentsCount) * 100, 1) : 0 }}% of Students" 
        changeType="neutral" 
        subtitle="Monitor Progress" />

    <x-dashboard.kpi-card 
        title="High Risk" 
        value="{{ $highRiskCount }}" 
        icon="fas fa-radiation" 
        color="red" 
        change="{{ $totalStudentsCount > 0 ? round(($highRiskCount / $totalStudentsCount) * 100, 1) : 0 }}% of Students" 
        changeType="down" 
        subtitle="Immediate Action Needed" />
</div>

<!-- Filter Bar -->
<form method="GET" action="{{ route('hod.students') }}" class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 mb-8 shadow-xs">
    <div class="flex items-center gap-2 mb-3 pb-3 border-b border-slate-100">
        <i class="fas fa-filter text-blue-600 text-sm"></i>
        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Student Directory Filter</h4>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
        <!-- Search Input -->
        <div class="lg:col-span-2">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Search Student</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, ID, or email..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 text-slate-900 font-medium">
            </div>
        </div>

        <!-- Semester -->
        <div>
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Semester</label>
            <select name="semester" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:bg-white focus:border-blue-500">
                <option value="">All Semesters</option>
                @for($i=1; $i<=8; $i++)
                    <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                @endfor
            </select>
        </div>

        <!-- Risk Level -->
        <div>
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Risk Status</label>
            <select name="risk" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:bg-white focus:border-blue-500">
                <option value="">All Risk Levels</option>
                <option value="High Risk" {{ request('risk') === 'High Risk' ? 'selected' : '' }}>High Risk</option>
                <option value="Medium Risk" {{ request('risk') === 'Medium Risk' ? 'selected' : '' }}>Medium Risk</option>
                <option value="Low Risk" {{ request('risk') === 'Low Risk' ? 'selected' : '' }}>Low Risk</option>
            </select>
        </div>

        <!-- Apply & Reset Buttons -->
        <div class="flex items-center gap-2">
            <button type="submit" class="flex-1 px-3 py-1.5 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition text-center shadow-2xs">
                Apply
            </button>
            <a href="{{ route('hod.students') }}" class="px-3 py-1.5 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition border border-slate-200 text-center">
                Reset
            </a>
        </div>
    </div>
</form>

<!-- Modern Table -->
<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 z-10">
                <tr>
                    <th>Student</th>
                    <th>ID & Program</th>
                    <th>Attendance Progress</th>
                    <th>Performance</th>
                    <th>Risk Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($students as $student)
                    @php
                        $stName = $student->user->name ?? 'Student';
                        $stReg = $student->user->reg_number ?? $student->student_id;
                        $stEmail = $student->user->email ?? '';
                        
                        // Calculate Attendance %
                        $deptCourseIds = \App\Models\Course::whereIn('faculty_id', \App\Models\Faculty::where('department', $hod->department)->pluck('id'))->pluck('id');
                        $attRecord = \App\Models\Attendance::where('student_id', $student->id)
                            ->whereIn('course_id', $deptCourseIds)
                            ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                            ->first();
                        $attPercent = ($attRecord && $attRecord->total > 0) ? round(($attRecord->present / $attRecord->total) * 100, 1) : 82.0;

                        // Calculate Avg Marks
                        $avgMarksVal = \App\Models\Mark::where('student_id', $student->id)->whereIn('course_id', $deptCourseIds)->avg('total_marks') ?? 72.0;

                        // Risk status
                        $highestRisk = $student->academicRisks->sortByDesc(fn($r) => $r->risk_level === 'High Risk' ? 2 : 1)->first();
                        $riskLabel = $highestRisk ? $highestRisk->risk_level : ($attPercent < 75 || $avgMarksVal < 45 ? 'High Risk' : ($attPercent < 80 ? 'Medium Risk' : 'Low Risk'));

                        $emailUrl = route('email.send', [
                            'recipient_type' => 'student',
                            'student_id'     => $student->id,
                            'subject'        => "Academic Performance Notice - {$hod->department}",
                            'message'        => "Dear {$stName},\n\nThis is an academic status update from the HOD office.\n\nCurrent Attendance: {$attPercent}%\nAverage Marks: " . round($avgMarksVal, 1) . "\n\nPlease keep up good performance or contact your advisor if help is needed.\n\nRegards,\nHOD - {$hod->department}"
                        ]);
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition duration-150">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shadow-2xs shrink-0">
                                    {{ strtoupper(substr($stName, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="font-extrabold text-slate-900 block leading-tight">{{ $stName }}</span>
                                    <span class="text-[11px] text-slate-400 font-medium block leading-tight mt-0.5">{{ $stEmail }}</span>
                                </div>
                            </div>
                        </td>

                        <td>
                            <code class="px-2 py-0.5 text-[11px] rounded bg-slate-100 text-blue-700 font-mono font-semibold">{{ $stReg }}</code>
                            <span class="text-[11px] text-slate-500 font-medium block mt-0.5">Sem {{ $student->semester }} &bull; {{ $student->program }}</span>
                        </td>

                        <td>
                            <div class="w-36 space-y-1">
                                <div class="flex items-center justify-between text-[11px] font-bold">
                                    <span class="text-slate-700">{{ $attPercent }}%</span>
                                    <span class="{{ $attPercent >= 75 ? 'text-emerald-600' : 'text-red-600' }} text-[10px]">
                                        {{ $attPercent >= 75 ? 'Optimal' : 'Low' }}
                                    </span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-1.5 rounded-full {{ $attPercent >= 75 ? 'bg-emerald-500' : ($attPercent >= 65 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ min(100, $attPercent) }}%"></div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="text-xs font-extrabold text-slate-800 block">{{ round($avgMarksVal, 1) }} Marks</span>
                            <span class="text-[10px] font-semibold text-slate-500">Grade: {{ $avgMarksVal >= 80 ? 'A+' : ($avgMarksVal >= 60 ? 'B' : 'C') }}</span>
                        </td>

                        <td>
                            @if($riskLabel === 'High Risk')
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-red-100 text-red-800 border border-red-200 inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> High Risk
                                </span>
                            @elseif($riskLabel === 'Medium Risk')
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200 inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span> Medium Risk
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Low Risk
                                </span>
                            @endif
                        </td>

                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('hod.students.show', $student->id) }}" class="px-2.5 py-1 text-xs font-bold rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition border border-blue-100">
                                    <i class="fas fa-eye text-[10px]"></i> Profile
                                </a>
                                <a href="{{ $emailUrl }}" class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition border border-slate-200">
                                    <i class="fas fa-paper-plane text-[10px]"></i> Email
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-slate-400 py-10">
                            <i class="fas fa-user-slash text-3xl text-slate-300 block mb-2"></i>
                            No student records found matching the criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-slate-200 bg-slate-50/50">
        {{ $students->links() }}
    </div>
</div>

@endsection
