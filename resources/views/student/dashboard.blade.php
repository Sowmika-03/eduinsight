@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2.5rem;">
    <h1 style="font-size: 2rem; font-weight: 700; color: #1E293B; margin: 0; letter-spacing: -0.5px;">
        <i class="fas fa-chart-line" style="color: #5B7CFF; margin-right: 0.75rem;"></i>
        My Dashboard
    </h1>
    <p style="color: #64748b; margin-top: 0.5rem; font-size: 0.95rem;">Track your academic performance and stay informed about alerts.</p>
</div>

<!-- Performance Stats -->
<div class="row g-3" style="margin-bottom: 2rem;">
    <div class="col-lg-3 col-md-6">
        <div class="stat-box">
            <i class="fas fa-book"></i>
            <h3>{{ $enrolledCourses->count() }}</h3>
            <p>Enrolled Courses</p>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-box">
            <i class="fas fa-star"></i>
            <h3>{{ $overallPerformance['average'] }}</h3>
            <p>Average Marks</p>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-box">
            <i class="fas fa-check"></i>
            <h3>{{ count($attendanceData) }}</h3>
            <p>Courses Tracked</p>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-box">
            <i class="fas fa-bell"></i>
            <h3>{{ $alerts->count() }}</h3>
            <p>Active Alerts</p>
        </div>
    </div>
</div>

<!-- Enrolled Courses -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <h5 style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                <i class="fas fa-book" style="color: #5B7CFF;"></i>
                Enrolled Courses
            </h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-code" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Course Code</th>
                            <th><i class="fas fa-heading" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Course Name</th>
                            <th><i class="fas fa-user-tie" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Faculty</th>
                            <th><i class="fas fa-check-circle" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrolledCourses as $enrollment)
                            <tr>
                                <td><span style="font-weight: 700; color: #1E293B;">{{ $enrollment->course->course_code }}</span></td>
                                <td>{{ $enrollment->course->course_name }}</td>
                                <td>{{ $enrollment->course->faculty->user->name }}</td>
                                <td>
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #10B981; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #94a3b8; padding: 2rem; font-weight: 500;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                                    No enrolled courses
                                </td>
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
<div class="row" style="margin-bottom: 2rem;">
    <div class="col-12">
        <div class="dashboard-card">
            <h5 style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                <i class="fas fa-exclamation-triangle" style="color: #EF4444;"></i>
                Academic Risk Analysis
            </h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-book" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Course</th>
                            <th><i class="fas fa-shield" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Risk Level</th>
                            <th><i class="fas fa-chart-bar" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Risk Score</th>
                            <th><i class="fas fa-percent" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($academicRisks as $risk)
                            <tr>
                                <td><span style="font-weight: 600; color: #1E293B;">{{ $risk->course->course_name }}</span></td>
                                <td>
                                    @if($risk->risk_level === 'High Risk')
                                        <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #EF4444; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">{{ $risk->risk_level }}</span>
                                    @elseif($risk->risk_level === 'Medium Risk')
                                        <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">{{ $risk->risk_level }}</span>
                                    @else
                                        <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #10B981; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">{{ $risk->risk_level }}</span>
                                    @endif
                                </td>
                                <td style="color: #64748b; font-weight: 600;">{{ round($risk->risk_score * 100, 1) }}%</td>
                                <td style="color: #64748b; font-weight: 600;">{{ round($risk->attendance_percentage, 1) }}%</td>
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
    <div class="col-12">
        <div class="dashboard-card">
            <h5 style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                <i class="fas fa-bell" style="color: #EF4444;"></i>
                Recent Alerts
            </h5>
            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                @foreach($alerts->take(5) as $alert)
                    <div style="display: flex; gap: 1rem; padding: 1rem; border-left: 4px solid {{ $alert->severity === 'high' ? '#EF4444' : ($alert->severity === 'medium' ? '#F59E0B' : '#3B82F6') }}; background: rgba({{ $alert->severity === 'high' ? '239, 68, 68' : ($alert->severity === 'medium' ? '245, 158, 11' : '59, 130, 246') }}, 0.05); border-radius: 10px;">
                        <div style="display: flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; border-radius: 50%; background: rgba({{ $alert->severity === 'high' ? '239, 68, 68' : ($alert->severity === 'medium' ? '245, 158, 11' : '59, 130, 246') }}, 0.2);">
                            <i class="fas fa-{{ $alert->severity === 'high' ? 'exclamation-circle' : ($alert->severity === 'medium' ? 'alert' : 'info-circle') }}" style="color: {{ $alert->severity === 'high' ? '#EF4444' : ($alert->severity === 'medium' ? '#F59E0B' : '#3B82F6') }}; font-size: 1.2rem;"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: #1E293B; margin-bottom: 0.25rem;">{{ ucfirst($alert->alert_type) }}</div>
                            <p style="color: #64748b; margin: 0; font-size: 0.9rem;">{{ $alert->message }}</p>
                            <small style="color: #94a3b8; display: block; margin-top: 0.5rem;">{{ $alert->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('student.alerts') }}" 
               style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5B7CFF 0%, #7B4DFF 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(91, 124, 255, 0.3);"
               onmouseover="this.style.boxShadow='0 6px 16px rgba(91, 124, 255, 0.4)'; this.style.transform='translateY(-2px)'"
               onmouseout="this.style.boxShadow='0 4px 12px rgba(91, 124, 255, 0.3)'; this.style.transform='translateY(0)'">
                <i class="fas fa-bell"></i> View All Alerts
            </a>
        </div>
    </div>
</div>
@endif
@endsection
