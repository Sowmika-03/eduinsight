<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Get all students and courses
        $students = DB::table('students')->limit(10)->get();
        $courses = DB::table('courses')->get();

        if ($students->isNotEmpty() && $courses->isNotEmpty()) {
            $alertTypes = ['low_attendance', 'low_marks', 'high_risk', 'missing_assignment'];
            $severities = ['low', 'medium', 'high'];
            $messages = [
                'low_attendance' => 'Your attendance is below the required threshold. Please attend classes regularly.',
                'low_marks' => 'Your recent marks are below average. Consider seeking help from faculty members.',
                'high_risk' => 'Your academic performance shows signs of risk. Please meet with your faculty advisor.',
                'missing_assignment' => 'You have missed submitting an important assignment. Please complete and submit it.',
            ];

            foreach ($students as $index => $student) {
                // Create 2-3 alerts per student
                $alertCount = rand(2, 3);
                for ($i = 0; $i < $alertCount; $i++) {
                    $course = $courses[rand(0, count($courses->toArray()) - 1)];
                    $alertType = $alertTypes[rand(0, count($alertTypes) - 1)];
                    $severity = $severities[rand(0, count($severities) - 1)];

                    DB::table('alerts')->insert([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'alert_type' => $alertType,
                        'message' => $messages[$alertType],
                        'severity' => $severity,
                        'is_read' => rand(0, 1) ? true : false,
                        'alert_date' => now()->subDays(rand(1, 15)),
                        'action_taken' => rand(0, 1) ? 'Notified via email' : null,
                        'created_at' => now()->subDays(rand(1, 15)),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        DB::table('alerts')->delete();
    }
};
