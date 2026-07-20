@extends('layouts.app')

@section('title', 'Faculty Management & Allocations')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-users-cog"></i>
                <span>Academic Operations &bull; Faculty Directory</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Faculty Management & Student Allocation
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Oversee department faculty workloads, student mentoring limits, and advisory allocations.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2 shrink-0">
            <a href="{{ route('admin.faculty.statistics') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 transition border border-purple-200 flex items-center gap-1.5 shadow-2xs">
                <i class="fas fa-chart-pie"></i>
                <span>Workload Statistics</span>
            </a>
            <a href="{{ route('admin.faculty.pending') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 transition border border-amber-200 flex items-center gap-1.5 shadow-2xs">
                <i class="fas fa-user-clock"></i>
                <span>Pending Approvals</span>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-red-600"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600">&times;</button>
        </div>
    @endif

    <!-- Faculty Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse ($faculty as $fac)
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex flex-col justify-between space-y-4 hover:border-blue-300 transition duration-150">
                
                <div>
                    <!-- Faculty Card Header -->
                    <div class="flex items-start justify-between border-b border-slate-100 pb-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-purple-600 text-white flex items-center justify-center text-sm font-extrabold shadow-sm">
                                {{ strtoupper(substr($fac->user->name ?? 'F', 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900 leading-snug">
                                    {{ $fac->user->name }}
                                </h3>
                                <p class="text-xs text-slate-500 font-semibold mt-0.5">
                                    {{ $fac->department ?? 'MCA Department' }} &bull; {{ $fac->specialization ?? 'Computer Applications' }}
                                </p>
                                <span class="text-[11px] text-slate-400 font-medium block mt-0.5">
                                    <i class="fas fa-envelope text-slate-300 mr-1"></i> {{ $fac->user->email }}
                                </span>
                            </div>
                        </div>

                        <div class="text-right">
                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 inline-block">
                                {{ $fac->getAssignedStudentCount() }} / {{ $fac->max_students }} Students
                            </span>
                            <span class="text-[10px] text-slate-400 font-semibold block mt-1">
                                Max Limit: {{ $fac->max_students }}
                            </span>
                        </div>
                    </div>

                    <!-- Assigned Students Sub-Table -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Assigned Students ({{ $fac->assignedStudents->count() }})
                            </span>
                        </div>

                        @if ($fac->assignedStudents->isEmpty())
                            <div class="p-4 text-center text-slate-400 text-xs bg-slate-50 rounded-xl border border-slate-100 font-medium">
                                No students assigned to this faculty member yet.
                            </div>
                        @else
                            <div class="max-h-44 overflow-y-auto border border-slate-200 rounded-xl divide-y divide-slate-100 bg-slate-50/50">
                                @foreach ($fac->assignedStudents as $student)
                                    <div class="p-2.5 flex items-center justify-between text-xs hover:bg-white transition">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                                {{ strtoupper(substr($student->user->name ?? 'S', 0, 1)) }}
                                            </div>
                                            <div>
                                                <span class="font-bold text-slate-900 block leading-tight">{{ $student->user->name }}</span>
                                                <span class="text-[10px] text-slate-400 font-semibold">{{ $student->student_id }} &bull; {{ $student->program }}</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.faculty.remove-student', [$fac, $student]) }}" method="POST" onsubmit="return confirm('Remove student from faculty allocation?')">
                                            @csrf
                                            <button type="submit" class="p-1 text-slate-300 hover:text-red-600 transition" title="Remove Student">
                                                <i class="fas fa-user-minus text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Faculty Card Actions Footer -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                    <a href="{{ route('admin.faculty.assign-form', $fac) }}" class="flex-1 px-3 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition text-center shadow-2xs">
                        <i class="fas fa-user-plus mr-1"></i> Manage Allocation
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-2 p-8 text-center bg-white border border-slate-200 rounded-2xl">
                <i class="fas fa-users-slash text-2xl text-slate-300 mb-2 block"></i>
                <p class="text-xs text-slate-500 font-semibold">No faculty members found in the directory.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $faculty->links() }}
    </div>

</div>
@endsection
