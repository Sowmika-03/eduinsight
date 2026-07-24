@props(['nlQuery' => null, 'roleContext' => [], 'results' => [], 'columns' => [], 'chartConfig' => null, 'kpis' => [], 'recommendations' => [], 'insights' => []])

@php
    $roleContext = $roleContext ?? [];
    if (!is_array($roleContext)) {
        $roleContext = [];
    }

    $queryStr = strtolower($nlQuery->natural_language_query ?? '');
    $intent = strtolower($nlQuery->query_intent ?? 'analytics');
    
    // Auto-determine Output Mode (Requirement 6)
    $outputMode = 'analytics'; // Default

    if (str_contains($queryStr, 'report') || str_contains($queryStr, 'audit') || str_contains($queryStr, 'summary report')) {
        $outputMode = 'report';
    } elseif ($intent === 'compare' || str_contains($queryStr, 'compare') || str_contains($queryStr, 'versus') || str_contains($queryStr, 'vs')) {
        $outputMode = 'comparison';
    } elseif ($intent === 'trend' || str_contains($queryStr, 'trend') || str_contains($queryStr, 'over time') || str_contains($queryStr, 'monthly')) {
        $outputMode = 'trend';
    } elseif (str_contains($queryStr, 'student') || isset($results[0]['student_id']) || isset($results[0]['student_name'])) {
        $outputMode = 'student';
    }

    // Determine Report Title for Report Mode (Requirement 5)
    $reportTitle = "Executive Academic Analysis Report";
    if (str_contains($queryStr, 'student')) {
        $reportTitle = "Comprehensive Student Analytics Report";
    } elseif (str_contains($queryStr, 'faculty') || str_contains($queryStr, 'teacher')) {
        $reportTitle = "Faculty Evaluation & Workload Report";
    } elseif (str_contains($queryStr, 'department') || str_contains($queryStr, 'branch')) {
        $reportTitle = "Department Performance & Comparison Report";
    } elseif (str_contains($queryStr, 'semester')) {
        $reportTitle = "Semester Academic Progression Report";
    } elseif (str_contains($queryStr, 'risk')) {
        $reportTitle = "Institutional Academic Risk Audit Report";
    } elseif (str_contains($queryStr, 'attendance')) {
        $reportTitle = "Institutional Attendance Audit Report";
    } elseif (str_contains($queryStr, 'performance') || str_contains($queryStr, 'marks')) {
        $reportTitle = "Academic Performance Evaluation Report";
    } else {
        $reportTitle = "Institutional Intelligence Executive Report";
    }

    $generatedTimestamp = now()->format('F d, Y h:i A');
    $appliedScope = $roleContext['current_scope'] ?? ($roleContext['access_level'] ?? 'Authorized Scope');
    $userRole = $roleContext['role_name'] ?? 'Authorized User';
    $department = $roleContext['department'] ?? 'Institution Wide';
@endphp

