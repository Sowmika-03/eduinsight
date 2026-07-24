@props(['nlQuery' => null, 'roleContext' => [], 'resultsCount' => 0])

@php
    $roleContext = $roleContext ?? [];
    if (!is_array($roleContext)) {
        $roleContext = [];
    }
    $requestedQuery = $nlQuery->natural_language_query ?? '';
    $intent = ucwords(str_replace('_', ' ', $nlQuery->query_intent ?? 'Academic Analytics'));
    $requestedDept = $roleContext['requested_dept'] ?? ($roleContext['department'] ?? 'All');
    $appliedDept = $roleContext['applied_dept'] ?? ($roleContext['department'] ?? 'All');
    $roleScopeApplied = $roleContext['role_scope_applied'] ?? 'Role Scope Filter';
    $rowsReturned = $resultsCount ?? 0;
    $executionTime = $nlQuery->execution_time ?? 10;
@endphp

<div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-3.5 mb-6">
    <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold">
                <i class="fas fa-list-check"></i>
            </div>
            <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800">
                QUERY STATUS PANEL
            </h4>
        </div>
        <span class="text-xs font-mono font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">
            ⚡ {{ $executionTime }} ms
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 text-xs">
        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Requested Query</span>
            <span class="font-extrabold text-slate-900 text-xs leading-snug block" title="{{ $requestedQuery }}">{{ $requestedQuery }}</span>
        </div>

        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Detected Intent</span>
            <span class="font-extrabold text-indigo-700 text-xs block">{{ $intent }}</span>
        </div>

        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Requested Department</span>
            <span class="font-extrabold text-amber-700 text-xs block">{{ $requestedDept }}</span>
        </div>

        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Applied Department</span>
            <span class="font-extrabold text-emerald-700 text-xs block">{{ $appliedDept }}</span>
        </div>

        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Role Scope Applied</span>
            <span class="font-extrabold text-purple-700 text-xs truncate block" title="{{ $roleScopeApplied }}">{{ $roleScopeApplied }}</span>
        </div>

        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Rows Returned</span>
            <span class="font-black text-slate-900 text-sm block">{{ $rowsReturned }}</span>
        </div>
    </div>
</div>
