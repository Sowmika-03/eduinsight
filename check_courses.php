<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Course;
use App\Models\Enrollment;

echo "=== MCA COURSES ===\n";
$courses = Course::all();
foreach ($courses as $course) {
    echo "{$course->course_code} - {$course->course_name}\n";
    echo "  Faculty ID: {$course->faculty_id}, Semester: {$course->semester}\n";
}

echo "\n=== ENROLLMENTS ===\n";
$enrollments = Enrollment::join('students', 'enrollments.student_id', '=', 'students.id')
    ->join('courses', 'enrollments.course_id', '=', 'courses.id')
    ->join('users', 'students.user_id', '=', 'users.id')
    ->select('users.name', 'courses.course_code', 'courses.course_name')
    ->where('users.email', 'student@eduinsight.com')
    ->get();

echo "Student (student@eduinsight.com) enrolled in:\n";
foreach ($enrollments as $enrollment) {
    echo "- {$enrollment->course_code}: {$enrollment->course_name}\n";
}
echo "Total enrollments: " . $enrollments->count() . "\n";
