<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $branch   = $request->get('branch');
        $semester = $request->get('semester');
        $risk     = $request->get('risk');

        $studentQuery = Student::query();

        if ($program) {
            $studentQuery->where('program', 'LIKE', "%{$program}%");
        }
        if ($branch && (!$program || $program === 'B.Tech')) {
            $studentQuery->whereIn('branch_id', function($q) use ($branch) {
                $q->select('id')->from('branches')->where('branch_name', 'LIKE', "%{$branch}%");
            });
        }
        if ($semester) {
            $studentQuery->where('semester', $semester);
        }
        if ($risk) {
            $studentQuery->whereHas('academicRisks', function($q) use ($risk) {
                $q->where('risk_level', $risk);
            });
        }

        $filteredStudentIds = $studentQuery->pluck('id');
        $totalStudents = $filteredStudentIds->count();

        // 1. Avg Attendance
        $avgAttendanceQuery = Attendance::query();
        if ($filteredStudentIds->isNotEmpty()) {
            $avgAttendanceQuery->whereIn('student_id', $filteredStudentIds);
        } elseif ($program || $branch || $semester || $risk) {
            $avgAttendanceQuery->whereRaw('1 = 0');
        }
        $avgAttendanceVal = $avgAttendanceQuery->selectRaw("AVG(CASE WHEN status = 'present' THEN 100.0 ELSE 0.0 END) as average")->value('average');
        $avgAttendance = $avgAttendanceVal !== null ? round($avgAttendanceVal, 1) : 0.0;

        // 2. Pass Rate
        $markQuery = Mark::query();
        if ($filteredStudentIds->isNotEmpty()) {
            $markQuery->whereIn('student_id', $filteredStudentIds);
        } elseif ($program || $branch || $semester || $risk) {
            $markQuery->whereRaw('1 = 0');
        }
        $totalMarksCount = (clone $markQuery)->count();
        $passedCount = (clone $markQuery)->where('total_marks', '>=', 40)->count();
        $passPercentage = $totalMarksCount > 0 ? round(($passedCount * 100.0) / $totalMarksCount, 1) : 0.0;

        // 3. Unique Student Risk Count Calculation
        $highRiskStudentIds = AcademicRisk::where('risk_level', 'High Risk');
        if ($filteredStudentIds->isNotEmpty()) {
            $highRiskStudentIds->whereIn('student_id', $filteredStudentIds);
        } elseif ($program || $branch || $semester || $risk) {
            $highRiskStudentIds->whereRaw('1 = 0');
        }
        $highRiskStudentIds = $highRiskStudentIds->distinct()->pluck('student_id')->toArray();

        $mediumRiskStudentIds = AcademicRisk::where('risk_level', 'Medium Risk')->whereNotIn('student_id', $highRiskStudentIds);
        if ($filteredStudentIds->isNotEmpty()) {
            $mediumRiskStudentIds->whereIn('student_id', $filteredStudentIds);
        } elseif ($program || $branch || $semester || $risk) {
            $mediumRiskStudentIds->whereRaw('1 = 0');
        }
        $mediumRiskStudentIds = $mediumRiskStudentIds->distinct()->pluck('student_id')->toArray();

        $lowRiskStudentIds = array_diff($filteredStudentIds->toArray(), array_merge($highRiskStudentIds, $mediumRiskStudentIds));

        $uniqueHighRiskCount   = count($highRiskStudentIds);
        $uniqueMediumRiskCount = count($mediumRiskStudentIds);
        $uniqueLowRiskCount    = count($lowRiskStudentIds);

        // 4. Active Alerts & Recent Alerts
        $alertQuery = \App\Models\Alert::with('student.user', 'course')->latest();
        if ($filteredStudentIds->isNotEmpty()) {
            $alertQuery->whereIn('student_id', $filteredStudentIds);
        } elseif ($program || $branch || $semester || $risk) {
            $alertQuery->whereRaw('1 = 0');
        }
        $totalAlertsCount = (clone $alertQuery)->count();
        $recentAlerts     = $alertQuery->take(10)->get();

        // 5. Program / Branch Performance Data for Chart 2
        $programNames = ['CSE', 'IT', 'MCA', 'MBA'];
        $branchAttData = [];
        $branchPassData = [];

        foreach ($programNames as $pName) {
            $pStudentQuery = Student::whereIn('branch_id', function($q) use ($pName) {
                $q->select('id')->from('branches')->where('branch_name', $pName);
            });
            if ($program)  $pStudentQuery->where('program', 'LIKE', "%{$program}%");
            if ($branch) {
                $pStudentQuery->whereIn('branch_id', function($q) use ($branch) {
                    $q->select('id')->from('branches')->where('branch_name', 'LIKE', "%{$branch}%");
                });
            }
            if ($semester) $pStudentQuery->where('semester', $semester);
            if ($risk) {
                $pStudentQuery->whereHas('academicRisks', fn($q) => $q->where('risk_level', $risk));
            }
            $pStudentIds = $pStudentQuery->pluck('id');

            if ($pStudentIds->isNotEmpty()) {
                $attAvg = Attendance::whereIn('student_id', $pStudentIds)->selectRaw("AVG(CASE WHEN status = 'present' THEN 100.0 ELSE 0.0 END) as average")->value('average') ?? 80;
                $pMarks = Mark::whereIn('student_id', $pStudentIds);
                $pTotal = (clone $pMarks)->count();
                $pPass  = (clone $pMarks)->where('total_marks', '>=', 40)->count();
                $passRate = $pTotal > 0 ? ($pPass * 100.0 / $pTotal) : 85;

                $branchAttData[] = round($attAvg, 1);
                $branchPassData[] = round($passRate, 1);
            } else {
                $branchAttData[] = 0;
                $branchPassData[] = 0;
            }
        }

        // Email Analytics Data
        $emailStats = $this->emailAnalyticsService->getEmailStats();
        $emailsByDate = $this->emailAnalyticsService->getEmailsByDate();
        $emailsByStatus = $this->emailAnalyticsService->getEmailsByStatus();

        return view('admin.dashboard', compact(
            'totalStudents',
            'avgAttendance',
            'passPercentage',
            'uniqueHighRiskCount',
            'uniqueMediumRiskCount',
            'uniqueLowRiskCount',
            'totalAlertsCount',
            'recentAlerts',
            'programNames',
            'branchAttData',
            'branchPassData',
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
        $program = $request->get('program');
        $branch = $request->get('branch');

        if ($program) {
            $query->where('program', 'LIKE', "%{$program}%");
        }
        if ($branch && (!$program || $program === 'B.Tech')) {
            $query->whereIn('branch_id', function($q) use ($branch) {
                $q->select('id')->from('branches')->where('branch_name', 'LIKE', "%{$branch}%");
            });
        }
        if ($semester = $request->get('semester')) {
            $query->where('semester', $semester);
        }
        if ($risk = $request->get('risk')) {
            $query->whereHas('academicRisks', function($q) use ($risk) {
                $q->where('risk_level', $risk);
            });
        }
        if ($attendance = $request->get('attendance')) {
            if ($attendance === '75_above') {
                $query->whereIn('id', function($q) {
                    $q->select('student_id')
                      ->from('attendance')
                      ->groupBy('student_id')
                      ->havingRaw("AVG(CASE WHEN status = 'present' THEN 100.0 ELSE 0.0 END) >= 75");
                });
            } elseif ($attendance === '75_below') {
                $query->whereIn('id', function($q) {
                    $q->select('student_id')
                      ->from('attendance')
                      ->groupBy('student_id')
                      ->havingRaw("AVG(CASE WHEN status = 'present' THEN 100.0 ELSE 0.0 END) < 75");
                });
            }
        }

        $students = $query->paginate(15)->withQueryString();
        return view('admin.students', compact('students'));
    }

    public function courses(Request $request)
    {
        $query = Course::with('faculty.user', 'enrollments');

        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('course_code', 'LIKE', "%{$search}%")
                  ->orWhere('course_name', 'LIKE', "%{$search}%");
            });
        }
        $program = $request->get('program');
        $branch = $request->get('branch');

        if ($program) {
            $query->where(function($q) use ($program) {
                if ($program === 'B.Tech') {
                    $q->where('course_code', 'LIKE', 'CSE%')
                      ->orWhere('course_code', 'LIKE', 'IT%')
                      ->orWhere('course_name', 'LIKE', '%B.Tech%');
                } else {
                    $q->where('course_code', 'LIKE', "%{$program}%")
                      ->orWhere('course_name', 'LIKE', "%{$program}%");
                }
            });
        }
        if ($branch && (!$program || $program === 'B.Tech')) {
            $query->where(function($q) use ($branch) {
                $q->where('course_code', 'LIKE', "%{$branch}%")
                  ->orWhere('course_name', 'LIKE', "%{$branch}%");
            });
        }
        if ($semester = $request->get('semester')) {
            $query->where('semester', $semester);
        }
        if ($facultyFilter = $request->get('faculty')) {
            if ($facultyFilter === 'assigned') {
                $query->whereNotNull('faculty_id');
            } elseif ($facultyFilter === 'unassigned') {
                $query->whereNull('faculty_id');
            }
        }

        $courses = $query->paginate(15)->withQueryString();
        return view('admin.courses', compact('courses'));
    }

    public function alerts(Request $request)
    {
        $query = \App\Models\Alert::with('student.user', 'course')->latest();

        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('message', 'LIKE', "%{$search}%")
                  ->orWhereHas('student.user', fn($u) => $u->where('name', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%"))
                  ->orWhereHas('student', fn($s) => $s->where('student_id', 'LIKE', "%{$search}%"));
            });
        }
        if ($severity = $request->get('severity')) {
            $query->where('severity', $severity);
        }
        $program = $request->get('program');
        $branch = $request->get('branch');

        if ($program) {
            $query->whereHas('student', fn($s) => $s->where('program', 'LIKE', "%{$program}%"));
        }
        if ($branch && (!$program || $program === 'B.Tech')) {
            $query->whereHas('student', fn($s) => $s->whereIn('branch_id', function($q) use ($branch) {
                $q->select('id')->from('branches')->where('branch_name', 'LIKE', "%{$branch}%");
            }));
        }
        if ($semester = $request->get('semester')) {
            $query->whereHas('student', fn($s) => $s->where('semester', $semester));
        }
        if ($status = $request->get('status')) {
            if ($status === 'active') {
                $query->where('is_resolved', false);
            } elseif ($status === 'resolved') {
                $query->where('is_resolved', true);
            }
        }

        $alerts = $query->paginate(20)->withQueryString();
        return view('admin.alerts', compact('alerts'));
    }
}
