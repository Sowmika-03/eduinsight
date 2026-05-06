@extends('layouts.app')

@section('title', 'Manage Faculty & Students')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-users-cog"></i> Manage Faculty & Students</h2>
            <p class="text-muted">Approve faculty and assign students</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.faculty.statistics') }}" class="btn btn-info me-2">
                <i class="fas fa-chart-bar"></i> Statistics
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse ($faculty as $fac)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $fac->user->name }}</h5>
                                <small>{{ $fac->department }} • {{ $fac->specialization }}</small>
                            </div>
                            <div class="text-end">
                                <div class="badge bg-success">{{ $fac->getAssignedStudentCount() }}/{{ $fac->max_students }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label"><strong>Contact:</strong></label>
                            <p>{{ $fac->user->email }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Assigned Students ({{ $fac->assignedStudents->count() }})</strong></label>
                            @if ($fac->assignedStudents->isEmpty())
                                <p class="text-muted">No students assigned yet</p>
                            @else
                                <div style="max-height: 200px; overflow-y: auto;">
                                    <table class="table table-sm mb-0">
                                        <tbody>
                                            @foreach ($fac->assignedStudents as $student)
                                                <tr>
                                                    <td>{{ $student->user->name }}</td>
                                                    <td class="text-muted small">{{ $student->student_id }}</td>
                                                    <td class="text-end">
                                                        <form action="{{ route('admin.faculty.remove-student', [$fac, $student]) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this student?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('admin.faculty.assign-form', $fac) }}" class="btn btn-sm btn-primary flex-grow-1">
                                <i class="fas fa-plus"></i> Assign Students
                            </a>
                            <button class="btn btn-sm btn-warning flex-grow-1" data-bs-toggle="modal" data-bs-target="#updateMaxModal{{ $fac->id }}">
                                <i class="fas fa-edit"></i> Change Max
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Update Max Students Modal -->
                <div class="modal fade" id="updateMaxModal{{ $fac->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Max Students for {{ $fac->user->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.faculty.update-max', $fac) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Maximum Students Allowed</label>
                                        <input type="number" name="max_students" class="form-control" value="{{ $fac->max_students }}" min="{{ $fac->getAssignedStudentCount() }}" max="200" required>
                                        <small class="text-muted">Current: {{ $fac->getAssignedStudentCount() }} assigned</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-warning">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No approved faculty members yet!
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $faculty->links() }}
    </div>
</div>
@endsection
