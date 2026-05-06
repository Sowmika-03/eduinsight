@extends('layouts.app')

@section('title', $student->user->name . ' - Profile')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-user-graduate"></i> {{ $student->user->name }}</h2>
            <p class="text-muted">Student ID: {{ $student->user->reg_number }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('faculty.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Student Info -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-id-card"></i> Student Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">ID:</dt>
                        <dd class="col-sm-7"><code>{{ $student->user->reg_number }}</code></dd>

                        <dt class="col-sm-5">Email:</dt>
                        <dd class="col-sm-7">{{ $student->user->email }}</dd>

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
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Performance Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Courses Enrolled</h6>
                                    <h3 class="text-primary">{{ $student->enrollments->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Avg GPA</h6>
                                    <h3 class="text-success">{{ $student->gpa ?? 'N/A' }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Avg Attendance</h6>
                                    <h3 class="text-warning">
                                        @php
                                            $avgAttendance = \App\Models\Attendance::where('student_id', $student->id)
                                                ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                                                ->first();
                                            echo $avgAttendance && $avgAttendance->total > 0 
                                                ? round(($avgAttendance->present / $avgAttendance->total) * 100, 1) . '%'
                                                : 'N/A';
                                        @endphp
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
                                <th>Semester</th>
                                <th>Attendance</th>
                                <th>Average Mark</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($student->enrollments as $enrollment)
                                @php
                                    $course = $enrollment->course;
                                    $attendance = \App\Models\Attendance::where('course_id', $course->id)
                                        ->where('student_id', $student->id)
                                        ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                                        ->first();
                                    $attendancePercent = $attendance && $attendance->total > 0 
                                        ? round(($attendance->present / $attendance->total) * 100, 1)
                                        : 0;
                                    
                                    $marks = \App\Models\Mark::where('course_id', $course->id)
                                        ->where('student_id', $student->id)
                                        ->avg('total_marks');
                                    $avgMark = $marks ? round($marks, 2) : 'N/A';
                                @endphp
                                <tr>
                                    <td><code>{{ $course->course_code }}</code></td>
                                    <td>{{ $course->course_name }}</td>
                                    <td>Semester {{ $course->semester }}</td>
                                    <td>
                                        <span class="badge bg-{{ $attendancePercent >= 75 ? 'success' : ($attendancePercent >= 50 ? 'warning' : 'danger') }}">
                                            {{ $attendancePercent }}%
                                        </span>
                                    </td>
                                    <td>
                                        @if ($avgMark !== 'N/A')
                                            <strong class="text-{{ $avgMark >= 70 ? 'success' : ($avgMark >= 50 ? 'warning' : 'danger') }}">
                                                {{ $avgMark }}
                                            </strong>
                                        @else
                                            <span class="text-muted">No marks</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($attendancePercent >= 75 && $avgMark !== 'N/A' && $avgMark >= 50)
                                            <span class="badge bg-success">Good</span>
                                        @elseif ($attendancePercent < 50 || ($avgMark !== 'N/A' && $avgMark < 40))
                                            <span class="badge bg-danger">At Risk</span>
                                        @else
                                            <span class="badge bg-warning">Average</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Not enrolled in any courses
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts and Warnings -->
    @php
        $riskRecords = \App\Models\AcademicRisk::where('student_id', $student->id)->get();
    @endphp
    @if ($riskRecords->isNotEmpty())
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-exclamation-circle"></i> Academic Risk Alerts</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Reason</th>
                                    <th>Description</th>
                                    <th>Date Flagged</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riskRecords as $risk)
                                    <tr>
                                        <td>{{ ucfirst(str_replace('_', ' ', $risk->risk_type)) }}</td>
                                        <td>{{ $risk->description }}</td>
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
