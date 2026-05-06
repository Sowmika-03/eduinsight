@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-chart-line"></i> Admin Dashboard
        </h2>
    </div>
</div>

<!-- Stats Row -->
<div class="row">
    <div class="col-md-3">
        <div class="stat-box">
            <i class="fas fa-users fa-2x"></i>
            <h3>{{ $totalStudents }}</h3>
            <p>Total Students</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <i class="fas fa-check fa-2x"></i>
            <h3>{{ round($avgAttendance, 1) }}%</h3>
            <p>Avg Attendance</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <i class="fas fa-star fa-2x"></i>
            <h3>{{ round($passPercentage, 1) }}%</h3>
            <p>Pass Rate</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <i class="fas fa-exclamation-triangle fa-2x"></i>
            <h3>{{ $highRiskStudents }}</h3>
            <p>High Risk</p>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Risk Distribution</h5>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="riskChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Students by Program</h5>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="programChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Alerts -->
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5>Recent Alerts</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Alert Type</th>
                            <th>Severity</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAlerts as $alert)
                            <tr>
                                <td>{{ $alert->student->user->name }}</td>
                                <td>{{ $alert->course?->course_name ?? 'N/A' }}</td>
                                <td>
                                    @if($alert->alert_type === 'low_attendance')
                                        <span class="badge bg-warning">Low Attendance</span>
                                    @elseif($alert->alert_type === 'low_marks')
                                        <span class="badge bg-info">Low Marks</span>
                                    @elseif($alert->alert_type === 'high_risk')
                                        <span class="badge bg-danger">High Risk</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="alert-badge alert-{{ $alert->severity }}">
                                        {{ ucfirst($alert->severity) }}
                                    </span>
                                </td>
                                <td>{{ $alert->alert_date->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No alerts</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Email Analytics -->
@include('components.email-analytics')

@endsection

@section('scripts')
<script>
// Initialize charts immediately - Chart.js is loaded in head
document.addEventListener('DOMContentLoaded', function() {
    // Risk Distribution Chart
    const riskCtx = document.getElementById('riskChart');
    if (riskCtx && typeof Chart !== 'undefined') {
        const riskLow = {{ $riskDistribution->where('risk_level', 'Low Risk')->first()?->count ?? 0 }};
        const riskMedium = {{ $riskDistribution->where('risk_level', 'Medium Risk')->first()?->count ?? 0 }};
        const riskHigh = {{ $riskDistribution->where('risk_level', 'High Risk')->first()?->count ?? 0 }};
        
        new Chart(riskCtx, {
            type: 'doughnut',
            data: {
                labels: ['Low Risk', 'Medium Risk', 'High Risk'],
                datasets: [{
                    data: [riskLow, riskMedium, riskHigh],
                    backgroundColor: ['#51cf66', '#ffa500', '#ff6b6b'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Program Distribution Chart
    const programCtx = document.getElementById('programChart');
    if (programCtx && typeof Chart !== 'undefined') {
        const programLabels = {!! json_encode($performanceByProgram->pluck('program')->values()->toArray()) !!};
        const programData = {!! json_encode($performanceByProgram->pluck('total')->values()->toArray()) !!};
        
        new Chart(programCtx, {
            type: 'bar',
            data: {
                labels: programLabels.length > 0 ? programLabels : ['No Data'],
                datasets: [{
                    label: 'Students',
                    data: programData.length > 0 ? programData : [0],
                    backgroundColor: '#667eea',
                    borderColor: '#5568d3',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
@endsection
