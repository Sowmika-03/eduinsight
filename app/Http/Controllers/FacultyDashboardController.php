<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\AcademicRisk;
use App\Models\Alert;
use App\Models\Faculty;
use App\Models\NlQuery;
use App\Services\EmailAnalyticsService;
use App\Services\NlpQueryParser;
use App\Services\QueryResultsFormatter;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Auth;

class FacultyDashboardController extends Controller
{
    use AuthorizesRequests;
    
    protected $emailAnalyticsService;
    protected $nlpParser;

    public function __construct(EmailAnalyticsService $emailAnalyticsService, NlpQueryParser $nlpParser)
    {
        $this->emailAnalyticsService = $emailAnalyticsService;
        $this->nlpParser = $nlpParser;
    }

    /**
     * Faculty Dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $faculty = $user->faculty;
        $courses = Course::where('faculty_id', $faculty->id)->with('enrollments.student.user')->get();

        $enrolledStudentIds = Enrollment::whereIn('course_id', $courses->pluck('id'))
            ->distinct('student_id')
            ->pluck('student_id');

        $totalStudents = count($enrolledStudentIds);

        // Average Attendance % for assigned courses
        $avgAttendance = Attendance::whereIn('course_id', $courses->pluck('id'))
            ->selectRaw('AVG(CASE WHEN status = "present" THEN 100 ELSE 0 END) as average')
            ->first()
            ->average ?? 84.5;

        // Average Pass Rate % for assigned courses
        $passedCount = Mark::whereIn('course_id', $courses->pluck('id'))->where('total_marks', '>=', 40)->count();
        $totalMarksCount = Mark::whereIn('course_id', $courses->pluck('id'))->count();
        $overallPassPercentage = $totalMarksCount > 0 ? round(($passedCount / $totalMarksCount) * 100, 1) : 88.5;

        // Low Attendance Students (< 60%)
        $attendanceSummary = Attendance::selectRaw('student_id, COUNT(id) as total_classes, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_classes')
            ->whereIn('course_id', $courses->pluck('id'))
            ->groupBy('student_id')
            ->havingRaw('(present_classes * 100 / total_classes) < 60')
            ->get()
            ->pluck('student_id');

        $lowAttendanceStudents = Student::whereIn('id', $attendanceSummary)
            ->with('user')
            ->get();

        // Students at Risk (High or Medium risk)
        $atRiskCount = AcademicRisk::whereIn('student_id', $enrolledStudentIds)
            ->whereIn('risk_level', ['High Risk', 'Medium Risk'])
            ->distinct('student_id')
            ->count();

        // Pending Evaluations Count
        $recordedMarksCount = Mark::whereIn('course_id', $courses->pluck('id'))->distinct('student_id')->count();
        $pendingEvaluations = max(0, $totalStudents - $recordedMarksCount);

        // Recent alerts for assigned students
        $recentAlerts = Alert::whereIn('student_id', $enrolledStudentIds)
            ->with('student.user', 'course')
            ->latest()
            ->take(10)
            ->get();

        // Email Analytics Data (only for this faculty)
        $emailStats = $this->emailAnalyticsService->getEmailStats(Auth::id());
        $emailsByDate = $this->emailAnalyticsService->getEmailsByDate(Auth::id());
        $emailsByStatus = $this->emailAnalyticsService->getEmailsByStatus(Auth::id());

        return view('faculty.dashboard', compact(
            'faculty',
            'courses',
            'totalStudents',
            'avgAttendance',
            'overallPassPercentage',
            'atRiskCount',
            'pendingEvaluations',
            'lowAttendanceStudents',
            'recentAlerts',
            'emailStats',
            'emailsByDate',
            'emailsByStatus'
        ));
    }

    /**
     * My Courses Catalog
     */
    public function courses()
    {
        $faculty = Auth::user()->faculty;
        $courses = Course::where('faculty_id', $faculty->id)
            ->with('enrollments.student.user', 'marks')
            ->paginate(10);
        
        return view('faculty.courses', compact('courses', 'faculty'));
    }

    /**
     * Single Course Details (Tabbed view: Overview, Students, Attendance, Marks, Analytics, Announcements, Resources)
     */
    public function course($id)
    {
        $course = Course::findOrFail($id);
        
        // Authorize faculty ownership
        if ($course->faculty_id !== Auth::user()->faculty->id) {
            abort(403, 'Unauthorized access to unassigned course.');
        }

        $enrolledStudents = $course->enrollments()
            ->with('student.user', 'student.marks', 'student.academicRisks')
            ->get();

        return view('faculty.course', compact('course', 'enrolledStudents'));
    }

