@extends('layouts.app')

@section('title', 'EduInsight AI Assistant')

@section('content')

@php
    $deptName = $hod->department ?? 'Computer Science';
    $userRole = Auth::user()->role->slug;
@endphp

<div x-data="{ 
    pinnedQueries: ['Show students with attendance below 75%', 'Show high risk students in department'],
    setQuery(text) {
        $refs.queryInput.value = text;
    }
}" class="space-y-6">

    <!-- 1. GREETING BANNER -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-purple-950 text-white border border-slate-800 rounded-2xl p-6 sm:p-8 shadow-md relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/20 border border-purple-400/30 text-purple-200 text-xs font-bold uppercase tracking-wider mb-3">
                    <i class="fas fa-robot text-purple-300"></i>
                    <span>EduInsight AI Assistant &bull; {{ $deptName }} Context</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Natural Language Academic Assistant
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl font-medium">
                    Query real-time {{ $deptName }} student marks, attendance trends, risk scores, and faculty metrics in plain English.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <span class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider border {{ $roleContext['scope_badge_class'] ?? 'bg-blue-100 text-blue-800 border-blue-200' }}">
                    {{ $roleContext['scope_badge_label'] ?? 'Department Scope' }}
                </span>
            </div>
        </div>
    </div>

    <!-- 1. AI CONTEXT PANEL -->
    @include('components.ai.context-card', ['roleContext' => $roleContext])

    <!-- 2. SUGGESTED QUESTIONS & PINNED QUERIES -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-lightbulb text-amber-500 text-xs"></i>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800">Suggested & Pinned Queries</h4>
            </div>
            <span class="text-[11px] text-slate-400 font-semibold">Click to populate input</span>
        </div>
        
        <div class="flex flex-wrap gap-2">
            <button @click="setQuery('Show students with attendance below 75%')" type="button" class="px-3 py-1.5 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200 text-xs font-bold transition flex items-center gap-1.5">
                <i class="fas fa-thumbtack text-purple-600 text-[10px]"></i> Show students with attendance below 75%
            </button>
            <button @click="setQuery('List high risk students in department')" type="button" class="px-3 py-1.5 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200 text-xs font-bold transition flex items-center gap-1.5">
                <i class="fas fa-thumbtack text-purple-600 text-[10px]"></i> List high risk students in department
            </button>
            <button @click="setQuery('Show top performing students')" type="button" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-semibold transition flex items-center gap-1.5">
                <i class="fas fa-search text-slate-400 text-[10px]"></i> Show top performing students
            </button>
            <button @click="setQuery('Show course-wise average marks')" type="button" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-semibold transition flex items-center gap-1.5">
                <i class="fas fa-search text-slate-400 text-[10px]"></i> Show course-wise average marks
            </button>
        </div>
    </div>

    <!-- 3. NATURAL LANGUAGE INPUT -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <form method="POST" action="{{ route('hod.ai.query') }}" class="space-y-3">
            @csrf
            <label class="text-xs font-extrabold text-slate-800 uppercase tracking-wider block">
                Ask EduInsight AI Assistant
            </label>
            <div class="relative">
                <input type="text" x-ref="queryInput" name="natural_language_query" 
                       value="{{ $activeQuery ? $activeQuery->natural_language_query : '' }}"
                       placeholder="Ask anything (e.g. Show students with attendance below 75% in {{ $deptName }}...)" 
                       required minlength="4"
                       class="w-full pl-4 pr-36 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-purple-600 focus:ring-2 focus:ring-purple-100 text-slate-900 font-semibold transition shadow-2xs">
                
                <button type="submit" class="absolute right-2 top-2 bottom-2 px-5 text-xs font-extrabold rounded-lg bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white transition shadow-2xs flex items-center gap-1.5">
                    <i class="fas fa-paper-plane text-xs"></i>
                    <span>Execute AI</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 4. CONVERSATION PANEL & EXECUTIVE RESPONSE (Department Intelligence Assistant) -->
    @if($activeQuery)
    <div class="space-y-6">
        <div class="bg-white border border-emerald-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
            
            <!-- HOD Department Assistant Header -->
            <div class="flex items-start gap-3 border-b border-emerald-100 pb-4">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-700 text-white flex items-center justify-center text-lg font-bold shadow-md shrink-0">
                    <i class="fas fa-building-columns text-emerald-200"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-emerald-800">Department Intelligence AI &bull; {{ $deptName ?? 'Department' }}</span>
                        <span class="text-[10px] font-bold text-slate-400 font-mono">⚡ {{ $activeQuery->execution_time ?? 14 }}ms</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-black text-slate-900 mt-0.5">
                        "{{ $activeQuery->natural_language_query }}"
                    </h3>
                </div>
            </div>

            @if(!empty($roleContext['is_cross_dept']))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-950 flex items-center gap-2">
                    <i class="fas fa-info-circle text-emerald-600 text-sm"></i>
                    <span>Notice: Results are evaluated specifically for the {{ $roleContext['department'] ?? 'your' }} department scope.</span>
                </div>
            @endif

            @if(count($results) === 0)
                @include('components.ai.no-records-panel', ['roleContext' => $roleContext])
            @else
                <!-- INTELLIGENT RESULT RENDERER -->
                @include('components.ai.intelligent-result-renderer', [
                    'nlQuery' => $activeQuery,
                    'roleContext' => $roleContext,
                    'results' => $results,
                    'columns' => $columns,
                    'chartConfig' => $chartConfig,
                    'kpis' => $kpis ?? [],
                    'recommendations' => $recommendations ?? [],
                    'insights' => $insights ?? []
                ])
            @endif

            <!-- Follow-up Questions -->
            <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center gap-2">
                <span class="text-xs font-bold text-slate-500 mr-2">Suggested Follow-ups:</span>
                <button @click="setQuery('Show attendance breakdown for these students')" type="button" class="px-3 py-1 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200">
                    Show attendance breakdown for these students
                </button>
                <button @click="setQuery('Show course pass percentage')" type="button" class="px-3 py-1 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200">
                    Show course pass percentage
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- 5. RECENT QUERY HISTORY -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <i class="fas fa-history text-purple-600 text-sm"></i>
                <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Natural Language Query History</h3>
            </div>
            <span class="text-xs text-slate-400 font-semibold">{{ $recentQueries->count() }} Recent Queries</span>
        </div>

        <div class="space-y-2">
            @forelse($recentQueries as $q)
                <a href="{{ route('hod.ai', ['query_id' => $q->id]) }}" class="block p-3 rounded-xl border border-slate-100 hover:border-purple-200 hover:bg-purple-50/50 transition flex items-center justify-between">
                    <div>
                        <span class="text-xs font-extrabold text-slate-900 block">{{ $q->natural_language_query }}</span>
                        <span class="text-[11px] text-slate-400 font-medium block mt-0.5">{{ $q->created_at->diffForHumans() }} &bull; {{ $q->result_count ?? 0 }} results</span>
                    </div>
                    <span class="px-2.5 py-1 text-[10px] font-extrabold rounded-lg bg-purple-100 text-purple-800">
                        View Result &rarr;
                    </span>
                </a>
            @empty
                <p class="text-xs text-slate-400 py-4 text-center">No recent AI queries recorded. Execute a query above!</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

@section('scripts')
@if($chartConfig && !empty($chartConfig['data']))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const aiCtx = document.getElementById('aiResultChart');
    if (aiCtx && typeof Chart !== 'undefined') {
        const labels = {!! json_encode($chartConfig['data']['labels']) !!};
        const values = {!! json_encode($chartConfig['data']['values']) !!};
        const type = '{{ $chartConfig['data']['type'] }}';

        new Chart(aiCtx, {
            type: type === 'pie' ? 'pie' : 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Metric Evaluation',
                    data: values,
                    backgroundColor: type === 'pie' ? ['#2563eb', '#059669', '#7c3aed', '#d97706', '#dc2626'] : '#7c3aed',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales: type === 'pie' ? {} : { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }
});
</script>
@endif
@endsection
