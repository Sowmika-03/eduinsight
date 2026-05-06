<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Course::class => \App\Policies\CoursePolicy::class,
        \App\Models\Mark::class => \App\Policies\MarkPolicy::class,
        \App\Models\Attendance::class => \App\Policies\AttendancePolicy::class,
        \App\Models\EmailLog::class => \App\Policies\EmailLogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define role-based gates
        Gate::define('admin-only', function (User $user) {
            return $user->role->slug === 'admin';
        });

        Gate::define('faculty-only', function (User $user) {
            return $user->role->slug === 'faculty';
        });

        Gate::define('student-only', function (User $user) {
            return $user->role->slug === 'student';
        });

        // Composite gates for access control
        Gate::define('is-admin', function (User $user) {
            return $user->role->slug === 'admin';
        });

        Gate::define('is-faculty', function (User $user) {
            return $user->role->slug === 'faculty';
        });

        Gate::define('is-student', function (User $user) {
            return $user->role->slug === 'student';
        });

        // Feature-based gates
        Gate::define('manage-courses', function (User $user) {
            return in_array($user->role->slug, ['admin', 'faculty']);
        });

        Gate::define('manage-students', function (User $user) {
            return $user->role->slug === 'admin';
        });

        Gate::define('view-marks', function (User $user) {
            return in_array($user->role->slug, ['admin', 'faculty', 'student']);
        });

        Gate::define('record-attendance', function (User $user) {
            return $user->role->slug === 'faculty';
        });

        Gate::define('view-predictions', function (User $user) {
            return $user->role->slug === 'student';
        });
    }
}
