<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== ALL COURSES ===\n";
$all_courses = DB::table('courses')->get();
foreach ($all_courses as $course) {
    echo "{$course->course_code} - {$course->course_name} (Faculty ID: {$course->faculty_id}, Semester: {$course->semester})\n";
}
echo "Total courses: " . count($all_courses) . "\n";

echo "\n=== ALL FACULTY ===\n";
$faculty = DB::table('faculty')
    ->join('users', 'faculty.user_id', '=', 'users.id')
    ->select('faculty.id', 'faculty.user_id', 'faculty.department', 'users.name', 'users.email')
    ->get();
foreach ($faculty as $f) {
    echo "{$f->name} ({$f->email}) - Department: {$f->department}\n";
}

echo "\n=== HOD INFO ===\n";
$hods = DB::table('hods')
    ->join('users', 'hods.user_id', '=', 'users.id')
    ->select('hods.id', 'hods.user_id', 'hods.department', 'users.name', 'users.email')
    ->get();
foreach ($hods as $h) {
    echo "{$h->name} ({$h->email}) - Department: {$h->department}\n";
}

echo "\n=== STUDENT ENROLLMENTS (student@eduinsight.com) ===\n";
$student_enrollments = DB::table('enrollments')
    ->join('students', 'enrollments.student_id', '=', 'students.id')
    ->join('users', 'students.user_id', '=', 'users.id')
    ->join('courses', 'enrollments.course_id', '=', 'courses.id')
    ->select('users.name', 'courses.course_code', 'courses.course_name')
    ->where('users.email', 'student@eduinsight.com')
    ->get();
echo "Enrollments: " . count($student_enrollments) . "\n";
foreach ($student_enrollments as $e) {
    echo "- {$e->course_code}: {$e->course_name}\n";
}
