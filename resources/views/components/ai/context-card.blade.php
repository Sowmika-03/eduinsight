@props(['roleContext' => []])

@php
    $roleContext = $roleContext ?? [];
    if (!is_array($roleContext)) {
        $roleContext = [];
    }
    $roleName = $roleContext['role_name'] ?? 'User';
    $currentScope = $roleContext['current_scope'] ?? ($roleContext['access_level'] ?? 'Authorized Scope');
    $department = $roleContext['department'] ?? 'General';
    $accessLevel = $roleContext['access_level'] ?? 'Standard Analytics';
    $visibleData = $roleContext['visible_data'] ?? ['Academic Records'];
    $roleExplanation = $roleContext['role_explanation'] ?? 'Access is scoped to authorized institutional parameters.';
    $badgeClass = $roleContext['scope_badge_class'] ?? 'bg-blue-100 text-blue-800 border-blue-300';
@endphp

<div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs transition hover:shadow-md mb-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-purple-600 to-slate-900 text-white flex items-center justify-center text-lg font-bold shadow-xs">
                <i class="fas fa-shield-halved"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">AI Governance & Security Context</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider border {{ $badgeClass }}">
                        {{ $currentScope }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 font-semibold mt-0.5">
                    Institutional Role-Based Access Control (RBAC) Active
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 text-xs font-bold rounded-xl bg-slate-100 text-slate-700 border border-slate-200">
                <i class="fas fa-building-columns text-slate-400 mr-1"></i> Dept: {{ $department }}
            </span>
        </div>
    </div>

    <!-- AI Context Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 mt-4 text-xs">
        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Current Role</span>
            <span class="font-extrabold text-slate-900 text-sm block">{{ $roleName }}</span>
        </div>

        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Current Scope</span>
            <span class="font-extrabold text-slate-900 text-sm block">{{ $currentScope }}</span>
        </div>

        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Department</span>
            <span class="font-extrabold text-slate-900 text-sm block">{{ $department }}</span>
        </div>

        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Access Level</span>
            <span class="font-extrabold text-indigo-700 text-sm block">{{ $accessLevel }}</span>
        </div>
    </div>

    <!-- Visible Data & Role Explanation -->
    <div class="mt-4 pt-3.5 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
        <div class="md:col-span-1">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">Visible Data</span>
            <div class="flex flex-wrap gap-1.5">
                @foreach($visibleData as $vItem)
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-50 text-indigo-800 border border-indigo-100">
                        {{ $vItem }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="md:col-span-2 bg-indigo-50/60 border border-indigo-100 rounded-xl p-3 text-xs text-indigo-950 font-medium">
            <span class="font-bold text-indigo-900 block mb-0.5">Role Explanation:</span>
            <p class="leading-relaxed">{{ $roleExplanation }}</p>
        </div>
    </div>
</div>
