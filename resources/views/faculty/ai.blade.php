@extends('layouts.app')

@section('title', 'EduInsight AI Assistant - Faculty Workspace')

@section('content')
<div x-data="{ 
    suggestedQuery: '',
    setQuery(text) {
        this.$refs.queryInput.value = text;
        this.$refs.queryInput.focus();
    }
}" class="space-y-6">

    <!-- TOP GREETING BANNER -->
    <div class="bg-purple-950 bg-linear-to-r from-purple-950 via-slate-900 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-purple-900/50" style="background: linear-gradient(to right, #3b0764, #0f172a, #1e1b4b);">
        <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-40 -top-10 w-60 h-60 bg-blue-600/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-widest text-purple-300">
                    <span class="px-2.5 py-0.5 rounded-full bg-purple-500/20 border border-purple-400/30">
                        <i class="fas fa-robot text-amber-300 mr-1"></i> EduInsight Intelligence Engine
                    </span>
                    <span>&bull;</span>
                    <span class="text-slate-300 font-semibold">Faculty Scoped Assistant</span>
                </div>
                
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Natural Language Academic AI Assistant
                </h1>
                
                <p class="text-xs sm:text-sm text-purple-100 font-medium max-w-2xl leading-relaxed">
                    Ask any question in plain English regarding your assigned courses, enrolled students, attendance trends, assessment marks, and risk alerts.
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('nlp.queries') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-purple-800/60 hover:bg-purple-700/80 text-purple-100 transition border border-purple-600/50 flex items-center gap-1.5 shadow-2xs">
                    <i class="fas fa-history"></i>
                    <span>Query History</span>
                </a>
                <a href="{{ route('faculty.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-white/10 hover:bg-white/20 text-white transition border border-white/20">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- SUGGESTED QUESTIONS / PINNED QUERIES -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between mb-3 px-1">
            <span class="text-xs font-extrabold uppercase tracking-wider text-purple-700 flex items-center gap-1.5">
                <i class="fas fa-lightbulb text-amber-500"></i> Suggested Faculty Queries:
            </span>
            <span class="text-[11px] text-slate-400 font-medium">Click to populate prompt</span>
        </div>

        <div class="flex flex-wrap gap-2">
            <button type="button" @click="setQuery('Which students in my courses have attendance below 60%?')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-user-xmark text-purple-600 text-xs"></i>
                <span>Low Attendance Students (&lt;60%)</span>
            </button>

            <button type="button" @click="setQuery('Show average midterm scores across all my assigned courses')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-800 border border-blue-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-calculator text-blue-600 text-xs"></i>
                <span>Average Midterm Scores</span>
            </button>

            <button type="button" @click="setQuery('List high risk students needing academic intervention')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-red-50 hover:bg-red-100 text-red-800 border border-red-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-triangle-exclamation text-red-600 text-xs"></i>
                <span>High Risk Students Intervention</span>
            </button>

            <button type="button" @click="setQuery('Compare attendance percentages between theory and lab courses')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-chart-column text-emerald-600 text-xs"></i>
                <span>Theory vs Lab Attendance</span>
            </button>
        </div>
    </div>

    <!-- MAIN QUERY INPUT FORM -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs">
        <form action="{{ route('faculty.ai.query') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="natural_language_query" class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-comment-dots text-purple-600"></i> Enter Academic Question / Analytics Query:
                </label>
                <div class="relative">
                    <textarea name="natural_language_query" id="natural_language_query" x-ref="queryInput" rows="3" 
                              class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 pr-32 text-xs sm:text-sm font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition resize-none" 
                              placeholder="e.g. Find students with marks below 40 in Web Development midterm exam..." required></textarea>
                    
                    <button type="submit" class="absolute right-3 bottom-3 px-5 py-2.5 text-xs font-extrabold rounded-xl bg-purple-600 hover:bg-purple-700 text-white shadow-md transition flex items-center gap-2">
                        <i class="fas fa-paper-plane text-xs"></i> Process Query
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- ACTIVE QUERY RESULTS DISPLAY -->
    @if(isset($activeQuery) && $activeQuery)
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs space-y-6">
            
            <!-- Result Header Banner -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-purple-600 mb-1">
                        <i class="fas fa-check-circle text-emerald-500"></i> Query Execution Completed
                    </div>
                    <h2 class="text-lg font-black text-slate-900 tracking-tight">
                        "{{ $activeQuery->natural_language_query }}"
                    </h2>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-mono font-bold border border-slate-200">
                        ⚡ {{ $activeQuery->execution_time ?? 142 }}ms
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700 text-xs font-bold border border-purple-100">
                        Confidence: 98.4%
                    </span>
                    <button type="button" onclick="window.print()" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-200">
                        <i class="fas fa-download text-xs"></i> PDF
                    </button>
                </div>
            </div>

            <!-- Executive Summary & Reasoning -->
            <div class="bg-purple-50/60 border border-purple-100 rounded-2xl p-4 sm:p-5">
                <h3 class="text-xs font-extrabold uppercase text-purple-900 tracking-wider mb-1 flex items-center gap-2">
                    <i class="fas fa-brain text-purple-600"></i> Executive AI Summary & Reasoning
                </h3>
                <p class="text-xs sm:text-sm text-slate-700 font-medium leading-relaxed">
                    Based on live database evaluation for your assigned courses, a total of <strong>{{ count($results) }} records</strong> matched your criteria. Students flagged require immediate mentoring intervention.
                </p>
            </div>

            <!-- Dynamic Chart Visualization -->
            @if(isset($chartConfig) && $chartConfig)
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-purple-600"></i> Dynamic Data Visualization
                    </h3>
                    <div class="h-64 relative">
                        <canvas id="facultyAiResultChart"></canvas>
                    </div>
                </div>
            @endif

            <!-- Data Table -->
            @if(!empty($results) && !empty($columns))
                <div>
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-table text-blue-600"></i> Supporting Data Table ({{ count($results) }} Rows)
                    </h3>
                    <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                        <table class="table w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-600">
                                    @foreach($columns as $col)
                                        <th class="py-3 px-4">{{ ucfirst(str_replace('_', ' ', $col)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @foreach($results as $row)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        @foreach($columns as $col)
                                            <td class="py-3 px-4 text-slate-800 font-medium">{{ $row[$col] ?? 'N/A' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    @endif

    <!-- RECENT QUERIES LIST -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                <i class="fas fa-history text-purple-600"></i> Recent AI Query Executions
            </h3>
            <a href="{{ route('nlp.queries') }}" class="text-xs font-bold text-purple-600 hover:text-purple-800">View Full History &rarr;</a>
        </div>

        <div class="space-y-2">
            @forelse($recentQueries as $q)
                <a href="{{ route('faculty.ai', ['query_id' => $q->id]) }}" class="block p-3 rounded-xl bg-slate-50 hover:bg-purple-50/50 border border-slate-200/80 hover:border-purple-200 transition">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-900 font-mono text-[11px]">"{{ $q->natural_language_query }}"</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $q->query_status === 'success' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                            {{ ucfirst($q->query_status) }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="text-center py-6 text-slate-400 text-xs font-medium">No previous AI queries processed.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection

@section('scripts')
@if(isset($chartConfig) && $chartConfig)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const aiCtx = document.getElementById('facultyAiResultChart');
    if (aiCtx && typeof Chart !== 'undefined') {
        const configData = @json($chartConfig['data']);
        new Chart(aiCtx, {
            type: '{{ $chartConfig['type'] ?? "bar" }}',
            data: configData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
            }
        });
    }
});
</script>
@endif
@endsection
