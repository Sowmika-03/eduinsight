@extends('layouts.app')

@section('title', 'EduInsight AI Response')

@section('content')

@php
    $allQueries = \App\Models\NlQuery::where('user_id', Auth::id())->latest()->get();
    
    // Group Query History into Today, Yesterday, and Older
    $todayQueries     = $allQueries->filter(fn($q) => $q->created_at->isToday());
    $yesterdayQueries = $allQueries->filter(fn($q) => $q->created_at->isYesterday());
    $olderQueries     = $allQueries->filter(fn($q) => !$q->created_at->isToday() && !$q->created_at->isYesterday());

    $roleName      = ucfirst(Auth::user()->role->name ?? Auth::user()->role->slug);
    $resultCount   = count($results);

    // Context-Aware Follow-Up Generator
    $userQueryText = strtolower($nlQuery->natural_language_query);
    if (str_contains($userQueryText, 'attend') || str_contains($userQueryText, 'absent')) {
        $dynamicFollowups = [
            ['title' => 'Show High Risk Students', 'query' => 'Show High Risk students'],
            ['title' => 'Send Warning Emails', 'url' => route('email.send')],
            ['title' => 'Compare Departments', 'query' => 'Department attendance summary']
        ];
    } elseif (str_contains($userQueryText, 'risk') || str_contains($userQueryText, 'fail') || str_contains($userQueryText, 'marks')) {
        $dynamicFollowups = [
            ['title' => 'View High Risk Students', 'query' => 'Show High Risk students'],
            ['title' => 'Send Warning Emails', 'url' => route('email.send')],
            ['title' => 'Review Low Attendance Students', 'query' => 'Show students below 75% attendance']
        ];
    } else {
        $dynamicFollowups = [
            ['title' => 'Show High Risk Students', 'query' => 'Show High Risk students'],
            ['title' => 'Send Warning Emails', 'url' => route('email.send')],
            ['title' => 'Compare Departments', 'query' => 'Department attendance summary']
        ];
    }
@endphp

