<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Mark;
use App\Models\AcademicRisk;
use App\Models\Alert;
use Illuminate\Http\Request;
use Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        $enrolledCourses = $student->enrollments()->with('course.faculty.user')->get();

        $recentMarks = $student->marks()->latest()->take(5)->get();

        $attendanceData = $student->attendance()
            ->selectRaw('course_id, COUNT(*) as total, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present')
            ->groupBy('course_id')
            ->get();

        $academicRisks = $student->academicRisks()->with('course')->get();

        $alerts = $student->alerts()->with('course')->latest()->take(10)->get();

        $overallPerformance = $this->calculateOverallPerformance($student);

        return view('student.dashboard', compact(
            'enrolledCourses',
            'recentMarks',
            'attendanceData',
            'academicRisks',
            'alerts',
            'overallPerformance'
        ));
    }

    public function marks()
    {
        $student = Auth::user()->student;
        $marks = $student->marks()->with('course')->paginate(15);

        return view('student.marks', compact('marks'));
    }

    public function attendance()
    {
        $student = Auth::user()->student;
        $attendance = $student->attendance()->with('course')->orderBy('attendance_date', 'desc')->paginate(15);

        $attendanceSummary = $student->attendance()
            ->selectRaw('course_id, COUNT(*) as total, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present')
            ->groupBy('course_id')
            ->get();

        return view('student.attendance', compact('attendance', 'attendanceSummary'));
    }

    public function riskPrediction()
    {
        $student = Auth::user()->student;
        $risks = $student->academicRisks()->with('course')->get();

        return view('student.risk-prediction', compact('risks'));
    }

    public function alerts()
    {
        $student = Auth::user()->student;
        $alerts = $student->alerts()->with('course')->latest()->paginate(15);

        return view('student.alerts', compact('alerts'));
    }

    private function calculateOverallPerformance($student)
    {
        $marks = $student->marks()->get();

        if ($marks->isEmpty()) {
            return [
                'average' => 0,
                'status' => 'No marks yet',
            ];
        }

        $average = $marks->avg('total_marks');

        return [
            'average' => round($average, 2),
            'status' => $this->getPerformanceStatus($average),
        ];
    }

    private function getPerformanceStatus($average)
    {
        if ($average >= 75) return 'Excellent';
        if ($average >= 60) return 'Good';
        if ($average >= 50) return 'Satisfactory';
        return 'Needs Improvement';
    }
}
