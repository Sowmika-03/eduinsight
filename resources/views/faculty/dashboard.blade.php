@extends('layouts.app')

@section('title', 'Faculty Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-chalkboard-user"></i> Faculty Dashboard
        </h2>
    </div>
</div>

<!-- Stats Row -->
<div class="row">
    <div class="col-md-4">
        <div class="stat-box">
            <i class="fas fa-book fa-2x"></i>
            <h3>{{ $courses->count() }}</h3>
            <p>Courses Teaching</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-box">
            <i class="fas fa-users fa-2x"></i>
            <h3>{{ $totalStudents }}</h3>
            <p>Total Students</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-box">
            <i class="fas fa-check fa-2x"></i>
            <h3>{{ round($avgAttendance, 1) }}%</h3>
            <p>Avg Attendance</p>
        </div>
    </div>
</div>

<!-- Courses Section -->
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5>My Courses</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Semester</th>
                            <th>Students</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                            <tr>
                                <td><strong>{{ $course->course_code }}</strong></td>
                                <td>{{ $course->course_name }}</td>
                                <td>{{ $course->semester }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $course->enrollments->count() }} students
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('faculty.course.show', $course) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No courses assigned</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Low Attendance Students -->
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5><i class="fas fa-exclamation-circle text-warning"></i> Students with Low Attendance</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowAttendanceStudents as $student)
                            <tr>
                                <td>{{ $student->user->name }}</td>
                                <td>{{ $student->user->email }}</td>
                                <td>
                                    <span class="badge bg-danger">
                                        Attendance < 60%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No students with low attendance</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Recent Alerts -->
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5><i class="fas fa-bell text-danger"></i> Recent Student Alerts</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Alert Type</th>
                            <th>Course</th>
                            <th>Severity</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAlerts as $alert)
                            <tr>
                                <td>{{ $alert->student->user->name }}</td>
                                <td>
                                    @if($alert->alert_type === 'low_attendance')
                                        <span class="badge bg-warning">Low Attendance</span>
                                    @elseif($alert->alert_type === 'low_marks')
                                        <span class="badge bg-info">Low Marks</span>
                                    @elseif($alert->alert_type === 'high_risk')
                                        <span class="badge bg-danger">High Risk</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $alert->alert_type)) }}</span>
                                    @endif
                                </td>
                                <td>{{ $alert->course?->course_name ?? 'N/A' }}</td>
                                <td>
                                    @if($alert->severity === 'high')
                                        <span class="badge bg-danger">High</span>
                                    @elseif($alert->severity === 'medium')
                                        <span class="badge bg-warning">Medium</span>
                                    @else
                                        <span class="badge bg-info">Low</span>
                                    @endif
                                </td>
                                <td>{{ $alert->alert_date->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No recent alerts</td>
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
