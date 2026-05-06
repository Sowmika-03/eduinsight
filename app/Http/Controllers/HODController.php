<?php

namespace App\Http\Controllers;

use App\Models\HOD;
use App\Models\Faculty;
use App\Models\Course;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\AcademicRisk;
use App\Models\Alert;
use App\Services\EmailAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HODController extends Controller
{
    protected $emailAnalyticsService;

    public function __construct(EmailAnalyticsService $emailAnalyticsService)
    {
        $this->emailAnalyticsService = $emailAnalyticsService;
    }

    /**
     * Show HOD Dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();
        $hod = $user->hod;

        // Faculty Statistics
        $totalFaculty = Faculty::where('department', $hod->department)->count();
        $activeFaculty = Faculty::where('department', $hod->department)
            ->where('approval_status', 'approved')
            ->count();

        // Student Statistics
        $enrolledStudents = Enrollment::whereIn(
            'course_id',
            Course::whereIn('faculty_id', Faculty::where('department', $hod->department)->pluck('id'))->pluck('id')
        )->count();

        // Course Statistics
        $totalCourses = Course::whereIn(
            'faculty_id',
            Faculty::where('department', $hod->department)->pluck('id')
        )->count();

        // Academic Risk Students
        $riskStudents = AcademicRisk::whereIn(
            'student_id',
            Student::whereIn(
                'id',
                Enrollment::whereIn(
                    'course_id',
                    Course::whereIn('faculty_id', Faculty::where('department', $hod->department)->pluck('id'))->pluck('id')
                )->pluck('student_id')
            )->pluck('id')
        )->distinct('student_id')->count();

        // Department Faculty
        $faculty = Faculty::where('department', $hod->department)
            ->with('user', 'courses')
            ->paginate(10);

        // Low Attendance Students (< 75%)
        $lowAttendanceStudents = $this->getLowAttendanceStudents($hod);

        // Recent Alerts
        $recentAlerts = AcademicRisk::whereIn(
            'student_id',
            Student::whereIn(
                'id',
                Enrollment::whereIn(
                    'course_id',
                    Course::whereIn('faculty_id', Faculty::where('department', $hod->department)->pluck('id'))->pluck('id')
                )->pluck('student_id')
            )->pluck('id')
        )->latest()->limit(5)->get();

        // Email Analytics Data (only for this HOD)
        $emailStats = $this->emailAnalyticsService->getEmailStats(auth()->id());
        $emailsByDate = $this->emailAnalyticsService->getEmailsByDate(auth()->id());
        $emailsByStatus = $this->emailAnalyticsService->getEmailsByStatus(auth()->id());

        return view('hod.dashboard', compact(
            'hod',
            'totalFaculty',
            'activeFaculty',
            'enrolledStudents',
            'totalCourses',
            'riskStudents',
            'faculty',
            'lowAttendanceStudents',
            'recentAlerts',
            'emailStats',
            'emailsByDate',
            'emailsByStatus'
        ));
    }

    /**
     * Show Faculty Management
     */
    public function manageFaculty()
    {
        $user = auth()->user();
        $hod = $user->hod;

        $faculty = Faculty::where('department', $hod->department)
            ->with('user', 'courses')
            ->paginate(15);

        return view('hod.faculty.index', compact('faculty', 'hod'));
    }

    /**
     * Show Individual Faculty Profile
     */
    public function showFaculty($id)
    {
        $faculty = Faculty::with('user', 'courses')->findOrFail($id);
        $user = auth()->user();
        $hod = $user->hod;

        // Verify faculty belongs to this HOD's department
        if ($faculty->department !== $hod->department) {
            abort(403, 'Unauthorized');
        }

        // Get faculty statistics
        $totalCourses = $faculty->courses()->count();
        $totalStudents = Enrollment::whereIn('course_id', $faculty->courses()->pluck('id'))->distinct('student_id')->count();
        
        $avgAttendance = Attendance::whereIn('course_id', $faculty->courses()->pluck('id'))
            ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
            ->first();
        $attendancePercent = $avgAttendance && $avgAttendance->total > 0 
            ? round(($avgAttendance->present / $avgAttendance->total) * 100, 1)
            : 0;

        $courses = $faculty->courses()->with('enrollments')->paginate(10);

        return view('hod.faculty.show', compact('faculty', 'hod', 'totalCourses', 'totalStudents', 'attendancePercent', 'courses'));
    }

    /**
     * Show Student Management for Department
     */
    public function manageStudents()
    {
        $user = auth()->user();
        $hod = $user->hod;

        // Get all students in courses taught by faculty in this department
        $studentIds = Enrollment::whereIn(
            'course_id',
            Course::whereIn('faculty_id', Faculty::where('department', $hod->department)->pluck('id'))->pluck('id')
        )->distinct('student_id')->pluck('student_id');

        $students = Student::whereIn('id', $studentIds)
            ->with('user', 'enrollments')
            ->paginate(15);

        return view('hod.students.index', compact('students', 'hod'));
    }

    /**
     * Show Individual Student Profile
     */
    public function showStudent($id)
    {
        $student = Student::with('user', 'enrollments')->findOrFail($id);
        $user = auth()->user();
        $hod = $user->hod;

        // Verify student is in this department
        $departmentCourseIds = Course::whereIn('faculty_id', Faculty::where('department', $hod->department)->pluck('id'))->pluck('id');
        $isInDepartment = Enrollment::where('student_id', $student->id)
            ->whereIn('course_id', $departmentCourseIds)
            ->exists();

        if (!$isInDepartment) {
            abort(403, 'Unauthorized');
        }

        // Get student statistics
        $enrollments = $student->enrollments()->whereIn('course_id', $departmentCourseIds)->get();
        
        $avgAttendance = Attendance::where('student_id', $student->id)
            ->whereIn('course_id', $departmentCourseIds)
            ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
            ->first();
        $attendancePercent = $avgAttendance && $avgAttendance->total > 0 
            ? round(($avgAttendance->present / $avgAttendance->total) * 100, 1)
            : 0;

        $avgMarks = Mark::where('student_id', $student->id)
            ->whereIn('course_id', $departmentCourseIds)
            ->avg('total_marks');

        $riskRecords = AcademicRisk::where('student_id', $student->id)->get();

        return view('hod.students.show', compact('student', 'hod', 'enrollments', 'attendancePercent', 'avgMarks', 'riskRecords'));
    }

    /**
     * Show Department Courses
     */
    public function manageCourses()
    {
        $user = auth()->user();
        $hod = $user->hod;

        $courses = Course::whereIn('faculty_id', Faculty::where('department', $hod->department)->pluck('id'))
            ->with('faculty.user', 'enrollments')
            ->paginate(15);

        return view('hod.courses.index', compact('courses', 'hod'));
    }

    /**
     * Show Department Analytics
     */
    public function analytics()
    {
        $user = auth()->user();
        $hod = $user->hod;

        // Faculty Performance
        $facultyStats = Faculty::where('department', $hod->department)
            ->with('courses')
            ->get()
            ->map(function ($faculty) {
                $totalStudents = Enrollment::whereIn('course_id', $faculty->courses()->pluck('id'))->distinct('student_id')->count();
                $avgMarks = Mark::whereIn('course_id', $faculty->courses()->pluck('id'))->avg('total_marks');
                
                $avgAttendance = Attendance::whereIn('course_id', $faculty->courses()->pluck('id'))
                    ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                    ->first();
                $attendancePercent = $avgAttendance && $avgAttendance->total > 0 
                    ? round(($avgAttendance->present / $avgAttendance->total) * 100, 1)
                    : 0;

                return [
                    'name' => $faculty->user->name,
                    'totalStudents' => $totalStudents,
                    'avgMarks' => round($avgMarks ?? 0, 2),
                    'avgAttendance' => $attendancePercent,
                    'courses' => $faculty->courses()->count(),
                ];
            });

        // Student Performance
        $studentIds = Enrollment::whereIn(
            'course_id',
            Course::whereIn('faculty_id', Faculty::where('department', $hod->department)->pluck('id'))->pluck('id')
        )->distinct('student_id')->pluck('student_id');

        $studentStats = Student::whereIn('id', $studentIds)
            ->with('user', 'enrollments')
            ->get()
            ->map(function ($student) use ($hod) {
                $departmentCourseIds = Course::whereIn('faculty_id', Faculty::where('department', $hod->department)->pluck('id'))->pluck('id');
                
                $avgMarks = Mark::where('student_id', $student->id)
                    ->whereIn('course_id', $departmentCourseIds)
                    ->avg('total_marks');
                
                $avgAttendance = Attendance::where('student_id', $student->id)
                    ->whereIn('course_id', $departmentCourseIds)
                    ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                    ->first();
                $attendancePercent = $avgAttendance && $avgAttendance->total > 0 
                    ? round(($avgAttendance->present / $avgAttendance->total) * 100, 1)
                    : 0;

                return [
                    'id' => $student->id,
                    'name' => $student->user->name,
                    'regNumber' => $student->user->reg_number,
                    'avgMarks' => round($avgMarks ?? 0, 2),
                    'avgAttendance' => $attendancePercent,
                    'courses' => $student->enrollments()->whereIn('course_id', $departmentCourseIds)->count(),
                ];
            });

        return view('hod.analytics', compact('hod', 'facultyStats', 'studentStats'));
    }

    /**
     * Get students with low attendance
     */
    private function getLowAttendanceStudents($hod, $limit = 5)
    {
        $departmentCourseIds = Course::whereIn('faculty_id', Faculty::where('department', $hod->department)->pluck('id'))->pluck('id');
        
        $studentIds = Enrollment::whereIn('course_id', $departmentCourseIds)->distinct('student_id')->pluck('student_id');

        return Student::whereIn('id', $studentIds)
            ->with('user')
            ->get()
            ->map(function ($student) use ($departmentCourseIds) {
                $avgAttendance = Attendance::where('student_id', $student->id)
                    ->whereIn('course_id', $departmentCourseIds)
                    ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                    ->first();
                
                $attendancePercent = $avgAttendance && $avgAttendance->total > 0 
                    ? round(($avgAttendance->present / $avgAttendance->total) * 100, 1)
                    : 100;

                return [
                    'student' => $student,
                    'attendance' => $attendancePercent,
                ];
            })
            ->filter(fn($item) => $item['attendance'] < 75)
            ->sortBy(fn($item) => $item['attendance'])
            ->take($limit)
            ->values();
    }

    /**
     * Get alerts for a specific student (API endpoint)
     */
    public function getStudentAlerts(Student $student)
    {
        // Verify the student belongs to this HOD's department
        $user = auth()->user();
        $hod = $user->hod;
        
        // Get department courses
        $departmentFacultyIds = Faculty::where('department', $hod->department)->pluck('id');
        $departmentCourseIds = Course::whereIn('faculty_id', $departmentFacultyIds)->pluck('id');
        
        // Get academic risks for this student
        $alerts = AcademicRisk::where('student_id', $student->id)
            ->latest()
            ->get()
            ->map(function ($risk) {
                return [
                    'alert_type' => 'Academic Risk',
                    'risk_level' => $risk->risk_level,
                    'attendance_percentage' => $risk->attendance_percentage,
                    'average_marks' => $risk->average_marks,
                    'created_at' => $risk->created_at->format('M d, Y g:i A'),
                ];
            });

        return response()->json([
            'alerts' => $alerts,
            'student' => $student->user->name,
        ]);
    }
}
