@extends('layouts.app')

@section('title', 'Student Marks')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-pen"></i> My Marks
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
                            <th>Course</th>
                            <th>Assessment Type</th>
                            <th>Internal Marks</th>
                            <th>External Marks</th>
                            <th>Total Marks</th>
                            <th>Grade</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($marks as $mark)
                            <tr>
                                <td><strong>{{ $mark->course->course_name }}</strong></td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst($mark->assessment_type) }}
                                    </span>
                                </td>
                                <td>{{ $mark->internal_marks ?? 'N/A' }}</td>
                                <td>{{ $mark->external_marks ?? 'N/A' }}</td>
                                <td><strong>{{ $mark->total_marks ?? 'N/A' }}</strong></td>
                                <td>
                                    <span class="badge bg-@if($mark->grade === 'A') success @elseif($mark->grade === 'F') danger @else warning @endif">
                                        {{ $mark->grade }}
                                    </span>
                                </td>
                                <td>{{ $mark->mark_date->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No marks recorded yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $marks->links() }}
        </div>
    </div>
</div>
@endsection
