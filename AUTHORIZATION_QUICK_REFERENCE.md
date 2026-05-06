# Authorization Quick Reference

## Common Patterns

### Protecting Routes

```php
// Admin only
Route::middleware(['authRole:admin'])->group(function () { });

// Faculty or Admin
Route::middleware(['authRole:faculty,admin'])->group(function () { });

// Student only
Route::middleware(['authRole:student'])->group(function () { });
```

### Authorization in Controllers

```php
// Check policy
$this->authorize('teach', $course);
$this->authorize('manageMarks', $course);
$this->authorize('delete', $mark);

// Check gate
Gate::authorize('admin-only');
Gate::authorize('manage-courses');

// Check using service
if (!Authorization::isAdmin()) {
    abort(403);
}

if (Authorization::cannot('teach', $course)) {
    abort(403);
}
```

### Authorization in Views

```blade
{{-- Using policies --}}
@can('teach', $course)
    <button>Manage Course</button>
@endcan

@cannot('delete', $mark)
    <p>Cannot delete this mark</p>
@endcannot

{{-- Using gates --}}
@can('admin-only')
    <div>Admin panel</div>
@endcan

{{-- Using service --}}
@if(Authorization::isAdmin())
    <p>Admin view</p>
@endif

@if(Authorization::can('teach', $course))
    <button>Edit Course</button>
@endif
```

### Adding User Data to Checks

```php
// In your views/templates
<p>Current role: {{ Authorization::getUserRole() }}</p>

@if(Authorization::isStudent())
    Student dashboard
@elseif(Authorization::isFaculty())
    Faculty dashboard
@elseif(Authorization::isAdmin())
    Admin dashboard
@endif
```

## When to Use What

| Scenario | Solution |
|----------|----------|
| Protect entire route group | `authRole` middleware |
| Check model operation | `$this->authorize()` with Policy |
| Check feature access | `Gate::authorize()` |
| Conditional view content | `@can` Blade directive |
| Reusable helper checks | `Authorization::method()` |
| View-only role checks | `Authorization::hasRole()` |

## Creating New Policies

```php
// Create policy
php artisan make:policy CoursePolicyPolicy --model=Course

// Edit app/Policies/CoursePolicy.php
public function myAction(User $user, Course $course): bool
{
    return $user->role->slug === 'faculty' && $user->faculty?->id === $course->faculty_id;
}

// Register in AuthServiceProvider
protected $policies = [
    Course::class => CoursePolicy::class,
];

// Use in controller
$this->authorize('myAction', $course);
```

## Creating New Gates

```php
// In AuthServiceProvider::boot()
Gate::define('my-feature', function (User $user) {
    return $user->role->slug === 'admin';
});

// Use in code
if (Gate::allows('my-feature')) {
    // do something
}

$this->authorize('my-feature');

// Use in views
@can('my-feature')
    <p>Feature visible</p>
@endcan
```

## Common Authorization Patterns

### Check if Faculty Teaches Course

```php
// In policy or gate
$user->faculty?->courses()->where('id', $course->id)->exists()

// Using authorization service
Authorization::isFacultyOfId($course->faculty_id)
```

### Check if Student Enrolled in Course

```php
// In policy
$user->student?->courses()->where('id', $course->id)->exists()

// Using authorization service
Authorization::isStudentWithId($student->id)
```

### Admin Can Do Anything

```php
if ($user->role->slug === 'admin') {
    return true;
}
```

## Error Handling

```php
// This will abort with 403 Forbidden
$this->authorize('teach', $course);

// Check before authorizing
if (!Gate::allows('admin-only')) {
    abort(403, 'Must be admin');
}

// Try-catch approach
try {
    $this->authorize('delete', $mark);
} catch (\Illuminate\Auth\Access\AuthorizationException $e) {
    return redirect('dashboard')->with('error', 'Unauthorized');
}
```

## Testing Authorization

```php
// In tests
$faculty = User::factory()->create(['role_id' => $facultyRole->id]);

// Test policy
$this->assertTrue($faculty->can('teach', $course));
$this->assertFalse($student->can('teach', $course));

// Test gate
$this->assertTrue(Gate::forUser($faculty)->allows('manage-courses'));
$this->assertFalse(Gate::forUser($student)->allows('admin-only'));

// Test route
$this->actingAs($faculty)->post('/faculty/marks')->assertStatus(200);
$this->actingAs($student)->post('/faculty/marks')->assertStatus(403);
```

## Debugging

```php
// Check current user role
dd(Auth::user()->role->slug);

// List available gates
dd(Gate::policies());

// Check if gate allows
dd(Gate::forUser(Auth::user())->allows('admin-only'));

// Check policy
dd(Auth::user()->can('teach', $course));

// Check using service
dd(Authorization::getUserRole());
dd(Authorization::hasRole('admin'));
```
