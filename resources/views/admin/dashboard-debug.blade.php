@extends('layouts.app')

@section('title', 'Admin Dashboard Debug')

@section('content')
<div class="container-fluid">
    <h2>Dashboard Debug Info</h2>
    
    <div class="alert alert-info">
        <h5>Risk Distribution Data:</h5>
        <pre>
@foreach($riskDistribution as $risk)
{{ $risk->risk_level }}: {{ $risk->count }}
@endforeach
        </pre>
    </div>
    
    <div class="alert alert-info">
        <h5>Program Distribution Data:</h5>
        <pre>
@foreach($performanceByProgram as $program)
{{ $program->program }}: {{ $program->total }}
@endforeach
        </pre>
    </div>
    
    <div class="card">
        <div class="card-header">Risk Chart (JSON)</div>
        <div class="card-body">
            <pre>{{ json_encode(['labels' => ['Low Risk', 'Medium Risk', 'High Risk'], 'data' => [$riskDistribution->where('risk_level', 'Low Risk')->first()?->count ?? 0, $riskDistribution->where('risk_level', 'Medium Risk')->first()?->count ?? 0, $riskDistribution->where('risk_level', 'High Risk')->first()?->count ?? 0]], JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>
    
    <div class="card mt-3">
        <div class="card-header">Program Chart Data (JSON)</div>
        <div class="card-body">
            <pre>{{ json_encode(['labels' => $performanceByProgram->pluck('program'), 'data' => $performanceByProgram->pluck('total')], JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Risk Distribution Chart</div>
                <div class="card-body">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="riskChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Program Distribution Chart</div>
                <div class="card-body">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="programChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Document loaded, initializing charts...');
    
    // Risk Distribution Chart
    const riskCtx = document.getElementById('riskChart');
    console.log('Risk context:', riskCtx);
    
    if (riskCtx && typeof Chart !== 'undefined') {
        const riskLow = {{ $riskDistribution->where('risk_level', 'Low Risk')->first()?->count ?? 0 }};
        const riskMedium = {{ $riskDistribution->where('risk_level', 'Medium Risk')->first()?->count ?? 0 }};
        const riskHigh = {{ $riskDistribution->where('risk_level', 'High Risk')->first()?->count ?? 0 }};
        
        console.log('Risk data:', {low: riskLow, medium: riskMedium, high: riskHigh});
        
        new Chart(riskCtx, {
            type: 'doughnut',
            data: {
                labels: ['Low Risk', 'Medium Risk', 'High Risk'],
                datasets: [{
                    data: [riskLow, riskMedium, riskHigh],
                    backgroundColor: ['#51cf66', '#ffa500', '#ff6b6b'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
        console.log('Risk chart created');
    } else {
        console.error('Canvas or Chart not found');
    }
    
    // Program Distribution Chart
    const programCtx = document.getElementById('programChart');
    console.log('Program context:', programCtx);
    
    if (programCtx && typeof Chart !== 'undefined') {
        const programLabels = {!! json_encode($performanceByProgram->pluck('program')->values()->toArray()) !!};
        const programData = {!! json_encode($performanceByProgram->pluck('total')->values()->toArray()) !!};
        
        console.log('Program labels:', programLabels);
        console.log('Program data:', programData);
        
        new Chart(programCtx, {
            type: 'bar',
            data: {
                labels: programLabels,
                datasets: [{
                    label: 'Students',
                    data: programData,
                    backgroundColor: '#667eea',
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false
            }
        });
        console.log('Program chart created');
    } else {
        console.error('Canvas or Chart not found for program');
    }
});
</script>
@endsection
