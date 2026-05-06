<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * Determine if the user can view any course.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view course lists
    }

    /**
     * Determine if the user can view the course.
     */
    public function view(User $user, Course $course): bool
    {
        return $user->role->slug === 'admin' || 
               ($user->role->slug === 'faculty' && $user->faculty?->id === $course->faculty_id) ||
               ($user->role->slug === 'student' && $user->student?->courses()->where('course_id', $course->id)->exists());
    }

    /**
     * Determine if the user can create courses.
     */
    public function create(User $user): bool
    {
        return $user->role->slug === 'admin';
    }

    /**
     * Determine if the user can update the course.
     */
    public function update(User $user, Course $course): bool
    {
        return $user->role->slug === 'admin' ||
               ($user->role->slug === 'faculty' && $user->faculty?->id === $course->faculty_id);
    }

    /**
     * Determine if the user can delete the course.
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->role->slug === 'admin' ||
               ($user->role->slug === 'faculty' && $user->faculty?->id === $course->faculty_id);
    }

    /**
     * Determine if the user can teach the course.
     */
    public function teach(User $user, Course $course): bool
    {
        return $user->role->slug === 'faculty' && $user->faculty?->id === $course->faculty_id;
    }

    /**
     * Determine if the user can manage marks for this course.
     */
    public function manageMarks(User $user, Course $course): bool
    {
        return $user->role->slug === 'faculty' && $user->faculty?->id === $course->faculty_id;
    }

    /**
     * Determine if the user can record attendance for this course.
     */
    public function recordAttendance(User $user, Course $course): bool
    {
        return $user->role->slug === 'faculty' && $user->faculty?->id === $course->faculty_id;
    }
}
