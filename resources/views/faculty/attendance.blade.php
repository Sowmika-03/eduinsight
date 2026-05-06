@extends('layouts.app')

@section('title', 'Attendance Management')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-clipboard-list"></i> Attendance Management</h2>
            <p class="text-muted">View and manage student attendance for your courses</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('faculty.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($courses->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> You don't have any courses yet.
        </div>
    @else
        <!-- Course Tabs -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    @foreach ($courses as $index => $course)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($index === 0) active @endif" id="course-{{ $course->id }}-tab" 
                                    data-bs-toggle="tab" data-bs-target="#course-{{ $course->id }}-content" 
                                    type="button" role="tab">
                                {{ $course->course_name }} ({{ $course->course_code }})
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="tab-content">
                @foreach ($courses as $index => $course)
                    <div class="tab-pane fade @if($index === 0) show active @endif" id="course-{{ $course->id }}-content" role="tabpanel">
                        <div class="card-body">
                            @if (isset($attendanceData[$course->id]) && $attendanceData[$course->id]->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Student Name</th>
                                                <th>Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($attendanceData[$course->id] as $attendance)
                                                <tr>
                                                    <td>{{ $attendance->attendance_date->format('d M Y') }}</td>
                                                    <td>
                                                        <strong>{{ $attendance->student->user->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $attendance->student->student_id }}</small>
                                                    </td>
                                                    <td>
                                                        @if ($attendance->status === 'present')
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check"></i> Present
                                                            </span>
                                                        @elseif ($attendance->status === 'absent')
                                                            <span class="badge bg-danger">
                                                                <i class="fas fa-times"></i> Absent
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">
                                                                <i class="fas fa-clock"></i> Late
                                                            </span>
                                                        @endif
                                                        <small class="text-muted">{{ $attendance->remarks ?? '' }}</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" 
                                                                data-bs-target="#editAttendanceModal{{ $attendance->id }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editAttendanceModal{{ $attendance->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Attendance</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form method="POST" action="{{ route('faculty.attendance.update', $attendance->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Student</label>
                                                                        <input type="text" class="form-control" 
                                                                               value="{{ $attendance->student->user->name }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Status</label>
                                                                        <select class="form-select" name="status" required>
                                                                            <option value="present" @selected($attendance->status === 'present')>Present</option>
                                                                            <option value="absent" @selected($attendance->status === 'absent')>Absent</option>
                                                                            <option value="late" @selected($attendance->status === 'late')>Late</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Remarks</label>
                                                                        <textarea class="form-control" name="remarks" rows="2" 
                                                                                  placeholder="Medical leave, etc...">{{ $attendance->remarks }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Attendance Statistics -->
                                <div class="row mt-4">
                                    @php
                                        $attendance_stats = $attendanceData[$course->id]->groupBy('student_id')->map(function($group) {
                                            $total = $group->count();
                                            $present = $group->where('status', 'present')->count();
                                            $percentage = ($present / $total) * 100;
                                            return [
                                                'total' => $total,
                                                'present' => $present,
                                                'percentage' => round($percentage, 2)
                                            ];
                                        });
                                    @endphp
                                    <div class="col-md-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h6 class="card-title text-muted">Average Attendance</h6>
                                                <h3 class="text-primary">
                                                    {{ round($attendance_stats->avg('percentage'), 1) }}%
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h6 class="card-title text-muted">Total Classes</h6>
                                                <h3 class="text-info">
                                                    {{ $attendanceData[$course->id]->pluck('attendance_date')->unique()->count() }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h6 class="card-title text-muted">Total Students</h6>
                                                <h3 class="text-success">
                                                    {{ $attendance_stats->count() }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h6 class="card-title text-muted">Low Attendance</h6>
                                                <h3 class="text-danger">
                                                    {{ $attendance_stats->where('percentage', '<', 60)->count() }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> No attendance records for this course yet.
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
