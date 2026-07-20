@extends('layouts.app')

@section('title', "Assign Students to {$faculty->user->name}")

@section('content')
<div class="space-y-6">

    <!-- Header Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-user-plus"></i>
                <span>Faculty Governance &bull; Mentoring Allocation</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Assign Students to {{ $faculty->user->name }}
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Available Capacity Slots: <strong class="text-emerald-600 font-bold">{{ $availableSlots }} available</strong> out of {{ $faculty->max_students }} max capacity limit.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.faculty.manage') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Directory</span>
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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Currently Assigned Students Panel -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-user-check text-emerald-600"></i>
                    <span>Currently Assigned ({{ $assignedStudents->count() }})</span>
                </h3>
            </div>

            @if ($assignedStudents->isEmpty())
                <div class="p-8 text-center text-slate-400 text-xs bg-slate-50 rounded-xl border border-slate-100 font-medium">
                    No students currently assigned to {{ $faculty->user->name }}.
                </div>
            @else
                <div class="max-h-96 overflow-y-auto border border-slate-200 rounded-xl divide-y divide-slate-100">
                    @foreach ($assignedStudents as $student)
                        <div class="p-3 flex items-center justify-between text-xs hover:bg-slate-50 transition">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($student->user->name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 block leading-tight">{{ $student->user->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-semibold">{{ $student->student_id }} &bull; {{ $student->program }}</span>
                                </div>
                            </div>
                            <form action="{{ route('admin.faculty.remove-student', [$faculty, $student]) }}" method="POST" onsubmit="return confirm('Remove student allocation?')">
                                @csrf
                                <button type="submit" class="p-1.5 text-slate-300 hover:text-red-600 transition" title="Remove Student">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Available Students to Assign Panel -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fas fa-user-plus text-blue-600"></i>
                    <span>Available Students to Assign ({{ $unassignedStudents->count() }})</span>
                </h3>
            </div>

            @if ($unassignedStudents->isEmpty())
                <div class="p-8 text-center text-slate-400 text-xs bg-slate-50 rounded-xl border border-slate-100 font-medium">
                    No unassigned students available.
                </div>
            @else
                <form action="{{ route('admin.faculty.assign', $faculty) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="max-h-72 overflow-y-auto border border-slate-200 rounded-xl p-3 bg-slate-50/50 divide-y divide-slate-100">
                        @foreach ($unassignedStudents as $student)
                            <label class="flex items-center gap-3 py-2 cursor-pointer hover:bg-white rounded-lg px-2 transition">
                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="rounded text-blue-600 focus:ring-0">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block leading-tight">{{ $student->user->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium">{{ $student->student_id }} &bull; {{ $student->program }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Assignment Notes (Optional):</label>
                        <textarea name="notes" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 font-medium placeholder-slate-400 focus:ring-0 focus:border-blue-500" placeholder="Add optional allocation notes..."></textarea>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="selectAll()" class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700">Select All</button>
                            <button type="button" onclick="clearAll()" class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700">Clear</button>
                        </div>
                        <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs">
                            <i class="fas fa-check mr-1"></i> Assign Selected
                        </button>
                    </div>
                </form>
            @endif
        </div>

    </div>

</div>

<script>
function selectAll() {
    document.querySelectorAll('input[name="student_ids[]"]').forEach(cb => cb.checked = true);
}
function clearAll() {
    document.querySelectorAll('input[name="student_ids[]"]').forEach(cb => cb.checked = false);
}
</script>
@endsection
