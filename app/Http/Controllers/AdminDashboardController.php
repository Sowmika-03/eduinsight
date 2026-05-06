<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\AcademicRisk;
use App\Models\Attendance;
use App\Models\Mark;
use App\Services\EmailAnalyticsService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $emailAnalyticsService;

    public function __construct(EmailAnalyticsService $emailAnalyticsService)
    {
        $this->emailAnalyticsService = $emailAnalyticsService;
    }

    public function index()
    {
        $totalStudents = Student::count();
        
        $avgAttendance = Attendance::selectRaw('AVG(CASE WHEN status = "present" THEN 100 ELSE 0 END) as average')
            ->first()
            ->average ?? 0;

        $passPercentage = Mark::selectRaw('COUNT(CASE WHEN total_marks >= 40 THEN 1 END) * 100.0 / COUNT(*) as pass_rate')
            ->first()
            ->pass_rate ?? 0;

        $highRiskStudents = AcademicRisk::where('risk_level', 'High Risk')->count();

        $recentAlerts = \App\Models\Alert::latest()->take(10)->get();

        $riskDistribution = AcademicRisk::selectRaw('risk_level, COUNT(*) as count')
            ->groupBy('risk_level')
            ->get();

        $performanceByProgram = Student::selectRaw('program, COUNT(*) as total')
            ->groupBy('program')
            ->get();

        // Email Analytics Data
        $emailStats = $this->emailAnalyticsService->getEmailStats();
        $emailsByDate = $this->emailAnalyticsService->getEmailsByDate();
        $emailsByStatus = $this->emailAnalyticsService->getEmailsByStatus();

        return view('admin.dashboard', compact(
            'totalStudents',
            'avgAttendance',
            'passPercentage',
            'highRiskStudents',
            'recentAlerts',
            'riskDistribution',
            'performanceByProgram',
            'emailStats',
            'emailsByDate',
            'emailsByStatus'
        ));
    }

    public function students()
    {
        $students = Student::with('user', 'academicRisks')->paginate(15);
        return view('admin.students', compact('students'));
    }

    public function courses()
    {
        $courses = Course::with('faculty', 'enrollments')->paginate(15);
        return view('admin.courses', compact('courses'));
    }

    public function alerts()
    {
        $alerts = \App\Models\Alert::latest()->paginate(20);
        return view('admin.alerts', compact('alerts'));
    }
}
