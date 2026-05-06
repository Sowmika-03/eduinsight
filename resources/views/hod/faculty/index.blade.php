@extends('layouts.hod')

@section('hod-content')
<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-user-tie"></i> Faculty Management</h2>
            <p class="text-muted">Manage faculty in your department</p>
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
                <input type="text" class="form-control" id="searchFaculty" placeholder="Search faculty by name or ID...">
            </div>
        </div>
    </div>

    <!-- Faculty List -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Faculty List ({{ $faculty->total() }})</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Employee ID</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Specialization</th>
                                <th>Courses</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($faculty as $fac)
                                <tr class="faculty-row">
                                    <td>
                                        <strong>{{ $fac->user->name }}</strong>
                                    </td>
                                    <td><code>{{ $fac->employee_id }}</code></td>
                                    <td>{{ $fac->user->email }}</td>
                                    <td>{{ $fac->user->phone ?? 'N/A' }}</td>
                                    <td>{{ $fac->specialization }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $fac->courses()->count() }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $fac->approval_status === 'approved' ? 'success' : ($fac->approval_status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($fac->approval_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('hod.faculty.show', $fac->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No faculty found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $faculty->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchFaculty').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.faculty-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
