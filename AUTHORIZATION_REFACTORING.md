# Authorization Refactoring: Middleware to Gates and Policies

## Overview

This document describes the refactoring of the EduInsight authorization system from a role-based middleware approach to Laravel's modern **Gates and Policies** pattern.

## What Changed

### Before (Middleware-based)
```php
// Old approach using CheckRole middleware
Route::middleware(['role:admin'])->group(function () {
    // Protected routes
});

Route::middleware(['role:faculty'])->group(function () {
    // Protected routes
});
```

### After (Gates and Policies)
```php
// New approach using Gates and AuthServiceProvider
Route::middleware(['authRole:admin'])->group(function () {
    // Protected routes
});

// OR use authorization checks in controllers
$this->authorize('teach', $course);
$this->authorize('manageMarks', $course);
```

## New Files Created

### 1. **AuthServiceProvider** (`app/Providers/AuthServiceProvider.php`)
Central location for all authorization logic, including:
- **Role-based Gates**: `admin-only`, `faculty-only`, `student-only`
- **Feature-based Gates**: `manage-courses`, `manage-students`, `view-marks`, etc.
- **Policy Mappings**: Links models to their authorization policies

**Usage in Controllers:**
```php
// Check if user can perform action
if (Gate::allows('admin-only')) {
    // Handle admin-specific logic
}

// Or simply authorize
$this->authorize('admin-only');
```

### 2. **Policies** (in `app/Policies/`)

#### CoursePolicy (`app/Policies/CoursePolicy.php`)
Controls authorization for course-related operations:
- `view()` - User can view course
- `teach()` - Faculty can teach course
- `manageMarks()` - Faculty can manage marks
- `recordAttendance()` - Faculty can record attendance
- `update()` / `delete()` - Admin or course instructor

**Usage:**
```php
$this->authorize('teach', $course);
$this->authorize('manageMarks', $course);
```

#### MarkPolicy (`app/Policies/MarkPolicy.php`)
Controls authorization for marks operations:
- `view()` - User can view mark
- `create()` - Faculty or admin
- `update()` / `delete()` - Admin or course instructor

#### AttendancePolicy (`app/Policies/AttendancePolicy.php`)
Controls authorization for attendance operations:
- `view()` - User can view attendance
- `create()` / `update()` / `delete()` - Faculty or admin
- `record()` - Faculty can record attendance

### 3. **Middleware** (`app/Http/Middleware/AuthorizeByRole.php`)
Enhanced role-based middleware for route protection:
```php
Route::middleware(['authRole:admin,faculty'])->group(function () {
    // Only admin and faculty can access
});
```

### 4. **AuthorizationService** (`app/Services/AuthorizationService.php`)
Utility service for authorization checks throughout the application:

**Available Methods:**
```php
// Check single role
Authorization::hasRole('admin');
Authorization::isAdmin();
Authorization::isFaculty();
Authorization::isStudent();

// Check multiple roles
Authorization::hasAnyRole(['admin', 'faculty']);

// Check permissions
Authorization::can('teach', $course);
Authorization::cannot('delete', $mark);

// Get user info
Authorization::getUserRole();
Authorization::isFacultyOfId(5);
Authorization::isStudentWithId(10);
```

### 5. **Authorization Facade** (`app/Facades/Authorization.php`)
Convenient facade for using AuthorizationService in controllers and views:

**In Controllers:**
```php
use App\Facades\Authorization;

if (Authorization::isAdmin()) {
    // Admin-only logic
}
```

**In Views:**
```blade
@if(Authorization::isFaculty())
    <p>Faculty options</p>
@endif
```

## Updated Files

### 1. **bootstrap/app.php**
Registered new middleware alias:
```php
$middleware->alias([
    'role' => \App\Http\Middleware\CheckRole::class,
    'authRole' => \App\Http\Middleware\AuthorizeByRole::class,
]);
```

### 2. **routes/web.php**
Updated route middleware from `'role:admin'` to `'authRole:admin'`:
```php
// Admin Routes
Route::middleware(['authRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    // routes
});

// Faculty Routes
Route::middleware(['authRole:faculty'])->prefix('faculty')->name('faculty.')->group(function () {
    // routes
});
```

