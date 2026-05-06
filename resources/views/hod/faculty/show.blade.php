@extends('layouts.hod')

@use('App\Models\Attendance')

@section('hod-content')
<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-user-tie"></i> {{ $faculty->user->name }}</h2>
            <p class="text-muted">{{ $faculty->userrole->name ?? 'Faculty' }} • {{ $faculty->employee_id }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('hod.faculty') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Faculty
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Faculty Information -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-id-card"></i> Faculty Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-6">Employee ID:</dt>
                        <dd class="col-sm-6"><code>{{ $faculty->employee_id }}</code></dd>

                        <dt class="col-sm-6">Email:</dt>
                        <dd class="col-sm-6">{{ $faculty->user->email }}</dd>

                        <dt class="col-sm-6">Phone:</dt>
                        <dd class="col-sm-6">{{ $faculty->user->phone ?? 'N/A' }}</dd>

                        <dt class="col-sm-6">Department:</dt>
                        <dd class="col-sm-6">{{ $faculty->department }}</dd>

                        <dt class="col-sm-6">Specialization:</dt>
                        <dd class="col-sm-6">{{ $faculty->specialization }}</dd>

                        <dt class="col-sm-6">Qualification:</dt>
                        <dd class="col-sm-6">{{ $faculty->qualification }}</dd>

                        <dt class="col-sm-6">Experience:</dt>
                        <dd class="col-sm-6">{{ $faculty->experience_years }} years</dd>

                        <dt class="col-sm-6">Status:</dt>
                        <dd class="col-sm-6">
                            <span class="badge bg-{{ $faculty->approval_status === 'approved' ? 'success' : ($faculty->approval_status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($faculty->approval_status) }}
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Faculty Statistics -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Teaching Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Active Courses</h6>
                                    <h3 class="text-primary">{{ $totalCourses }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Total Students</h6>
                                    <h3 class="text-info">{{ $totalStudents }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Avg Attendance</h6>
                                    <h3 class="text-warning">{{ $attendancePercent }}%</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Taught -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-book"></i> Courses ({{ $courses->total() }})</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Credits</th>
                                <th>Students</th>
                                <th>Semester</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                                <tr>
                                    <td><code>{{ $course->course_code }}</code></td>
                                    <td>{{ $course->course_name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $course->credits }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $course->enrollments()->count() }}</span>
                                    </td>
                                    <td>Semester {{ $course->semester }}</td>
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
                                                        <p>
                                                            <strong>Course Code:</strong> {{ $course->course_code }}<br>
                                                            <strong>Credits:</strong> {{ $course->credits }}<br>
                                                            <strong>Semester:</strong> {{ $course->semester }}<br>
                                                            <strong>Total Classes:</strong> {{ $course->total_classes }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>
                                                            <strong>Enrolled Students:</strong> <span class="badge bg-info">{{ $course->enrollments()->count() }}</span><br>
                                                            <strong>Description:</strong><br>
                                                            <small>{{ $course->description }}</small>
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
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No courses assigned
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
@endsection