<div class="space-y-6">

    <!-- MODE 1: FULL EXECUTIVE REPORT RENDERER (Requirement 5) -->
    @if($outputMode === 'report')
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6 border-t-4 border-t-indigo-600 print:shadow-none print:border-0" id="printableReport">
            <!-- Report Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-200 pb-5 gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-indigo-100 text-indigo-800 border border-indigo-200">
                            Enterprise AI Report
                        </span>
                        <span class="text-xs font-bold text-slate-400">&bull; {{ $generatedTimestamp }}</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        {{ $reportTitle }}
                    </h2>
                    <p class="text-xs text-slate-500 font-semibold">
                        Query: "<em>{{ $nlQuery->natural_language_query ?? 'Academic Query' }}</em>" &bull; Evaluated Scope: <strong>{{ $appliedScope }}</strong> ({{ $department }})
                    </p>
                </div>
                <div class="flex items-center gap-2 shrink-0 print:hidden">
                    <button type="button" onclick="window.print()" class="px-4 py-2 text-xs font-extrabold rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs transition flex items-center gap-2">
                        <i class="fas fa-file-pdf"></i> Export Report PDF
                    </button>
                </div>
            </div>

            <!-- Executive Summary & Dynamic Observations -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2 p-5 rounded-2xl bg-indigo-50/60 border border-indigo-100 space-y-2">
                    <h4 class="text-xs font-black uppercase tracking-wider text-indigo-900 flex items-center gap-2">
                        <i class="fas fa-align-left text-indigo-600"></i> Executive Summary
                    </h4>
                    <p class="text-xs sm:text-sm text-indigo-950 font-medium leading-relaxed">
                        @if(!empty($roleContext['is_cross_dept']) && !empty($roleContext['requested_dept']))
                            The requested query targeted {{ $roleContext['requested_dept'] }} data. Evaluated within your authorized {{ $department }} scope. {{ count($results) }} record(s) matched criteria.
                        @else
                            Evaluated <strong>{{ count($results) }} record(s)</strong> across the institutional database under {{ $appliedScope }}. Overall dataset compliance is active.
                        @endif
                    </p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-900 text-white border border-slate-800 space-y-2">
                    <h4 class="text-xs font-black uppercase tracking-wider text-purple-300 flex items-center gap-2">
                        <i class="fas fa-shield-halved text-purple-400"></i> Governance Metadata
                    </h4>
                    <div class="text-xs space-y-1 text-slate-300 font-medium">
                        <div><span class="text-slate-400">Generated Role:</span> <strong>{{ $userRole }}</strong></div>
                        <div><span class="text-slate-400">Department:</span> <strong>{{ $department }}</strong></div>
                        <div><span class="text-slate-400">Applied Scope:</span> <strong class="text-purple-300">{{ $appliedScope }}</strong></div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Observations (Requirement 3) -->
            @if(!empty($insights))
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <h4 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                        <i class="fas fa-brain text-indigo-600"></i> Intelligent Observations
                    </h4>
                    <ul class="space-y-1.5 text-xs text-slate-700 font-semibold list-disc list-inside">
                        @foreach($insights as $obs)
                            <li>{!! $obs !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Chart Visualization -->
            @if($chartConfig && !empty($chartConfig['data']))
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                    <h4 class="text-xs font-black uppercase tracking-wider text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-chart-line text-indigo-600"></i> Visual Data Chart
                    </h4>
                    <div class="h-64 relative">
                        <canvas id="intelligentReportChart"></canvas>
                    </div>
                </div>
            @endif

            <!-- Categorized Recommendations Dashboard (Requirement 4) -->
            @include('components.ai.recommendation-dashboard', ['recommendations' => $recommendations, 'roleContext' => $roleContext])

            <!-- Supporting Table -->
            @if(!empty($results) && !empty($columns))
                <div>
                    <h4 class="text-xs font-black uppercase tracking-wider text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-table text-indigo-600"></i> Supporting Data Table ({{ count($results) }} Rows)
                    </h4>
                    <div class="table-responsive border border-slate-200 rounded-2xl overflow-hidden">
                        <table class="table mb-0 w-full text-left border-collapse">
                            <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-black uppercase text-slate-500">
                                <tr>
                                    @foreach($columns as $col)
                                        <th class="py-3 px-4">{{ str_replace('_', ' ', $col) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-medium">
                                @foreach($results as $row)
                                    <tr class="hover:bg-slate-50 transition">
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
        </div>

    <!-- MODE 2: COMPARISON DASHBOARD RENDERER -->
    @elseif($outputMode === 'comparison')
        <div class="space-y-6">
            <div class="p-5 rounded-2xl bg-indigo-50/70 border border-indigo-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-indigo-200 text-indigo-900 border border-indigo-300">
                        Comparison Dashboard
                    </span>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight mt-1">
                        Comparative Analytics View
                    </h3>
                </div>
                <button type="button" onclick="window.print()" class="px-3.5 py-1.5 text-xs font-bold rounded-xl bg-white text-slate-700 border border-slate-200 shadow-2xs">
                    <i class="fas fa-print mr-1 text-slate-400"></i> Print Dashboard
                </button>
            </div>

            <!-- Dynamic Observations (Requirement 3) -->
            @if(!empty($insights))
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1.5">
                    <h4 class="text-xs font-black uppercase text-slate-800 flex items-center gap-2">
                        <i class="fas fa-brain text-indigo-600"></i> Comparative Observations
                    </h4>
                    <ul class="space-y-1 text-xs text-slate-700 font-semibold list-disc list-inside">
                        @foreach($insights as $obs)
                            <li>{!! $obs !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($chartConfig && !empty($chartConfig['data']))
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                    <h4 class="text-xs font-black uppercase text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-chart-column text-indigo-600"></i> Comparative Data Chart
                    </h4>
                    <div class="h-64 relative">
                        <canvas id="intelligentComparisonChart"></canvas>
                    </div>
                </div>
            @endif

            <!-- Data Table -->
            @if(!empty($results) && !empty($columns))
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                    <h4 class="text-xs font-black uppercase text-slate-800 mb-3">Comparison Records Table</h4>
                    <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                        <table class="table mb-0 w-full text-left border-collapse">
                            <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-black uppercase text-slate-500">
                                <tr>
                                    @foreach($columns as $col)
                                        <th class="py-3 px-4">{{ str_replace('_', ' ', $col) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-medium">
                                @foreach($results as $row)
                                    <tr class="hover:bg-slate-50">
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

            @include('components.ai.recommendation-dashboard', ['recommendations' => $recommendations, 'roleContext' => $roleContext])
        </div>

    <!-- MODE 3: TREND DASHBOARD RENDERER -->
    @elseif($outputMode === 'trend')
        <div class="space-y-6">
            <div class="p-5 rounded-2xl bg-purple-50/70 border border-purple-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-purple-200 text-purple-900 border border-purple-300">
                        Trend Analysis View
                    </span>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight mt-1">
                        Academic Progression Trends
                    </h3>
                </div>
            </div>

            @if($chartConfig && !empty($chartConfig['data']))
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                    <h4 class="text-xs font-black uppercase text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-chart-line text-purple-600"></i> Trend Line Visualization
                    </h4>
                    <div class="h-64 relative">
                        <canvas id="intelligentTrendChart"></canvas>
                    </div>
                </div>
            @endif

            <!-- Dynamic Observations -->
            @if(!empty($insights))
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1.5">
                    <h4 class="text-xs font-black uppercase text-slate-800 flex items-center gap-2">
                        <i class="fas fa-brain text-purple-600"></i> Dynamic Trend Insights
                    </h4>
                    <ul class="space-y-1 text-xs text-slate-700 font-semibold list-disc list-inside">
                        @foreach($insights as $obs)
                            <li>{!! $obs !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @include('components.ai.recommendation-dashboard', ['recommendations' => $recommendations, 'roleContext' => $roleContext])
        </div>

    <!-- MODE 4: DETAILED STUDENT TABLE & CARDS RENDERER -->
    @elseif($outputMode === 'student')
        <div class="space-y-6">
            <!-- Dynamic Observations (Requirement 3) -->
            @if(!empty($insights))
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1.5">
                    <h4 class="text-xs font-black uppercase text-slate-800 flex items-center gap-2">
                        <i class="fas fa-brain text-indigo-600"></i> Intelligent Student Insights
                    </h4>
                    <ul class="space-y-1 text-xs text-slate-700 font-semibold list-disc list-inside">
                        @foreach($insights as $obs)
                            <li>{!! $obs !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Supporting Data Table with Predictions -->
            @if(!empty($results) && !empty($columns))
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                            <i class="fas fa-users-gear text-indigo-600"></i> Detailed Student Records ({{ count($results) }} Rows)
                        </h4>
                        <button type="button" onclick="window.print()" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                            <i class="fas fa-download mr-1"></i> Export PDF
                        </button>
                    </div>

                    <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                        <table class="table mb-0 w-full text-left border-collapse">
                            <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-black uppercase text-slate-500">
                                <tr>
                                    @foreach($columns as $col)
                                        <th class="py-3 px-4">{{ str_replace('_', ' ', $col) }}</th>
                                    @endforeach
                                    @if(isset($results[0]['prediction']))
                                        <th class="py-3 px-4">AI Risk Prediction</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-medium">
                                @foreach($results as $row)
                                    <tr class="hover:bg-slate-50 transition">
                                        @foreach($columns as $col)
                                            <td class="py-3 px-4 text-slate-800">
                                                @if(is_numeric($row[$col]))
                                                    <span class="font-mono font-bold">{{ is_float($row[$col]) ? round($row[$col], 2) : $row[$col] }}</span>
                                                @else
                                                    {{ $row[$col] }}
                                                @endif
                                            </td>
                                        @endforeach
                                        @if(isset($row['prediction']))
                                            <td class="py-3 px-4">
                                                <span class="px-2.5 py-1 text-[10px] font-extrabold rounded-full border {{ $row['prediction_badge'] ?? 'bg-slate-100 text-slate-700' }}">
                                                    {{ $row['prediction'] }}
                                                </span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @include('components.ai.recommendation-dashboard', ['recommendations' => $recommendations, 'roleContext' => $roleContext])
        </div>

    <!-- MODE 5: STANDARD ANALYTICS SUMMARY RENDERER (DEFAULT) -->
    @else
        <div class="space-y-6">
            <!-- Dynamic Observations (Requirement 3) -->
            @if(!empty($insights))
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1.5">
                    <h4 class="text-xs font-black uppercase text-slate-800 flex items-center gap-2">
                        <i class="fas fa-brain text-indigo-600"></i> Intelligent Executive Observations
                    </h4>
                    <ul class="space-y-1 text-xs text-slate-700 font-semibold list-disc list-inside">
                        @foreach($insights as $obs)
                            <li>{!! $obs !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($chartConfig && !empty($chartConfig['data']))
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                    <h4 class="text-xs font-black uppercase text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-indigo-600"></i> Visual Data Chart
                    </h4>
                    <div class="h-64 relative">
                        <canvas id="intelligentAnalyticsChart"></canvas>
                    </div>
                </div>
            @endif

            <!-- Data Table -->
            @if(!empty($results) && !empty($columns))
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                    <h4 class="text-xs font-black uppercase text-slate-800 mb-3">Analytics Data Table ({{ count($results) }} Rows)</h4>
                    <div class="table-responsive border border-slate-200 rounded-xl overflow-hidden">
                        <table class="table mb-0 w-full text-left border-collapse">
                            <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-black uppercase text-slate-500">
                                <tr>
                                    @foreach($columns as $col)
                                        <th class="py-3 px-4">{{ str_replace('_', ' ', $col) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-medium">
                                @foreach($results as $row)
                                    <tr class="hover:bg-slate-50">
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

            @include('components.ai.recommendation-dashboard', ['recommendations' => $recommendations, 'roleContext' => $roleContext])
        </div>
    @endif

</div>

<!-- Chart.js Auto-Initializer Script for Renderer -->
@if($chartConfig && !empty($chartConfig['data']))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvasIds = ['intelligentReportChart', 'intelligentComparisonChart', 'intelligentTrendChart', 'intelligentAnalyticsChart'];
    let targetCanvas = null;
    for (const id of canvasIds) {
        const el = document.getElementById(id);
        if (el) { targetCanvas = el; break; }
    }

    if (targetCanvas && typeof Chart !== 'undefined') {
        const configData = @json($chartConfig['data']);
        new Chart(targetCanvas, {
            type: '{{ $chartConfig['type'] ?? "bar" }}',
            data: configData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
});
</script>
@endif
