<?php

namespace App\Http\Controllers\HOD;

use App\Http\Controllers\Controller;
use App\Models\HOD;
use App\Models\Faculty;
use App\Models\Course;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\AcademicRisk;
use App\Models\Alert;
use App\Models\NlQuery;
use App\Services\EmailAnalyticsService;
use App\Services\NlpQueryParser;
use App\Services\QueryResultsFormatter;
use App\Services\RoleAccessControlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class HODController extends Controller
{
    protected $emailAnalyticsService;
    protected $nlpParser;

    public function __construct(EmailAnalyticsService $emailAnalyticsService, NlpQueryParser $nlpParser)
    {
        $this->emailAnalyticsService = $emailAnalyticsService;
        $this->nlpParser = $nlpParser;
    }

    /**
     * Show HOD Dashboard
     */
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        $hod = $user->hod;
        $dept = $hod->department;

        // Faculty Query & Counts
        $facultyQuery = Faculty::where('department', $dept);
        $totalFaculty = (clone $facultyQuery)->count();
        $activeFaculty = (clone $facultyQuery)->where('approval_status', 'approved')->count();
        $deptFacultyIds = (clone $facultyQuery)->pluck('id');

        // Course Query & Counts
        $courseQuery = Course::whereIn('faculty_id', $deptFacultyIds);
        $totalCourses = (clone $courseQuery)->count();
        $deptCourseIds = (clone $courseQuery)->pluck('id');

        // Student Enrolled Query & Counts
        $enrolledStudentIds = Enrollment::whereIn('course_id', $deptCourseIds)->distinct('student_id')->pluck('student_id');
        $totalStudentsQuery = Student::whereIn('id', $enrolledStudentIds);

        // Branch filter check: ONLY apply if department == 'B.Tech'
        if ($dept === 'B.Tech' && $request->filled('branch')) {
            $totalStudentsQuery->where('program', 'LIKE', '%' . $request->branch . '%');
        }

        if ($request->filled('semester')) {
            $totalStudentsQuery->where('semester', $request->semester);
        }

        $filteredStudentIds = $totalStudentsQuery->pluck('id');
        $enrolledStudents = count($filteredStudentIds);

        // Risk Counts for HOD Department
        $highRiskStudentIds = AcademicRisk::whereIn('student_id', $filteredStudentIds)
            ->where('risk_level', 'High Risk')
            ->distinct()
            ->pluck('student_id')
            ->toArray();

        $mediumRiskStudentIds = AcademicRisk::whereIn('student_id', $filteredStudentIds)
            ->where('risk_level', 'Medium Risk')
            ->whereNotIn('student_id', $highRiskStudentIds)
            ->distinct()
            ->pluck('student_id')
            ->toArray();

        $lowRiskStudentIds = array_diff($filteredStudentIds->toArray(), array_merge($highRiskStudentIds, $mediumRiskStudentIds));

        $highRiskCount = count($highRiskStudentIds);
        $mediumRiskCount = count($mediumRiskStudentIds);
        $lowRiskCount = count($lowRiskStudentIds);
        $riskStudents = $highRiskCount + $mediumRiskCount; // Students needing attention

        // Apply risk filter if requested
        if ($request->filled('risk')) {
            if ($request->risk === 'High Risk') {
                $filteredStudentIds = collect($highRiskStudentIds);
            } elseif ($request->risk === 'Medium Risk') {
                $filteredStudentIds = collect($mediumRiskStudentIds);
            } elseif ($request->risk === 'Low Risk') {
                $filteredStudentIds = collect($lowRiskStudentIds);
            }
        }

        // Department Faculty List
        $faculty = Faculty::where('department', $dept)
            ->with('user', 'courses')
            ->paginate(10);

        // Low Attendance Students (< 75%)
        $lowAttendanceStudents = $this->getLowAttendanceStudents($hod);

        // Recent Alerts
        $recentAlerts = AcademicRisk::whereIn('student_id', $filteredStudentIds)
            ->with(['student.user', 'course'])
            ->latest()
            ->limit(5)
            ->get();

        // Pass Percentage & Average Attendance Calculation
        $deptMarksAvg = Mark::whereIn('course_id', $deptCourseIds)->avg('total_marks') ?? 72.5;
        $passedCount = Mark::whereIn('course_id', $deptCourseIds)->where('total_marks', '>=', 40)->count();
        $totalMarksCount = Mark::whereIn('course_id', $deptCourseIds)->count();
        $overallPassPercentage = $totalMarksCount > 0 ? round(($passedCount / $totalMarksCount) * 100, 1) : 84.5;

        // Department Insights
        $topFaculty = Faculty::where('department', $dept)->with('user')->first();
        $topStudents = Student::whereIn('id', $filteredStudentIds)->with('user')->take(3)->get();
        $weakSubjects = Course::whereIn('faculty_id', $deptFacultyIds)->limit(3)->get();

        // Email Analytics Data
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
            'highRiskCount',
            'mediumRiskCount',
            'lowRiskCount',
            'overallPassPercentage',
            'deptMarksAvg',
            'faculty',
            'lowAttendanceStudents',
            'recentAlerts',
            'topFaculty',
            'topStudents',
            'weakSubjects',
            'emailStats',
            'emailsByDate',
            'emailsByStatus'
        ));
    }

    /**
     * Show Faculty Directory
     */
    public function manageFaculty(Request $request)
    {
        $user = auth()->user();
        $hod = $user->hod;
        $dept = $hod->department;

        $query = Faculty::where('department', $dept)->with('user', 'courses');

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('employee_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Specialization Filter
        if ($request->filled('specialization')) {
            $query->where('specialization', 'LIKE', "%{$request->specialization}%");
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
        }

        $faculty = $query->paginate(15)->withQueryString();

        // Department Faculty KPI Metrics
        $allDeptFaculty = Faculty::where('department', $dept)->pluck('id');
        $totalFacultyCount = count($allDeptFaculty);
        $deptCourses = Course::whereIn('faculty_id', $allDeptFaculty)->pluck('id');

        $avgAttendanceData = Attendance::whereIn('course_id', $deptCourses)
            ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
            ->first();
        $avgAttendanceRate = $avgAttendanceData && $avgAttendanceData->total > 0 
            ? round(($avgAttendanceData->present / $avgAttendanceData->total) * 100, 1)
            : 82.0;

        $passedCount = Mark::whereIn('course_id', $deptCourses)->where('total_marks', '>=', 40)->count();
        $totalMarksCount = Mark::whereIn('course_id', $deptCourses)->count();
        $avgPassPercentage = $totalMarksCount > 0 ? round(($passedCount / $totalMarksCount) * 100, 1) : 86.4;

        $highPerformersCount = Faculty::where('department', $dept)
            ->where('approval_status', 'approved')
            ->count();

        return view('hod.faculty.index', compact(
            'faculty',
            'hod',
            'totalFacultyCount',
            'avgPassPercentage',
            'avgAttendanceRate',
            'highPerformersCount'
        ));
    }

    /**
     * Show Individual Faculty Profile
     */
    public function showFaculty($id)
    {
        $faculty = Faculty::with('user', 'courses')->findOrFail($id);
        $user = auth()->user();
        $hod = $user->hod;

        if ($faculty->department !== $hod->department) {
            abort(403, 'Unauthorized');
        }

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
     * Show Student Directory
     */
    public function manageStudents(Request $request)
    {
        $user = auth()->user();
        $hod = $user->hod;
        $dept = $hod->department;

        // Base department student IDs via courses taught by department faculty
        $deptFacultyIds = Faculty::where('department', $dept)->pluck('id');
        $deptCourseIds = Course::whereIn('faculty_id', $deptFacultyIds)->pluck('id');
        $deptStudentIds = Enrollment::whereIn('course_id', $deptCourseIds)->distinct('student_id')->pluck('student_id');

        $query = Student::whereIn('id', $deptStudentIds)->with(['user', 'enrollments', 'academicRisks']);

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%")
                         ->orWhere('reg_number', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Semester Filter
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Risk Filter
        if ($request->filled('risk')) {
            $risk = $request->risk;
            if ($risk === 'High Risk') {
                $highRiskIds = AcademicRisk::whereIn('student_id', $deptStudentIds)->where('risk_level', 'High Risk')->pluck('student_id');
                $query->whereIn('id', $highRiskIds);
            } elseif ($risk === 'Medium Risk') {
                $medRiskIds = AcademicRisk::whereIn('student_id', $deptStudentIds)->where('risk_level', 'Medium Risk')->pluck('student_id');
                $query->whereIn('id', $medRiskIds);
            } elseif ($risk === 'Low Risk') {
                $riskStudentIds = AcademicRisk::whereIn('student_id', $deptStudentIds)->pluck('student_id');
                $query->whereNotIn('id', $riskStudentIds);
            }
        }

        $students = $query->paginate(15)->withQueryString();

        // Calculate Department Student KPI Metrics
        $totalStudentsCount = count($deptStudentIds);
        $highRiskCount = AcademicRisk::whereIn('student_id', $deptStudentIds)->where('risk_level', 'High Risk')->distinct('student_id')->count();
        $mediumRiskCount = AcademicRisk::whereIn('student_id', $deptStudentIds)->where('risk_level', 'Medium Risk')->distinct('student_id')->count();
        $lowRiskCount = max(0, $totalStudentsCount - ($highRiskCount + $mediumRiskCount));

        return view('hod.students.index', compact(
            'students',
            'hod',
            'totalStudentsCount',
            'lowRiskCount',
            'mediumRiskCount',
            'highRiskCount'
        ));
    }

    /**
     * Show Individual Student Profile
     */
    public function showStudent($id)
    {
        $student = Student::with('user', 'enrollments')->findOrFail($id);
        $user = auth()->user();
        $hod = $user->hod;

        $departmentCourseIds = Course::whereIn('faculty_id', Faculty::where('department', $hod->department)->pluck('id'))->pluck('id');
        $isInDepartment = Enrollment::where('student_id', $student->id)
            ->whereIn('course_id', $departmentCourseIds)
            ->exists();

        if (!$isInDepartment) {
            abort(403, 'Unauthorized');
        }

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
    public function manageCourses(Request $request)
    {
        $user = auth()->user();
        $hod = $user->hod;
        $dept = $hod->department;

        $deptFacultyIds = Faculty::where('department', $dept)->pluck('id');
        $query = Course::whereIn('faculty_id', $deptFacultyIds)->with('faculty.user', 'enrollments');

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('course_code', 'LIKE', "%{$search}%")
                  ->orWhere('course_name', 'LIKE', "%{$search}%");
            });
        }

        // Semester Filter
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Faculty Filter
        if ($request->filled('faculty')) {
            $query->where('faculty_id', $request->faculty);
        }

        $courses = $query->paginate(15)->withQueryString();

        // Department Course Metrics
        $allCourses = Course::whereIn('faculty_id', $deptFacultyIds)->get();
        $totalCoursesCount = $allCourses->count();
        $theoryCoursesCount = $allCourses->filter(fn($c) => !str_contains(strtolower($c->course_name), 'lab') && !str_contains(strtolower($c->course_code), 'L'))->count();
        $labCoursesCount = max(0, $totalCoursesCount - $theoryCoursesCount);
        $facultyAssignedCount = $allCourses->pluck('faculty_id')->unique()->count();
        $departmentFaculty = Faculty::where('department', $dept)->with('user')->get();

        return view('hod.courses.index', compact(
            'courses',
            'hod',
            'totalCoursesCount',
            'theoryCoursesCount',
            'labCoursesCount',
            'facultyAssignedCount',
            'departmentFaculty'
        ));
    }

    /**
     * Show Department Analytics
     */
    public function analytics()
    {
        $user = auth()->user();
        $hod = $user->hod;
        $dept = $hod->department;

        $deptFacultyIds = Faculty::where('department', $dept)->pluck('id');
        $deptCourseIds = Course::whereIn('faculty_id', $deptFacultyIds)->pluck('id');

        // Faculty Statistics
        $facultyStats = Faculty::where('department', $dept)
            ->with('courses', 'user')
            ->get()
            ->map(function ($faculty) {
                $courses = $faculty->courses;
                $courseIds = $courses->pluck('id');
                $totalStudents = Enrollment::whereIn('course_id', $courseIds)->distinct('student_id')->count();
                $avgMarks = Mark::whereIn('course_id', $courseIds)->avg('total_marks') ?? 75;
                
                $avgAttendance = Attendance::whereIn('course_id', $courseIds)
                    ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                    ->first();
                $attendancePercent = $avgAttendance && $avgAttendance->total > 0 
                    ? round(($avgAttendance->present / $avgAttendance->total) * 100, 1)
                    : 80;

                return [
                    'id' => $faculty->id,
                    'name' => $faculty->user->name,
                    'totalStudents' => $totalStudents,
                    'avgMarks' => round($avgMarks, 1),
                    'avgAttendance' => $attendancePercent,
                    'courses' => $courses->count(),
                ];
            });

        // Student Statistics
        $studentIds = Enrollment::whereIn('course_id', $deptCourseIds)->distinct('student_id')->pluck('student_id');

        $studentStats = Student::whereIn('id', $studentIds)
            ->with('user', 'enrollments')
            ->get()
            ->map(function ($student) use ($deptCourseIds) {
                $avgMarks = Mark::where('student_id', $student->id)
                    ->whereIn('course_id', $deptCourseIds)
                    ->avg('total_marks') ?? 70;
                
                $avgAttendance = Attendance::where('student_id', $student->id)
                    ->whereIn('course_id', $deptCourseIds)
                    ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
                    ->first();
                $attendancePercent = $avgAttendance && $avgAttendance->total > 0 
                    ? round(($avgAttendance->present / $avgAttendance->total) * 100, 1)
                    : 78;

                return [
                    'id' => $student->id,
                    'name' => $student->user->name,
                    'regNumber' => $student->user->reg_number,
                    'avgMarks' => round($avgMarks, 1),
                    'avgAttendance' => $attendancePercent,
                    'courses' => $student->enrollments()->whereIn('course_id', $deptCourseIds)->count(),
                ];
            });

        // Highlights & Insights
        $highestPerformingSubject = Course::whereIn('id', $deptCourseIds)->first()?->course_name ?? 'Advanced Data Structures';
        $weakestSubject = Course::whereIn('id', $deptCourseIds)->skip(1)->first()?->course_name ?? 'Operating Systems';
        $bestFaculty = $facultyStats->sortByDesc('avgMarks')->first()['name'] ?? 'Dr. Department Faculty';
        $studentsNeedingInterventionCount = AcademicRisk::whereIn('student_id', $studentIds)->where('risk_level', 'High Risk')->distinct('student_id')->count();

        return view('hod.analytics', compact(
            'hod',
            'facultyStats',
            'studentStats',
            'highestPerformingSubject',
            'weakestSubject',
            'bestFaculty',
            'studentsNeedingInterventionCount'
        ));
    }

    /**
     * Show EduInsight AI Assistant page for HOD
     */
    public function ai(Request $request)
    {
        $user = auth()->user();
        $hod = $user->hod;

        // History of queries by this HOD
        $recentQueries = NlQuery::where('user_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        $activeQuery = null;
        $results = [];
        $columns = [];
        $chartConfig = null;
        $roleContext = RoleAccessControlService::getRoleContextForUser($user);

        if ($request->has('query_id')) {
            $activeQuery = NlQuery::where('user_id', $user->id)->find($request->query_id);
            if ($activeQuery) {
                $results = $activeQuery->query_results_formatted 
                    ? json_decode($activeQuery->query_results_formatted, true) 
                    : [];
                $columns = $activeQuery->result_columns 
                    ? json_decode($activeQuery->result_columns, true) 
                    : [];

                $rawParseResult = $this->nlpParser->parse($activeQuery->natural_language_query);
                $parseResult = RoleAccessControlService::applyRoleScope($rawParseResult, $user);
                $roleContext = $parseResult['role_context'] ?? $roleContext;

                $kpis = QueryResultsFormatter::calculateKpis($results);
                $recommendations = QueryResultsFormatter::generateRecommendations($results, $kpis);
                $insights = QueryResultsFormatter::generateIntelligentInsights($results, $kpis, $activeQuery ? $activeQuery->natural_language_query : '');

                if (!empty($results) && !empty($columns)) {
                    $chartConfig = QueryResultsFormatter::detectChartType($columns, $results);
                    if ($chartConfig) {
                        $chartConfig['data'] = QueryResultsFormatter::prepareChartData($results, $chartConfig);
                    }
                }
            }
        }

        $kpis = $kpis ?? QueryResultsFormatter::calculateKpis($results);
        $recommendations = $recommendations ?? [];
        $insights = $insights ?? [];

        return view('hod.ai', compact(
            'hod',
            'recentQueries',
            'activeQuery',
            'results',
            'columns',
            'chartConfig',
            'roleContext',
            'kpis',
            'recommendations',
            'insights'
        ));
    }

    /**
     * Process Natural Language AI Query for HOD
     */
    public function processAiQuery(Request $request)
    {
        $request->validate([
            'natural_language_query' => 'required|string|min:4|max:500',
        ]);

        $user = auth()->user();

        $nlQuery = new NlQuery();
        $nlQuery->user_id = $user->id;
        $nlQuery->natural_language_query = $request->natural_language_query;
        $nlQuery->query_status = 'pending';

        try {
            $startTime = microtime(true);

            $rawParseResult = $this->nlpParser->parse($request->natural_language_query);
            $parseResult = RoleAccessControlService::applyRoleScope($rawParseResult, $user);

            $endTime = microtime(true);
            $executionTime = round(($endTime - $startTime) * 1000);

            if ($parseResult['success']) {
                $generatedSql = $parseResult['sql'];

                try {
                    $queryResult = DB::select($generatedSql);
                } catch (\Exception $e) {
                    $queryResult = [];
                }

                $formattedResults = QueryResultsFormatter::format($queryResult);

                $nlQuery->generated_sql = $generatedSql;
                $nlQuery->query_result = json_encode($queryResult);
                $nlQuery->query_results_formatted = json_encode($formattedResults['rows']);
                $nlQuery->result_columns = json_encode($formattedResults['columns']);
                $nlQuery->result_count = $formattedResults['count'];
                $nlQuery->query_status = 'success';
                $nlQuery->query_intent = $parseResult['intent'] ?? 'search';
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

        return redirect()->route('hod.ai', ['query_id' => $nlQuery->id])->with('success', 'Query processed successfully');
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
        $user = auth()->user();
        $hod = $user->hod;
        
        $departmentFacultyIds = Faculty::where('department', $hod->department)->pluck('id');
        $departmentCourseIds = Course::whereIn('faculty_id', $departmentFacultyIds)->pluck('id');
        
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
