@props(['recommendations' => [], 'roleContext' => []])

@php
    $roleContext = $roleContext ?? [];
    if (!is_array($roleContext)) {
        $roleContext = [];
    }

    $categorized = [
        'Student Recommendations' => [],
        'Faculty Recommendations' => [],
        'Department Recommendations' => [],
        'Administrative Recommendations' => []
    ];

    if (!empty($recommendations)) {
        foreach ($recommendations as $rec) {
            $cat = $rec['category'] ?? '';
            if (str_contains(strtolower($cat), 'student')) {
                $categorized['Student Recommendations'][] = $rec;
            } elseif (str_contains(strtolower($cat), 'faculty') || str_contains(strtolower($cat), 'teacher') || str_contains(strtolower($cat), 'tutorial')) {
                $categorized['Faculty Recommendations'][] = $rec;
            } elseif (str_contains(strtolower($cat), 'dept') || str_contains(strtolower($cat), 'department')) {
                $categorized['Department Recommendations'][] = $rec;
            } else {
                $categorized['Administrative Recommendations'][] = $rec;
            }
        }
    }

    $userRole = strtolower($roleContext['role_name'] ?? '');

    // Filter categories based on Role-Based Access Control (RBAC Task 2)
    $showCategories = [];
    if (str_contains($userRole, 'student')) {
        $showCategories = ['Student Recommendations'];
    } elseif (str_contains($userRole, 'faculty') || str_contains($userRole, 'teacher')) {
        $showCategories = ['Faculty Recommendations', 'Student Recommendations'];
    } elseif (str_contains($userRole, 'head') || str_contains($userRole, 'hod')) {
        $showCategories = ['Department Recommendations', 'Faculty Recommendations'];
    } else {
        // Administrator: Full Enterprise Scope
        $showCategories = ['Student Recommendations', 'Faculty Recommendations', 'Department Recommendations', 'Administrative Recommendations'];
    }
@endphp

<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs space-y-5 mb-6">
    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm font-bold shadow-2xs">
                <i class="fas fa-lightbulb"></i>
            </div>
            <div>
                <h3 class="text-sm font-black uppercase tracking-wider text-slate-900">
                    AI Recommendation Dashboard
                </h3>
                <p class="text-xs text-slate-500 font-semibold mt-0.5">
                    Categorized Actionable Interventions Generated from Dataset Findings
                </p>
            </div>
        </div>
        <span class="px-2.5 py-1 text-[10px] font-extrabold uppercase rounded-full bg-amber-50 text-amber-800 border border-amber-200">
            Action Plan Active
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- 1. STUDENT RECOMMENDATIONS -->
        @if(in_array('Student Recommendations', $showCategories) && !empty($categorized['Student Recommendations']))
            <div class="p-4 rounded-xl bg-purple-50/70 border border-purple-200/80 space-y-2">
                <h4 class="text-xs font-black uppercase tracking-wider text-purple-900 flex items-center gap-2">
                    <i class="fas fa-user-graduate text-purple-600"></i>
                    <span>Student Recommendations</span>
                </h4>
                <div class="space-y-2 pt-1">
                    @foreach($categorized['Student Recommendations'] as $item)
                        <div class="bg-white p-3 rounded-xl border border-purple-100 shadow-2xs space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-900">{{ $item['title'] }}</span>
                                <span class="px-2 py-0.5 text-[9px] font-extrabold uppercase rounded-md bg-purple-100 text-purple-800">
                                    {{ $item['priority'] ?? 'Action' }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $item['action'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 2. FACULTY RECOMMENDATIONS -->
        @if(in_array('Faculty Recommendations', $showCategories) && !empty($categorized['Faculty Recommendations']))
            <div class="p-4 rounded-xl bg-blue-50/70 border border-blue-200/80 space-y-2">
                <h4 class="text-xs font-black uppercase tracking-wider text-blue-900 flex items-center gap-2">
                    <i class="fas fa-chalkboard-user text-blue-600"></i>
                    <span>Faculty Recommendations</span>
                </h4>
                <div class="space-y-2 pt-1">
                    @foreach($categorized['Faculty Recommendations'] as $item)
                        <div class="bg-white p-3 rounded-xl border border-blue-100 shadow-2xs space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-900">{{ $item['title'] }}</span>
                                <span class="px-2 py-0.5 text-[9px] font-extrabold uppercase rounded-md bg-blue-100 text-blue-800">
                                    {{ $item['priority'] ?? 'Action' }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $item['action'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 3. DEPARTMENT RECOMMENDATIONS -->
        @if(in_array('Department Recommendations', $showCategories) && !empty($categorized['Department Recommendations']))
            <div class="p-4 rounded-xl bg-emerald-50/70 border border-emerald-200/80 space-y-2">
                <h4 class="text-xs font-black uppercase tracking-wider text-emerald-900 flex items-center gap-2">
                    <i class="fas fa-building-columns text-emerald-600"></i>
                    <span>Department Recommendations</span>
                </h4>
                <div class="space-y-2 pt-1">
                    @foreach($categorized['Department Recommendations'] as $item)
                        <div class="bg-white p-3 rounded-xl border border-emerald-100 shadow-2xs space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-900">{{ $item['title'] }}</span>
                                <span class="px-2 py-0.5 text-[9px] font-extrabold uppercase rounded-md bg-emerald-100 text-emerald-800">
                                    {{ $item['priority'] ?? 'Action' }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $item['action'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 4. ADMINISTRATIVE RECOMMENDATIONS -->
        @if(in_array('Administrative Recommendations', $showCategories) && !empty($categorized['Administrative Recommendations']))
            <div class="p-4 rounded-xl bg-amber-50/70 border border-amber-200/80 space-y-2">
                <h4 class="text-xs font-black uppercase tracking-wider text-amber-900 flex items-center gap-2">
                    <i class="fas fa-user-shield text-amber-600"></i>
                    <span>Administrative Recommendations</span>
                </h4>
                <div class="space-y-2 pt-1">
                    @foreach($categorized['Administrative Recommendations'] as $item)
                        <div class="bg-white p-3 rounded-xl border border-amber-100 shadow-2xs space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-900">{{ $item['title'] }}</span>
                                <span class="px-2 py-0.5 text-[9px] font-extrabold uppercase rounded-md bg-amber-100 text-amber-800">
                                    {{ $item['priority'] ?? 'Action' }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $item['action'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
</div>
