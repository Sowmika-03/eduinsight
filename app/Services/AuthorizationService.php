<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthorizationService
{
    /**
     * Check if the authenticated user has a specific role.
     *
     * @param string $role
     * @return bool
     */
    public static function hasRole(string $role): bool
    {
        $user = Auth::user();
        return $user && $user->role->slug === $role;
    }

    /**
     * Check if the authenticated user has any of the specified roles.
     *
     * @param array $roles
     * @return bool
     */
    public static function hasAnyRole(array $roles): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }
        return in_array($user->role->slug, $roles);
    }

    /**
     * Check if the authenticated user is an admin.
     *
     * @return bool
     */
    public static function isAdmin(): bool
    {
        return self::hasRole('admin');
    }

    /**
     * Check if the authenticated user is faculty.
     *
     * @return bool
     */
    public static function isFaculty(): bool
    {
        return self::hasRole('faculty');
    }

    /**
     * Check if the authenticated user is a student.
     *
     * @return bool
     */
    public static function isStudent(): bool
    {
        return self::hasRole('student');
    }

    /**
     * Check if the authenticated user can perform an action on a model.
     *
     * @param string $action
     * @param Model|string $model
     * @return bool
     */
    public static function can(string $action, $model): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        if (is_string($model)) {
            return Gate::allows($action);
        }

        return Gate::allows($action, $model);
    }

    /**
     * Check if the authenticated user cannot perform an action on a model.
     *
     * @param string $action
     * @param Model|string $model
     * @return bool
     */
    public static function cannot(string $action, $model): bool
    {
        return !self::can($action, $model);
    }

    /**
     * Get the role slug of the authenticated user.
     *
     * @return string|null
     */
    public static function getUserRole(): ?string
    {
        $user = Auth::user();
        return $user?->role?->slug;
    }

    /**
     * Check if the authenticated user belongs to faculty with specific ID.
     *
     * @param int $facultyId
     * @return bool
     */
    public static function isFacultyOfId(int $facultyId): bool
    {
        $user = Auth::user();
        return $user && $user->role->slug === 'faculty' && $user->faculty?->id === $facultyId;
    }

    /**
     * Check if the authenticated user is a specific student.
     *
     * @param int $studentId
     * @return bool
     */
    public static function isStudentWithId(int $studentId): bool
    {
        $user = Auth::user();
        return $user && $user->role->slug === 'student' && $user->student?->id === $studentId;
    }
}
