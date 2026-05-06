@extends('layouts.hod')

@use('App\Models\Course')
@use('App\Models\Attendance')
@use('App\Models\Mark')

@section('hod-content')
<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-user-graduate"></i> {{ $student->user->name }}</h2>
            <p class="text-muted">{{ $student->user->reg_number }} • {{ $student->program }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('hod.students') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Students
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Student Information -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-id-card"></i> Student Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Student ID:</dt>
                        <dd class="col-sm-7"><code>{{ $student->user->reg_number }}</code></dd>

                        <dt class="col-sm-5">Email:</dt>
                        <dd class="col-sm-7">{{ $student->user->email }}</dd>

                        <dt class="col-sm-5">Program:</dt>
                        <dd class="col-sm-7">{{ $student->program }}</dd>

                        <dt class="col-sm-5">Batch:</dt>
                        <dd class="col-sm-7">{{ $student->batch }}</dd>

                        <dt class="col-sm-5">Semester:</dt>
                        <dd class="col-sm-7">{{ $student->semester }}</dd>

                        <dt class="col-sm-5">GPA:</dt>
                        <dd class="col-sm-7">{{ $student->gpa ?? 'N/A' }}</dd>

                        <dt class="col-sm-5">Status:</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-success">Active</span>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Performance Overview -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Academic Performance</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Courses Enrolled</h6>
                                    <h3 class="text-primary">{{ $enrollments->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Avg Attendance</h6>
                                    <h3 class="text-{{ $attendancePercent >= 75 ? 'success' : ($attendancePercent >= 50 ? 'warning' : 'danger') }}">
                                        {{ $attendancePercent }}%
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Avg Grade</h6>
                                    <h3 class="text-{{ $avgMarks >= 70 ? 'success' : ($avgMarks >= 50 ? 'warning' : 'danger') }}">
                                        {{ $avgMarks !== null ? round($avgMarks, 2) : 'N/A' }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrolled Courses -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-book"></i> Enrolled Courses</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Faculty</th>
                                <th>Attendance</th>
                                <th>Avg Marks</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($enrollments as $enrollment)
                                @php
                                    $course = $enrollment->course;
                                    $courseAttendance = \App\Models\Attendance::where('course_id', $course->id)
                                        ->where('student_id', $student->id)
                                        ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                                        ->first();
                                    $courseAttendancePercent = $courseAttendance && $courseAttendance->total > 0 
                                        ? round(($courseAttendance->present / $courseAttendance->total) * 100, 1)
                                        : 0;
                                    
                                    $courseMarks = \App\Models\Mark::where('course_id', $course->id)
                                        ->where('student_id', $student->id)
                                        ->avg('total_marks');
                                @endphp
                                <tr>
                                    <td><code>{{ $course->course_code }}</code></td>
                                    <td>{{ $course->course_name }}</td>
                                    <td>{{ $course->faculty->user->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $courseAttendancePercent >= 75 ? 'success' : ($courseAttendancePercent >= 50 ? 'warning' : 'danger') }}">
                                            {{ $courseAttendancePercent }}%
                                        </span>
                                    </td>
                                    <td>
                                        @if ($courseMarks)
                                            <strong class="text-{{ $courseMarks >= 70 ? 'success' : ($courseMarks >= 50 ? 'warning' : 'danger') }}">
                                                {{ round($courseMarks, 2) }}
                                            </strong>
                                        @else
                                            <span class="text-muted">No marks</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($courseAttendancePercent >= 75 && $courseMarks && $courseMarks >= 50)
                                            <span class="badge bg-success">Good</span>
                                        @elseif ($courseAttendancePercent < 50 || ($courseMarks && $courseMarks < 40))
                                            <span class="badge bg-danger">At Risk</span>
                                        @else
                                            <span class="badge bg-warning">Average</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No courses enrolled
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Risk Alerts -->
    @if ($riskRecords->isNotEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-exclamation-circle"></i> Academic Risk Alerts</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Risk Type</th>
                                    <th>Course</th>
                                    <th>Description</th>
                                    <th>Risk Score</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riskRecords as $risk)
                                    @php
                                        $course = \App\Models\Course::find($risk->course_id);
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="badge bg-danger">
                                                {{ ucfirst(str_replace('_', ' ', $risk->risk_type)) }}
                                            </span>
                                        </td>
                                        <td>{{ $course?->course_name ?? 'N/A' }}</td>
                                        <td>{{ $risk->description }}</td>
                                        <td>
                                            <strong>{{ round($risk->risk_score * 100, 1) }}%</strong>
                                        </td>
                                        <td>{{ $risk->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
