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

    public function index(Request $request)
    {
        $program  = $request->get('program');
        $semester = $request->get('semester');

        $studentQuery = Student::query();
        if ($program) {
            $studentQuery->where('program', 'LIKE', "%{$program}%");
        }
        if ($semester) {
            $studentQuery->where('semester', $semester);
        }

        $filteredStudentIds = $studentQuery->pluck('id');

        $totalStudents = $studentQuery->count();
        
        $avgAttendanceQuery = Attendance::query();
        if ($filteredStudentIds->isNotEmpty()) {
            $avgAttendanceQuery->whereIn('student_id', $filteredStudentIds);
        }
        $avgAttendance = $avgAttendanceQuery->selectRaw('AVG(CASE WHEN status = "present" THEN 100 ELSE 0 END) as average')
            ->first()
            ->average ?? 80.0;

        $markQuery = Mark::query();
        if ($filteredStudentIds->isNotEmpty()) {
            $markQuery->whereIn('student_id', $filteredStudentIds);
        }
        $passPercentage = $markQuery->selectRaw('COUNT(CASE WHEN total_marks >= 40 THEN 1 END) * 100.0 / COUNT(*) as pass_rate')
            ->first()
            ->pass_rate ?? 85.0;

        $riskQuery = AcademicRisk::query();
        if ($filteredStudentIds->isNotEmpty()) {
            $riskQuery->whereIn('student_id', $filteredStudentIds);
        }
        $highRiskStudents = $riskQuery->where('risk_level', 'High Risk')->distinct()->count('student_id');

        $alertQuery = \App\Models\Alert::query();
        if ($filteredStudentIds->isNotEmpty()) {
            $alertQuery->whereIn('student_id', $filteredStudentIds);
        }
        $recentAlerts = $alertQuery->latest()->take(10)->get();

        $riskDistribution = AcademicRisk::query();
        if ($filteredStudentIds->isNotEmpty()) {
            $riskDistribution->whereIn('student_id', $filteredStudentIds);
        }
        $riskDistribution = $riskDistribution->selectRaw('risk_level, COUNT(*) as count')
            ->groupBy('risk_level')
            ->get();

        $performanceByProgram = Student::query();
        if ($filteredStudentIds->isNotEmpty()) {
            $performanceByProgram->whereIn('id', $filteredStudentIds);
        }
        $performanceByProgram = $performanceByProgram->selectRaw('program, COUNT(*) as total')
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

    public function students(Request $request)
    {
        $query = Student::with('user', 'academicRisks');
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('student_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%"));
            });
        }
        if ($program = $request->get('program')) {
            $query->where('program', 'LIKE', "%{$program}%");
        }
        $students = $query->paginate(15)->withQueryString();
        return view('admin.students', compact('students'));
    }

    public function courses(Request $request)
    {
        $query = Course::with('faculty', 'enrollments');
        if ($search = $request->get('search')) {
            $query->where('course_code', 'LIKE', "%{$search}%")
                  ->orWhere('course_name', 'LIKE', "%{$search}%");
        }
        $courses = $query->paginate(15)->withQueryString();
        return view('admin.courses', compact('courses'));
    }

    public function alerts(Request $request)
    {
        $query = \App\Models\Alert::latest();
        if ($severity = $request->get('severity')) {
            $query->where('severity', $severity);
        }
        $alerts = $query->paginate(20)->withQueryString();
        return view('admin.alerts', compact('alerts'));
    }
}
