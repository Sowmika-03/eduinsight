<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration {
    public function up(): void
    {
        $roleTable = DB::table('roles');
        $role_faculty = $roleTable->where('slug', 'faculty')->first();
        $role_hod = $roleTable->where('slug', 'hod')->first();
        $role_student = $roleTable->where('slug', 'student')->first();

        if ($role_faculty && $role_hod && $role_student) {
            // Update/Create Faculty (MCA Department)
            $faculty_result = DB::table('users')->updateOrInsert(
                ['email' => 'john.smith@eduinsight.com'],
                [
                    'name' => 'Dr. John Smith',
                    'password' => Hash::make('password'),
                    'role_id' => $role_faculty->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Create Faculty record for MCA department
            $faculty_user = DB::table('users')->where('email', 'john.smith@eduinsight.com')->first();
            if ($faculty_user) {
                DB::table('faculty')->updateOrInsert(
                    ['user_id' => $faculty_user->id],
                    [
                        'department' => 'MCA',
                        'joining_date' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            // Create HOD User (MCA Department)
            $hod_result = DB::table('users')->updateOrInsert(
                ['email' => 'hod@eduinsight.com'],
                [
                    'name' => 'Prof. Michael Chen',
                    'password' => Hash::make('password'),
                    'role_id' => $role_hod->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $hod_user = DB::table('users')->where('email', 'hod@eduinsight.com')->first();
            if ($hod_user) {
                DB::table('hods')->updateOrInsert(
                    ['user_id' => $hod_user->id],
                    [
                        'department' => 'MCA',
                        'joining_date' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            // Create Student User
            DB::table('users')->updateOrInsert(
                ['email' => 'student@eduinsight.com'],
                [
                    'name' => 'Saiganesh',
                    'password' => Hash::make('password'),
                    'role_id' => $role_student->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $student_user = DB::table('users')->where('email', 'student@eduinsight.com')->first();
            if ($student_user) {
                $student = DB::table('students')->updateOrInsert(
                    ['user_id' => $student_user->id],
                    [
                        'registration' => 'MC2024001',
                        'program' => 'MCA',
                        'semester' => 2,
                        'parent_email' => 'parent@example.com',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                $student_record = DB::table('students')->where('user_id', $student_user->id)->first();
                if ($student_record) {
                    $courses = DB::table('courses')->limit(3)->get();
                    foreach ($courses as $course) {
                        DB::table('enrollments')->updateOrInsert(
                            ['student_id' => $student_record->id, 'course_id' => $course->id],
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
    }

    public function down(): void
    {
        // Keep data on rollback
    }
};
