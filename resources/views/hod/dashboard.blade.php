@extends('layouts.hod')

@use('App\Models\Student')

@section('hod-content')
<div style="margin-bottom: 2.5rem;">
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1.5rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; color: #1E293B; margin: 0; letter-spacing: -0.5px;">
                <i class="fas fa-chalkboard-user" style="color: #5B7CFF; margin-right: 0.75rem;"></i>
                HOD Dashboard
            </h1>
            <p style="color: #64748b; margin-top: 0.5rem; font-size: 0.95rem; margin-bottom: 0;">
                {{ $hod->department }} Department Overview
            </p>
        </div>
        <a href="{{ route('hod.analytics') }}" 
           style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5B7CFF 0%, #7B4DFF 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(91, 124, 255, 0.3);"
           onmouseover="this.style.boxShadow='0 6px 16px rgba(91, 124, 255, 0.4)'; this.style.transform='translateY(-2px)'"
           onmouseout="this.style.boxShadow='0 4px 12px rgba(91, 124, 255, 0.3)'; this.style.transform='translateY(0)'">
            <i class="fas fa-chart-bar"></i> Analytics
        </a>
    </div>

    <!-- Key Statistics -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="stat-box">
            <i class="fas fa-users"></i>
            <h3>{{ $totalFaculty }}</h3>
            <p>Total Faculty</p>
            <small style="display: block; color: #10B981; font-weight: 500; margin-top: 0.5rem;">{{ $activeFaculty }} Active</small>
        </div>
        <div class="stat-box">
            <i class="fas fa-book"></i>
            <h3>{{ $totalCourses }}</h3>
            <p>Active Courses</p>
        </div>
        <div class="stat-box">
            <i class="fas fa-graduation-cap"></i>
            <h3>{{ $enrolledStudents }}</h3>
            <p>Enrolled Students</p>
        </div>
        <div class="stat-box" style="border-left: 4px solid rgba(239, 68, 68, 0.3);">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>{{ $riskStudents }}</h3>
            <p>At Risk Students</p>
        </div>
    </div>

    <!-- Quick Action Buttons -->
    <div style="margin-bottom: 2rem;">
        <div class="dashboard-card">
            <h5 style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                <i class="fas fa-bolt" style="color: #F59E0B;"></i>
                Quick Actions
            </h5>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('hod.faculty') }}" 
                   style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5B7CFF 0%, #7B4DFF 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(91, 124, 255, 0.3);"
                   onmouseover="this.style.boxShadow='0 6px 16px rgba(91, 124, 255, 0.4)'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.boxShadow='0 4px 12px rgba(91, 124, 255, 0.3)'; this.style.transform='translateY(0)'">
                    <i class="fas fa-user-tie"></i> Manage Faculty
                </a>
                <a href="{{ route('hod.students') }}" 
                   style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5B7CFF 0%, #7B4DFF 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(91, 124, 255, 0.3);"
                   onmouseover="this.style.boxShadow='0 6px 16px rgba(91, 124, 255, 0.4)'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.boxShadow='0 4px 12px rgba(91, 124, 255, 0.3)'; this.style.transform='translateY(0)'">
                    <i class="fas fa-users"></i> Manage Students
                </a>
                <a href="{{ route('hod.courses') }}" 
                   style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5B7CFF 0%, #7B4DFF 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(91, 124, 255, 0.3);"
                   onmouseover="this.style.boxShadow='0 6px 16px rgba(91, 124, 255, 0.4)'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.boxShadow='0 4px 12px rgba(91, 124, 255, 0.3)'; this.style.transform='translateY(0)'">
                    <i class="fas fa-book"></i> Manage Courses
                </a>
                <a href="{{ route('hod.analytics') }}" 
                   style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: rgba(91, 124, 255, 0.1); color: #5B7CFF; border: 2px solid rgba(91, 124, 255, 0.2); border-radius: 10px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;"
                   onmouseover="this.style.background='rgba(91, 124, 255, 0.15)'; this.style.borderColor='rgba(91, 124, 255, 0.3)'"
                   onmouseout="this.style.background='rgba(91, 124, 255, 0.1)'; this.style.borderColor='rgba(91, 124, 255, 0.2)'">
                    <i class="fas fa-chart-line"></i> View Analytics
                </a>
            </div>
        </div>
    </div>

    <!-- Department Faculty & Low Attendance Section -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <!-- Department Faculty Overview -->
        <div class="dashboard-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h5 style="display: flex; align-items: center; gap: 0.75rem; margin: 0;">
                    <i class="fas fa-users" style="color: #5B7CFF;"></i>
                    Department Faculty
                </h5>
                <a href="{{ route('hod.faculty') }}" 
                   style="font-size: 0.9rem; color: #5B7CFF; text-decoration: none; font-weight: 600; transition: all 0.3s ease;"
                   onmouseover="this.style.color='#7B4DFF'"
                   onmouseout="this.style.color='#5B7CFF'">
                    View All →
                </a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Name</th>
                            <th><i class="fas fa-id-card" style="margin-right: 0.5rem; color: #5B7CFF;"></i>ID</th>
                            <th><i class="fas fa-star" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Specialization</th>
                            <th><i class="fas fa-book" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Courses</th>
                            <th><i class="fas fa-check" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($faculty->take(5) as $fac)
                            <tr>
                                <td><span style="font-weight: 600; color: #1E293B;">{{ $fac->user->name }}</span></td>
                                <td><code style="background: rgba(91, 124, 255, 0.1); padding: 0.3rem 0.6rem; border-radius: 4px; color: #5B7CFF; font-weight: 500;">{{ $fac->employee_id }}</code></td>
                                <td>{{ $fac->specialization }}</td>
                                <td>
                                    <span class="badge" style="background: rgba(91, 124, 255, 0.15); color: #5B7CFF; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">{{ $fac->courses()->count() }}</span>
                                </td>
                                <td>
                                    <span class="badge" style="background: rgba({{ $fac->approval_status === 'approved' ? '16, 185, 129' : '245, 158, 11' }}, 0.15); color: {{ $fac->approval_status === 'approved' ? '#10B981' : '#F59E0B' }}; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">
                                        {{ ucfirst($fac->approval_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2rem; font-weight: 500;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                                    No faculty found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Attendance Students -->
        <div class="dashboard-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h5 style="display: flex; align-items: center; gap: 0.75rem; margin: 0;">
                    <i class="fas fa-clipboard-list" style="color: #F59E0B;"></i>
                    Low Attendance
                </h5>
                <a href="{{ route('hod.students') }}" 
                   style="font-size: 0.9rem; color: #5B7CFF; text-decoration: none; font-weight: 600; transition: all 0.3s ease;"
                   onmouseover="this.style.color='#7B4DFF'"
                   onmouseout="this.style.color='#5B7CFF'">
                    View All →
                </a>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @forelse ($lowAttendanceStudents as $item)
                    <a href="{{ route('hod.students.show', $item['student']->id) }}" 
                       style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(255,255,255,0.5); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 10px; text-decoration: none; transition: all 0.3s ease; cursor: pointer;"
                       onmouseover="this.style.background='rgba(245, 158, 11, 0.1)'; this.style.borderColor='rgba(245, 158, 11, 0.3)'"
                       onmouseout="this.style.background='rgba(255,255,255,0.5)'; this.style.borderColor='rgba(245, 158, 11, 0.2)'">
                        <div>
                            <div style="font-weight: 700; color: #1E293B; margin-bottom: 0.25rem;">{{ $item['student']->user->name }}</div>
                            <small style="color: #64748b; font-weight: 500;">{{ $item['student']->user->reg_number }}</small>
                        </div>
                        <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #EF4444; font-weight: 600; padding: 0.5rem 1rem; border-radius: 8px;">
                            {{ $item['attendance'] }}%
                        </span>
                    </a>
                @empty
                    <div style="text-align: center; color: #94a3b8; padding: 2rem; font-weight: 500;">
                        <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 1rem; display: block; color: #10B981;"></i>
                        No attendance issues
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Alerts -->
    <div style="margin-bottom: 2rem;">
        <div class="dashboard-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h5 style="display: flex; align-items: center; gap: 0.75rem; margin: 0;">
                    <i class="fas fa-bell" style="color: #EF4444;"></i>
                    Recent Academic Alerts
                </h5>
                <a href="{{ route('hod.students') }}" 
                   style="font-size: 0.9rem; color: #5B7CFF; text-decoration: none; font-weight: 600; transition: all 0.3s ease;"
                   onmouseover="this.style.color='#7B4DFF'"
                   onmouseout="this.style.color='#5B7CFF'">
                    View All →
                </a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Student</th>
                            <th><i class="fas fa-building" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Department</th>
                            <th><i class="fas fa-flag" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Risk Type</th>
                            <th><i class="fas fa-file-alt" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Description</th>
                            <th><i class="fas fa-calendar" style="margin-right: 0.5rem; color: #5B7CFF;"></i>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentAlerts as $alert)
                            @php
                                $student = Student::find($alert->student_id);
                            @endphp
                            <tr>
                                <td><span style="font-weight: 600; color: #1E293B;">{{ $student->user->name }}</span></td>
                                <td>{{ $hod->department }}</td>
                                <td>
                                    <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #EF4444; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 8px;">
                                        {{ ucfirst(str_replace('_', ' ', $alert->risk_type)) }}
                                    </span>
                                </td>
                                <td style="color: #64748b; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $alert->description }}</td>
                                <td style="color: #64748b; font-weight: 500;">{{ $alert->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2rem; font-weight: 500;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                                    No recent alerts
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Email Analytics -->
    @include('components.email-analytics')
</div>
@endsection
