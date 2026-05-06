@extends('layouts.app')

@section('title', 'Risk Analysis')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-exclamation-triangle"></i> Academic Risk Analysis
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            @if($risks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Risk Level</th>
                                <th>Risk Score</th>
                                <th>Attendance</th>
                                <th>Internal Marks</th>
                                <th>External Marks</th>
                                <th>Recommendations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($risks as $risk)
                                <tr>
                                    <td><strong>{{ $risk->course->course_name }}</strong></td>
                                    <td>
                                        @if($risk->risk_level === 'High Risk')
                                            <span class="badge bg-danger">{{ $risk->risk_level }}</span>
                                        @elseif($risk->risk_level === 'Medium Risk')
                                            <span class="badge bg-warning">{{ $risk->risk_level }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $risk->risk_level }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar bg-@if($risk->risk_score > 0.67) danger @elseif($risk->risk_score > 0.33) warning @else success @endif" 
                                                 style="width: {{ $risk->risk_score * 100 }}%">
                                                {{ round($risk->risk_score * 100, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ round($risk->attendance_percentage, 1) }}%</td>
                                    <td>{{ $risk->internal_marks ?? 'N/A' }}</td>
                                    <td>{{ $risk->external_marks ?? 'N/A' }}</td>
                                    <td>
                                        @if($risk->recommendations)
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                                    data-bs-target="#recommendationModal{{ $risk->id }}">
                                                View
                                            </button>
                                            
                                            <div class="modal fade" id="recommendationModal{{ $risk->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Recommendations</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul>
                                                                @foreach(json_decode($risk->recommendations) as $rec)
                                                                    <li>{{ $rec }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No risk predictions available yet.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Risk Assessment Guide -->
<div class="row">
    <div class="col-md-12">
        <div class="dashboard-card">
            <h5>Understanding Risk Levels</h5>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="alert alert-success">
                        <h6><i class="fas fa-check"></i> Low Risk</h6>
                        <p class="small">Good attendance (75%+) and marks (50+). Keep up the good work!</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation"></i> Medium Risk</h6>
                        <p class="small">Moderate attendance (60-75%) or marks (40-50). Need improvement.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-exclamation-triangle"></i> High Risk</h6>
                        <p class="small">Low attendance (<60%) or marks (<40). Urgent action required.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
