@extends('layouts.app')

@section('title', $course->course_name)

@section('content')
<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-book-open"></i> {{ $course->course_name }}</h2>
            <p class="text-muted">{{ $course->course_code }} • Semester {{ $course->semester }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('faculty.courses') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Courses
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted"><i class="fas fa-users"></i> Enrolled</h6>
                    <h3 class="text-primary">{{ $course->enrollments->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted"><i class="fas fa-calendar"></i> Classes</h6>
                    <h3 class="text-info">{{ $course->total_classes }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted"><i class="fas fa-star"></i> Credits</h6>
                    <h3 class="text-warning">{{ $course->credits }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted"><i class="fas fa-check"></i> Avg Attendance</h6>
                    <h3 class="text-success">
                        @php
                            $avgAttendance = \App\Models\Attendance::where('course_id', $course->id)
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

    <div class="row">
        <!-- Course Information -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Course Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Code:</dt>
                        <dd class="col-sm-7"><code>{{ $course->course_code }}</code></dd>

                        <dt class="col-sm-5">Semester:</dt>
                        <dd class="col-sm-7">{{ $course->semester }}</dd>

                        <dt class="col-sm-5">Credits:</dt>
                        <dd class="col-sm-7">{{ $course->credits }}</dd>

                        <dt class="col-sm-5">Classes:</dt>
                        <dd class="col-sm-7">{{ $course->total_classes }}</dd>
                    </dl>
                    <hr>
                    <h6 class="font-weight-bold mb-2">Description</h6>
                    <p class="text-muted">{{ $course->description }}</p>
                </div>
            </div>
        </div>

        <!-- Enrolled Students -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-users"></i> Enrolled Students ({{ $course->enrollments->count() }})</h5>
                    <input type="text" id="searchStudents" class="form-control form-control-sm" style="width: 200px;" placeholder="Search students...">
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Attendance</th>
                                <th>Avg Mark</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($course->enrollments as $enrollment)
                                @php
                                    $student = $enrollment->student;
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
                                <tr class="student-row">
                                    <td>{{ $student->user->reg_number }}</td>
                                    <td>{{ $student->user->name }}</td>
                                    <td>{{ $student->user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $attendancePercent >= 75 ? 'success' : ($attendancePercent >= 50 ? 'warning' : 'danger') }}">
                                            {{ $attendancePercent }}%
                                        </span>
                                    </td>
                                    <td>
                                        @if ($avgMark !== 'N/A')
                                            <strong>{{ $avgMark }}</strong>/100
                                        @else
                                            <span class="text-muted">No marks</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                                data-bs-target="#studentModal{{ $student->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Student Modal -->
                                <div class="modal fade" id="studentModal{{ $student->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $student->user->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6>Student Information</h6>
                                                <p>
                                                    <strong>Registration Number:</strong> {{ $student->user->reg_number }}<br>
                                                    <strong>Email:</strong> {{ $student->user->email }}<br>
                                                    <strong>GPA:</strong> {{ $student->gpa ?? 'N/A' }}
                                                </p>

                                                <h6 class="mt-3">Course Performance</h6>
                                                <p>
                                                    <strong>Attendance:</strong><br>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-{{ $attendancePercent >= 75 ? 'success' : ($attendancePercent >= 50 ? 'warning' : 'danger') }}" 
                                                             style="width: {{ $attendancePercent }}%">
                                                            {{ $attendancePercent }}%
                                                        </div>
                                                    </div>
                                                </p>

                                                <p>
                                                    <strong>Average Mark:</strong> 
                                                    @if ($avgMark !== 'N/A')
                                                        {{ $avgMark }}/100
                                                    @else
                                                        <span class="text-muted">No marks recorded</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <a href="{{ route('faculty.student.show', $student->id) }}" class="btn btn-primary">
                                                    View Full Profile
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No students enrolled in this course
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchStudents').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.student-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
