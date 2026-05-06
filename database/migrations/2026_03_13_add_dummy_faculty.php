<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Faculty;

return new class extends Migration
{
    public function up(): void
    {
        // Create dummy faculty users
        $facultyData = [
            [
                'name' => 'Dr. Rajesh Kumar',
                'email' => 'rajesh.kumar@eduinsight.com',
                'specialization' => 'Data Structures & Algorithms',
                'employee_id' => 'FAC010',
                'qualification' => 'Ph.D. in Computer Science',
                'experience_years' => 12
            ],
            [
                'name' => 'Prof. Priya Singh',
                'email' => 'priya.singh@eduinsight.com',
                'specialization' => 'Database Systems',
                'employee_id' => 'FAC011',
                'qualification' => 'M.Tech in Database Engineering',
                'experience_years' => 10
            ],
            [
                'name' => 'Dr. Arun Patel',
                'email' => 'arun.patel@eduinsight.com',
                'specialization' => 'Web Technologies',
                'employee_id' => 'FAC012',
                'qualification' => 'Ph.D. in Web Systems',
                'experience_years' => 9
            ],
            [
                'name' => 'Mrs. Maya Sharma',
                'email' => 'maya.sharma@eduinsight.com',
                'specialization' => 'Software Engineering',
                'employee_id' => 'FAC013',
                'qualification' => 'M.Tech in Software Engineering',
                'experience_years' => 8
            ],
            [
                'name' => 'Prof. Vikram Desai',
                'email' => 'vikram.desai@eduinsight.com',
                'specialization' => 'Machine Learning',
                'employee_id' => 'FAC014',
                'qualification' => 'M.Tech in AI & Machine Learning',
                'experience_years' => 7
            ],
            [
                'name' => 'Dr. Anjali Gupta',
                'email' => 'anjali.gupta@eduinsight.com',
                'specialization' => 'Advanced Java Programming',
                'employee_id' => 'FAC015',
                'qualification' => 'B.Tech in Computer Science with Java Certification',
                'experience_years' => 11
            ]
        ];

        foreach ($facultyData as $data) {
            // Create user
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('password'),
                    'role_id' => 2  // Faculty role ID
                ]
            );

            // Create faculty profile
            Faculty::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'employee_id' => $data['employee_id'],
                    'department' => 'MCA',
                    'specialization' => $data['specialization'],
                    'qualification' => $data['qualification'],
                    'experience_years' => $data['experience_years'],
                    'approval_status' => 'approved',
                    'max_students' => 50
                ]
            );
        }
    }

    public function down(): void
    {
        // Delete faculty users (cleanup)
        User::whereIn('email', [
            'rajesh.kumar@eduinsight.com',
            'priya.singh@eduinsight.com',
            'arun.patel@eduinsight.com',
            'maya.sharma@eduinsight.com',
            'vikram.desai@eduinsight.com',
            'anjali.gupta@eduinsight.com'
        ])->delete();
    }
};
