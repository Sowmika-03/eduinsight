<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Get the faculty member from MCA department
        $faculty = DB::table('faculty')
            ->join('users', 'faculty.user_id', '=', 'users.id')
            ->where('faculty.department', 'MCA')
            ->select('faculty.id', 'faculty.user_id')
            ->first();

        if ($faculty) {
            $facultyId = $faculty->user_id;

            // Create MCA Courses
            $courses = [
                [
                    'course_code' => 'MCA101',
                    'course_name' => 'Data Structures and Algorithms',
                    'description' => 'Advanced concepts in data structures and algorithm design',
                    'credits' => 4,
                    'faculty_id' => $facultyId,
                    'semester' => 1,
                    'total_classes' => 40,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'course_code' => 'MCA102',
                    'course_name' => 'Database Management Systems',
                    'description' => 'Relational and non-relational database concepts',
                    'credits' => 4,
                    'faculty_id' => $facultyId,
                    'semester' => 1,
                    'total_classes' => 40,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'course_code' => 'MCA103',
                    'course_name' => 'Web Development Fundamentals',
                    'description' => 'HTML, CSS, JavaScript and web frameworks',
                    'credits' => 3,
                    'faculty_id' => $facultyId,
                    'semester' => 1,
                    'total_classes' => 35,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'course_code' => 'MCA201',
                    'course_name' => 'Advanced Java Programming',
                    'description' => 'OOP concepts, design patterns, and enterprise Java',
                    'credits' => 4,
                    'faculty_id' => $facultyId,
                    'semester' => 2,
                    'total_classes' => 40,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'course_code' => 'MCA202',
                    'course_name' => 'Software Engineering',
                    'description' => 'Software development lifecycle, design patterns, and methodologies',
                    'credits' => 4,
                    'faculty_id' => $facultyId,
                    'semester' => 2,
                    'total_classes' => 40,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'course_code' => 'MCA203',
                    'course_name' => 'Machine Learning Basics',
                    'description' => 'Introduction to ML algorithms and applications',
                    'credits' => 3,
                    'faculty_id' => $facultyId,
                    'semester' => 2,
                    'total_classes' => 35,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($courses as $course) {
                DB::table('courses')->updateOrInsert(
                    ['course_code' => $course['course_code']],
                    $course
                );
            }

            // Enroll the student in all MCA courses
            $student = DB::table('students')
                ->where('registration', 'MC2024001')
                ->first();

            if ($student) {
                $mca_courses = DB::table('courses')
                    ->where('faculty_id', $facultyId)
                    ->get();

                foreach ($mca_courses as $course) {
                    DB::table('enrollments')->updateOrInsert(
                        ['student_id' => $student->id, 'course_id' => $course->id],
                        [
                            'enrollment_date' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }
    }

    public function down(): void
    {
        // Rollback courses
        DB::table('courses')->whereIn('course_code', ['MCA101', 'MCA102', 'MCA103', 'MCA201', 'MCA202', 'MCA203'])->delete();
    }
};
