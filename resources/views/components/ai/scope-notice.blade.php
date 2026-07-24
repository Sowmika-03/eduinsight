@props(['roleContext' => []])

@php
    $roleContext = $roleContext ?? [];
    if (!is_array($roleContext)) {
        $roleContext = [];
    }
    $isScopeAdjusted = !empty($roleContext['is_cross_dept']) || !empty($roleContext['scope_notice']);
    $reqDept = $roleContext['requested_dept'] ?? 'Outside Scope';
    $currDept = $roleContext['department'] ?? 'Authorized Dept';
    $roleName = $roleContext['role_name'] ?? 'Authorized Role';
    $noticeMsg = $roleContext['scope_notice'] ?? null;
@endphp

@if($isScopeAdjusted)
<div class="bg-amber-50 border-2 border-amber-300 rounded-2xl p-5 shadow-xs space-y-3 mb-6">
    <div class="flex items-start gap-3">
        <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-lg font-bold shrink-0 mt-0.5 shadow-2xs">
            <i class="fas fa-shield-cat"></i>
        </div>
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <h4 class="text-xs font-black uppercase tracking-wider text-amber-900 flex items-center gap-2">
                    <span>AI Scope Notice</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-amber-200 text-amber-900 border border-amber-400">
                        Scope Adjusted
                    </span>
                </h4>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 my-2.5 py-2 px-3 rounded-xl bg-amber-100/70 border border-amber-200 text-xs">
                <div>
                    <span class="text-[10px] font-bold text-amber-800 uppercase block">Requested Department</span>
                    <span class="font-black text-amber-950 text-sm">{{ $reqDept }}</span>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-amber-800 uppercase block">Current Department</span>
                    <span class="font-black text-amber-950 text-sm">{{ $currDept }}</span>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-amber-800 uppercase block">Role</span>
                    <span class="font-black text-amber-950 text-sm">{{ $roleName }}</span>
                </div>
            </div>

            <div class="space-y-2">
                <span class="text-xs font-extrabold text-amber-950 uppercase tracking-wide block">AI Scope Adjustment</span>
                <p class="text-xs text-amber-950 font-medium leading-relaxed">
                    Your query requested <strong>{{ $reqDept }}</strong> data. According to institutional Role-Based Access Control (RBAC), this request has been automatically evaluated within your authorized <strong>{{ $currDept }}</strong> department.
                </p>
            </div>

            <div class="mt-3 bg-white/90 border border-amber-200 rounded-xl p-3 text-xs text-slate-800 space-y-1">
                <span class="font-extrabold text-amber-950 block">To analyse {{ $reqDept }} data, please sign in as:</span>
                <ul class="list-disc list-inside space-y-0.5 text-slate-700 font-semibold pl-1">
                    <li>Administrator</li>
                    <li class="font-normal text-slate-500 text-[10px] pl-4 list-none">or</li>
                    <li>{{ $reqDept }} Head of Department</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif
