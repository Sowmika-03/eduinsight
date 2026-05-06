@extends('layouts.app')

@section('title', 'Faculty Course')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-book"></i> {{ $course->course_name }}
        </h2>
    </div>
</div>

<!-- Course Details -->
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Course Code:</strong> {{ $course->course_code }}</p>
                    <p><strong>Credits:</strong> {{ $course->credits }}</p>
                    <p><strong>Semester:</strong> {{ $course->semester }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Total Classes:</strong> {{ $course->total_classes }}</p>
                    <p><strong>Enrolled Students:</strong> {{ $enrolledStudents->count() }}</p>
                    <p><strong>Description:</strong> {{ $course->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enrolled Students -->
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5>Enrolled Students</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrolledStudents as $enrollment)
                            <tr>
                                <td>{{ $enrollment->student->student_id }}</td>
                                <td>{{ $enrollment->student->user->name }}</td>
                                <td>{{ $enrollment->student->user->email }}</td>
                                <td>
                                    <span class="badge bg-success">{{ ucfirst($enrollment->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No students enrolled</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