### 3. **FacultyDashboardController**
Added policy-based authorization:
```php
public function course($id)
{
    $course = Course::findOrFail($id);
    $this->authorize('teach', $course); // Uses CoursePolicy::teach()
    // ...
}

public function addMarks(Request $request)
{
    // ... validation ...
    $course = Course::findOrFail($validated['course_id']);
    $this->authorize('manageMarks', $course);
    // ...
}
```

### 4. **MlRiskPredictionController**
Added authorization to prevent unauthorized access:
```php
public function predictRisk($studentId, $courseId)
{
    $student = Student::findOrFail($studentId);
    $this->authorizeRiskPrediction($student, $courseId);
    // ...
}

private function authorizeRiskPrediction(Student $student, $courseId)
{
    // Authorization logic for admin, faculty, and students
}
```

### 5. **AppServiceProvider**
Registered AuthorizationService singleton:
```php
public function register(): void
{
    $this->app->singleton('authorization', function ($app) {
        return new \App\Services\AuthorizationService();
    });
}
```

## Migration Guide

### For Existing Code

#### 1. **Route Protection**
Old:
```php
Route::middleware(['role:admin'])->group(function () { });
```

New:
```php
Route::middleware(['authRole:admin'])->group(function () { });
```

#### 2. **Authorization Checks in Controllers**
Old:
```php
// No centralized way, checks were in middleware only
```

New - Option A (Using Policies):
```php
$this->authorize('teach', $course); // Calls CoursePolicy::teach()
```

New - Option B (Using Gates):
```php
Gate::authorize('manage-courses');
```

New - Option C (Using Service):
```php
if (!Authorization::isAdmin()) {
    abort(403);
}
```

#### 3. **Authorization Checks in Views**
Old:
```blade
{{-- No good way to check roles in views --}}
```

New:
```blade
@can('teach', $course)
    <button>Manage Course</button>
@endcan

@if(Authorization::isFaculty())
    <p>Faculty dashboard</p>
@endif
```

## Authorization Decision Tree

### For Adding New Authorization Rules

1. **Route-level authorization?** → Use `authRole:role_name` middleware
2. **Model-specific operations?** → Create Policy class and use `$this->authorize('action', $model)`
3. **Feature/role checks?** → Define Gate in AuthServiceProvider
4. **Reusable checks across app?** → Add method to AuthorizationService
5. **View-level checks?** → Use `@can` directive or `Authorization::method()`

## Best Practices

### ✅ DO

- Use Policies for model-related authorization
- Use Gates for application-wide authorization
- Define authorization rules in AuthServiceProvider
- Check authorization early in controllers
- Use `$this->authorize()` in controller methods
- Create specific gates for features, not just roles

### ❌ DON'T

- Check authorization logic inline in controllers
- Duplicate authorization rules across files
- Use plain role checks instead of gates
- Skip authorization checks in controllers handling user input
- Mix old middleware and new gates in the same route

## Testing Authorization

```php
// Test that user can perform action
$this->actingAs($user)
    ->post('/admin/dashboard')
    ->assertStatus(200);

// Test that user cannot perform action
$this->actingAs($student)
    ->post('/admin/dashboard')
    ->assertStatus(403);

// Test policy directly
$this->assertTrue($user->can('teach', $course));
$this->assertFalse($student->can('manageMarks', $course));
```

## Troubleshooting

### Authorization Failing on Valid User
1. Check if User has valid `role` relationship
2. Verify role `slug` matches policy checks
3. Check if faculty/student relationships are properly loaded

### Middleware Not Working
1. Verify middleware is registered in `bootstrap/app.php`
2. Check middleware class path is correct
3. Ensure route uses correct middleware alias

### Policy Not Called
1. Register policy in AuthServiceProvider's `$policies` array
2. Use correct model class name in policy mapping
3. Verify model is being passed to `$this->authorize()`

## Future Improvements

1. Add permission-based system (beyond roles)
2. Implement resource-level access policies
3. Add audit logging for authorization checks
4. Create admin dashboard for managing permissions
5. Add role hierarchy (e.g., admin > faculty > student)

## References

- [Laravel Authorization Docs](https://laravel.com/docs/authorization)
- [Laravel Policies](https://laravel.com/docs/authorization#creating-policies)
- [Laravel Gates](https://laravel.com/docs/authorization#gates)
