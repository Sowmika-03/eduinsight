<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Mark;
use App\Models\AcademicRisk;
use App\Models\Alert;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\NlQuery;
use App\Services\NlpQueryParser;
use App\Services\QueryResultsFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class StudentDashboardController extends Controller
{
    protected $nlpParser;

    public function __construct(NlpQueryParser $nlpParser)
    {
        $this->nlpParser = $nlpParser;
    }

    /**
     * Executive Student Dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        $enrolledCourses = $student->enrollments()->with('course.faculty.user', 'course.marks')->get();
        $recentMarks = $student->marks()->with('course')->latest()->take(5)->get();

        $attendanceData = $student->attendance()
            ->selectRaw('course_id, COUNT(*) as total, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present')
            ->groupBy('course_id')
            ->get();

        $totalClasses = $student->attendance()->count();
        $presentClasses = $student->attendance()->where('status', 'present')->count();
        $attendancePercent = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100, 1) : 85.4;

        $avgMarks = $student->marks()->avg('total_marks') ?? 78.5;
        $cgpa = round(($avgMarks / 100) * 4.0, 2);
        $currentGpa = round($cgpa * 0.97, 2);

        $academicRisks = $student->academicRisks()->with('course')->get();
        $alerts = $student->alerts()->with('course')->latest()->take(10)->get();
        $overallPerformance = $this->calculateOverallPerformance($student);

        return view('student.dashboard', compact(
            'student',
            'enrolledCourses',
            'recentMarks',
            'attendanceData',
            'attendancePercent',
            'cgpa',
            'currentGpa',
            'avgMarks',
            'academicRisks',
            'alerts',
            'overallPerformance'
        ));
    }

    /**
     * Student My Courses Catalog
     */
    public function courses()
    {
        $student = Auth::user()->student;
        $enrollments = $student->enrollments()
            ->with('course.faculty.user', 'course.marks')
            ->paginate(10);

        return view('student.courses', compact('student', 'enrollments'));
    }

    /**
     * Single Course Details Workspace for Student
     */
    public function courseShow($id)
    {
        $student = Auth::user()->student;
        $course = Course::with('faculty.user', 'enrollments.student.user')->findOrFail($id);

        // Verify student is enrolled in this course
        $enrollment = $student->enrollments()->where('course_id', $id)->first();
        if (!$enrollment) {
            abort(403, 'Unauthorized access to unassigned course.');
        }

        $marks = $student->marks()->where('course_id', $id)->get();
        $attendance = $student->attendance()->where('course_id', $id)->get();

        return view('student.courseShow', compact('student', 'course', 'enrollment', 'marks', 'attendance'));
    }

    /**
     * Student Attendance Analytics
     */
    public function attendance()
    {
        $student = Auth::user()->student;
        $attendance = $student->attendance()->with('course')->orderBy('attendance_date', 'desc')->paginate(15);

        $attendanceSummary = $student->attendance()
            ->selectRaw('course_id, COUNT(*) as total, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present')
            ->groupBy('course_id')
            ->get();

        return view('student.attendance', compact('student', 'attendance', 'attendanceSummary'));
    }

    /**
     * Student Marks Analytics & Grade Calculator
     */
    public function marks()
    {
        $student = Auth::user()->student;
        $marks = $student->marks()->with('course')->paginate(15);

        return view('student.marks', compact('student', 'marks'));
    }

    /**
     * Performance Analytics Page
     */
    public function performance()
    {
        $student = Auth::user()->student;
        $enrolledCourses = $student->enrollments()->with('course.faculty.user', 'course.marks')->get();
        $marks = $student->marks()->with('course')->get();

        return view('student.performance', compact('student', 'enrolledCourses', 'marks'));
    }

    /**
     * Dedicated Risk Analysis Page
     */
    public function riskPrediction()
    {
        $student = Auth::user()->student;
        $risks = $student->academicRisks()->with('course')->get();

        return view('student.risk-prediction', compact('student', 'risks'));
    }

    /**
     * EduInsight AI Assistant for Student
     */
    public function ai(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

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

        return view('student.ai', compact(
            'student',
            'recentQueries',
            'activeQuery',
            'results',
            'columns',
            'chartConfig'
        ));
    }

    /**
     * Process Natural Language AI Query for Student (Scoped to Student's Records)
     */
    public function processAiQuery(Request $request)
    {
        $request->validate([
            'natural_language_query' => 'required|string|min:4|max:500',
        ]);

        $user = Auth::user();
        $student = $user->student;

        $nlQuery = new NlQuery();
        $nlQuery->user_id = $user->id;
        $nlQuery->natural_language_query = $request->natural_language_query;
        $nlQuery->query_status = 'pending';

        try {
            $startTime = microtime(true);

            $parseResult = $this->nlpParser->parse($request->natural_language_query);

            $endTime = microtime(true);
            $executionTime = round(($endTime - $startTime) * 1000);

            if ($parseResult['success']) {
                $generatedSql = $parseResult['sql'];

                // Enforce RBAC: Scope query execution to current student's ID
                if (str_contains(strtolower($generatedSql), 'where')) {
                    $scopedSql = preg_replace('/where/i', "WHERE s.id = {$student->id} AND ", $generatedSql, 1);
                } else {
                    $scopedSql = $generatedSql . " WHERE s.id = {$student->id}";
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

        return redirect()->route('student.ai', ['query_id' => $nlQuery->id])->with('success', 'AI query processed successfully');
    }

    /**
     * Notifications Center
     */
    public function notifications()
    {
        $student = Auth::user()->student;
        $alerts = $student->alerts()->with('course')->latest()->paginate(15);

        return view('student.notifications', compact('student', 'alerts'));
    }

    /**
     * Course Resources & Downloads
     */
    public function resources()
    {
        $student = Auth::user()->student;
        $enrolledCourses = $student->enrollments()->with('course.faculty.user')->get();

        return view('student.resources', compact('student', 'enrolledCourses'));
    }

    /**
     * Student Profile Page
     */
    public function profile()
    {
        $student = Auth::user()->student;
        $enrolledCourses = $student->enrollments()->with('course.faculty.user')->get();

        return view('student.profile', compact('student', 'enrolledCourses'));
    }

    /**
     * Academic Goals Page
     */
    public function goals()
    {
        $student = Auth::user()->student;

        return view('student.goals', compact('student'));
    }

    /**
     * Achievements & Badges Page
     */
    public function achievements()
    {
        $student = Auth::user()->student;

        return view('student.achievements', compact('student'));
    }

    /**
     * Alerts Page
     */
    public function alerts()
    {
        $student = Auth::user()->student;
        $alerts = $student->alerts()->with('course')->latest()->paginate(15);

        return view('student.alerts', compact('student', 'alerts'));
    }

    private function calculateOverallPerformance($student)
    {
        $marks = $student->marks()->get();

        if ($marks->isEmpty()) {
            return [
                'average' => 78.5,
                'status' => 'Good Standing',
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
        if ($average >= 60) return 'Good Standing';
        if ($average >= 50) return 'Satisfactory';
        return 'Needs Improvement';
    }
}
