@extends('layouts.app')

@section('title', 'My Courses')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-book"></i> My Courses</h2>
            <p class="text-muted">View and manage your courses</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('faculty.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    @if ($courses->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> You don't have any courses assigned yet.
        </div>
    @else
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">{{ $course->course_name }}</h5>
                                    <small>{{ $course->course_code }} • {{ $course->credits }} Credits</small>
                                </div>
                                <span class="badge bg-light text-primary">{{ $course->enrollments->count() }} Students</span>
                            </div>
                        </div>

                        <div class="card-body">
                            <p class="text-muted">{{ $course->description }}</p>
                            
                            <dl class="row mb-0">
                                <dt class="col-sm-6">Semester:</dt>
                                <dd class="col-sm-6">{{ $course->semester }}</dd>

                                <dt class="col-sm-6">Total Classes:</dt>
                                <dd class="col-sm-6">{{ $course->total_classes }}</dd>

                                <dt class="col-sm-6">Enrolled Students:</dt>
                                <dd class="col-sm-6">{{ $course->enrollments->count() }}</dd>
                            </dl>
                        </div>

                        <div class="card-footer bg-light">
                            <div class="btn-group w-100" role="group">
                                <a href="{{ route('faculty.course.show', $course->id) }}" class="btn btn-sm btn-primary flex-grow-1">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                <button class="btn btn-sm btn-info flex-grow-1" data-bs-toggle="modal" 
                                        data-bs-target="#courseStatsModal{{ $course->id }}">
                                    <i class="fas fa-chart-bar"></i> Statistics
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Modal -->
                    <div class="modal fade" id="courseStatsModal{{ $course->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $course->course_name }} - Statistics</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <h6 class="card-title text-muted">Total Students</h6>
                                                    <h3 class="text-primary">{{ $course->enrollments->count() }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <h6 class="card-title text-muted">Total Classes</h6>
                                                    <h3 class="text-info">{{ $course->total_classes }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @php
                                        $avgAttendance = \App\Models\Attendance::where('course_id', $course->id)
                                            ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                                            ->first();
                                        $attendancePercent = $avgAttendance && $avgAttendance->total > 0 
                                            ? round(($avgAttendance->present / $avgAttendance->total) * 100, 1)
                                            : 0;
                                    @endphp

                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Average Attendance</h6>
                                            <div class="progress mb-2" style="height: 25px;">
                                                <div class="progress-bar bg-success" style="width: {{ $attendancePercent }}%">
                                                    {{ $attendancePercent }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection
