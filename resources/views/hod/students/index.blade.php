@extends('layouts.hod')

@section('hod-content')
<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-graduation-cap"></i> Student Management</h2>
            <p class="text-muted">Manage students in {{ $hod->department }} Department</p>
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
                <input type="text" class="form-control" id="searchStudent" placeholder="Search student by name, ID, or email...">
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Students ({{ $students->total() }})</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Program</th>
                                <th>Batch</th>
                                <th>Courses</th>
                                <th>GPA</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr class="student-row">
                                    <td><code>{{ $student->user->reg_number }}</code></td>
                                    <td>{{ $student->user->name }}</td>
                                    <td>{{ $student->user->email }}</td>
                                    <td>{{ $student->program }}</td>
                                    <td>{{ $student->batch }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $student->enrollments()->count() }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $student->gpa ?? 'N/A' }}</strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('hod.students.show', $student->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No students found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchStudent').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.student-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
