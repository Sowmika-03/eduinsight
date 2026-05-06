<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\User;
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
    public function manageFaculty()
    {
        $faculty = Faculty::where('approval_status', 'approved')
            ->with(['user', 'assignedStudents'])
            ->paginate(10);

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
     * Show faculty statistics
     */
    public function statistics()
    {
        $stats = [
            'total_faculty' => Faculty::count(),
            'approved_faculty' => Faculty::where('approval_status', 'approved')->count(),
            'pending_faculty' => Faculty::where('approval_status', 'pending')->count(),
            'rejected_faculty' => Faculty::where('approval_status', 'rejected')->count(),
            'total_assignments' => \DB::table('faculty_students')->count(),
        ];

        $facultyStats = Faculty::where('approval_status', 'approved')
            ->with('assignedStudents')
            ->get()
            ->map(function ($faculty) {
                return [
                    'name' => $faculty->user->name,
                    'assigned_students' => $faculty->getAssignedStudentCount(),
                    'max_students' => $faculty->max_students,
                    'available_slots' => $faculty->max_students - $faculty->getAssignedStudentCount(),
                ];
            });

        return view('admin.faculty.statistics', compact('stats', 'facultyStats'));
    }
}
