@props(['roleContext' => []])

@php
    $roleContext = $roleContext ?? [];
    if (!is_array($roleContext)) {
        $roleContext = [];
    }
    $scopeDept = $roleContext['department'] ?? 'authorized scope';
    $roleName = $roleContext['role_name'] ?? 'user role';
@endphp

<div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 shadow-xs space-y-5 mb-6">
    
    <!-- AI Educational Notice -->
    <div class="bg-indigo-50/80 border border-indigo-200 rounded-xl p-4 flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-sm font-bold shrink-0 mt-0.5 shadow-2xs">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div>
            <h4 class="text-xs font-black uppercase tracking-wider text-indigo-900 mb-1">
                AI Educational Notice
            </h4>
            <p class="text-xs text-indigo-950 font-medium leading-relaxed">
                This result has been restricted according to institutional role-based access policies. The AI continues processing your query using your authorized academic scope ({{ $scopeDept }}).
            </p>
        </div>
    </div>

    <!-- No Matching Records Details -->
    <div class="bg-white border border-slate-200 rounded-xl p-5 space-y-4">
        <div class="flex items-center gap-2.5">
            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-slate-100 text-slate-700 border border-slate-300">
                No Matching Records
            </span>
            <h3 class="text-sm font-extrabold text-slate-900">
                Your query was successfully processed. However, no records satisfied the requested academic conditions within your authorized access scope.
            </h3>
        </div>

        <div class="pt-3 border-t border-slate-100">
            <h4 class="text-xs font-black uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                <i class="fas fa-sliders text-indigo-600"></i> Suggested Actions
            </h4>
            <ul class="space-y-1.5 text-xs text-slate-700 font-medium list-disc list-inside pl-1">
                <li>Try another numerical threshold (e.g. attendance below 75% instead of 50%).</li>
                <li>Change semester or academic year filter.</li>
                <li>Remove restrictive department or course filters.</li>
                <li>Generate a general department performance summary.</li>
            </ul>
        </div>
    </div>
</div>
