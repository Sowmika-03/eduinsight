@extends('layouts.app')

@section('title', 'Course Resources & Download Center')

@section('content')
<div x-data="{ 
    searchTerm: '',
    selectedCategory: 'all'
}" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-folder-open"></i>
                <span>Academic Material Repository</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Course Resources & Download Center
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Lecture notes, lab manuals, reference e-books, assignment guidelines, and exam question banks.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 items-center">
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Search File / Topic</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="searchTerm" placeholder="Search by document title..." class="w-full pl-8 pr-3 py-2 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Material Type</label>
                <select x-model="selectedCategory" class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <option value="all">All Material Types</option>
                    <option value="pdf">Syllabus & Notes (PDF)</option>
                    <option value="lab">Lab Code Manuals</option>
                    <option value="exam">Past Exam Papers</option>
                </select>
            </div>

            <div class="text-right sm:self-end">
                <span class="text-xs text-slate-500 font-medium">12 Documents Available</span>
            </div>
        </div>
    </div>

    <!-- RESOURCES GRID BY COURSE -->
    <div class="space-y-6">
        @forelse($enrolledCourses as $enrollment)
            @php $c = $enrollment->course; @endphp
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <span class="px-2.5 py-0.5 text-[10px] font-extrabold uppercase rounded bg-blue-50 text-blue-700 border border-blue-100">
                            {{ $c->course_code }}
                        </span>
                        <h3 class="text-base font-extrabold text-slate-900 mt-1">{{ $c->course_name }}</h3>
                    </div>
                    <span class="text-xs text-slate-500 font-medium">Faculty: {{ $c->faculty->user->name ?? 'Coordinator' }}</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between group hover:bg-blue-50/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs">
                                PDF
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">Complete Syllabus & Schedule</div>
                                <div class="text-[10px] text-slate-400 font-mono">2.4 MB &bull; Updated Jan 2026</div>
                            </div>
                        </div>
                        <a href="#" onclick="alert('Downloading Syllabus PDF...')" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-blue-600 transition" title="Download">
                            <i class="fas fa-download text-xs"></i>
                        </a>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between group hover:bg-blue-50/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                DOC
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">Lecture Slides & Notes</div>
                                <div class="text-[10px] text-slate-400 font-mono">5.8 MB &bull; Modules 1 - 4</div>
                            </div>
                        </div>
                        <a href="#" onclick="alert('Downloading Lecture Notes...')" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-blue-600 transition" title="Download">
                            <i class="fas fa-download text-xs"></i>
                        </a>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between group hover:bg-blue-50/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs">
                                ZIP
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">Lab Manual & Sample Code</div>
                                <div class="text-[10px] text-slate-400 font-mono">12.1 MB &bull; Practical Exercises</div>
                            </div>
                        </div>
                        <a href="#" onclick="alert('Downloading Lab Manual Archive...')" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-blue-600 transition" title="Download">
                            <i class="fas fa-download text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-xs">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl mb-2">
                    <i class="fas fa-folder-open"></i>
                </div>
                <p class="text-xs font-bold text-slate-700">No Course Resources Uploaded</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Resources uploaded by your faculty will appear here.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
