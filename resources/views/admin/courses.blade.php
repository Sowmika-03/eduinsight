@extends('layouts.app')

@section('title', 'All Courses')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-book"></i> All Courses
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Faculty</th>
                            <th>Semester</th>
                            <th>Credits</th>
                            <th>Students</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                            <tr>
                                <td><strong>{{ $course->course_code }}</strong></td>
                                <td>{{ $course->course_name }}</td>
                                <td>{{ $course->faculty->user->name }}</td>
                                <td>{{ $course->semester }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $course->credits }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $course->enrollments->count() }} students
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No courses found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $courses->links() }}
        </div>
    </div>
</div>
@endsection
