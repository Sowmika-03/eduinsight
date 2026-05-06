@extends('layouts.app')

@section('title', 'Faculty Management Statistics')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-bar-chart"></i> Faculty Management Statistics</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.faculty.manage') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Management
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h6 class="card-title">Total Faculty</h6>
                    <h2>{{ $stats['total_faculty'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h6 class="card-title">Approved</h6>
                    <h2>{{ $stats['approved_faculty'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h6 class="card-title">Pending</h6>
                    <h2>{{ $stats['pending_faculty'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h6 class="card-title">Rejected</h6>
                    <h2>{{ $stats['rejected_faculty'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Faculty Details -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Faculty Overview</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Faculty Name</th>
                                    <th class="text-center">Assigned Students</th>
                                    <th class="text-center">Max Capacity</th>
                                    <th class="text-center">Available Slots</th>
                                    <th class="text-center">Utilization %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($facultyStats as $fac)
                                    <tr>
                                        <td>
                                            <strong>{{ $fac['name'] }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $fac['assigned_students'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ $fac['max_students'] }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $fac['available_slots'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $utilization = ($fac['assigned_students'] / $fac['max_students']) * 100;
                                                $color = $utilization < 50 ? 'success' : ($utilization < 80 ? 'warning' : 'danger');
                                            @endphp
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar bg-{{ $color }}" style="width: {{ $utilization }}%">
                                                    {{ number_format($utilization, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No faculty data available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Student Assignments</h6>
                    <h3 class="text-primary">{{ $stats['total_assignments'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Average Capacity Utilization</h6>
                    @php
                        if($facultyStats->count() > 0) {
                            $totalUtilization = 0;
                            foreach($facultyStats as $fac) {
                                $totalUtilization += ($fac['assigned_students'] / $fac['max_students']) * 100;
                            }
                            $avgUtilization = $totalUtilization / $facultyStats->count();
                        } else {
                            $avgUtilization = 0;
                        }
                    @endphp
                    <h3 class="text-info">{{ number_format($avgUtilization, 1) }}%</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Available Slots</h6>
                    @php
                        $totalAvailableSlots = 0;
                        foreach($facultyStats as $fac) {
                            $totalAvailableSlots += $fac['available_slots'];
                        }
                    @endphp
                    <h3 class="text-success">{{ $totalAvailableSlots }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
