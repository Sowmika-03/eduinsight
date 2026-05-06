@extends('layouts.app')

@section('title', 'Query Results')

@section('content')
<div class="container-fluid mt-4">
    <!-- Query Info -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-2"><strong>Query:</strong> {{ $nlQuery->natural_language_query }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> {{ $nlQuery->execution_time }}ms | 
                                <i class="fas fa-database"></i> {{ $nlQuery->result_count }} records
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            @if ($nlQuery->query_status === 'success')
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Success
                                </span>
                            @elseif ($nlQuery->query_status === 'error')
                                <span class="badge bg-danger">
                                    <i class="fas fa-exclamation"></i> Error
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-hourglass"></i> Processing
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($nlQuery->query_status === 'success')
        <div class="row">
            <!-- Results Table (Left side) -->
            <div class="col-md-{{ $chartConfig ? '6' : '12' }}">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">
                            <i class="fas fa-table"></i> Results
                            <span class="badge bg-primary float-end">{{ count($results) }} rows</span>
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @if (!empty($results))
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-light position-sticky top-0">
                                        <tr>
                                            @foreach ($columns as $column)
                                                <th class="text-nowrap">{{ ucwords(str_replace('_', ' ', $column)) }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $row)
                                            <tr>
                                                @foreach ($columns as $column)
                                                    <td class="text-nowrap">
                                                        @php
                                                            $value = $row[$column] ?? '-';
                                                            // Format percentages
                                                            if (str_contains(strtolower($column), 'percent') || 
                                                                str_contains(strtolower($column), 'percentage')) {
                                                                echo number_format($value, 2) . '%';
                                                            } 
                                                            // Format currency
                                                            elseif (str_contains(strtolower($column), 'fee') || 
                                                                    str_contains(strtolower($column), 'amount')) {
                                                                echo '₹' . number_format($value, 2);
                                                            }
                                                            // Format dates
                                                            elseif (str_contains(strtolower($column), 'date')) {
                                                                echo \Carbon\Carbon::parse($value)->format('d M Y');
                                                            }
                                                            else {
                                                                echo $value;
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
                            <div class="alert alert-info m-3">No results found</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Chart (Right side if available) -->
            @if ($chartConfig)
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-bar"></i> 
                                {{ ucfirst($chartConfig['type']) }} Chart
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="resultChart" style="max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- SQL Query (Only visible to Admin) -->
        @if ($showSql)
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning bg-opacity-10 border-warning">
                            <h6 class="mb-0">
                                <i class="fas fa-database"></i> Generated SQL Query
                                <small class="text-muted">(Admin Only)</small>
                            </h6>
                        </div>
                        <div class="card-body">
                            <pre class="mb-0"><code class="language-sql">{{ $nlQuery->generated_sql }}</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Export Options -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="d-flex gap-2">
                    <a href="{{ route('nlp.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Queries
                    </a>
                    <button onclick="exportToCSV()" class="btn btn-success">
                        <i class="fas fa-download"></i> Export as CSV
                    </button>
                    <button onclick="exportToJSON()" class="btn btn-info text-white">
                        <i class="fas fa-download"></i> Export as JSON
                    </button>
                </div>
            </div>
        </div>

    @elseif ($nlQuery->query_status === 'error')
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">
                        <i class="fas fa-exclamation-triangle"></i> Query Error
                    </h4>
                    <p>{{ $nlQuery->error_message }}</p>
                    <hr>
                    <p class="mb-0">
                        <a href="{{ route('nlp.create') }}" class="btn btn-sm btn-primary">Try Another Query</a>
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Chart.js Script -->
@if ($chartConfig && !empty($results))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartData = @json($chartConfig['data']);
        const ctx = document.getElementById('resultChart').getContext('2d');
        
        @if ($chartConfig['type'] === 'bar')
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: '{{ ucwords(str_replace("_", " ", $chartConfig["valueColumn"])) }}',
                        data: chartData.values,
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        @elseif ($chartConfig['type'] === 'pie')
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        data: chartData.values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 159, 64, 0.8)',
                        ],
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        @endif
    </script>
@endif

<script>
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
    a.download = 'query-results.csv';
    a.click();
}

function exportToJSON() {
    const results = @json($results);
    const json = JSON.stringify(results, null, 2);
    const blob = new Blob([json], { type: 'application/json' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'query-results.json';
    a.click();
}
</script>
@endsection

