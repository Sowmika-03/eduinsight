@extends('layouts.app')

@section('title', 'EduInsight AI Assistant')

@section('content')

@php
    $deptName = $hod->department;
@endphp

<!-- 1. GREETING BANNER -->
<div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-purple-950 text-white border border-slate-800 rounded-2xl p-6 sm:p-8 mb-8 shadow-md relative overflow-hidden">
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/20 border border-purple-400/30 text-purple-200 text-xs font-semibold uppercase tracking-wider mb-3">
                <i class="fas fa-robot text-purple-300"></i>
                <span>EduInsight AI Assistant &bull; {{ $deptName }} Department</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                Natural Language Intelligence Assistant
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl font-medium">
                Query {{ $deptName }} department data in plain English. Analyze student risk, attendance trends, course pass rates, and faculty metrics instantly.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <div class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-xs font-semibold text-white backdrop-blur-md flex items-center gap-2">
                <i class="fas fa-shield-alt text-emerald-400"></i>
                <span>Role-Scoped: {{ $deptName }} Only</span>
            </div>
        </div>
    </div>
</div>

<!-- 2. SUGGESTED QUESTIONS -->
<div class="bg-white border border-slate-200 rounded-2xl p-5 mb-8 shadow-xs">
    <div class="flex items-center gap-2 mb-3">
        <i class="fas fa-lightbulb text-amber-500 text-sm"></i>
        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Suggested Department Questions</h4>
    </div>
    
    <div class="flex flex-wrap gap-2" x-data>
        <button @click="$refs.queryInput.value = 'Show students with attendance below 75%'" type="button" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-purple-50 hover:text-purple-700 hover:border-purple-200 border border-slate-200 text-xs text-slate-700 font-semibold transition text-left">
            <i class="fas fa-search text-purple-500 text-[10px] mr-1"></i> Show students with attendance below 75%
        </button>
        <button @click="$refs.queryInput.value = 'List high risk students in department'" type="button" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-purple-50 hover:text-purple-700 hover:border-purple-200 border border-slate-200 text-xs text-slate-700 font-semibold transition text-left">
            <i class="fas fa-search text-purple-500 text-[10px] mr-1"></i> List high risk students in department
        </button>
        <button @click="$refs.queryInput.value = 'Show top performers'" type="button" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-purple-50 hover:text-purple-700 hover:border-purple-200 border border-slate-200 text-xs text-slate-700 font-semibold transition text-left">
            <i class="fas fa-search text-purple-500 text-[10px] mr-1"></i> Show top performers
        </button>
        <button @click="$refs.queryInput.value = 'Show students failing in courses'" type="button" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-purple-50 hover:text-purple-700 hover:border-purple-200 border border-slate-200 text-xs text-slate-700 font-semibold transition text-left">
            <i class="fas fa-search text-purple-500 text-[10px] mr-1"></i> Show students failing in courses
        </button>
    </div>
</div>

<!-- 3. INPUT BOX -->
<div class="bg-white border border-slate-200 rounded-2xl p-5 mb-8 shadow-xs" x-data>
    <form method="POST" action="{{ route('hod.ai.query') }}" class="space-y-4">
        @csrf
        <div>
            <label class="text-xs font-bold text-slate-800 uppercase tracking-wider block mb-2">
                Ask EduInsight AI Assistant
            </label>
            <div class="relative">
                <input type="text" x-ref="queryInput" name="natural_language_query" 
                       value="{{ $activeQuery ? $activeQuery->natural_language_query : '' }}"
                       placeholder="e.g. List high risk students in {{ $deptName }} department..." 
                       required minlength="4"
                       class="w-full pl-4 pr-32 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-purple-600 focus:ring-2 focus:ring-purple-100 text-slate-900 font-medium transition shadow-2xs">
                
                <button type="submit" class="absolute right-2 top-2 bottom-2 px-5 text-xs font-bold rounded-lg bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white transition shadow-2xs flex items-center gap-1.5">
                    <i class="fas fa-paper-plane text-xs"></i>
                    <span>Execute AI</span>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- 4. CONVERSATION PANEL & AI RESPONSE -->
