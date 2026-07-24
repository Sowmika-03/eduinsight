@extends('layouts.app')

@section('title', 'EduInsight AI Academic Advisor')

@section('content')

@php
    $allQueries = \App\Models\NlQuery::where('user_id', Auth::id())->latest()->get();
    
    // Group Query History into Today, Yesterday, and Older
    $todayQueries     = $allQueries->filter(fn($q) => $q->created_at->isToday());
    $yesterdayQueries = $allQueries->filter(fn($q) => $q->created_at->isYesterday());
    $olderQueries     = $allQueries->filter(fn($q) => !$q->created_at->isToday() && !$q->created_at->isYesterday());

    $roleSlug      = strtolower(Auth::user()->role->slug ?? 'student');
    $roleName      = ucfirst(Auth::user()->role->name ?? $roleSlug);
    $resultCount   = count($results);
@endphp

<!-- Main Container with Left History Sidebar -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:h-[calc(100vh-9rem)]">
    
    <!-- LEFT SIDEBAR: Grouped History & Viva Shortcuts -->
    <div class="lg:col-span-1 h-full flex flex-col min-h-0 space-y-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs h-full flex flex-col overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3 shrink-0">
                <div class="flex items-center gap-2">
                    <i class="fas fa-history text-blue-600 text-xs"></i>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Query History</h3>
                </div>
                <a href="{{ route('nlp.create') }}" class="p-1 text-xs font-bold text-blue-600 hover:text-blue-800 transition" title="New AI Session">
                    <i class="fas fa-plus-circle"></i>
                </a>
            </div>

            <div class="flex-1 overflow-y-auto pr-1 space-y-3">
                
                <!-- TODAY GROUP -->
                @if($todayQueries->isNotEmpty())
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 block mb-1.5 px-1">Today</span>
                        <div class="space-y-1.5">
                            @foreach($todayQueries as $qItem)
                                <div class="group p-2 rounded-xl border {{ $qItem->id === $nlQuery->id ? 'border-blue-300 bg-blue-50/50' : 'border-slate-200/80 hover:border-blue-300 hover:bg-slate-50' }} transition">
                                    <a href="{{ route('nlp.show', $qItem) }}" class="block">
                                        <p class="text-xs font-semibold text-slate-800 group-hover:text-blue-600 truncate leading-snug">
                                            {{ $qItem->natural_language_query }}
                                        </p>
                                    </a>
                                    <div class="flex items-center justify-between mt-1.5 text-[10px] text-slate-400">
                                        <span>{{ $qItem->created_at->format('h:i A') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- YESTERDAY GROUP -->
                @if($yesterdayQueries->isNotEmpty())
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1.5 px-1">Yesterday</span>
                        <div class="space-y-1.5">
                            @foreach($yesterdayQueries as $qItem)
                                <div class="group p-2 rounded-xl border {{ $qItem->id === $nlQuery->id ? 'border-blue-300 bg-blue-50/50' : 'border-slate-200/80 hover:border-blue-300 hover:bg-slate-50' }} transition">
                                    <a href="{{ route('nlp.show', $qItem) }}" class="block">
                                        <p class="text-xs font-semibold text-slate-800 group-hover:text-blue-600 truncate leading-snug">
                                            {{ $qItem->natural_language_query }}
                                        </p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- OLDER GROUP -->
                @if($olderQueries->isNotEmpty())
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1.5 px-1">Older Conversations</span>
                        <div class="space-y-1.5">
                            @foreach($olderQueries as $qItem)
                                <div class="group p-2 rounded-xl border {{ $qItem->id === $nlQuery->id ? 'border-blue-300 bg-blue-50/50' : 'border-slate-200/80 hover:border-blue-300 hover:bg-slate-50' }} transition">
                                    <a href="{{ route('nlp.show', $qItem) }}" class="block">
                                        <p class="text-xs font-semibold text-slate-800 group-hover:text-blue-600 truncate leading-snug">
                                            {{ $qItem->natural_language_query }}
                                        </p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <!-- PROFESSOR DEMO / VIVA SHORTCUTS -->
            <div class="border-t border-slate-100 pt-3 mt-3 shrink-0 space-y-1.5">
                <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 flex items-center gap-1">
                    <i class="fas fa-graduation-cap"></i> Viva & Demo Questions
                </span>
                <div class="grid grid-cols-1 gap-1 text-[11px]">
                    <a href="{{ route('nlp.create') }}?query=Which department performs best" class="p-1.5 rounded-lg bg-indigo-50/60 hover:bg-indigo-100 text-indigo-900 font-semibold truncate block">
                        Which department performs best?
                    </a>
                    <a href="{{ route('nlp.create') }}?query=Show department rankings" class="p-1.5 rounded-lg bg-indigo-50/60 hover:bg-indigo-100 text-indigo-900 font-semibold truncate block">
                        Show department rankings
                    </a>
                    <a href="{{ route('nlp.create') }}?query=Which branch has lowest attendance" class="p-1.5 rounded-lg bg-indigo-50/60 hover:bg-indigo-100 text-indigo-900 font-semibold truncate block">
                        Which branch has lowest attendance?
                    </a>
                    <a href="{{ route('nlp.create') }}?query=Generate Department Report" class="p-1.5 rounded-lg bg-indigo-50/60 hover:bg-indigo-100 text-indigo-900 font-semibold truncate block">
                        Generate Department Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CHAT & ADVISOR RESPONSE AREA -->
    <div class="lg:col-span-3 h-full flex flex-col min-h-0">
        
        <!-- Header Section -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0 mb-4">
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                        EduInsight Academic Advisor
                    </h1>
                    <!-- COLORED STATUS BADGE -->
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider border {{ $roleContext['scope_badge_class'] ?? 'bg-blue-100 text-blue-800 border-blue-200' }}">
                        {{ $roleContext['scope_badge_label'] ?? ($roleContext['access_level'] ?? $roleName) }}
                    </span>
                    @if($resultCount === 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-slate-100 text-slate-800 border border-slate-200">
                            No Matching Records
                        </span>
                    @endif
                </div>
                <p class="text-xs font-semibold text-slate-500 mt-0.5">
                    Role-Aware Academic Decision Support System
                </p>
            </div>

            <!-- Status Badge & Exports -->
            <div class="flex flex-wrap items-center gap-2 shrink-0">
                @if($resultCount > 0)
                    <button onclick="window.print()" class="px-3 py-1.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                    <button onclick="exportToCSV()" class="px-3 py-1.5 text-xs font-bold rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition border border-emerald-200 flex items-center gap-1.5">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </button>
                @endif
                <a href="{{ route('nlp.create') }}" class="px-3.5 py-1.5 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs">
                    + New Query
                </a>
            </div>
        </div>

        <!-- CONVERSATION SPEECH BUBBLES -->
        <div class="flex-1 overflow-y-auto space-y-5 pr-2 pb-6">
            
            <!-- User Speech Bubble -->
            <div class="flex items-start justify-end gap-3">
                <div class="max-w-xl bg-blue-600 text-white rounded-2xl rounded-tr-none p-4 shadow-2xs">
                    <div class="flex items-center gap-2 text-[11px] font-bold text-blue-200 uppercase tracking-wider mb-1">
                        <i class="fas fa-user"></i>
                        <span>You ({{ $roleName }})</span>
                    </div>
                    <p class="text-xs sm:text-sm font-semibold leading-relaxed">
                        {{ $nlQuery->natural_language_query }}
                    </p>
                </div>
                <div class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shadow-2xs shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>

            <!-- EduInsight AI Response Bubble -->
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm shadow-md shrink-0">
                    <i class="fas fa-brain"></i>
                </div>

                <div class="flex-1 min-w-0 bg-white border border-slate-200/90 rounded-2xl rounded-tl-none p-6 shadow-xs space-y-6">
                    
                    <!-- 1. AI CONTEXT PANEL -->
                    @include('components.ai.context-card', ['roleContext' => $roleContext])

                    <!-- 2. AI SCOPE NOTICE (Appears before results when query requests data outside scope) -->
                    @include('components.ai.scope-notice', ['roleContext' => $roleContext])

                    <!-- 3. QUERY STATUS PANEL -->
                    @include('components.ai.query-status-panel', ['nlQuery' => $nlQuery, 'roleContext' => $roleContext, 'resultsCount' => $resultCount])

                    <!-- 4. ROLE INFORMATION PANEL -->
                    @include('components.ai.role-info-panel', ['roleContext' => $roleContext])

                    <!-- 5. AI INSIGHTS & SECURITY CONTEXT (Requirement 1 & 2) -->
                    @include('components.ai.ai-insights-security', ['nlQuery' => $nlQuery, 'roleContext' => $roleContext, 'resultsCount' => $resultCount])

                    @if ($nlQuery->query_status === 'success' && !$unauthorized)

                        @if(count($results) === 0)
                            @include('components.ai.no-records-panel', ['roleContext' => $roleContext])
                        @else
                            <!-- 6. INTELLIGENT RESULT RENDERER (Requirement 3, 4, 5, 6, 8) -->
                            @include('components.ai.intelligent-result-renderer', [
                                'nlQuery' => $nlQuery,
                                'roleContext' => $roleContext,
                                'results' => $results,
                                'columns' => $columns,
                                'chartConfig' => $chartConfig,
                                'kpis' => $kpis,
                                'recommendations' => $recommendations,
                                'insights' => $insights ?? []
                            ])
                        @endif

                        <!-- 6. SUGGESTED NEXT QUESTIONS -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                                Suggested Next Questions
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($dynamicFollowups as $fItem)
                                    @if(isset($fItem['query']))
                                        <a href="{{ route('nlp.create') }}" onclick="event.preventDefault(); setFollowup('{{ $fItem['query'] }}');" 
                                           class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-800 hover:text-blue-700 transition border border-slate-200 text-xs font-semibold inline-flex items-center gap-1.5">
                                            <span>{{ $fItem['title'] }}</span>
                                            <i class="fas fa-arrow-right text-[10px] text-slate-400"></i>
                                        </a>
                                    @else
                                        <a href="{{ $fItem['url'] }}" 
                                           class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-800 hover:text-blue-700 transition border border-slate-200 text-xs font-semibold inline-flex items-center gap-1.5">
                                            <span>{{ $fItem['title'] }}</span>
                                            <i class="fas fa-external-link-alt text-[10px] text-slate-400"></i>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    @elseif ($nlQuery->query_status === 'error')
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-red-900 text-xs">
                            <div class="flex items-center gap-2 font-bold text-sm text-red-800 mb-1">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                                <span>Query Error</span>
                            </div>
                            <p class="font-medium text-red-700 leading-relaxed">
                                {{ $nlQuery->error_message }}
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
@if ($chartConfig && !empty($results))
<script>
document.addEventListener('DOMContentLoaded', function() {
    try {
        const chartData = @json($chartConfig['data']);
        const ctx = document.getElementById('resultChart');
        if (ctx && typeof Chart !== 'undefined' && chartData && chartData.labels && chartData.labels.length > 0) {
            const rawType = '{{ $chartConfig["type"] }}';
            const chartType = rawType === 'pie' ? 'pie' : (rawType === 'line' ? 'line' : 'bar');
            const isHorizontal = rawType === 'horizontalBar';

            new Chart(ctx, {
                type: chartType,
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: '{{ ucwords(str_replace("_", " ", $chartConfig["valueColumn"] ?? "value")) }}',
                        data: chartData.values,
                        backgroundColor: chartType === 'pie' 
                            ? ['#dc2626', '#d97706', '#059669', '#2563eb', '#7c3aed', '#0891b2']
                            : '#2563eb',
                        borderColor: '#1d4ed8',
                        borderWidth: 1,
                        borderRadius: chartType === 'bar' ? 6 : 0
                    }]
                },
                options: {
                    indexAxis: isHorizontal ? 'y' : 'x',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: chartType === 'pie' }
                    }
                }
            });
        }
    } catch (e) {
        console.warn('Chart rendering skipped:', e);
    }
});
</script>
@endif

<script>
function setFollowup(queryText) {
    window.location.href = "{{ route('nlp.create') }}?query=" + encodeURIComponent(queryText);
}

function exportToCSV() {
    const results = @json($results);
    const columns = @json($columns);
    
    if (!results || results.length === 0) {
        alert('No data to export.');
        return;
    }

    let csv = columns.join(',') + '\n';
    results.forEach(row => {
        csv += columns.map(col => {
            const val = row[col] || '';
            return typeof val === 'string' && val.includes(',') ? `"${val}"` : val;
        }).join(',') + '\n';
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'eduinsight-academic-advisor.csv';
    a.click();
}
</script>
@endsection
