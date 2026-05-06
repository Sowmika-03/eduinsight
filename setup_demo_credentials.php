<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\HOD;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Demo Credentials Setup ===\n\n";

// 1. Ensure Faculty User exists with correct email
echo "1. Setting up Faculty user (john.smith@eduinsight.com)...\n";
$facultyUser = User::updateOrCreate(
    ['email' => 'john.smith@eduinsight.com'],
    [
        'name' => 'Dr. John Smith',
        'email' => 'john.smith@eduinsight.com',
        'password' => Hash::make('password'),
        'role_id' => Role::where('slug', 'faculty')->first()->id ?? 3,
    ]
);
echo "✓ Faculty user ready: john.smith@eduinsight.com\n\n";

// 2. Ensure HOD User exists
echo "2. Setting up HOD user (michael.chen@eduinsight.com)...\n";
$hodUser = User::updateOrCreate(
    ['email' => 'michael.chen@eduinsight.com'],
    [
        'name' => 'Prof. Michael Chen',
        'email' => 'michael.chen@eduinsight.com',
        'password' => Hash::make('password'),
        'role_id' => Role::where('slug', 'hod')->first()->id ?? 4,
    ]
);

// Create HOD record if it doesn't exist
if (!HOD::where('user_id', $hodUser->id)->exists()) {
    HOD::create([
        'user_id' => $hodUser->id,
        'department' => 'Computer Science',
        'joining_date' => now(),
    ]);
}
echo "✓ HOD user ready: michael.chen@eduinsight.com\n\n";

// 3. Ensure Student User exists with dummy data
echo "3. Setting up Student user (student@eduinsight.com)...\n";
$studentUser = User::updateOrCreate(
    ['email' => 'student@eduinsight.com'],
    [
        'name' => 'Saiganesh',
        'email' => 'student@eduinsight.com',
        'password' => Hash::make('password'),
        'role_id' => Role::where('slug', 'student')->first()->id ?? 5,
    ]
);

// Create Student record if it doesn't exist
$student = Student::updateOrCreate(
    ['user_id' => $studentUser->id],
    [
        'user_id' => $studentUser->id,
        'registration' => 'BT2024001',
        'program' => 'B.Tech CS',
        'semester' => 2,
        'parent_email' => 'parent@example.com',
    ]
);

// Enroll student in courses
$courses = Course::take(3)->get();
foreach ($courses as $course) {
    Enrollment::updateOrCreate(
        ['student_id' => $student->id, 'course_id' => $course->id],
        ['enrollment_date' => now()]
    );
}

echo "✓ Student user ready: student@eduinsight.com\n";
echo "✓ Student enrolled in " . $student->enrollments->count() . " courses\n\n";

echo "=== Demo Credentials Setup Complete ===\n";
echo "\nYou can now login with:\n";
echo "Admin:  admin@eduinsight.com / password\n";
echo "Faculty: john.smith@eduinsight.com / password\n";
echo "HOD:    michael.chen@eduinsight.com / password\n";
echo "Student: student@eduinsight.com / password\n";
