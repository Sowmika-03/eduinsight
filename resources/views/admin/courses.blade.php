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
