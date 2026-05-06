@extends('layouts.app')

@section('title', 'Student Attendance')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-check-circle"></i> Attendance Records
        </h2>
    </div>
</div>

<!-- Attendance Summary -->
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5>Attendance Summary by Course</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Total Classes</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Attendance %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendanceSummary as $summary)
                            <tr>
                                <td>{{ $summary->course?->course_name ?? 'N/A' }}</td>
                                <td>{{ $summary->total }}</td>
                                <td><span class="badge bg-success">{{ $summary->present }}</span></td>
                                <td><span class="badge bg-danger">{{ $summary->total - $summary->present }}</span></td>
                                <td>
                                    @php
                                        $percentage = ($summary->present / $summary->total) * 100;
                                    @endphp
                                    <span class="badge bg-@if($percentage >= 75) success @elseif($percentage >= 60) warning @else danger @endif">
                                        {{ round($percentage, 1) }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No attendance records</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Attendance Records -->
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5>Detailed Attendance Records</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendance as $record)
                            <tr>
                                <td>{{ $record->attendance_date->format('M d, Y') }}</td>
                                <td>{{ $record->course->course_name }}</td>
                                <td>
                                    @if($record->status === 'present')
                                        <span class="badge bg-success">Present</span>
                                    @elseif($record->status === 'absent')
                                        <span class="badge bg-danger">Absent</span>
                                    @else
                                        <span class="badge bg-warning">Late</span>
                                    @endif
                                </td>
                                <td>{{ $record->remarks ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No attendance records</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $attendance->links() }}
        </div>
    </div>
</div>
@endsection
