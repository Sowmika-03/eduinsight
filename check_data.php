<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;
use App\Models\AcademicRisk;
use App\Models\Alert;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Mark;
use App\Models\Attendance;

// Check Students
$studentCount = Student::count();
echo "Total Students: $studentCount\n";

// Check Academic Risks
$riskCount = AcademicRisk::count();
echo "Total Academic Risks: $riskCount\n";

if ($riskCount > 0) {
    $risks = AcademicRisk::selectRaw('risk_level, COUNT(*) as count')->groupBy('risk_level')->get();
    echo "Risk Distribution:\n";
    foreach ($risks as $r) {
        echo "  {$r->risk_level}: {$r->count}\n";
    }
}

// Check Programs
$programs = Student::selectRaw('program, COUNT(*) as total')->groupBy('program')->get();
echo "\nProgram Distribution:\n";
foreach ($programs as $p) {
    echo "  {$p->program}: {$p->total}\n";
}

// Check if we need to seed data
if ($studentCount < 5) {
    echo "\nSeeding sample data...\n";
    
    // Get or create courses
    $courses = Course::all();
    if ($courses->isEmpty()) {
        Course::create([
            'course_name' => 'Data Structures',
            'course_code' => 'CS201',
            'faculty_id' => 1
        ]);
        Course::create([
            'course_name' => 'Database Management',
            'course_code' => 'CS202',
            'faculty_id' => 1
        ]);
        $courses = Course::all();
    }
    
    // Create sample students with risks
    for ($i = 1; $i <= 5; $i++) {
        $student = Student::firstOrCreate(
            ['user_id' => null],
            [
                'registration' => 'TEST' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'program' => $i % 2 === 0 ? 'B.Tech CS' : 'B.Tech IT',
                'semester' => rand(1, 4)
            ]
        );
        
        // Create academic risks
        $riskLevels = ['Low Risk', 'Medium Risk', 'High Risk'];
        AcademicRisk::create([
            'student_id' => $student->id,
            'risk_level' => $riskLevels[array_rand($riskLevels)],
            'attendance_percentage' => rand(40, 95),
            'average_marks' => rand(35, 95),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Add marks
        foreach ($courses as $course) {
            Mark::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'total_marks' => rand(30, 100),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Add attendance
        for ($j = 0; $j < 10; $j++) {
            Attendance::create([
                'student_id' => $student->id,
                'course_id' => $courses->first()->id,
                'status' => rand(0, 1) ? 'present' : 'absent',
                'attendance_date' => now()->subDays(rand(1, 30)),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    
    echo "Data seeded successfully!\n";
}
