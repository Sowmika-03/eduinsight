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
                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full border {{ $roleContext['scope_badge_class'] ?? 'bg-orange-100 text-orange-800 border-orange-300' }}">
                    {{ $roleContext['scope_badge_label'] ?? 'Personal Scope' }}
                </span>
                <a href="{{ route('nlp.queries') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-purple-800/60 hover:bg-purple-700/80 text-purple-100 transition border border-purple-600/50 flex items-center gap-1.5 shadow-2xs">
                    <i class="fas fa-history"></i>
                    <span>Query History</span>
                </a>
            </div>
        </div>
    </div>

    <!-- STUDENT SUMMARY CARD (Personal Metrics Focus) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Attendance -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Personal Attendance</span>
                <i class="fas fa-calendar-check text-blue-500"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $attendancePercent }}%</div>
            <span class="text-[11px] {{ $attendancePercent >= 75 ? 'text-emerald-600 font-bold' : 'text-red-600 font-bold' }}">
                {{ $attendancePercent >= 75 ? '75% Required Threshold Met' : 'Below 75% Requirement' }}
            </span>
        </div>

        <!-- Marks -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Average Score</span>
                <i class="fas fa-award text-amber-500"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">{{ $avgMarks }}</div>
            <span class="text-[11px] text-slate-500 font-medium">Evaluated Assessments</span>
        </div>

        <!-- CGPA -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Current CGPA</span>
                <i class="fas fa-graduation-cap text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">{{ $cgpa }} <span class="text-xs text-slate-400 font-normal">/ 4.0</span></div>
            <span class="text-[11px] text-emerald-600 font-bold">Good Academic Standing</span>
        </div>

        <!-- Risk Status -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Risk Evaluation</span>
                <i class="fas fa-shield-alt text-emerald-500"></i>
            </div>
            <div class="text-2xl font-black {{ $riskLevel === 'High' ? 'text-red-600' : ($riskLevel === 'Medium' ? 'text-amber-600' : 'text-emerald-600') }} mt-1">
                {{ strtoupper($riskLevel) }} RISK
            </div>
            <span class="text-[11px] text-slate-500 font-medium">Personal Scope Protection</span>
        </div>
    </div>

    <!-- SUGGESTED STUDENT QUESTIONS (Task 1) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between mb-3 px-1">
            <span class="text-xs font-extrabold uppercase tracking-wider text-purple-700 flex items-center gap-1.5">
                <i class="fas fa-lightbulb text-amber-500"></i> Suggested Questions:
            </span>
            <span class="text-[11px] text-slate-400 font-medium">Click to populate prompt</span>
        </div>

        <div class="flex flex-wrap gap-2">
            <button type="button" @click="setQuery('Predict my GPA based on current marks')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-chart-line text-purple-600 text-xs"></i>
                <span>Predict my GPA</span>
            </button>

            <button type="button" @click="setQuery('Show my weak subjects and study topics')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-amber-600 text-xs"></i>
                <span>Show my weak subjects</span>
            </button>

            <button type="button" @click="setQuery('Show attendance trend across all subjects')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-800 border border-blue-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-calendar-check text-blue-600 text-xs"></i>
                <span>Show attendance trend</span>
            </button>

            <button type="button" @click="setQuery('How many classes can I miss and keep 75% attendance?')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-800 border border-indigo-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-clock text-indigo-600 text-xs"></i>
                <span>How many classes can I miss?</span>
            </button>

            <button type="button" @click="setQuery('Am I eligible for campus placement drives?')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-briefcase text-emerald-600 text-xs"></i>
                <span>Am I eligible for placement?</span>
            </button>

            <button type="button" @click="setQuery('Suggest a personalized study plan for exams')"
                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-800 border border-rose-200/80 transition text-left flex items-center gap-2">
                <i class="fas fa-book-open text-rose-600 text-xs"></i>
                <span>Suggest study plan</span>
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

    <!-- ACTIVE QUERY RESULTS DISPLAY (Copilot / Gemini Style Student AI Response) -->
    @if(isset($activeQuery) && $activeQuery)
        <div class="bg-white border border-purple-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
            
            <!-- Student AI Response Header -->
            <div class="flex items-start gap-3 border-b border-purple-100 pb-4">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white flex items-center justify-center text-lg font-bold shadow-md shrink-0">
                    <i class="fas fa-sparkles text-amber-300"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-purple-700">EduInsight Student AI Response</span>
                        <span class="text-[10px] font-bold text-slate-400 font-mono">{{ $activeQuery->created_at ? $activeQuery->created_at->diffForHumans() : 'Just now' }}</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-black text-slate-900 mt-0.5">
                        "{{ $activeQuery->natural_language_query }}"
                    </h3>
                </div>
            </div>

            <!-- Only display notice if cross-department or unauthorized filter occurred -->
            @if(!empty($roleContext['is_cross_dept']))
                <div class="p-4 rounded-2xl bg-purple-50 border border-purple-200 text-xs font-semibold text-purple-900 flex items-center gap-2">
                    <i class="fas fa-info-circle text-purple-600 text-sm"></i>
                    <span>Notice: Results are evaluated specifically for your personal student records in {{ $roleContext['department'] ?? 'your department' }}.</span>
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
