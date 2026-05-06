@extends('layouts.app')

@section('title', 'System Alerts')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-bell"></i> System Alerts
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
                            <th>Student</th>
                            <th>Course</th>
                            <th>Alert Type</th>
                            <th>Message</th>
                            <th>Severity</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alerts as $alert)
                            <tr>
                                <td>{{ $alert->student->user->name }}</td>
                                <td>{{ $alert->course?->course_name ?? 'N/A' }}</td>
                                <td>
                                    @if($alert->alert_type === 'low_attendance')
                                        <span class="badge bg-info">Low Attendance</span>
                                    @elseif($alert->alert_type === 'low_marks')
                                        <span class="badge bg-warning">Low Marks</span>
                                    @elseif($alert->alert_type === 'high_risk')
                                        <span class="badge bg-danger">High Risk</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($alert->message, 50) }}</td>
                                <td>
                                    <span class="alert-badge alert-{{ $alert->severity }}">
                                        {{ ucfirst($alert->severity) }}
                                    </span>
                                </td>
                                <td>{{ $alert->alert_date->format('M d, Y') }}</td>
                                <td>
                                    @if($alert->is_read)
                                        <span class="badge bg-secondary">Read</span>
                                    @else
                                        <span class="badge bg-primary">Unread</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No alerts found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $alerts->links() }}
        </div>
    </div>
</div>
@endsection
