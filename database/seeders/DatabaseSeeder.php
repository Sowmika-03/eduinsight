<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\HOD;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\AcademicRisk;
use App\Models\Alert;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'System administrator with full access',
        ]);

        $facultyRole = Role::create([
            'name' => 'Faculty',
            'slug' => 'faculty',
            'description' => 'Faculty member who teaches courses',
        ]);

        $hodRole = Role::create([
            'name' => 'Head of Department',
            'slug' => 'hod',
            'description' => 'Head of Department managing faculty and courses',
        ]);

        $studentRole = Role::create([
            'name' => 'Student',
            'slug' => 'student',
            'description' => 'Student enrolled in courses',
        ]);

        $parentRole = Role::create([
            'name' => 'Parent',
            'slug' => 'parent',
            'description' => 'Parent of a student',
        ]);

        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@eduinsight.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'status' => 'active',
        ]);

        // Create HOD User
        $hodUser = User::create([
            'name' => 'Prof. Michael Chen',
            'email' => 'hod@eduinsight.com',
            'password' => Hash::make('password'),
            'role_id' => $hodRole->id,
            'phone' => '555-1000',
            'status' => 'active',
        ]);

        // Create HOD Profile
        $hod = HOD::create([
            'user_id' => $hodUser->id,
            'employee_id' => 'HOD001',
            'department' => 'Computer Science',
            'specialization' => 'Computer Science Education',
            'qualification' => 'PhD Computer Science',
            'experience_years' => 12,
        ]);

        // Create Faculty Users
        $facultyUser1 = User::create([
            'name' => 'Dr. John Smith',
            'email' => 'john.smith@eduinsight.com',
            'password' => Hash::make('password'),
            'role_id' => $facultyRole->id,
            'phone' => '555-1001',
            'status' => 'active',
        ]);

        $facultyUser2 = User::create([
            'name' => 'Prof. Sarah Johnson',
            'email' => 'sarah.johnson@eduinsight.com',
            'password' => Hash::make('password'),
            'role_id' => $facultyRole->id,
            'phone' => '555-1002',
            'status' => 'active',
        ]);

        // Create Faculty Profiles
        Faculty::create([
            'user_id' => $facultyUser1->id,
            'employee_id' => 'FAC001',
            'department' => 'Computer Science',
            'specialization' => 'Database Systems',
            'qualification' => 'PhD Computer Science',
            'experience_years' => 8,
        ]);

        Faculty::create([
            'user_id' => $facultyUser2->id,
            'employee_id' => 'FAC002',
            'department' => 'Computer Science',
            'specialization' => 'Web Development',
            'qualification' => 'Master of Technology',
            'experience_years' => 5,
        ]);

        // Create Student Users
        $studentUsers = [];
        for ($i = 1; $i <= 20; $i++) {
            $studentUsers[] = User::create([
                'name' => "Student $i",
                'email' => "student$i@eduinsight.com",
                'password' => Hash::make('password'),
                'role_id' => $studentRole->id,
                'status' => 'active',
            ]);
        }

        // Create Student Profiles
        $students = [];
        foreach ($studentUsers as $index => $user) {
            $students[] = Student::create([
                'user_id' => $user->id,
                'student_id' => 'STU' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'admission_year' => '2023',
                'semester' => '4',
                'program' => ['B.Tech CS', 'B.Tech IT', 'MCA'][rand(0, 2)],
                'batch' => '2023-2027',
            ]);
        }

        // Create Courses
        $faculty1 = Faculty::where('user_id', $facultyUser1->id)->first();
        $faculty2 = Faculty::where('user_id', $facultyUser2->id)->first();

        $course1 = Course::create([
            'course_code' => 'CS201',
            'course_name' => 'Database Systems',
            'description' => 'Learn advanced database concepts',
            'credits' => 4,
            'faculty_id' => $faculty1->id,
            'semester' => '4',
            'total_classes' => 40,
        ]);

        $course2 = Course::create([
            'course_code' => 'CS202',
            'course_name' => 'Web Development',
            'description' => 'Modern web development techniques',
            'credits' => 3,
            'faculty_id' => $faculty2->id,
            'semester' => '4',
            'total_classes' => 35,
        ]);

        // Create Enrollments and sample data
        foreach ($students as $student) {
            // Enroll in courses
            Enrollment::create([
                'student_id' => $student->id,
                'course_id' => $course1->id,
                'status' => 'enrolled',
                'enrollment_date' => Carbon::now()->subMonths(3),
            ]);

            Enrollment::create([
                'student_id' => $student->id,
                'course_id' => $course2->id,
                'status' => 'enrolled',
                'enrollment_date' => Carbon::now()->subMonths(3),
            ]);

            // Add marks
            Mark::create([
                'student_id' => $student->id,
                'course_id' => $course1->id,
                'internal_marks' => rand(20, 45),
                'external_marks' => rand(20, 45),
                'total_marks' => rand(40, 90),
                'grade' => ['A', 'B', 'C', 'D', 'F'][rand(0, 4)],
                'assessment_type' => 'midterm',
                'mark_date' => Carbon::now()->subMonths(2),
            ]);

            Mark::create([
                'student_id' => $student->id,
                'course_id' => $course2->id,
                'internal_marks' => rand(20, 45),
                'external_marks' => rand(20, 45),
                'total_marks' => rand(40, 90),
                'grade' => ['A', 'B', 'C', 'D', 'F'][rand(0, 4)],
                'assessment_type' => 'midterm',
                'mark_date' => Carbon::now()->subMonths(2),
            ]);

            // Add academic risk
            AcademicRisk::create([
                'student_id' => $student->id,
                'course_id' => $course1->id,
                'attendance_percentage' => rand(50, 95),
                'internal_marks' => rand(20, 45),
                'external_marks' => rand(20, 45),
                'risk_level' => ['Low Risk', 'Medium Risk', 'High Risk'][rand(0, 2)],
                'risk_score' => round(rand(10, 90) / 100, 2),
                'recommendations' => json_encode(['Improve attendance', 'Study harder']),
                'prediction_date' => Carbon::now(),
            ]);
        }

        echo "Database seeded successfully!\n";
    }
}
