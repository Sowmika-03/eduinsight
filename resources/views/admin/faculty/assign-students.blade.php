@extends('layouts.app')

@section('title', "Assign Students to {$faculty->user->name}")

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-user-plus"></i> Assign Students to {{ $faculty->user->name }}</h2>
            <p class="text-muted">
                Available slots: <strong>{{ $availableSlots }}/{{ $faculty->max_students }}</strong>
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.faculty.manage') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Currently Assigned Students -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Currently Assigned ({{ $assignedStudents->count() }})</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @if ($assignedStudents->isEmpty())
                        <p class="text-muted text-center py-5">No students assigned yet</p>
                    @else
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Student</th>
                                    <th>ID</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignedStudents as $student)
                                    <tr>
                                        <td>{{ $student->user->name }}</td>
                                        <td><span class="badge bg-secondary">{{ $student->student_id }}</span></td>
                                        <td class="text-end">
                                            <form action="{{ route('admin.faculty.remove-student', [$faculty, $student]) }}" method="POST" style="display:inline;">
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
                    @endif
                </div>
            </div>
        </div>

        <!-- Available Students to Assign -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Available Students to Assign ({{ $unassignedStudents->count() }})</h5>
                </div>
                <div class="card-body">
                    @if ($unassignedStudents->isEmpty())
                        <p class="text-muted text-center py-5">No unassigned students available</p>
                    @else
                        <form action="{{ route('admin.faculty.assign', $faculty) }}" method="POST">
                            @csrf
                            <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                @foreach ($unassignedStudents as $student)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="student_ids[]" value="{{ $student->id }}" id="student{{ $student->id }}">
                                        <label class="form-check-label" for="student{{ $student->id }}">
                                            <strong>{{ $student->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $student->student_id }} • {{ $student->program }}</small>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Assignment Notes (Optional)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Add any notes about this assignment..."></textarea>
                            </div>

                            <div class="mt-3 d-flex gap-2">
                                <input type="button" class="btn btn-sm btn-secondary" value="Select All" onclick="selectAll()">
                                <input type="button" class="btn btn-sm btn-outline-secondary" value="Clear All" onclick="clearAll()">
                                <button type="submit" class="btn btn-sm btn-primary ms-auto">
                                    <i class="fas fa-check"></i> Assign Selected Students
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectAll() {
    document.querySelectorAll('input[name="student_ids[]"]').forEach(cb => cb.checked = true);
}

function clearAll() {
    document.querySelectorAll('input[name="student_ids[]"]').forEach(cb => cb.checked = false);
}
</script>
@endsection
