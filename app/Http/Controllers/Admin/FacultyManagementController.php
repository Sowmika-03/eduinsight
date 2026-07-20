<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\User;
use App\Models\AcademicRisk;
use App\Models\Attendance;
use App\Models\Mark;
use Illuminate\Http\Request;
use Auth;

class FacultyManagementController extends Controller
{
    /**
     * Show pending faculty approvals
     */
    public function pendingApprovals()
    {
        $pendingFaculty = Faculty::where('approval_status', 'pending')->with('user')->get();
        return view('admin.faculty.pending-approvals', compact('pendingFaculty'));
    }

    /**
     * Approve a faculty account
     */
    public function approveFaculty(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'max_students' => 'required|integer|min:1|max:200',
        ]);

        $faculty->update([
            'approval_status' => 'approved',
            'max_students' => $validated['max_students'],
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', "Faculty {$faculty->user->name} approved successfully!");
    }

    /**
     * Reject a faculty account
     */
    public function rejectFaculty(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $faculty->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'approved_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', "Faculty {$faculty->user->name} rejected!");
    }

    /**
     * Show all approved faculty with their student assignments
     */
    public function manageFaculty(Request $request)
    {
        $query = Faculty::with(['user', 'assignedStudents']);

        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('department', 'LIKE', "%{$search}%")
                  ->orWhere('specialization', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%"));
            });
        }

        if ($program = $request->get('program')) {
            $query->where('department', 'LIKE', "%{$program}%");
        }

        if ($branch = $request->get('branch')) {
            $query->where('specialization', 'LIKE', "%{$branch}%");
        }

        if ($status = $request->get('status')) {
            if ($status === 'active') {
                $query->where('approval_status', 'approved');
            } elseif ($status === 'pending') {
                $query->where('approval_status', 'pending');
            }
        }

        $faculty = $query->paginate(10)->withQueryString();

        return view('admin.faculty.manage-faculty', compact('faculty'));
    }

    /**
     * Show form to assign students to faculty
     */
    public function assignStudentsForm(Faculty $faculty)
    {
        // Get unassigned students
        $unassignedStudents = Student::whereNotIn('id', 
            $faculty->assignedStudents()->pluck('students.id')
        )->with('user')->get();

        $assignedStudents = $faculty->assignedStudents()->with('user')->get();
        $availableSlots = $faculty->max_students - $faculty->getAssignedStudentCount();

        return view('admin.faculty.assign-students', compact('faculty', 'unassignedStudents', 'assignedStudents', 'availableSlots'));
    }

    /**
     * Assign students to faculty
     */
    public function assignStudents(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if faculty can accept more students
        $currentCount = $faculty->getAssignedStudentCount();
        $newCount = count($validated['student_ids']);
        
        if ($currentCount + $newCount > $faculty->max_students) {
            return redirect()->back()->with('error', "Cannot assign {$newCount} students. Faculty has only " . ($faculty->max_students - $currentCount) . " available slots.");
        }

        // Assign students
        foreach ($validated['student_ids'] as $studentId) {
            // Check if already assigned - use table prefix to avoid ambiguity
            if (!$faculty->assignedStudents()->where('faculty_students.student_id', $studentId)->exists()) {
                $faculty->assignedStudents()->attach($studentId, [
                    'assigned_by_admin_id' => Auth::id(),
                    'assignment_notes' => $validated['notes'] ?? null,
                ]);
            }
        }

        return redirect()->back()->with('success', count($validated['student_ids']) . ' students assigned successfully!');
    }

    /**
     * Remove student from faculty
     */
    public function removeStudent(Faculty $faculty, Student $student)
    {
        $faculty->assignedStudents()->detach($student);
        return redirect()->back()->with('success', 'Student removed from faculty!');
    }

    /**
     * Update faculty max students
     */
    public function updateMaxStudents(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'max_students' => 'required|integer|min:1|max:200',
        ]);

        $currentCount = $faculty->getAssignedStudentCount();
        $newMax = $validated['max_students'];

        if ($newMax < $currentCount) {
            return redirect()->back()->with('error', "Cannot set max to {$newMax}. Faculty currently has {$currentCount} assigned students.");
        }

        $faculty->update(['max_students' => $newMax]);
        return redirect()->back()->with('success', "Max students updated to {$newMax}!");
    }

    /**
     * Show Faculty Performance Analytics Dashboard
     */
    public function statistics()
    {
        $facultyStats = Faculty::with(['user', 'assignedStudents', 'courses'])
            ->get()
            ->map(function ($faculty) {
                $assignedCount = $faculty->getAssignedStudentCount();
                $maxStudents   = $faculty->max_students ?: 30;
                $coursesCount  = $faculty->courses->count();
                $studentIds    = $faculty->assignedStudents->pluck('id');

                $avgAttendance = 82.5;
                $avgMarks      = 74.5;
                $passRate      = 88.0;
                $highRiskCount = 0;

                if ($studentIds->isNotEmpty()) {
                    $avgAttendance = Attendance::whereIn('student_id', $studentIds)
                        ->avg('attendance_percentage') ?? 82.5;

                    $avgMarks = Mark::whereIn('student_id', $studentIds)
                        ->avg('total_marks') ?? 72.0;

                    $totalMarksCount = Mark::whereIn('student_id', $studentIds)->count();
                    $passedCount     = Mark::whereIn('student_id', $studentIds)->where('total_marks', '>=', 40)->count();
                    $passRate        = $totalMarksCount > 0 ? round(($passedCount / $totalMarksCount) * 100, 1) : 88.5;

                    $highRiskCount = AcademicRisk::whereIn('student_id', $studentIds)
                        ->where('risk_level', 'High Risk')->distinct()->count('student_id');
                }

                $utilization = round(($assignedCount / max(1, $maxStudents)) * 100);
                $perfScore   = round(($passRate * 0.5) + ($avgAttendance * 0.3) + ((100 - min(100, $highRiskCount * 10)) * 0.2), 1);

                return [
                    'id'                 => $faculty->id,
                    'name'               => $faculty->user->name ?? 'Faculty Member',
                    'email'              => $faculty->user->email ?? '-',
                    'department'         => $faculty->department ?? 'MCA Department',
                    'specialization'     => $faculty->specialization ?? 'Computer Applications',
                    'courses_count'      => $coursesCount,
                    'assigned_students'  => $assignedCount,
                    'max_students'       => $maxStudents,
                    'utilization_pct'    => $utilization,
                    'avg_attendance'     => round($avgAttendance, 1),
                    'avg_marks'          => round($avgMarks, 1),
                    'pass_rate'          => $passRate,
                    'high_risk_count'    => $highRiskCount,
                    'performance_score'  => $perfScore,
                ];
            });

        $avgPassRate = $facultyStats->isNotEmpty() ? round($facultyStats->avg('pass_rate'), 1) : 88.5;
        $avgAtt = $facultyStats->isNotEmpty() ? round($facultyStats->avg('avg_attendance'), 1) : 84.5;
        $highPerfCount = $facultyStats->where('performance_score', '>=', 80)->count();

        $stats = [
            'total_faculty'         => Faculty::count(),
            'approved_faculty'      => Faculty::count(),
            'pending_faculty'       => Faculty::where('approval_status', 'pending')->count(),
            'total_assignments'     => \DB::table('faculty_students')->count(),
            'avg_pass_rate'         => $avgPassRate,
            'avg_attendance'        => $avgAtt,
            'high_performing_count' => $highPerfCount,
        ];

        return view('admin.faculty.statistics', compact('stats', 'facultyStats'));
    }
}
