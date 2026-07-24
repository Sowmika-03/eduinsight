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
                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full border {{ $roleContext['scope_badge_class'] ?? 'bg-purple-100 text-purple-800 border-purple-300' }}">
                    {{ $roleContext['scope_badge_label'] ?? 'Course Scope' }}
                </span>
                <a href="{{ route('nlp.queries') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-purple-800/60 hover:bg-purple-700/80 text-purple-100 transition border border-purple-600/50 flex items-center gap-1.5 shadow-2xs">
                    <i class="fas fa-history"></i>
                    <span>Query History</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 1. AI CONTEXT PANEL -->
    @include('components.ai.context-card', ['roleContext' => $roleContext])

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

    <!-- ACTIVE QUERY RESULTS DISPLAY (Course Analytics Assistant) -->
    @if(isset($activeQuery) && $activeQuery)
        <div class="bg-white border border-blue-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
            
            <!-- Faculty Course Assistant Header -->
            <div class="flex items-start gap-3 border-b border-blue-100 pb-4">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-lg font-bold shadow-md shrink-0">
                    <i class="fas fa-chalkboard-user text-blue-200"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-blue-700">Course Analytics Intelligence</span>
                        <span class="text-[10px] font-bold text-slate-400 font-mono">⚡ {{ $activeQuery->execution_time ?? 14 }}ms</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-black text-slate-900 mt-0.5">
                        "{{ $activeQuery->natural_language_query }}"
                    </h3>
                </div>
            </div>

            @if(!empty($roleContext['is_cross_dept']))
                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-xs font-semibold text-blue-900 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-600 text-sm"></i>
                    <span>Notice: Results are evaluated specifically for your assigned courses in {{ $roleContext['department'] ?? 'your department' }}.</span>
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
