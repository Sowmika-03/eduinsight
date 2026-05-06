<?php

namespace App\Policies;

use App\Models\Mark;
use App\Models\User;

class MarkPolicy
{
    /**
     * Determine if the user can view any marks.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view marks lists
    }

    /**
     * Determine if the user can view the mark.
     */
    public function view(User $user, Mark $mark): bool
    {
        return $user->role->slug === 'admin' ||
               ($user->role->slug === 'faculty' && $user->faculty?->courses()->where('course_id', $mark->course_id)->exists()) ||
               ($user->role->slug === 'student' && $user->student?->id === $mark->student_id);
    }

    /**
     * Determine if the user can create marks.
     */
    public function create(User $user): bool
    {
        return $user->role->slug === 'faculty' || $user->role->slug === 'admin';
    }

    /**
     * Determine if the user can update the mark.
     */
    public function update(User $user, Mark $mark): bool
    {
        return $user->role->slug === 'admin' ||
               ($user->role->slug === 'faculty' && $user->faculty?->courses()->where('course_id', $mark->course_id)->exists());
    }

    /**
     * Determine if the user can delete the mark.
     */
    public function delete(User $user, Mark $mark): bool
    {
        return $user->role->slug === 'admin' ||
               ($user->role->slug === 'faculty' && $user->faculty?->courses()->where('course_id', $mark->course_id)->exists());
    }
}
