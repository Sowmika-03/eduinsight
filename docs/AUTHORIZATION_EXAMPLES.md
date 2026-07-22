# Authorization Implementation Examples

## Example 1: Adding Authorization to Student Dashboard

### Step 1: Add Policy Method
```php
// app/Policies/StudentPolicy.php
namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    public function view(User $user, Student $student): bool
    {
        // Admin can view any student
        if ($user->role->slug === 'admin') {
            return true;
        }
        
        // Faculty can view their students
        if ($user->role->slug === 'faculty') {
            return $user->faculty
                ->courses()
                ->whereHas('enrollments', fn($q) => $q->where('student_id', $student->id))
                ->exists();
        }
        
        // Students can view their own profile
        return $user->role->slug === 'student' && $user->student?->id === $student->id;
    }
}
```

### Step 2: Register Policy
```php
// app/Providers/AuthServiceProvider.php
protected $policies = [
    \App\Models\Student::class => \App\Policies\StudentPolicy::class,
];
```

### Step 3: Use in Controller
```php
// app/Http/Controllers/StudentDashboardController.php
public function show($id)
{
    $student = Student::findOrFail($id);
    $this->authorize('view', $student);
    
    return view('student.show', compact('student'));
}
```

### Step 4: Use in View
```blade
{{-- resources/views/student/show.blade.php --}}
@can('view', $student)
    <div class="student-profile">
        <p>Name: {{ $student->user->name }}</p>
    </div>
@else
    <p>You cannot view this student's profile</p>
@endcan
```

## Example 2: Creating a New Role

### Step 1: Create Role in Database
```php
// database/seeders/RoleSeeder.php
public function run(): void
{
    Role::create([
        'name' => 'Department Chair',
        'slug' => 'department_chair',
        'description' => 'Department Chair',
    ]);
}
```

### Step 2: Add Gates
```php
// app/Providers/AuthServiceProvider.php
Gate::define('manage-department', function (User $user) {
    return $user->role->slug === 'department_chair';
});

Gate::define('is-department-chair', function (User $user) {
    return $user->role->slug === 'department_chair';
});
```

### Step 3: Add Routes
```php
// routes/web.php
Route::middleware(['authRole:department_chair'])->prefix('chair')->name('chair.')->group(function () {
    Route::get('/dashboard', [ChairDashboardController::class, 'index'])->name('dashboard');
    Route::get('/faculty', [ChairDashboardController::class, 'faculty'])->name('faculty');
    Route::post('/approve-course', [ChairDashboardController::class, 'approveCourse'])->name('approve-course');
});
```

### Step 4: Add AuthorizationService Helper
```php
// app/Services/AuthorizationService.php
public static function isDepartmentChair(): bool
{
    return self::hasRole('department_chair');
}
```

## Example 3: Permission-Based Authorization

### Step 1: Create Permission Model
```php
// app/Models/Permission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'slug'];
    
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
```

### Step 2: Add Permission Gates
```php
// app/Providers/AuthServiceProvider.php
Gate::define('has-permission', function (User $user, $permission) {
    return $user->role
        ->permissions()
        ->where('slug', $permission)
        ->exists();
});
```

### Step 3: Create Migration
```php
// database/migrations/2024_xx_xx_create_permission_role_table.php
Schema::create('permission_role', function (Blueprint $table) {
    $table->id();
    $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
    $table->foreignId('role_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```

### Step 4: Use in Controllers
```php
// app/Http/Controllers/CourseController.php
public function deleteMarks(Mark $mark)
{
    if (!Gate::forUser(Auth::user())->allows('has-permission', 'delete-marks')) {
        abort(403);
    }
    
    $mark->delete();
}
```

## Example 4: Resource-Level Authorization

### Step 1: Create Department Policy
```php
// app/Policies/DepartmentPolicy.php
namespace App\Policies;

use App\Models\Department;
use App\Models\User;

class DepartmentPolicy
{
    public function manage(User $user, Department $department): bool
    {
        return $user->role->slug === 'admin' || 
               ($user->role->slug === 'department_chair' && 
                $user->departmentChair?->department_id === $department->id);
    }
}
```

