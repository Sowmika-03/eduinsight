@extends('layouts.app')

@section('title', 'Curriculum & Courses')

@section('content')

<x-dashboard.section-header 
    title="Curriculum & Active Course Catalogue" 
    subtitle="Catalogue of 64 active course offerings mapped across MCA, CSE, IT, and MBA programs" 
    badge="64 Courses">
    <x-slot:actions>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary text-xs">
            <i class="fas fa-arrow-left"></i> Back to Command Center
        </a>
    </x-slot:actions>
</x-dashboard.section-header>

<!-- Enterprise Course Catalogue Filter Bar -->
<form method="GET" action="{{ route('admin.courses') }}" class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 mb-6 shadow-xs" x-data="{ selectedProgram: '{{ request('program') }}', selectedBranch: '{{ request('branch') }}' }">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-3 pb-3 border-b border-slate-100">
        <div class="flex items-center gap-2">
            <i class="fas fa-filter text-blue-600 text-sm"></i>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Course Analytics & Catalogue Filter</h4>
        </div>
        <span class="text-[11px] text-slate-400 font-medium">Enterprise Filter &bull; Branch visible only for B.Tech</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:flex lg:flex-wrap items-end gap-3">
        <!-- 🔍 Search Course -->
        <div class="flex-1 min-w-45">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Search Course</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search course code or title..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" onkeydown="if(event.key==='Enter'){this.form.submit();}">
            </div>
        </div>

        <!-- Program Dropdown -->
        <div class="w-full sm:w-auto min-w-35">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Program</label>
            <select name="program" x-model="selectedProgram" @change="if(selectedProgram !== 'B.Tech') { selectedBranch = ''; }; $el.form.submit()" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <option value="">All Programs</option>
                <option value="B.Tech" {{ request('program') === 'B.Tech' ? 'selected' : '' }}>B.Tech</option>
                <option value="MCA" {{ request('program') === 'MCA' ? 'selected' : '' }}>MCA</option>
                <option value="MBA" {{ request('program') === 'MBA' ? 'selected' : '' }}>MBA</option>
            </select>
        </div>

        <!-- Branch Dropdown (Visible ONLY for B.Tech) -->
        <div x-show="selectedProgram === 'B.Tech'" x-cloak class="w-full sm:w-auto min-w-32.5">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Branch</label>
            <select name="branch" x-model="selectedBranch" :disabled="selectedProgram !== 'B.Tech'" @change="$el.form.submit()" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <option value="">All Branches</option>
                <option value="CSE" {{ request('branch') === 'CSE' ? 'selected' : '' }}>CSE</option>
                <option value="IT" {{ request('branch') === 'IT' ? 'selected' : '' }}>IT</option>
            </select>
        </div>

        <!-- Semester Dropdown -->
        <div class="w-full sm:w-auto min-w-32.5">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Semester</label>
            <select name="semester" onchange="this.form.submit()" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <option value="">All Semesters</option>
                @for($i=1; $i<=8; $i++)
                    <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                @endfor
            </select>
        </div>

        <!-- Faculty Dropdown -->
        <div class="w-full sm:w-auto min-w-37.5">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Faculty</label>
            <select name="faculty" onchange="this.form.submit()" class="w-full text-xs py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <option value="">All Faculty</option>
                <option value="assigned" {{ request('faculty') === 'assigned' ? 'selected' : '' }}>Assigned</option>
                <option value="unassigned" {{ request('faculty') === 'unassigned' ? 'selected' : '' }}>Unassigned</option>
            </select>
        </div>

        <!-- Reset Button -->
        <div class="w-full sm:w-auto">
            <a href="{{ route('admin.courses') }}" class="w-full sm:w-auto px-4 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition border border-slate-200 flex items-center justify-center gap-1.5">
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
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Assigned Faculty</th>
                    <th>Semester</th>
                    <th>Credits</th>
                    <th>Enrolled Students</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr class="hover:bg-slate-50/80 transition duration-150">
                        <td>
                            <span class="font-mono text-xs font-bold text-slate-900 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                {{ $course->course_code }}
                            </span>
                        </td>
                        <td>
                            <span class="font-bold text-slate-900 text-xs">{{ $course->course_name }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-tie text-blue-600 text-xs"></i>
                                <span class="text-xs font-medium text-slate-700">{{ $course->faculty?->user?->name ?? 'Unassigned' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded bg-blue-50 text-blue-700 border border-blue-100">
                                Semester {{ $course->semester }}
                            </span>
                        </td>
                        <td>
                            <span class="px-2 py-0.5 text-xs font-bold rounded bg-purple-50 text-purple-700 border border-purple-100">
                                {{ $course->credits }} Credits
                            </span>
                        </td>
                        <td>
                            <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $course->enrollments->count() }} Students
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-slate-400 py-8">
                            No courses found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $courses->links() }}
    </div>
</div>

@endsection