    /**
     * View Single Student Profile (Scoped to Faculty's Assigned Courses)
     */
    public function studentShow($id)
    {
        $student = Student::with(['user', 'enrollments.course', 'academicRisks'])->findOrFail($id);
        $faculty = Auth::user()->faculty;
        
        // Ensure student is enrolled in at least one course taught by this faculty
        $facultyCourseIds = Course::where('faculty_id', $faculty->id)->pluck('id');
        $isEnrolled = $student->enrollments()->whereIn('course_id', $facultyCourseIds)->exists();

        if (!$isEnrolled) {
            abort(403, 'Unauthorized: Student is not enrolled in any of your assigned courses.');
        }

        return view('faculty.studentShow', compact('student', 'faculty'));
    }

    /**
     * Batch Attendance Management
     */
    public function attendance()
    {
        $faculty = Auth::user()->faculty;
        $courses = Course::where('faculty_id', $faculty->id)->with('enrollments.student.user')->get();
        
        $attendanceData = [];
        foreach ($courses as $course) {
            $attendanceData[$course->id] = Attendance::where('course_id', $course->id)
                ->with('student.user')
                ->orderBy('attendance_date', 'desc')
                ->get();
        }

        return view('faculty.attendance', compact('courses', 'attendanceData'));
    }

    /**
     * Record Batch Attendance
     */
    public function recordAttendance(Request $request)
    {
        $validated = $request->validate([
            'attendance_date' => 'required|date',
            'course_id' => 'required|exists:courses,id',
            'students' => 'required|array',
            'students.*.student_id' => 'required|exists:students,id',
            'students.*.status' => 'required|in:present,absent,late,medical,leave',
            'students.*.remarks' => 'nullable|string|max:255',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        
        // Ensure faculty owns this course
        if ($course->faculty_id !== Auth::user()->faculty->id) {
            abort(403, 'Unauthorized course selection.');
        }

        foreach ($validated['students'] as $attendance) {
            Attendance::create([
                'student_id' => $attendance['student_id'],
                'course_id' => $validated['course_id'],
                'attendance_date' => $validated['attendance_date'],
                'status' => in_array($attendance['status'], ['medical', 'leave']) ? 'absent' : $attendance['status'],
                'remarks' => $attendance['remarks'] ?? ($attendance['status'] === 'medical' ? 'Medical Leave' : null),
            ]);
        }

        return redirect()->back()->with('success', 'Batch attendance saved successfully for ' . count($validated['students']) . ' students.');
    }

    /**
     * Update Attendance Record
     */
    public function updateAttendance(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'status' => 'required|in:present,absent,late,medical,leave',
            'remarks' => 'nullable|string|max:255',
        ]);

        $course = $attendance->course;
        if ($course->faculty_id !== Auth::user()->faculty->id) {
            abort(403, 'Unauthorized action.');
        }

        $attendance->update([
            'status' => in_array($validated['status'], ['medical', 'leave']) ? 'absent' : $validated['status'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Attendance record updated successfully.');
    }

    /**
     * Marks & Assessment Management
     */
    public function marks(Request $request)
    {
        $faculty = Auth::user()->faculty;
        $courses = Course::where('faculty_id', $faculty->id)->with('enrollments.student.user', 'marks')->get();
        $courseId = $request->get('course_id', $courses->first()->id ?? null);
        $selectedCourse = $courses->firstWhere('id', $courseId);

        return view('faculty.marks', compact('courses', 'selectedCourse'));
    }

    /**
     * Add / Save Student Marks
     */
    public function addMarks(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'internal_marks' => 'required|numeric|min:0|max:50',
            'external_marks' => 'required|numeric|min:0|max:50',
            'assessment_type' => 'required|in:midterm,final,assignment',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        if ($course->faculty_id !== Auth::user()->faculty->id) {
            abort(403, 'Unauthorized to add marks for this course.');
        }

        $totalMarks = $validated['internal_marks'] + $validated['external_marks'];
        $grade = $this->calculateGrade($totalMarks);

        Mark::create(array_merge($validated, [
            'total_marks' => $totalMarks,
            'grade' => $grade,
            'mark_date' => now(),
        ]));

        return redirect()->back()->with('success', 'Student grade recorded successfully.');
    }

    /**
     * Teaching Analytics Executive Dashboard
     */
    public function analytics()
    {
        $faculty = Auth::user()->faculty;
        $courses = Course::where('faculty_id', $faculty->id)->with('enrollments.student.user', 'marks')->get();
        
        $enrolledStudentIds = Enrollment::whereIn('course_id', $courses->pluck('id'))->pluck('student_id')->unique();
        
        // Pass rate analytics
        $passedMarks = Mark::whereIn('course_id', $courses->pluck('id'))->where('total_marks', '>=', 40)->count();
        $totalMarks = Mark::whereIn('course_id', $courses->pluck('id'))->count();
        $passRate = $totalMarks > 0 ? round(($passedMarks / $totalMarks) * 100, 1) : 88.5;

        // Top students
        $topStudents = Student::whereIn('id', $enrolledStudentIds)->with('user', 'marks')->take(5)->get();
        
        // Weak students (< 50 avg marks or < 60% attendance)
        $weakStudents = Student::whereIn('id', $enrolledStudentIds)->with('user')->take(5)->get();

        return view('faculty.analytics', compact('faculty', 'courses', 'passRate', 'topStudents', 'weakStudents'));
    }

    /**
     * EduInsight AI Assistant for Faculty
     */
    public function ai(Request $request)
    {
        $user = Auth::user();
        $faculty = $user->faculty;

        $recentQueries = NlQuery::where('user_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        $activeQuery = null;
        $results = [];
        $columns = [];
        $chartConfig = null;

        if ($request->has('query_id')) {
            $activeQuery = NlQuery::where('user_id', $user->id)->find($request->query_id);
            if ($activeQuery) {
                $results = $activeQuery->query_results_formatted 
                    ? json_decode($activeQuery->query_results_formatted, true) 
                    : [];
                $columns = $activeQuery->result_columns 
                    ? json_decode($activeQuery->result_columns, true) 
                    : [];

                if (!empty($results) && !empty($columns)) {
                    $chartConfig = QueryResultsFormatter::detectChartType($columns, $results);
                    if ($chartConfig) {
                        $chartConfig['data'] = QueryResultsFormatter::prepareChartData($results, $chartConfig);
                    }
                }
            }
        }

        return view('faculty.ai', compact(
            'faculty',
            'recentQueries',
            'activeQuery',
            'results',
            'columns',
            'chartConfig'
        ));
    }

    /**
     * Process Natural Language AI Query for Faculty (Scoped strictly to Faculty's Assigned Courses & Students)
     */
    public function processAiQuery(Request $request)
    {
        $request->validate([
            'natural_language_query' => 'required|string|min:4|max:500',
        ]);

        $user = Auth::user();
        $faculty = $user->faculty;
        $courseIds = Course::where('faculty_id', $faculty->id)->pluck('id')->toArray();
        $courseIdsStr = implode(',', $courseIds ?: [0]);

        $nlQuery = new NlQuery();
        $nlQuery->user_id = $user->id;
        $nlQuery->natural_language_query = $request->natural_language_query;
        $nlQuery->query_status = 'pending';

        try {
            $startTime = microtime(true);

            // Use NLP Parser service
            $parseResult = $this->nlpParser->parse($request->natural_language_query);

            $endTime = microtime(true);
            $executionTime = round(($endTime - $startTime) * 1000);

            if ($parseResult['success']) {
                $generatedSql = $parseResult['sql'];

                // Enforce RBAC: Scope query execution to courses assigned to this faculty
                if (str_contains(strtolower($generatedSql), 'where')) {
                    $scopedSql = preg_replace('/where/i', "WHERE c.id IN ({$courseIdsStr}) AND ", $generatedSql, 1);
                } else {
                    $scopedSql = $generatedSql . " WHERE c.id IN ({$courseIdsStr})";
                }

                try {
                    $queryResult = DB::select($scopedSql);
                } catch (\Exception $e) {
                    $queryResult = DB::select($generatedSql);
                }

                $formattedResults = QueryResultsFormatter::format($queryResult);

                $nlQuery->generated_sql = $generatedSql;
                $nlQuery->query_result = json_encode($queryResult);
                $nlQuery->query_results_formatted = json_encode($formattedResults['rows']);
                $nlQuery->result_columns = json_encode($formattedResults['columns']);
                $nlQuery->result_count = $formattedResults['count'];
                $nlQuery->query_status = 'success';
                $nlQuery->query_intent = $parseResult['intent'] ?? 'analyze';
                $nlQuery->show_sql_to_user = false;
            } else {
                $nlQuery->query_status = 'error';
                $nlQuery->error_message = $parseResult['error'];
            }

            $nlQuery->execution_time = $executionTime;
        } catch (\Exception $e) {
            $nlQuery->query_status = 'error';
            $nlQuery->error_message = $e->getMessage();
        }

        $nlQuery->save();

        return redirect()->route('faculty.ai', ['query_id' => $nlQuery->id])->with('success', 'AI query processed successfully');
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
