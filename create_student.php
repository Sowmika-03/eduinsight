<?php

require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use App\Models\Student;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get student role
$studentRole = Role::where('slug', 'student')->first();

if (!$studentRole) {
    echo "❌ Student role not found\n";
    exit(1);
}

// Create user
$user = User::create([
    'name' => 'Test Student',
    'email' => 'bvsaiganesh9980@gmail.com',
    'password' => Hash::make('password'),
    'role_id' => $studentRole->id,
    'status' => 'active',
]);

echo "✅ User created: {$user->email}\n";

// Create student profile
$student = Student::create([
    'user_id' => $user->id,
    'student_id' => 'STU99999',
    'admission_year' => '2023',
    'semester' => '4',
    'program' => 'B.Tech CS',
    'batch' => '2023-2027',
    'parent_email' => 'parent@example.com', // Optional parent email
]);

echo "✅ Student profile created\n";
echo "\n📋 Login Credentials:\n";
echo "Email: bvsaiganesh9980@gmail.com\n";
echo "Password: password\n";
echo "Student ID: {$student->student_id}\n";
