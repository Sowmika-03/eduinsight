@extends('layouts.app')

@section('title', 'Manage Marks')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-pencil-alt"></i> Manage Marks</h2>
            <p class="text-muted">View and manage student marks for your courses</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('faculty.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Course Selection -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('faculty.marks.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Select Course</label>
                            <select name="course_id" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Select a Course --</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_name }} ({{ $course->course_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (request('course_id') && $selectedCourse)
        <!-- Selected Course Info -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <strong>{{ $selectedCourse->course_name }}</strong> ({{ $selectedCourse->course_code }}) - 
                    <span>{{ $selectedCourse->enrollments->count() }} Students Enrolled</span>
                </div>
            </div>
        </div>

        <!-- Marks Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-table"></i> Student Marks</h5>
                        <div class="input-group" style="width: 250px;">
                            <input type="text" class="form-control form-control-sm" id="searchMarks" placeholder="Search student...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Marks</th>
                                    <th>Average</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($selectedCourse->enrollments as $enrollment)
                                    @php
                                        $student = $enrollment->student;
                                        $studentMarks = $selectedCourse->marks()->where('student_id', $student->id)->get();
                                        $avgMark = $studentMarks->avg('total_marks') ?? 0;
                                    @endphp
                                    <tr class="mark-row">
                                        <td>{{ $student->user->reg_number }}</td>
                                        <td>{{ $student->user->name }}</td>
                                        <td>{{ $student->user->email }}</td>
                                        <td>
                                            @if ($studentMarks->count() > 0)
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach ($studentMarks as $mark)
                                                        <span class="badge bg-secondary">{{ $mark->total_marks }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">No marks</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($avgMark > 0)
                                                <strong class="text-{{ $avgMark >= 70 ? 'success' : ($avgMark >= 50 ? 'warning' : 'danger') }}">
                                                    {{ round($avgMark, 2) }}/100
                                                </strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" 
                                                    data-bs-target="#addMarkModal{{ $student->id }}">
                                                <i class="fas fa-plus"></i> Add Mark
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Add Mark Modal -->
                                    <div class="modal fade" id="addMarkModal{{ $student->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add Mark for {{ $student->user->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('faculty.marks.store') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                        <input type="hidden" name="course_id" value="{{ $selectedCourse->id }}">

                                                        <div class="mb-3">
                                                            <label class="form-label">Internal Marks (out of 50)</label>
                                                            <input type="number" name="internal_marks" class="form-control" 
                                                                   min="0" max="50" step="0.01" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">External Marks (out of 50)</label>
                                                            <input type="number" name="external_marks" class="form-control" 
                                                                   min="0" max="50" step="0.01" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Assessment Type</label>
                                                            <select name="assessment_type" class="form-select">
                                                                <option value="assignment">Assignment</option>
                                                                <option value="midterm">Midterm</option>
                                                                <option value="final">Final</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Add Mark</button>
                                                    </div>
                                                </form>
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
    @else
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> Please select a course to view and manage marks.
        </div>
    @endif
</div>

<script>
document.getElementById('searchMarks').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.mark-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
