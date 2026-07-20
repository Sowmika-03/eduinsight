@extends('layouts.app')

@section('title', 'Faculty Dashboard')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2.5rem;">
    <h1 style="font-size: 2rem; font-weight: 700; color: #1E293B; margin: 0; letter-spacing: -0.5px;">
        <i class="fas fa-chalkboard-user" style="color: #5B7CFF; margin-right: 0.75rem;"></i>
        Faculty Dashboard
    </h1>
    <p style="color: #64748b; margin-top: 0.5rem; font-size: 0.95rem;">Manage your courses and monitor student performance.</p>
</div>

<!-- Stats Row -->
<div class="row g-3" style="margin-bottom: 2rem;">
    <div class="col-lg-4 col-md-6">
        <div class="stat-box">
            <i class="fas fa-book"></i>
            <h3>{{ $courses->count() }}</h3>
            <p>Courses Teaching</p>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="stat-box">
            <i class="fas fa-users"></i>
            <h3>{{ $totalStudents }}</h3>
            <p>Total Students</p>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="stat-box">
            <i class="fas fa-check"></i>
            <h3>{{ round($avgAttendance, 1) }}%</h3>
            <p>Average Attendance</p>
        </div>
    </div>
</div>

<!-- Courses Section -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <h5 style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                <i class="fas fa-book" style="color: #5B7CFF;"></i>
                My Courses
            </h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-code" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Course Code</th>
                            <th><i class="fas fa-heading" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Course Name</th>
                            <th><i class="fas fa-calendar" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Semester</th>
                            <th><i class="fas fa-users" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Students</th>
                            <th><i class="fas fa-cog" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                            <tr>
                                <td><span style="font-weight: 700; color: #1E293B;">{{ $course->course_code }}</span></td>
                                <td>{{ $course->course_name }}</td>
                                <td>{{ $course->semester }}</td>
                                <td>
                                    <span class="badge" style="background: rgba(91, 124, 255, 0.15); color: #5B7CFF; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">
                                        {{ $course->enrollments->count() }} students
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('faculty.course.show', $course) }}" 
                                       style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 0.9rem; background: rgba(91, 124, 255, 0.1); color: #5B7CFF; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; font-size: 0.9rem;" 
                                       onmouseover="this.style.background='rgba(91, 124, 255, 0.2)'" 
                                       onmouseout="this.style.background='rgba(91, 124, 255, 0.1)'">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2rem; font-weight: 500;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                                    No courses assigned yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Low Attendance Students -->
<div class="row" style="margin-bottom: 2rem;">
    <div class="col-12">
        <div class="dashboard-card">
            <h5 style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                <i class="fas fa-exclamation-circle" style="color: #F59E0B;"></i>
                Students with Low Attendance
            </h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Student Name</th>
                            <th><i class="fas fa-envelope" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Email</th>
                            <th><i class="fas fa-percent" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowAttendanceStudents as $student)
                            <tr>
                                <td><span style="font-weight: 600; color: #1E293B;">{{ $student->user->name }}</span></td>
                                <td>{{ $student->user->email }}</td>
                                <td>
                                    <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #EF4444; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">
                                        Attendance < 60%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; color: #94a3b8; padding: 2rem; font-weight: 500;">
                                    <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 1rem; display: block; color: #10B981;"></i>
                                    All students have good attendance
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Recent Alerts -->
<div class="row" style="margin-bottom: 2rem;">
    <div class="col-12">
        <div class="dashboard-card">
            <h5 style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                <i class="fas fa-bell" style="color: #EF4444;"></i>
                Recent Student Alerts
            </h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Student</th>
                            <th><i class="fas fa-flag" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Alert Type</th>
                            <th><i class="fas fa-book" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Course</th>
                            <th><i class="fas fa-exclamation-circle" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Severity</th>
                            <th><i class="fas fa-calendar" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAlerts as $alert)
                            <tr>
                                <td><span style="font-weight: 600; color: #1E293B;">{{ $alert->student->user->name }}</span></td>
                                <td>
                                    @if($alert->alert_type === 'low_attendance')
                                        <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">Low Attendance</span>
                                    @elseif($alert->alert_type === 'low_marks')
                                        <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #3B82F6; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">Low Marks</span>
                                    @elseif($alert->alert_type === 'high_risk')
                                        <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #EF4444; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">High Risk</span>
                                    @else
                                        <span class="badge" style="background: rgba(100, 116, 139, 0.15); color: #64748b; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">{{ ucfirst(str_replace('_', ' ', $alert->alert_type)) }}</span>
                                    @endif
                                </td>
                                <td>{{ $alert->course?->course_name ?? 'N/A' }}</td>
                                <td>
                                    @if($alert->severity === 'high')
                                        <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #EF4444; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">High</span>
                                    @elseif($alert->severity === 'medium')
                                        <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">Medium</span>
                                    @else
                                        <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #3B82F6; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">Low</span>
                                    @endif
                                </td>
                                <td style="color: #64748b; font-weight: 500;">{{ $alert->alert_date->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2rem; font-weight: 500;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                                    No recent alerts
                                </td>
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
