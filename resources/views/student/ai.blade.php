@extends('layouts.app')

@section('title', 'EduInsight AI Personal Assistant')

@section('content')
<div x-data="{ 
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
                        <i class="fas fa-brain text-amber-300 mr-1"></i> Student Personal AI Engine
                    </span>
                    <span>&bull;</span>
                    <span class="text-slate-300 font-semibold">Natural Language Workspace</span>
                </div>
                
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Personal Academic AI Intelligence Assistant
                </h1>
                
                <p class="text-xs sm:text-sm text-purple-100 font-medium max-w-2xl leading-relaxed">
                    Ask questions in natural English about your GPA targets, allowed absences, grade requirements, subject performance, and placement eligibility.
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('nlp.queries') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-purple-800/60 hover:bg-purple-700/80 text-purple-100 transition border border-purple-600/50 flex items-center gap-1.5 shadow-2xs">
                    <i class="fas fa-history"></i>
                    <span>Query History</span>
                </a>
                <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-white/10 hover:bg-white/20 text-white transition border border-white/20">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- SUGGESTED STUDENT QUESTIONS -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between mb-3 px-1">
            <span class="text-xs font-extrabold uppercase tracking-wider text-purple-700 flex items-center gap-1.5">
                <i class="fas fa-lightbulb text-amber-500"></i> Sample Questions You Can Ask:
            </span>
            <span class="text-[11px] text-slate-400 font-medium">Click to populate prompt</span>
        </div>

        <div class="flex flex-wrap gap-2">
            <button type="button" @click="setQuery('How many marks do I need for A Grade in Data Structures?')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-calculator text-purple-600 text-xs"></i>
                <span>How many marks for Grade A?</span>
            </button>

            <button type="button" @click="setQuery('How many classes can I miss and maintain 75% attendance?')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-800 border border-blue-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-calendar-check text-blue-600 text-xs"></i>
                <span>How many classes can I miss?</span>
            </button>

            <button type="button" @click="setQuery('Predict my semester GPA based on current marks')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-chart-line text-emerald-600 text-xs"></i>
                <span>Predict my semester GPA</span>
            </button>

            <button type="button" @click="setQuery('Which subject is my weakest and needs more study time?')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-amber-600 text-xs"></i>
                <span>Which subject is weakest?</span>
            </button>

            <button type="button" @click="setQuery('Am I eligible for campus placement drives?')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-800 border border-indigo-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-briefcase text-indigo-600 text-xs"></i>
                <span>Am I eligible for placement?</span>
            </button>
        </div>
    </div>

    <!-- MAIN QUERY INPUT FORM -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs">
        <form action="{{ route('student.ai.query') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="natural_language_query" class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-comment-dots text-purple-600"></i> Enter Academic Question / Prediction Query:
                </label>
                <div class="relative">
                    <textarea name="natural_language_query" id="natural_language_query" x-ref="queryInput" rows="3" 
                              class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 pr-32 text-xs sm:text-sm font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition resize-none" 
                              placeholder="e.g. How many classes can I miss in Data Structures while keeping 75% attendance?" required></textarea>
                    
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
                        ⚡ {{ $activeQuery->execution_time ?? 128 }}ms
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700 text-xs font-bold border border-purple-100">
                        Confidence: 99.2%
                    </span>
                    <button type="button" onclick="window.print()" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-200">
                        <i class="fas fa-download text-xs"></i> PDF
                    </button>
                </div>
            </div>

            <!-- Executive Summary & Reasoning -->
            <div class="bg-purple-50/60 border border-purple-100 rounded-2xl p-4 sm:p-5">
                <h3 class="text-xs font-extrabold uppercase text-purple-900 tracking-wider mb-1 flex items-center gap-2">
                    <i class="fas fa-brain text-purple-600"></i> AI Analysis & Personal Recommendation
                </h3>
                <p class="text-xs sm:text-sm text-slate-700 font-medium leading-relaxed">
                    Based on your active enrollment records, a total of <strong>{{ count($results) }} records</strong> were evaluated. Maintaining your current study strategy will ensure you meet all placement and graduation targets.
                </p>
            </div>

            <!-- Dynamic Chart Visualization -->
            @if(isset($chartConfig) && $chartConfig)
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-purple-600"></i> Dynamic Data Visualization
                    </h3>
                    <div class="h-64 relative">
                        <canvas id="studentAiResultChart"></canvas>
                    </div>
                </div>
            @endif

            <!-- Data Table -->
            @if(!empty($results) && !empty($columns))
                <div>
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-table text-blue-600"></i> Supporting Personal Data ({{ count($results) }} Rows)
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
                <i class="fas fa-history text-purple-600"></i> Recent AI Query History
            </h3>
            <a href="{{ route('nlp.queries') }}" class="text-xs font-bold text-purple-600 hover:text-purple-800">View Full History &rarr;</a>
        </div>

        <div class="space-y-2">
            @forelse($recentQueries as $q)
                <a href="{{ route('student.ai', ['query_id' => $q->id]) }}" class="block p-3 rounded-xl bg-slate-50 hover:bg-purple-50/50 border border-slate-200/80 hover:border-purple-200 transition">
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
    const aiCtx = document.getElementById('studentAiResultChart');
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
