@extends('layouts.app')

@section('title', 'Student Notification Center')

@section('content')
<div x-data="{ 
    searchTerm: '',
    selectedCategory: 'all'
}" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-bell"></i>
                <span>Institutional Communications</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Student Notification & Alerts Center
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Faculty notices, attendance warnings, grade publications, and department announcements.
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
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Search Notifications</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="searchTerm" placeholder="Filter alerts by keyword..." class="w-full pl-8 pr-3 py-2 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Category</label>
                <select x-model="selectedCategory" class="w-full text-xs font-semibold py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 transition">
                    <option value="all">All Notification Types</option>
                    <option value="academic">Academic Notices</option>
                    <option value="attendance">Attendance Alerts</option>
                    <option value="exam">Exam Timetables</option>
                </select>
            </div>

            <div class="text-right sm:self-end">
                <span class="text-xs text-slate-500 font-medium">3 Unread Alerts</span>
            </div>
        </div>
    </div>

    <!-- NOTIFICATIONS LOG LIST -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-3">
        @forelse($alerts as $alert)
            <div class="p-4 rounded-xl bg-slate-50 hover:bg-blue-50/40 border border-slate-200/80 transition flex items-start justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl {{ $alert->severity === 'high' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center text-sm shrink-0 font-bold">
                        <i class="fas {{ $alert->severity === 'high' ? 'fa-triangle-exclamation' : 'fa-bell' }}"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-xs font-extrabold text-slate-900">{{ ucfirst(str_replace('_', ' ', $alert->alert_type)) }}</h4>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $alert->severity === 'high' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                                {{ $alert->severity }} Priority
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 font-medium mt-1">
                            {{ $alert->description ?? 'Official institutional notification regarding academic evaluation.' }}
                        </p>
                        <div class="text-[10px] text-slate-400 font-mono mt-1">
                            Course: {{ $alert->course->course_name ?? 'General' }} &bull; {{ $alert->created_at ? $alert->created_at->format('M d, Y g:i A') : 'Recent' }}
                        </div>
                    </div>
                </div>

                <span class="w-2 h-2 rounded-full bg-blue-600 shrink-0 mt-1" title="Unread"></span>
            </div>
        @empty
            <div class="text-center py-12 text-slate-400">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl mb-2">
                    <i class="fas fa-bell-slash"></i>
                </div>
                <p class="text-xs font-bold text-slate-700">No Notifications Logged</p>
                <p class="text-[11px] text-slate-400 mt-0.5">You are up to date on all institutional announcements!</p>
            </div>
        @endforelse

        <div class="pt-4">
            {{ $alerts->links() }}
        </div>
    </div>

</div>
@endsection
