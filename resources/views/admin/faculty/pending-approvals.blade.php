@extends('layouts.app')

@section('title', 'Faculty Approvals')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-clipboard-check"></i> Faculty Approvals</h2>
            <p class="text-muted">Review and approve pending faculty accounts</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    @if ($pendingFaculty->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-check-circle"></i> No pending faculty approvals!
        </div>
    @else
        <div class="row">
            @foreach ($pendingFaculty as $faculty)
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning bg-opacity-10">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">{{ $faculty->user->name }}</h5>
                                    <small class="text-muted">{{ $faculty->employee_id }}</small>
                                </div>
                                <span class="badge bg-warning">Pending</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-5">Email:</dt>
                                <dd class="col-sm-7">{{ $faculty->user->email }}</dd>

                                <dt class="col-sm-5">Department:</dt>
                                <dd class="col-sm-7">{{ $faculty->department }}</dd>

                                <dt class="col-sm-5">Specialization:</dt>
                                <dd class="col-sm-7">{{ $faculty->specialization }}</dd>

                                <dt class="col-sm-5">Qualification:</dt>
                                <dd class="col-sm-7">{{ $faculty->qualification }}</dd>

                                <dt class="col-sm-5">Experience:</dt>
                                <dd class="col-sm-7">{{ $faculty->experience_years }} years</dd>
                            </dl>
                        </div>
                        <div class="card-footer bg-light">
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $faculty->id }}">
                                <i class="fas fa-check"></i> Approve
                            </button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $faculty->id }}">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Approve Modal -->
                <div class="modal fade" id="approveModal{{ $faculty->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Approve Faculty: {{ $faculty->user->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.faculty.approve', $faculty) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Maximum Students Allowed</label>
                                        <input type="number" name="max_students" class="form-control" value="50" min="1" max="200" required>
                                        <small class="text-muted">Maximum number of students this faculty can teach</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Approve Faculty</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Reject Modal -->
                <div class="modal fade" id="rejectModal{{ $faculty->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reject Faculty: {{ $faculty->user->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.faculty.reject', $faculty) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Reason for Rejection</label>
                                        <textarea name="rejection_reason" class="form-control" rows="4" required placeholder="Enter reason..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Reject Faculty</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