@if($activeQuery)
<div class="space-y-6 mb-8">
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center text-sm font-bold shadow-2xs">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Query Evaluation Completed</h3>
                    <p class="text-xs text-slate-400 font-medium">Executed in {{ $activeQuery->execution_time ?? 12 }}ms &bull; Status: <span class="text-emerald-600 font-bold uppercase">{{ $activeQuery->query_status }}</span></p>
                </div>
            </div>

            <!-- Export Buttons -->
            <div class="flex items-center gap-2">
                <button type="button" onclick="window.print()" class="px-3 py-1.5 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1">
                    <i class="fas fa-download text-[10px]"></i> Export PDF
                </button>
            </div>
        </div>

        <!-- AI Response Summary -->
        <div class="p-4 rounded-xl bg-purple-50/70 border border-purple-100 mb-6">
            <h4 class="text-xs font-extrabold uppercase tracking-wider text-purple-900 mb-1 flex items-center gap-1.5">
                <i class="fas fa-align-left text-purple-600"></i> Executive Summary
            </h4>
            <p class="text-xs text-purple-950 font-medium leading-relaxed">
                Found <strong>{{ count($results) }} matching record(s)</strong> in {{ $deptName }} department database matching query: <em>"{{ $activeQuery->natural_language_query }}"</em>.
            </p>
        </div>

        <!-- AI Response Analytical Reason -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-1 flex items-center gap-1.5">
                    <i class="fas fa-brain text-purple-600"></i> Analytical Reason
                </h4>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                    Evaluated database tables (Students, Attendance, Marks, Courses) under Role-Based Access Control scoping strictly for department <strong>{{ $deptName }}</strong>.
                </p>
            </div>

            <!-- AI Response Recommendations -->
            <div class="p-4 rounded-xl bg-emerald-50/80 border border-emerald-200">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-900 mb-1 flex items-center gap-1.5">
                    <i class="fas fa-lightbulb text-emerald-600"></i> AI Takeaway Recommendations
                </h4>
                <ul class="text-xs text-emerald-900 space-y-1 font-medium list-disc list-inside">
                    <li>Schedule academic counseling for flagged students.</li>
                    <li>Notify course faculty advisors for progress monitoring.</li>
                </ul>
            </div>
        </div>

        <!-- Charts (Rendered dynamically if chartConfig exists) -->
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
                    <table class="table mb-0">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                @foreach($columns as $col)
                                    <th class="text-xs font-bold text-slate-700 uppercase">{{ str_replace('_', ' ', $col) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @foreach($results as $row)
                                <tr class="hover:bg-slate-50/80 transition">
                                    @foreach($columns as $col)
                                        <td class="font-medium text-slate-800">
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
        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center gap-2" x-data>
            <span class="text-xs font-bold text-slate-500 mr-2">Suggested Follow-ups:</span>
            <button @click="$refs.queryInput.value = 'Show attendance breakdown for these students'" type="button" class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200">
                Show attendance breakdown for these students
            </button>
            <button @click="$refs.queryInput.value = 'Show course pass percentage'" type="button" class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200">
                Show course pass percentage
            </button>
        </div>
    </div>
</div>
@endif

<!-- 5. HISTORY OF QUERIES BY THIS HOD -->
<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <i class="fas fa-history text-purple-600 text-sm"></i>
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">HOD Natural Language Query History</h3>
        </div>
        <span class="text-xs text-slate-400 font-semibold">{{ $recentQueries->count() }} Queries</span>
    </div>

    <div class="space-y-2">
        @forelse($recentQueries as $q)
            <a href="{{ route('hod.ai', ['query_id' => $q->id]) }}" class="block p-3 rounded-xl border border-slate-100 hover:border-purple-200 hover:bg-purple-50/50 transition flex items-center justify-between">
                <div>
                    <span class="text-xs font-extrabold text-slate-900 block">{{ $q->natural_language_query }}</span>
                    <span class="text-[11px] text-slate-400 font-medium block mt-0.5">{{ $q->created_at->diffForHumans() }} &bull; {{ $q->result_count ?? 0 }} results</span>
                </div>
                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-purple-100 text-purple-800">
                    VIEW &rarr;
                </span>
            </a>
        @empty
            <p class="text-xs text-slate-400 py-4 text-center">No query history yet. Try asking a question above!</p>
        @endforelse
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
                    label: 'Evaluation Metric',
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