### Step 2: Use in Routes
```php
// routes/web.php
Route::middleware(['authRole:admin,department_chair'])->group(function () {
    Route::get('/department/{department}', [DepartmentController::class, 'show'])->name('show');
    Route::put('/department/{department}', [DepartmentController::class, 'update'])->name('update');
});
```

### Step 3: Authorize in Controller
```php
// app/Http/Controllers/DepartmentController.php
public function update(Request $request, Department $department)
{
    $this->authorize('manage', $department);
    
    $department->update($request->validated());
    return redirect()->back();
}
```

## Example 5: Audit Trail with Authorization

### Step 1: Create Audit Model
```php
// app/Models/AuditLog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'changes',
    ];
}
```

### Step 2: Create Authorization Event
```php
// app/Events/AuthorizationCheck.php
namespace App\Events;

class AuthorizationCheck
{
    public function __construct(
        public $user,
        public $action,
        public $model,
        public $allowed
    ) {}
}
```

### Step 3: Log Authorization Checks
```php
// app/Providers/AuthServiceProvider.php
Gate::after(function (User $user, $ability, $result, ...$arguments) {
    AuditLog::create([
        'user_id' => $user->id,
        'action' => $ability,
        'result' => $result ? 'allowed' : 'denied',
        'model_type' => isset($arguments[0]) ? get_class($arguments[0]) : null,
    ]);
});
```

## Example 6: Conditional Authorization Based on Status

### Step 1: Create Status Check
```php
// app/Policies/CoursePolicy.php
public function editMarks(User $user, Course $course): bool
{
    // Faculty can only edit marks if course is active
    if ($course->status !== 'active') {
        return false;
    }
    
    return $user->role->slug === 'faculty' && 
           $user->faculty?->id === $course->faculty_id;
}
```

### Step 2: Use in Controller
```php
// app/Http/Controllers/FacultyDashboardController.php
public function editMarks(Request $request, Mark $mark)
{
    $this->authorize('editMarks', $mark->course);
    
    // Update marks
}
```

### Step 3: Display Conditional UI
```blade
{{-- Show edit button only if authorized and course is active --}}
@if($course->status === 'active' && Auth::user()->can('editMarks', $course))
    <button class="btn-edit">Edit Marks</button>
@else
    <p class="text-muted">Cannot edit marks for this course</p>
@endif
```

## Testing Authorization Examples

### Unit Test
```php
// tests/Unit/Policies/CoursePolicyTest.php
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Role;

class CoursePolicyTest extends TestCase
{
    public function test_faculty_can_teach_their_course()
    {
        $faculty = User::factory()->for(Role::where('slug', 'faculty')->first(), 'role')->create();
        $course = Course::factory()->create(['faculty_id' => $faculty->faculty->id]);
        
        $this->assertTrue($faculty->can('teach', $course));
    }
    
    public function test_faculty_cannot_teach_others_course()
    {
        $faculty1 = User::factory()->for(Role::where('slug', 'faculty')->first(), 'role')->create();
        $faculty2 = User::factory()->for(Role::where('slug', 'faculty')->first(), 'role')->create();
        $course = Course::factory()->create(['faculty_id' => $faculty1->faculty->id]);
        
        $this->assertFalse($faculty2->can('teach', $course));
    }
}
```

### Feature Test
```php
// tests/Feature/CoursePolicyTest.php
public function test_faculty_can_access_their_course()
{
    $faculty = User::factory()->for(Role::where('slug', 'faculty')->first(), 'role')->create();
    $course = Course::factory()->create(['faculty_id' => $faculty->faculty->id]);
    
    $this->actingAs($faculty)
        ->get("/faculty/course/{$course->id}")
        ->assertStatus(200);
}

public function test_student_cannot_access_faculty_course()
{
    $student = User::factory()->for(Role::where('slug', 'student')->first(), 'role')->create();
    $course = Course::factory()->create();
    
    $this->actingAs($student)
        ->get("/faculty/course/{$course->id}")
        ->assertStatus(403);
}
```
