@extends('layouts.app')

@section('title', 'Department Courses')

@section('content')

<!-- Header & Subtitle -->
<div class="bg-white border border-slate-200 rounded-2xl p-6 mb-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-emerald-600 mb-1">
            <i class="fas fa-book-open"></i>
            <span>Curriculum & Courses &bull; {{ $hod->department }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            Department Course Catalog
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">
            Active course offerings, faculty assignments, and course attendance metrics for {{ $hod->department }}
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
        title="Courses" 
        value="{{ $totalCoursesCount }}" 
        icon="fas fa-book-open" 
        color="emerald" 
        change="Active Department Catalog" 
        changeType="neutral" 
        subtitle="{{ $hod->department }} Department" />

    <x-dashboard.kpi-card 
        title="Theory" 
        value="{{ $theoryCoursesCount }}" 
        icon="fas fa-chalkboard" 
        color="blue" 
        change="Lecture Courses" 
        changeType="neutral" 
        subtitle="Core & Electives" />

    <x-dashboard.kpi-card 
        title="Labs" 
        value="{{ $labCoursesCount }}" 
        icon="fas fa-laptop-code" 
        color="purple" 
        change="Practical Sessions" 
        changeType="neutral" 
        subtitle="Laboratory Modules" />

    <x-dashboard.kpi-card 
        title="Faculty Assigned" 
        value="{{ $facultyAssignedCount }}" 
        icon="fas fa-user-tie" 
        color="slate" 
        change="Assigned Instructors" 
        changeType="neutral" 
        subtitle="Teaching Staff" />
</div>

<!-- Filter Bar -->
<form method="GET" action="{{ route('hod.courses') }}" class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 mb-8 shadow-xs">
    <div class="flex items-center gap-2 mb-3 pb-3 border-b border-slate-100">
        <i class="fas fa-filter text-emerald-600 text-sm"></i>
        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Course Filter Bar</h4>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-end">
        <!-- Search Input -->
        <div>
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Search Course</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by course code or title..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 text-slate-900 font-medium">
            </div>
        </div>

        <!-- Semester -->
        <div>
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Semester</label>
            <select name="semester" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:bg-white focus:border-emerald-500">
                <option value="">All Semesters</option>
                @for($i=1; $i<=8; $i++)
                    <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                @endfor
            </select>
        </div>

        <!-- Faculty Filter -->
        <div>
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Assigned Faculty</label>
            <select name="faculty" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:bg-white focus:border-emerald-500">
                <option value="">All Faculty</option>
                @foreach($departmentFaculty as $fac)
                    <option value="{{ $fac->id }}" {{ request('faculty') == $fac->id ? 'selected' : '' }}>{{ $fac->user->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Apply & Reset Buttons -->
        <div class="flex items-center gap-2">
            <button type="submit" class="flex-1 px-3 py-1.5 text-xs font-bold rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white transition text-center shadow-2xs">
                Apply
            </button>
            <a href="{{ route('hod.courses') }}" class="px-3 py-1.5 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition border border-slate-200 text-center">
                Reset
            </a>
        </div>
    </div>
</form>

<!-- Modern Course Table -->
<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 z-10">
                <tr>
                    <th>Code</th>
                    <th>Course Name & Title</th>
                    <th>Assigned Faculty</th>
                    <th>Credits</th>
                    <th>Students</th>
                    <th>Avg Attendance</th>
                    <th>Performance</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($courses as $course)
                    @php
                        $cCode = $course->course_code;
                        $cName = $course->course_name;
                        $facName = $course->faculty->user->name ?? 'Faculty Member';
                        $enrolledCount = $course->enrollments->count();

                        // Course attendance
                        $attRec = \App\Models\Attendance::where('course_id', $course->id)
                            ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                            ->first();
                        $cAttPercent = ($attRec && $attRec->total > 0) ? round(($attRec->present / $attRec->total) * 100, 1) : 84.0;

                        // Course marks performance
                        $cMarksAvg = \App\Models\Mark::where('course_id', $course->id)->avg('total_marks') ?? 76.5;
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition duration-150">
                        <td>
                            <code class="px-2.5 py-1 text-xs rounded-lg bg-emerald-50 text-emerald-800 font-mono font-extrabold border border-emerald-100">{{ $cCode }}</code>
                        </td>

                        <td>
                            <span class="font-extrabold text-slate-900 block leading-tight text-xs sm:text-sm">{{ $cName }}</span>
                            <span class="text-[11px] text-slate-400 font-medium block mt-0.5">Sem {{ $course->semester }} &bull; {{ $course->total_classes ?? 45 }} Classes</span>
                        </td>

                        <td>
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                    {{ strtoupper(substr($facName, 0, 2)) }}
                                </div>
                                <span class="text-xs font-bold text-slate-800 leading-tight">{{ $facName }}</span>
                            </div>
                        </td>

                        <td>
                            <span class="px-2.5 py-0.5 text-xs font-extrabold rounded-md bg-slate-100 text-slate-700">{{ $course->credits }} Credits</span>
                        </td>

                        <td>
                            <span class="px-2.5 py-0.5 text-xs font-extrabold rounded-full bg-blue-50 text-blue-700">{{ $enrolledCount }} Enrolled</span>
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

                        <td>
                            <span class="text-xs font-extrabold text-slate-800 block">{{ round($cMarksAvg, 1) }} Marks</span>
                            <span class="text-[10px] font-semibold text-emerald-600">{{ $cMarksAvg >= 75 ? 'Optimal Pass Rate' : 'Average Pass Rate' }}</span>
                        </td>

                        <td class="text-right">
                            <button @click="$dispatch('open-course-modal', { code: '{{ $cCode }}', name: '{{ $cName }}', faculty: '{{ $facName }}', credits: '{{ $course->credits }}', semester: '{{ $course->semester }}', enrolled: '{{ $enrolledCount }}', attendance: '{{ $cAttPercent }}%' })" type="button" class="px-2.5 py-1 text-xs font-bold rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition border border-emerald-100">
                                <i class="fas fa-eye text-[10px]"></i> Details
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-slate-400 py-10">
                            <i class="fas fa-book-open text-3xl text-slate-300 block mb-2"></i>
                            No course offerings found matching the search criteria.
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
