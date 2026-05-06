@extends('layouts.hod')

@section('hod-content')
<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-chart-bar"></i> Department Analytics</h2>
            <p class="text-muted">Comprehensive analytics for {{ $hod->department }} Department</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('hod.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Faculty Performance Analytics -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Faculty Performance Analytics</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Faculty Name</th>
                                <th>Courses</th>
                                <th>Students</th>
                                <th>Avg Marks</th>
                                <th>Avg Attendance</th>
                                <th>Performance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($facultyStats as $faculty)
                                <tr>
                                    <td>
                                        <strong>{{ $faculty['name'] }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $faculty['courses'] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $faculty['totalStudents'] }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-{{ $faculty['avgMarks'] >= 70 ? 'success' : ($faculty['avgMarks'] >= 50 ? 'warning' : 'danger') }}">
                                            {{ $faculty['avgMarks'] }}
                                        </strong>
                                    </td>
                                    <td>
                                        <strong class="text-{{ $faculty['avgAttendance'] >= 75 ? 'success' : ($faculty['avgAttendance'] >= 50 ? 'warning' : 'danger') }}">
                                            {{ $faculty['avgAttendance'] }}%
                                        </strong>
                                    </td>
                                    <td>
                                        @php
                                            $score = ($faculty['avgMarks'] + ($faculty['avgAttendance'] / 100 * 100)) / 2;
                                        @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $score >= 70 ? 'success' : ($score >= 50 ? 'warning' : 'danger') }}" 
                                                 style="width: {{ $score }}%">
                                                {{ round($score, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No faculty data available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Performance Analytics -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Student Performance Analytics</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student Name</th>
                                <th>Alerts</th>
                                <th>Courses</th>
                                <th>Avg Marks</th>
                                <th>Avg Attendance</th>
                                <th>Performance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($studentStats as $student)
                                <tr>
                                    <td>
                                        <strong>{{ $student['name'] }}</strong>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#alertsModal" 
                                                onclick="loadStudentAlerts({{ $student['id'] }}, '{{ $student['name'] }}')">
                                            <i class="fas fa-bell"></i> View Alerts
                                        </button>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $student['courses'] }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-{{ $student['avgMarks'] >= 70 ? 'success' : ($student['avgMarks'] >= 50 ? 'warning' : 'danger') }}">
                                            {{ $student['avgMarks'] }}
                                        </strong>
                                    </td>
                                    <td>
                                        <strong class="text-{{ $student['avgAttendance'] >= 75 ? 'success' : ($student['avgAttendance'] >= 50 ? 'warning' : 'danger') }}">
                                            {{ $student['avgAttendance'] }}%
                                        </strong>
                                    </td>
                                    <td>
                                        @php
                                            $score = ($student['avgMarks'] + ($student['avgAttendance'] / 100 * 100)) / 2;
                                        @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $score >= 70 ? 'success' : ($score >= 50 ? 'warning' : 'danger') }}" 
                                                 style="width: {{ $score }}%">
                                                {{ round($score, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No student data available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Faculty</h6>
                    <h3 class="text-primary">{{ count($facultyStats) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Students</h6>
                    <h3 class="text-info">{{ count($studentStats) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Avg Faculty Performance</h6>
                    <h3 class="text-success">
                        @php
                            $avgFacultyScore = count($facultyStats) > 0 
                                ? round(collect($facultyStats)->avg(fn($f) => ($f['avgMarks'] + ($f['avgAttendance'])) / 2), 1)
                                : 0;
                        @endphp
                        {{ $avgFacultyScore }}%
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Avg Student Performance</h6>
                    <h3 class="text-warning">
                        @php
                            $avgStudentScore = count($studentStats) > 0 
                                ? round(collect($studentStats)->avg(fn($s) => ($s['avgMarks'] + ($s['avgAttendance'])) / 2), 1)
                                : 0;
                        @endphp
                        {{ $avgStudentScore }}%
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alerts Modal -->
<div class="modal fade" id="alertsModal" tabindex="-1" aria-labelledby="alertsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertsModalLabel">
                    <i class="fas fa-lightbulb"></i> Recommendations
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="alertsContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading recommendations...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function loadStudentAlerts(studentId, studentName) {
    const alertsContent = document.getElementById('alertsContent');
    const modalLabel = document.getElementById('alertsModalLabel');
    
    // Update modal title
    modalLabel.innerHTML = `<i class="fas fa-lightbulb"></i> Recommendations`;
    
    // Show loading state
    alertsContent.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading recommendations...</p>
        </div>
    `;
    
    // Fetch alerts from server
    fetch(`/hod/student/${studentId}/alerts`)
        .then(response => response.json())
        .then(data => {
            if (data.alerts && data.alerts.length > 0) {
                let recommendations = [];
                
                // Generate recommendations based on alerts
                data.alerts.forEach(alert => {
                    // Check attendance
                    if (alert.attendance_percentage < 75) {
                        recommendations.push({
                            icon: 'fa-calendar-check',
                            text: 'Improve attendance',
                            priority: 1
                        });
                    }
                    
                    // Check marks
                    if (alert.average_marks === null || alert.average_marks < 50) {
                        recommendations.push({
                            icon: 'fa-book',
                            text: 'Study harder',
                            priority: 1
                        });
                    } else if (alert.average_marks < 70) {
                        recommendations.push({
                            icon: 'fa-pencil-alt',
                            text: 'Improve academic performance',
                            priority: 2
                        });
                    }
                    
                    // Check risk level
                    if (alert.risk_level === 'High Risk') {
                        recommendations.push({
                            icon: 'fa-user-graduate',
                            text: 'Seek academic support from faculty',
                            priority: 1
                        });
                    } else if (alert.risk_level === 'Medium Risk') {
                        recommendations.push({
                            icon: 'fa-clock',
                            text: 'Focus more on assignments',
                            priority: 2
                        });
                    }
                });
                
                // Remove duplicates and sort by priority
                recommendations = [...new Map(recommendations.map(item => [item.text, item])).values()]
                    .sort((a, b) => a.priority - b.priority);
                
                if (recommendations.length > 0) {
                    let html = `
                        <div style="padding: 20px;">
                            <ul style="list-style: none; padding: 0;">
                    `;
                    
                    recommendations.forEach(rec => {
                        html += `
                            <li style="margin-bottom: 15px; padding-left: 30px; position: relative;">
                                <i class="fas ${rec.icon}" style="position: absolute; left: 0; color: #667eea; font-size: 18px;"></i>
                                <strong>${rec.text}</strong>
                            </li>
                        `;
                    });
                    
                    html += `
                            </ul>
                        </div>
                    `;
                    
                    alertsContent.innerHTML = html;
                } else {
                    alertsContent.innerHTML = `
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle"></i> Great! No recommendations needed. Keep up the good work!
                        </div>
                    `;
                }
            } else {
                alertsContent.innerHTML = `
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle"></i> Excellent performance! No recommendations at this time.
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alertsContent.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle"></i> Error loading recommendations. Please try again.
                </div>
            `;
        });
}
</script>
@endsection
