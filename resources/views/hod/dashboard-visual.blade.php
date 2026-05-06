@extends('layouts.hod')

@section('hod-content')
<div class="dashboard-container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-chart-pie"></i> Department Dashboard</h2>
            <p class="text-muted">Real-time analytics and performance metrics</p>
        </div>
        <div class="col-md-4 text-end">
            <small class="text-muted">Last updated: {{ now()->format('d M Y g:i A') }} IST</small>
        </div>
    </div>

    <!-- Key Metrics Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h3 class="text-primary mb-2">{{ $totalFaculty }}</h3>
                    <p class="text-muted mb-0"><i class="fas fa-users me-1"></i> Total Faculty</p>
                    <small class="text-success">{{ $activeFaculty }} Active</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h3 class="text-info mb-2">{{ $totalCourses }}</h3>
                    <p class="text-muted mb-0"><i class="fas fa-book me-1"></i> Active Courses</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h3 class="text-warning mb-2">{{ $enrolledStudents }}</h3>
                    <p class="text-muted mb-0"><i class="fas fa-graduation-cap me-1"></i> Enrolled</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h3 class="text-danger mb-2">{{ $riskStudents }}</h3>
                    <p class="text-muted mb-0"><i class="fas fa-exclamation-triangle me-1"></i> At Risk</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row mb-4">
        <!-- Faculty Performance Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Faculty Performance</h5>
                </div>
                <div class="card-body">
                    <canvas id="facultyPerformanceChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Student Distribution Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-pie-chart"></i> Attendance Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row mb-4">
        <!-- Average Marks Distribution -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Student Average Marks</h5>
                </div>
                <div class="card-body">
                    <canvas id="marksDistributionChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Course Enrollment Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-doughnut"></i> Course Enrollment</h5>
                </div>
                <div class="card-body">
                    <canvas id="enrollmentChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Attendance Alert -->
    @if($lowAttendanceStudents->isNotEmpty())
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-exclamation-circle"></i> Students with Low Attendance</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($lowAttendanceStudents as $item)
                        <div class="col-md-6 mb-3">
                            <div class="alert alert-warning mb-0">
                                <strong>{{ $item['student']->user->name }}</strong>
                                <div class="progress mt-2" style="height: 20px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $item['attendance'] }}%">
                                        {{ $item['attendance'] }}%
                                    </div>
                                </div>
                                <small class="text-muted">ID: {{ $item['student']->user->reg_number }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Alerts -->
    @if($recentAlerts->isNotEmpty())
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-bell"></i> Recent Student Alerts</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Alert Type</th>
                                    <th>Risk Level</th>
                                    <th>Attendance %</th>
                                    <th>Avg Marks</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAlerts as $alert)
                                    <tr>
                                        <td>
                                            <strong>{{ $alert->student->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $alert->student->registration }}</small>
                                        </td>
                                        <td>
                                            @if($alert->risk_level === 'High Risk')
                                                <span class="badge bg-danger">High Risk</span>
                                            @elseif($alert->risk_level === 'Medium Risk')
                                                <span class="badge bg-warning">Medium Risk</span>
                                            @else
                                                <span class="badge bg-success">Low Risk</span>
                                            @endif
                                        </td>
                                        <td>{{ $alert->risk_level }}</td>
                                        <td>
                                            <span class="badge bg-{{ $alert->attendance_percentage >= 75 ? 'success' : ($alert->attendance_percentage >= 50 ? 'warning' : 'danger') }}">
                                                {{ round($alert->attendance_percentage, 1) }}%
                                            </span>
                                        </td>
                                        <td>{{ round($alert->average_marks, 1) }}</td>
                                        <td>{{ $alert->created_at->format('M d, Y g:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No recent alerts</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-success">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle text-success" style="font-size: 32px;"></i>
                    <h5 class="mt-3">No Active Alerts</h5>
                    <p class="text-muted">All students are doing well!</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Faculty Performance Chart
    const facultyCtx = document.getElementById('facultyPerformanceChart').getContext('2d');
    new Chart(facultyCtx, {
        type: 'bar',
        data: {
            labels: @json($facultyStats->pluck('name')),
            datasets: [{
                label: 'Average Marks',
                data: @json($facultyStats->pluck('avgMarks')),
                backgroundColor: 'rgba(102, 126, 234, 0.8)',
                borderRadius: 5,
                borderSkipped: false,
            }, {
                label: 'Attendance %',
                data: @json($facultyStats->pluck('avgAttendance')),
                backgroundColor: 'rgba(118, 75, 162, 0.8)',
                borderRadius: 5,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Attendance Distribution Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Good Attendance (≥75%)', 'Average (50-74%)', 'Low (<50%)'],
            datasets: [{
                data: @json([
                    $studentStats->filter(fn($s) => $s['avgAttendance'] >= 75)->count(),
                    $studentStats->filter(fn($s) => $s['avgAttendance'] >= 50 && $s['avgAttendance'] < 75)->count(),
                    $studentStats->filter(fn($s) => $s['avgAttendance'] < 50)->count()
                ]),
                backgroundColor: [
                    'rgba(75, 192, 75, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(244, 67, 54, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Marks Distribution Chart
    const marksCtx = document.getElementById('marksDistributionChart').getContext('2d');
    new Chart(marksCtx, {
        type: 'line',
        data: {
            labels: @json($studentStats->take(10)->pluck('name')),
            datasets: [{
                label: 'Average Marks',
                data: @json($studentStats->take(10)->pluck('avgMarks')),
                borderColor: 'rgba(75, 192, 75, 1)',
                backgroundColor: 'rgba(75, 192, 75, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: 'rgba(75, 192, 75, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }, {
                label: 'Attendance %',
                data: @json($studentStats->take(10)->pluck('avgAttendance')),
                borderColor: 'rgba(102, 126, 234, 1)',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                yAxisID: 'y1',
                pointRadius: 5,
                pointBackgroundColor: 'rgba(102, 126, 234, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Average Marks'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Attendance %'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });

    // Course Enrollment Chart
    const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
    const enrollmentData = @json($courses->pluck('enrollments', 'course_name')->take(5));
    const courseLabels = @json($courses->pluck('course_name')->take(5));
    
    new Chart(enrollmentCtx, {
        type: 'polarArea',
        data: {
            labels: courseLabels,
            datasets: [{
                data: courseLabels.map((label, index) => enrollmentData[index] ? Object.keys(enrollmentData[index]).length : 0),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 75, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            scales: {
                r: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

<style>
    .dashboard-container {
        padding: 20px;
    }

    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .card-header {
        border-bottom: none;
        padding: 15px 20px;
    }

    .card-body {
        padding: 20px;
    }
</style>
@endsection