<!-- Main Container with Left History Sidebar -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:h-[calc(100vh-9rem)]">
    
    <!-- LEFT SIDEBAR: Grouped History -->
    <div class="lg:col-span-1 h-full flex flex-col min-h-0">
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
                                        <div class="flex items-center gap-1.5">
                                            <button type="button" class="text-slate-300 hover:text-amber-500 transition"><i class="fas fa-star"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-blue-600 transition"><i class="fas fa-thumbtack"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-red-600 transition"><i class="fas fa-trash-alt"></i></button>
                                        </div>
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
                                    <div class="flex items-center justify-between mt-1.5 text-[10px] text-slate-400">
                                        <span>Yesterday</span>
                                        <div class="flex items-center gap-1.5">
                                            <button type="button" class="text-slate-300 hover:text-amber-500 transition"><i class="fas fa-star"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-blue-600 transition"><i class="fas fa-thumbtack"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-red-600 transition"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
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
                                    <div class="flex items-center justify-between mt-1.5 text-[10px] text-slate-400">
                                        <span>{{ $qItem->created_at->format('M d, Y') }}</span>
                                        <div class="flex items-center gap-1.5">
                                            <button type="button" class="text-slate-300 hover:text-amber-500 transition"><i class="fas fa-star"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-blue-600 transition"><i class="fas fa-thumbtack"></i></button>
                                            <button type="button" class="text-slate-300 hover:text-red-600 transition"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- MAIN CHAT & RESPONSE AREA -->
    <div class="lg:col-span-3 h-full flex flex-col min-h-0">
        
        <!-- Header Section -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0 mb-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    EduInsight AI
                </h1>
                <p class="text-xs font-semibold text-slate-500 mt-0.5">
                    Academic Decision Support Assistant
                </p>
            </div>

            <!-- Status Badge & Exports -->
            <div class="flex flex-wrap items-center gap-2 shrink-0">
                <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1.5 mr-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>EduInsight AI Online</span>
                </span>
                @if($resultCount > 0)
                    <button onclick="window.print()" class="px-3 py-1.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                        <i class="fas fa-print"></i> PDF / Print
                    </button>
                    <button onclick="exportToCSV()" class="px-3 py-1.5 text-xs font-bold rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition border border-emerald-200 flex items-center gap-1.5">
                        <i class="fas fa-file-csv"></i> CSV
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
                        <span>You</span>
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
                    
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <span class="text-xs font-bold text-slate-900 uppercase tracking-wider">EduInsight AI</span>
                        <span class="text-[11px] text-slate-400 font-medium">
                            <i class="fas fa-bolt text-amber-500"></i> {{ $nlQuery->execution_time }}ms &bull; {{ $resultCount }} records
                        </span>
                    </div>

                    @if ($nlQuery->query_status === 'success')

                        <!-- 1. EXECUTIVE SUMMARY -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                                Executive Summary
                            </h4>
                            <p class="text-xs sm:text-sm text-slate-800 font-medium leading-relaxed bg-blue-50/60 p-4 rounded-xl border border-blue-100">
                                {{ $resultCount }} student evaluation record(s) currently match your search criteria for <strong>"{{ $nlQuery->natural_language_query }}"</strong>.
                            </p>
                        </div>

                        <!-- 2. KEY FINDINGS -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                                Key Findings
                            </h4>
                            <div class="space-y-1.5 text-xs sm:text-sm text-slate-700 font-medium bg-slate-50 p-4 rounded-xl border border-slate-200/80">
                                <p class="flex items-start gap-2">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Identified {{ $resultCount }} records evaluated in {{ $nlQuery->execution_time }}ms.</span>
                                </p>
                                <p class="flex items-start gap-2">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Evaluated columns: {{ implode(', ', array_map('ucwords', array_map(fn($c) => str_replace('_', ' ', $c), array_slice($columns, 0, 4)))) }}.</span>
                                </p>
                                <p class="flex items-start gap-2">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Database execution completed under {{ $roleName }} institutional scope.</span>
                                </p>
                            </div>
                        </div>

                        <!-- 3. RECOMMENDATIONS -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                                Recommendations
                            </h4>
                            <div class="space-y-1.5 text-xs sm:text-sm text-slate-700 font-medium bg-amber-50/70 p-4 rounded-xl border border-amber-200/80">
                                <p class="flex items-start gap-2">
                                    <span class="text-amber-600 font-bold">•</span>
                                    <span>Schedule academic counseling for flagged students.</span>
                                </p>
                                <p class="flex items-start gap-2">
                                    <span class="text-amber-600 font-bold">•</span>
                                    <span>Dispatch automated warning emails to parent contacts via Email Gateway.</span>
                                </p>
                                <p class="flex items-start gap-2">
                                    <span class="text-amber-600 font-bold">•</span>
                                    <span>Monitor class attendance logs for upcoming semester assessments.</span>
                                </p>
                            </div>
                        </div>

                        <!-- 4. VISUAL ANALYTICS (DISPLAY CHART ONLY WHEN USEFUL) -->
                        @if ($chartConfig)
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                                    Visual Analytics
                                </h4>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 w-full h-80 relative">
                                    <canvas id="resultChart"></canvas>
                                </div>
                            </div>
                        @endif

                        <!-- 5. RELEVANT DATA TABLE -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                                Data Table ({{ $resultCount }} Records)
                            </h4>

                            @if(!empty($results))
                                <div class="overflow-x-auto w-full bg-white border border-slate-200 rounded-xl shadow-2xs max-h-112.5">
                                    <table class="w-full min-w-full divide-y divide-slate-200">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                @foreach ($columns as $column)
                                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">{{ ucwords(str_replace('_', ' ', $column)) }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach ($results as $row)
                                                <tr class="hover:bg-slate-50/80 transition">
                                                    @foreach ($columns as $column)
                                                        <td class="px-4 py-3 text-xs text-slate-800 font-medium whitespace-nowrap">
                                                            @php
                                                                $val = $row[$column] ?? '-';
                                                                if (str_contains(strtolower($column), 'percent') || str_contains(strtolower($column), 'percentage')) {
                                                                    echo '<span class="font-bold text-blue-600">' . number_format($val, 1) . '%</span>';
                                                                } elseif (str_contains(strtolower($column), 'risk')) {
                                                                    if (str_contains(strtolower($val), 'high')) {
                                                                        echo '<span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-800 border border-red-200">HIGH RISK</span>';
                                                                    } elseif (str_contains(strtolower($val), 'medium')) {
                                                                        echo '<span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">MEDIUM RISK</span>';
                                                                    } else {
                                                                        echo '<span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">LOW RISK</span>';
                                                                    }
                                                                } else {
                                                                    echo $val;
                                                                }
                                                            @endphp
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-6 text-center text-slate-400 bg-slate-50 rounded-xl border border-slate-200 text-xs">
                                    No records returned for this query.
                                </div>
                            @endif
                        </div>

                        <!-- 6. SUGGESTED FOLLOW-UP QUESTIONS -->
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
                            <div class="mt-3">
                                <a href="{{ route('nlp.create') }}" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-red-600 text-white hover:bg-red-700 transition shadow-2xs">
                                    Try Another Query &rarr;
                                </a>
                            </div>
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
    const chartData = @json($chartConfig['data']);
    const ctx = document.getElementById('resultChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: '{{ $chartConfig["type"] === "pie" ? "pie" : "bar" }}',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: '{{ ucwords(str_replace("_", " ", $chartConfig["valueColumn"])) }}',
                    data: chartData.values,
                    backgroundColor: ['#2563eb', '#7c3aed', '#059669', '#d97706', '#dc2626'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: '{{ $chartConfig["type"] === "pie" }}' ? true : false }
                }
            }
        });
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
    a.download = 'eduinsight-ai-results.csv';
    a.click();
}
</script>
@endsection
