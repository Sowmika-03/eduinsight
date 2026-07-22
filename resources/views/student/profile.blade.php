@extends('layouts.app')

@section('title', 'My Student Profile & Credentials')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-linear-to-tr from-blue-700 to-blue-500 text-white flex items-center justify-center font-black text-2xl shadow-md shrink-0" style="background: linear-gradient(to top right, #1d4ed8, #3b82f6);">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div>
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                    <i class="fas fa-id-card"></i>
                    <span>Official Academic Profile</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ Auth::user()->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-0.5">
                    Registration No: <span class="font-mono font-bold text-slate-800">{{ $student->student_id ?? 'STU-2026' }}</span> &bull; {{ Auth::user()->email }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('student.goals') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-purple-600 hover:bg-purple-700 text-white transition flex items-center gap-1.5 shadow-2xs">
                <i class="fas fa-bullseye"></i> Academic Goals
            </a>
            <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- PROFILE DETAILS GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Academic Info Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-graduation-cap text-blue-600"></i> Academic Details
            </h3>

            <div class="space-y-3 text-xs">
                <div class="flex justify-between py-1.5 border-b border-slate-50">
                    <span class="text-slate-400 font-semibold">Program:</span>
                    <span class="font-bold text-slate-900">{{ $student->program ?? 'B.Tech CSE' }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-50">
                    <span class="text-slate-400 font-semibold">Semester:</span>
                    <span class="font-bold text-slate-900">Semester {{ $student->semester ?? 4 }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-50">
                    <span class="text-slate-400 font-semibold">Cumulative CGPA:</span>
                    <span class="font-black text-emerald-600">{{ number_format($cgpa, 2) }} / 4.0</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-50">
                    <span class="text-slate-400 font-semibold">Overall Attendance:</span>
                    <span class="font-black text-blue-600">{{ $attendancePercent }}%</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-50">
                    <span class="text-slate-400 font-semibold">Faculty Advisor:</span>
                    <span class="font-bold text-slate-900">Dr. Bala Murali Krishna</span>
                </div>
                <div class="flex justify-between py-1.5">
                    <span class="text-slate-400 font-semibold">Parent Contact Email:</span>
                    <span class="font-mono text-slate-700 font-medium">{{ $student->parent_email ?? 'parent@edu.in' }}</span>
                </div>
            </div>
        </div>

        <!-- Skills & Certifications Card -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-award text-amber-500"></i> Verified Skills & Achievements
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="text-xs font-extrabold text-slate-900">Full-Stack Web Development</div>
                    <div class="text-[11px] text-slate-500 font-medium mt-0.5">Grade A+ &bull; Proficient in PHP, JavaScript, Tailwind & SQL</div>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="text-xs font-extrabold text-slate-900">Database Systems & Optimization</div>
                    <div class="text-[11px] text-slate-500 font-medium mt-0.5">Grade A &bull; MySQL Query Performance & Normalization</div>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="text-xs font-extrabold text-slate-900">Algorithms & Complexity</div>
                    <div class="text-[11px] text-slate-500 font-medium mt-0.5">Grade B+ &bull; Dynamic Programming & Graph Search</div>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="text-xs font-extrabold text-slate-900">Software Architecture</div>
                    <div class="text-[11px] text-slate-500 font-medium mt-0.5">Grade A &bull; Agile Scrum & System Modeling</div>
                </div>
            </div>

            <!-- Academic Timeline -->
            <div class="pt-2">
                <h4 class="text-xs font-extrabold uppercase text-slate-800 tracking-wider mb-2">Academic Progression Timeline</h4>
                <div class="flex items-center gap-2 text-xs font-bold">
                    <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100">Sem 1: 3.65 CGPA</span>
                    <i class="fas fa-arrow-right text-slate-300 text-xs"></i>
                    <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100">Sem 2: 3.72 CGPA</span>
                    <i class="fas fa-arrow-right text-slate-300 text-xs"></i>
                    <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100">Sem 3: 3.78 CGPA</span>
                    <i class="fas fa-arrow-right text-slate-300 text-xs"></i>
                    <span class="px-3 py-1.5 rounded-xl bg-blue-600 text-white font-black">Sem 4: 3.82 CGPA</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
