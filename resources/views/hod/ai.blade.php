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
                <div class="px-3.5 py-2 rounded-xl bg-white/10 border border-white/20 text-xs font-bold text-white backdrop-blur-md flex items-center gap-2">
                    <i class="fas fa-shield-alt text-emerald-400"></i>
                    <span>RBAC Enforced: {{ strtoupper($userRole) }} Scope</span>
                </div>
            </div>
        </div>
    </div>

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

    <!-- 4. CONVERSATION PANEL & EXECUTIVE RESPONSE -->
    @if($activeQuery)
    <div class="space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-4 mb-5 gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-purple-700 to-indigo-600 text-white flex items-center justify-center text-base font-bold shadow-2xs">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900">Query Evaluation Complete</h3>
                        <div class="flex items-center gap-3 text-xs text-slate-500 font-medium mt-0.5">
                            <span><i class="fas fa-stopwatch text-amber-500"></i> Latency: <strong>{{ $activeQuery->execution_time ?? 14 }}ms</strong></span>
                            <span>&bull;</span>
                            <span><i class="fas fa-shield-alt text-emerald-500"></i> Confidence: <strong>98.5%</strong></span>
                            <span>&bull;</span>
                            <span class="text-emerald-600 font-black uppercase">STATUS: {{ $activeQuery->query_status }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" onclick="window.print()" class="px-3.5 py-1.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1">
                        <i class="fas fa-file-pdf text-red-500"></i> Export PDF
                    </button>
                </div>
            </div>

            <!-- Executive Summary -->
            <div class="p-4 rounded-xl bg-purple-50 border border-purple-100 mb-5">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-purple-900 mb-1 flex items-center gap-1.5">
                    <i class="fas fa-align-left text-purple-600"></i> Executive Summary
                </h4>
                <p class="text-xs text-purple-950 font-medium leading-relaxed">
                    Evaluated <strong>{{ count($results) }} record(s)</strong> from active database for query: <em>"{{ $activeQuery->natural_language_query }}"</em> under {{ $deptName }} department scope.
                </p>
            </div>

            <!-- Reasoning & Recommendations -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-1 flex items-center gap-1.5">
                        <i class="fas fa-brain text-purple-600"></i> AI Analytical Reasoning
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        Query processed using SQL translation. Filtered against live student enrollment records, attendance logs, and internal assessment tables.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-900 mb-1 flex items-center gap-1.5">
                        <i class="fas fa-lightbulb text-emerald-600"></i> Strategic Recommendations
                    </h4>
                    <ul class="text-xs text-emerald-900 space-y-1 font-semibold list-disc list-inside">
                        <li>Issue warning notices to students below 75% attendance.</li>
                        <li>Assign course mentors for students with low midterm marks.</li>
                    </ul>
                </div>
            </div>

            <!-- Dynamic Chart -->
            @if($chartConfig && !empty($chartConfig['data']))
                <div class="mb-6 bg-slate-50 border border-slate-200 rounded-xl p-5">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-3 flex items-center gap-1.5">
                        <i class="fas fa-chart-bar text-purple-600"></i> Visual Data Chart
                    </h4>
                    <div class="h-64 relative">
                        <canvas id="aiResultChart"></canvas>
                    </div>
                </div>
            @endif

            <!-- Supporting Data Table -->
            @if(!empty($results) && !empty($columns))
                <div class="mb-6">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-3 flex items-center gap-1.5">
                        <i class="fas fa-table text-purple-600"></i> Supporting Data Table ({{ count($results) }} Rows)
                    </h4>
                    <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                        <table class="table mb-0 w-full text-left border-collapse">
                            <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-extrabold uppercase text-slate-500">
                                <tr>
                                    @foreach($columns as $col)
                                        <th class="py-3 px-4">{{ str_replace('_', ' ', $col) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-medium">
                                @foreach($results as $row)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        @foreach($columns as $col)
                                            <td class="py-3 px-4 text-slate-800">
                                                @if(is_numeric($row[$col]))
                                                    <span class="font-mono font-bold">{{ is_float($row[$col]) ? round($row[$col], 2) : $row[$col] }}</span>
                                                @else
                                                    {{ $row[$col] }}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
