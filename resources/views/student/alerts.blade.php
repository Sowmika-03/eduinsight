@extends('layouts.app')

@section('title', 'Alerts')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-bell"></i> My Alerts
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            @forelse($alerts as $alert)
                <div class="alert alert-{{ $alert->severity === 'high' ? 'danger' : ($alert->severity === 'medium' ? 'warning' : 'info') }} 
                      alert-dismissible fade show" role="alert">
                    <div class="row">
                        <div class="col-md-9">
                            <strong>
                                @if($alert->alert_type === 'low_attendance')
                                    <i class="fas fa-info-circle"></i> Low Attendance
                                @elseif($alert->alert_type === 'low_marks')
                                    <i class="fas fa-pencil"></i> Low Marks
                                @elseif($alert->alert_type === 'high_risk')
                                    <i class="fas fa-exclamation-triangle"></i> High Risk
                                @endif
                            </strong>
                            <p class="mb-1">{{ $alert->message }}</p>
                            @if($alert->course)
                                <small class="text-muted">
                                    Course: {{ $alert->course->course_name }}
                                </small>
                            @endif
                        </div>
                        <div class="col-md-3 text-end">
                            <small class="text-muted">{{ $alert->alert_date->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-check-circle"></i> You don't have any alerts!
                </div>
            @endforelse

            {{ $alerts->links() }}
        </div>
    </div>
</div>
@endsection
