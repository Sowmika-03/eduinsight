@props(['roleContext' => []])

@php
    $roleContext = $roleContext ?? [];
    if (!is_array($roleContext)) {
        $roleContext = [];
    }
    $role = $roleContext['role_name'] ?? 'User';
    $dept = $roleContext['department'] ?? 'Institution Wide';
    $scope = $roleContext['access_level'] ?? 'Standard Scope';
    $securityModel = $roleContext['security_model'] ?? 'Role-Based Access Control (RBAC)';
    $visList = $roleContext['visible_data'] ?? ["{$dept} Students", "{$dept} Faculty", "{$dept} Courses"];
    $badgeClass = $roleContext['scope_badge_class'] ?? 'bg-blue-100 text-blue-800 border-blue-300';
    $badgeLabel = $roleContext['scope_badge_label'] ?? $scope;
@endphp

<div class="bg-slate-900 text-white rounded-2xl p-4 shadow-sm border border-slate-800 space-y-3 mb-6">
    <div class="flex items-center justify-between border-b border-slate-800 pb-2">
        <div class="flex items-center gap-2 text-xs font-black uppercase tracking-wider text-purple-300">
            <i class="fas fa-id-card-clip text-purple-400"></i>
            <span>AI CONTEXT</span>
        </div>
        <span class="px-2.5 py-0.5 text-[10px] font-extrabold uppercase rounded-full border {{ $badgeClass }}">
            {{ $badgeLabel }}
        </span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 text-xs">
        <div>
            <span class="text-[10px] font-bold uppercase text-slate-400 block mb-0.5">Role</span>
            <span class="font-extrabold text-white text-xs block">{{ $role }}</span>
        </div>
        <div>
            <span class="text-[10px] font-bold uppercase text-slate-400 block mb-0.5">Department</span>
            <span class="font-extrabold text-white text-xs block">{{ $dept }}</span>
        </div>
        <div>
            <span class="text-[10px] font-bold uppercase text-slate-400 block mb-0.5">Access Scope</span>
            <span class="font-extrabold text-purple-300 text-xs block">{{ $scope }}</span>
        </div>
        <div>
            <span class="text-[10px] font-bold uppercase text-slate-400 block mb-0.5">Security Model</span>
            <span class="font-extrabold text-slate-300 text-xs block">{{ $securityModel }}</span>
        </div>
        <div>
            <span class="text-[10px] font-bold uppercase text-slate-400 block mb-0.5">Visibility</span>
            <span class="font-semibold text-slate-200 text-xs truncate block" title="{{ implode(', ', $visList) }}">{{ implode(', ', $visList) }}</span>
        </div>
    </div>
</div>
