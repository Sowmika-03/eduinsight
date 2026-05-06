<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
{
    /**
     * Determine if the user can view any attendance records.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view attendance lists
    }

    /**
     * Determine if the user can view the attendance record.
     */
    public function view(User $user, Attendance $attendance): bool
    {
        return $user->role->slug === 'admin' ||
               ($user->role->slug === 'faculty' && $user->faculty?->courses()->where('course_id', $attendance->course_id)->exists()) ||
               ($user->role->slug === 'student' && $user->student?->id === $attendance->student_id);
    }

    /**
     * Determine if the user can create attendance records.
     */
    public function create(User $user): bool
    {
        return $user->role->slug === 'faculty' || $user->role->slug === 'admin';
    }

    /**
     * Determine if the user can update attendance records.
     */
    public function update(User $user, Attendance $attendance): bool
    {
        return $user->role->slug === 'admin' ||
               ($user->role->slug === 'faculty' && $user->faculty?->courses()->where('course_id', $attendance->course_id)->exists());
    }

    /**
     * Determine if the user can delete attendance records.
     */
    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->role->slug === 'admin' ||
               ($user->role->slug === 'faculty' && $user->faculty?->courses()->where('course_id', $attendance->course_id)->exists());
    }

    /**
     * Determine if the user can record attendance for a course.
     */
    public function record(User $user): bool
    {
        return $user->role->slug === 'faculty' || $user->role->slug === 'admin';
    }
}
