@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-chart-line"></i> My Dashboard
        </h2>
    </div>
</div>

<!-- Performance Stats -->
<div class="row">
    <div class="col-md-3">
        <div class="stat-box">
            <i class="fas fa-book fa-2x"></i>
            <h3>{{ $enrolledCourses->count() }}</h3>
            <p>Enrolled Courses</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <i class="fas fa-star fa-2x"></i>
            <h3>{{ $overallPerformance['average'] }}</h3>
            <p>Avg Marks</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <i class="fas fa-check fa-2x"></i>
            <h3>{{ count($attendanceData) }}</h3>
            <p>Courses Tracked</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <i class="fas fa-bell fa-2x"></i>
            <h3>{{ $alerts->count() }}</h3>
            <p>Active Alerts</p>
        </div>
    </div>
</div>

<!-- Enrolled Courses -->
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5>Enrolled Courses</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Faculty</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrolledCourses as $enrollment)
                            <tr>
                                <td><strong>{{ $enrollment->course->course_code }}</strong></td>
                                <td>{{ $enrollment->course->course_name }}</td>
                                <td>{{ $enrollment->course->faculty->user->name }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No enrolled courses</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Academic Risk -->
@if($academicRisks->count() > 0)
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5 class="text-danger">
                <i class="fas fa-exclamation-triangle"></i> Academic Risk Analysis
            </h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Risk Level</th>
                            <th>Risk Score</th>
                            <th>Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($academicRisks as $risk)
                            <tr>
                                <td>{{ $risk->course->course_name }}</td>
                                <td>
                                    @if($risk->risk_level === 'High Risk')
                                        <span class="badge bg-danger">{{ $risk->risk_level }}</span>
                                    @elseif($risk->risk_level === 'Medium Risk')
                                        <span class="badge bg-warning">{{ $risk->risk_level }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $risk->risk_level }}</span>
                                    @endif
                                </td>
                                <td>{{ round($risk->risk_score * 100, 1) }}%</td>
                                <td>{{ round($risk->attendance_percentage, 1) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Recent Alerts -->
@if($alerts->count() > 0)
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5>
                <i class="fas fa-bell"></i> Recent Alerts
            </h5>
            @foreach($alerts->take(5) as $alert)
                <div class="alert alert-{{ $alert->severity === 'high' ? 'danger' : ($alert->severity === 'medium' ? 'warning' : 'info') }} alert-dismissible fade show" role="alert">
                    <strong>{{ ucfirst($alert->alert_type) }}:</strong> {{ $alert->message }}
                    <small class="d-block mt-2 text-muted">{{ $alert->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
            <a href="{{ route('student.alerts') }}" class="btn btn-sm btn-outline-primary">
                View All Alerts
            </a>
        </div>
    </div>
</div>
@endif
@endsection
