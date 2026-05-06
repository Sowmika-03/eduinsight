<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\AcademicRisk;
use App\Models\Alert;
use App\Services\EmailAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;

class FacultyDashboardController extends Controller
{
    use AuthorizesRequests;
    
    protected $emailAnalyticsService;

    public function __construct(EmailAnalyticsService $emailAnalyticsService)
    {
        $this->emailAnalyticsService = $emailAnalyticsService;
    }

    public function index()
    {
        $faculty = Auth::user()->faculty;
        $courses = Course::where('faculty_id', $faculty->id)->with('enrollments')->get();

        $totalStudents = $courses->sum(fn($c) => $c->enrollments->count());
        $avgAttendance = Attendance::whereIn('course_id', $courses->pluck('id'))
            ->selectRaw('AVG(CASE WHEN status = "present" THEN 100 ELSE 0 END) as average')
            ->first()
            ->average ?? 0;

        // Get attendance summary per student first
        $attendanceSummary = Attendance::selectRaw('student_id, COUNT(id) as total_classes, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_classes')
            ->whereIn('course_id', $courses->pluck('id'))
            ->groupBy('student_id')
            ->havingRaw('(present_classes * 100 / total_classes) < 60')
            ->get()
            ->pluck('student_id');

        // Get students with low attendance
        $lowAttendanceStudents = Student::whereIn('id', $attendanceSummary)
            ->with('user')
            ->get();

        // Get recent alerts for students in this faculty's courses
        $recentAlerts = Alert::whereIn(
            'student_id',
            Student::whereIn(
                'id',
                $courses->flatMap(fn($c) => $c->enrollments->pluck('student_id'))
            )->pluck('id')
        )->with('student.user', 'course')->latest()->take(10)->get();

        // Email Analytics Data (only for this faculty)
        $emailStats = $this->emailAnalyticsService->getEmailStats(Auth::id());
        $emailsByDate = $this->emailAnalyticsService->getEmailsByDate(Auth::id());
        $emailsByStatus = $this->emailAnalyticsService->getEmailsByStatus(Auth::id());

        return view('faculty.dashboard', compact('courses', 'totalStudents', 'avgAttendance', 'lowAttendanceStudents', 'recentAlerts', 'emailStats', 'emailsByDate', 'emailsByStatus'));
    }

    public function courses()
    {
        $faculty = Auth::user()->faculty;
        $courses = Course::where('faculty_id', $faculty->id)->with('enrollments')->paginate(10);
        
        return view('faculty.courses', compact('courses'));
    }

    public function attendance()
    {
        $faculty = Auth::user()->faculty;
        $courses = Course::where('faculty_id', $faculty->id)->get();
        
        // Get attendance data for all courses
        $attendanceData = [];
        foreach ($courses as $course) {
            $attendanceData[$course->id] = Attendance::where('course_id', $course->id)
                ->with('student.user')
                ->orderBy('attendance_date', 'desc')
                ->get();
        }

        return view('faculty.attendance', compact('courses', 'attendanceData'));
    }

    public function course($id)
    {
        $course = Course::findOrFail($id);
        // Verify faculty owns this course
        if ($course->faculty_id !== Auth::user()->faculty->id) {
            abort(403, 'Unauthorized');
        }

        $enrolledStudents = $course->enrollments()->with('student.user', 'student.marks', 'student.academicRisks')->get();

        return view('faculty.course', compact('course', 'enrolledStudents'));
    }

    public function addMarks(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'internal_marks' => 'required|numeric|min:0|max:50',
            'external_marks' => 'required|numeric|min:0|max:50',
            'assessment_type' => 'required|in:midterm,final,assignment',
        ]);

        // Authorize the user can manage marks for this course
        $course = Course::findOrFail($validated['course_id']);
        $this->authorize('manageMarks', $course);

        $totalMarks = $validated['internal_marks'] + $validated['external_marks'];
        $grade = $this->calculateGrade($totalMarks);

        Mark::create(array_merge($validated, [
            'total_marks' => $totalMarks,
            'grade' => $grade,
            'mark_date' => now(),
        ]));

        return redirect()->back()->with('success', 'Marks added successfully');
    }

    public function recordAttendance(Request $request)
    {
        $validated = $request->validate([
            'attendance_date' => 'required|date',
            'course_id' => 'required|exists:courses,id',
            'students' => 'required|array',
            'students.*.student_id' => 'required|exists:students,id',
            'students.*.status' => 'required|in:present,absent,late',
        ]);

        // Authorize the user can record attendance for this course
        $course = Course::findOrFail($validated['course_id']);
        $this->authorize('recordAttendance', $course);

        foreach ($validated['students'] as $attendance) {
            Attendance::create([
                'student_id' => $attendance['student_id'],
                'course_id' => $validated['course_id'],
                'attendance_date' => $validated['attendance_date'],
                'status' => $attendance['status'],
            ]);
        }

        return redirect()->back()->with('success', 'Attendance recorded successfully');
    }

    public function updateAttendance(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'status' => 'required|in:present,absent,late',
            'remarks' => 'nullable|string|max:255',
        ]);

        $course = $attendance->course;
        $this->authorize('recordAttendance', $course);

        $attendance->update([
            'status' => $validated['status'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Attendance updated successfully');
    }

    private function calculateGrade($marks)
    {
        if ($marks >= 80) return 'A';
        if ($marks >= 70) return 'B';
        if ($marks >= 60) return 'C';
        if ($marks >= 50) return 'D';
        return 'F';
    }
}
