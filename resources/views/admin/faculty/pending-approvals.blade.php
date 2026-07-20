@extends('layouts.app')

@section('title', 'Pending Faculty Approvals')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">
                <i class="fas fa-user-clock"></i>
                <span>Faculty Governance &bull; Account Approvals</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Pending Faculty Registrations
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Review and approve newly registered faculty accounts and assign initial student mentoring limits.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2 shrink-0">
            <a href="{{ route('admin.faculty.manage') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 transition border border-blue-200 flex items-center gap-1.5 shadow-2xs">
                <i class="fas fa-users"></i>
                <span>Faculty Directory</span>
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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse ($pendingFaculty as $fac)
            <div class="bg-white border border-amber-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between space-y-4">
                <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-sm font-extrabold shadow-sm">
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
                                {{ $fac->user->email }}
                            </span>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                        PENDING APPROVAL
                    </span>
                </div>

                <form action="{{ route('admin.faculty.approve', $fac) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Max Student Allocation Capacity:</label>
                        <input type="number" name="max_students" value="30" min="1" max="200" required 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs text-slate-900 font-semibold focus:ring-0 focus:border-blue-500">
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <button type="submit" class="flex-1 py-2 text-xs font-bold rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white transition shadow-2xs">
                            <i class="fas fa-check-circle mr-1"></i> Approve Faculty
                        </button>
                    </div>
                </form>
            </div>
        @empty
            <div class="col-span-2 p-10 text-center bg-white border border-slate-200 rounded-2xl">
                <i class="fas fa-user-check text-3xl text-emerald-500 mb-2 block"></i>
                <h4 class="text-sm font-bold text-slate-800">All Faculty Approvals Complete!</h4>
                <p class="text-xs text-slate-500 font-medium mt-1">There are no pending faculty registration requests waiting for administrative review.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
