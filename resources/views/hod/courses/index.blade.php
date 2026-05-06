@extends('layouts.hod')

@use('App\Models\Attendance')

@section('hod-content')
<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-book"></i> Course Management</h2>
            <p class="text-muted">View all courses in {{ $hod->department }} Department</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('hod.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="input-group">
                <input type="text" class="form-control" id="searchCourse" placeholder="Search course by code or name...">
            </div>
        </div>
    </div>

    <!-- Courses List -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Courses ({{ $courses->total() }})</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Faculty</th>
                                <th>Semester</th>
                                <th>Credits</th>
                                <th>Students</th>
                                <th>Avg Attendance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                                @php
                                    $avgAttendance = \App\Models\Attendance::where('course_id', $course->id)
                                        ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                                        ->first();
                                    $attendancePercent = $avgAttendance && $avgAttendance->total > 0 
                                        ? round(($avgAttendance->present / $avgAttendance->total) * 100, 1)
                                        : 0;
                                @endphp
                                <tr class="course-row">
                                    <td><code>{{ $course->course_code }}</code></td>
                                    <td>{{ $course->course_name }}</td>
                                    <td>{{ $course->faculty->user->name }}</td>
                                    <td>Sem {{ $course->semester }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $course->credits }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $course->enrollments()->count() }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $attendancePercent >= 75 ? 'success' : ($attendancePercent >= 50 ? 'warning' : 'danger') }}">
                                            {{ $attendancePercent }}%
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#courseModal{{ $course->id }}">
                                            <i class="fas fa-eye"></i> Details
                                        </button>
                                    </td>
                                </tr>

                                <!-- Course Details Modal -->
                                <div class="modal fade" id="courseModal{{ $course->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $course->course_name }} ({{ $course->course_code }})</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Course Information</h6>
                                                        <p>
                                                            <strong>Code:</strong> {{ $course->course_code }}<br>
                                                            <strong>Name:</strong> {{ $course->course_name }}<br>
                                                            <strong>Credits:</strong> {{ $course->credits }}<br>
                                                            <strong>Semester:</strong> {{ $course->semester }}<br>
                                                            <strong>Total Classes:</strong> {{ $course->total_classes }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Faculty & Enrollment</h6>
                                                        <p>
                                                            <strong>Faculty:</strong> {{ $course->faculty->user->name }}<br>
                                                            <strong>Enrolled Students:</strong> <span class="badge bg-info">{{ $course->enrollments()->count() }}</span><br>
                                                            <strong>Avg Attendance:</strong> <span class="badge bg-success">{{ $attendancePercent }}%</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No courses found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchCourse').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.course-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
