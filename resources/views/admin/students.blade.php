@extends('layouts.app')

@section('title', 'All Students')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-users"></i> All Students
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
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Program</th>
                            <th>Admission Year</th>
                            <th>Risk Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td><strong>{{ $student->student_id }}</strong></td>
                                <td>{{ $student->user->name }}</td>
                                <td>{{ $student->user->email }}</td>
                                <td>{{ $student->program }}</td>
                                <td>{{ $student->admission_year }}</td>
                                <td>
                                    @php
                                        $maxRisk = $student->academicRisks->max('risk_level');
                                    @endphp
                                    @if($maxRisk === 'High Risk')
                                        <span class="badge bg-danger">High Risk</span>
                                    @elseif($maxRisk === 'Medium Risk')
                                        <span class="badge bg-warning">Medium Risk</span>
                                    @else
                                        <span class="badge bg-success">Low Risk</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No students found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
