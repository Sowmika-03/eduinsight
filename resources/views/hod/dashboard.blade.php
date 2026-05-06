@extends('layouts.hod')

@use('App\Models\Student')

@section('hod-content')
<div class="mt-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-chalkboard-user"></i> HOD Dashboard</h2>
            <p class="text-muted">{{ $hod->department }} Department Overview</p>
        </div>
        <div class="col-md-4 d-flex gap-2 justify-content-end">
            <a href="{{ route('hod.analytics') }}" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> Analytics
            </a>
        </div>
    </div>

    <!-- Key Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2"><i class="fas fa-users"></i> Faculty</h6>
                            <h3 class="text-primary">{{ $totalFaculty }}</h3>
                            <small class="text-success">{{ $activeFaculty }} Active</small>
                        </div>
                        <i class="fas fa-users fa-2x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2"><i class="fas fa-book"></i> Courses</h6>
                            <h3 class="text-info">{{ $totalCourses }}</h3>
                            <small class="text-muted">Active Courses</small>
                        </div>
                        <i class="fas fa-book fa-2x text-info opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2"><i class="fas fa-graduation-cap"></i> Students</h6>
                            <h3 class="text-warning">{{ $enrolledStudents }}</h3>
                            <small class="text-muted">Enrolled</small>
                        </div>
                        <i class="fas fa-graduation-cap fa-2x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2"><i class="fas fa-exclamation-triangle"></i> At Risk</h6>
                            <h3 class="text-danger">{{ $riskStudents }}</h3>
                            <small class="text-muted">Students</small>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x text-danger opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Buttons -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3"><i class="fas fa-bolt"></i> Quick Actions</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('hod.faculty') }}" class="btn btn-primary">
                            <i class="fas fa-user-tie"></i> Manage Faculty
                        </a>
                        <a href="{{ route('hod.students') }}" class="btn btn-primary">
                            <i class="fas fa-users"></i> Manage Students
                        </a>
                        <a href="{{ route('hod.courses') }}" class="btn btn-primary">
                            <i class="fas fa-book"></i> Manage Courses
                        </a>
                        <a href="{{ route('hod.analytics') }}" class="btn btn-info">
                            <i class="fas fa-chart-line"></i> View Analytics
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Department Faculty Overview -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-users"></i> Department Faculty</h5>
                    <a href="{{ route('hod.faculty') }}" class="btn btn-sm btn-light">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Employee ID</th>
                                <th>Specialization</th>
                                <th>Courses</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($faculty->take(5) as $fac)
                                <tr>
                                    <td>{{ $fac->user->name }}</td>
                                    <td><code>{{ $fac->employee_id }}</code></td>
                                    <td>{{ $fac->specialization }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $fac->courses()->count() }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $fac->approval_status === 'approved' ? 'success' : 'warning' }}">
                                            {{ ucfirst($fac->approval_status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        No faculty found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Low Attendance Students -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-clipboard-list"></i> Low Attendance</h5>
                    <a href="{{ route('hod.students') }}" class="btn btn-sm btn-light">View All</a>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($lowAttendanceStudents as $item)
                        <a href="{{ route('hod.students.show', $item['student']->id) }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item['student']->user->name }}</h6>
                                    <small class="text-muted">{{ $item['student']->user->reg_number }}</small>
                                </div>
                                <span class="badge bg-danger">{{ $item['attendance'] }}%</span>
                            </div>
                        </a>
                    @empty
                        <div class="p-3 text-center text-muted">
                            <small>No attendance issues</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Alerts -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-bell"></i> Recent Academic Alerts</h5>
                    <a href="{{ route('hod.students') }}" class="btn btn-sm btn-light">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Department</th>
                                <th>Risk Type</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentAlerts as $alert)
                                @php
                                    $student = Student::find($alert->student_id);
                                @endphp
                                <tr>
                                    <td>{{ $student->user->name }}</td>
                                    <td>{{ $hod->department }}</td>
                                    <td>
                                        <span class="badge bg-danger">
                                            {{ ucfirst(str_replace('_', ' ', $alert->risk_type)) }}
                                        </span>
                                    </td>
                                    <td>{{ $alert->description }}</td>
                                    <td>{{ $alert->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
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
</div>
@endsection
