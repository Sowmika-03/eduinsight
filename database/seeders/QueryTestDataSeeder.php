<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\AcademicRisk;
use App\Models\Course;
use Carbon\Carbon;

class QueryTestDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed test data for query visualization
     */
    public function run(): void
    {
        // Get existing students and courses
        $students = Student::all();
        $dbCourse = Course::where('course_name', 'Database Systems')->first();
        $webCourse = Course::where('course_name', 'Web Development')->first();

        if (!$students->count() || !$dbCourse) {
            echo "No students or courses found. Run DatabaseSeeder first.\n";
            return;
        }

        // Seed varied data for each student
        $studentCount = 0;
        foreach ($students as $student) {
            $studentCount++;

            // Create varied attendance data (some below 60%, some above)
            $attendancePercentage = match ($studentCount % 5) {
                0 => rand(35, 55),    // Very low attendance
                1 => rand(56, 70),    // Low attendance
                2 => rand(75, 85),    // Good attendance
                3 => rand(86, 95),    // Excellent attendance
                default => rand(55, 75), // Medium attendance
            };

            // Add attendance records
            for ($i = 1; $i <= 40; $i++) {
                $isPresent = rand(1, 100) <= $attendancePercentage;
                Attendance::create([
                    'student_id' => $student->id,
                    'course_id' => $dbCourse->id,
                    'attendance_date' => Carbon::now()->subDays(rand(1, 60)),
                    'status' => $isPresent ? 'present' : 'absent',
                    'remarks' => $isPresent ? 'Present' : (rand(1, 10) == 1 ? 'Medical leave' : 'Absent'),
                ]);
            }

            // Create marks for Database course with variety
            $dbMarks = match ($studentCount % 5) {
                0 => [
                    'internal_marks' => rand(8, 15),
                    'external_marks' => rand(5, 18),
                    'total_marks' => rand(15, 35),
                    'grade' => 'F',
                    'risk_level' => 'High Risk',
                ],
                1 => [
                    'internal_marks' => rand(16, 25),
                    'external_marks' => rand(18, 30),
                    'total_marks' => rand(36, 55),
                    'grade' => 'D',
                    'risk_level' => 'Medium Risk',
                ],
                2 => [
                    'internal_marks' => rand(26, 35),
                    'external_marks' => rand(30, 40),
                    'total_marks' => rand(56, 75),
                    'grade' => 'B',
                    'risk_level' => 'Low Risk',
                ],
                3 => [
                    'internal_marks' => rand(36, 45),
                    'external_marks' => rand(40, 50),
                    'total_marks' => rand(76, 90),
                    'grade' => 'A',
                    'risk_level' => 'Low Risk',
                ],
                default => [
                    'internal_marks' => rand(20, 30),
                    'external_marks' => rand(20, 35),
                    'total_marks' => rand(40, 65),
                    'grade' => 'C',
                    'risk_level' => 'Low Risk',
                ],
            };

            Mark::create([
                'student_id' => $student->id,
                'course_id' => $dbCourse->id,
                'internal_marks' => $dbMarks['internal_marks'],
                'external_marks' => $dbMarks['external_marks'],
                'total_marks' => $dbMarks['total_marks'],
                'grade' => $dbMarks['grade'],
                'assessment_type' => 'midterm',
                'mark_date' => Carbon::now()->subMonth(),
            ]);

            // Create marks for Web Development course
            $webMarks = [
                'internal_marks' => rand(20, 45),
                'external_marks' => rand(20, 45),
                'total_marks' => rand(40, 90),
                'grade' => ['A', 'B', 'C', 'D'][rand(0, 3)],
            ];

            Mark::create([
                'student_id' => $student->id,
                'course_id' => $webCourse->id,
                'internal_marks' => $webMarks['internal_marks'],
                'external_marks' => $webMarks['external_marks'],
                'total_marks' => $webMarks['total_marks'],
                'grade' => $webMarks['grade'],
                'assessment_type' => 'midterm',
                'mark_date' => Carbon::now()->subMonth(),
            ]);

            // Create academic risk records
            AcademicRisk::create([
                'student_id' => $student->id,
                'course_id' => $dbCourse->id,
                'attendance_percentage' => $attendancePercentage,
                'internal_marks' => $dbMarks['internal_marks'],
                'external_marks' => $dbMarks['external_marks'],
                'risk_level' => $dbMarks['risk_level'],
                'risk_score' => round(rand(10, 95) / 100, 2),
                'risk_description' => $this->getRiskDescription($dbMarks['risk_level'], $attendancePercentage),
                'is_notified' => false,
                'recommendations' => json_encode($this->getRecommendations($dbMarks['risk_level'], $attendancePercentage)),
                'prediction_date' => Carbon::now(),
            ]);

            AcademicRisk::create([
                'student_id' => $student->id,
                'course_id' => $webCourse->id,
                'attendance_percentage' => rand(70, 95),
                'internal_marks' => $webMarks['internal_marks'],
                'external_marks' => $webMarks['external_marks'],
                'risk_level' => 'Low Risk',
                'risk_score' => round(rand(5, 30) / 100, 2),
                'risk_description' => 'Student is performing well',
                'is_notified' => false,
                'recommendations' => json_encode(['Keep up the good work']),
                'prediction_date' => Carbon::now(),
            ]);
        }

        echo "✅ Query test data seeded successfully!\n";
        echo "Total students: {$studentCount}\n";
    }

    private function getRiskDescription($riskLevel, $attendance)
    {
        if ($riskLevel === 'High Risk') {
            return "Student has very low attendance ({$attendance}%) and poor marks";
        } elseif ($riskLevel === 'Medium Risk') {
            return "Student has concerning attendance ({$attendance}%) and average marks";
        } else {
            return "Student is performing well with {$attendance}% attendance";
        }
    }

    private function getRecommendations($riskLevel, $attendance)
    {
        $recommendations = [];

        if ($attendance < 60) {
            $recommendations[] = 'Improve attendance immediately';
            $recommendations[] = 'Meet with faculty advisor';
        }

        if ($riskLevel === 'High Risk') {
            $recommendations[] = 'Attend extra classes';
            $recommendations[] = 'Get tutoring support';
            $recommendations[] = 'Review previous exams';
        } elseif ($riskLevel === 'Medium Risk') {
            $recommendations[] = 'Increase study hours';
            $recommendations[] = 'Form study groups';
        }

        return $recommendations;
    }
}
