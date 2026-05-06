<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\HOD;
use Illuminate\Support\Facades\Hash;

class HODSeeder extends Seeder
{
    /**
     * Run the database seeding.
     */
    public function run(): void
    {
        // Check if HOD role exists
        $hodRole = Role::where('slug', 'hod')->first();
        
        if (!$hodRole) {
            $hodRole = Role::create([
                'name' => 'Head of Department',
                'slug' => 'hod',
                'description' => 'Head of Department managing faculty and courses',
            ]);
        }

        // Check if HOD user exists
        $hodUser = User::where('email', 'hod@eduinsight.com')->first();

        if (!$hodUser) {
            $hodUser = User::create([
                'name' => 'Prof. Michael Chen',
                'email' => 'hod@eduinsight.com',
                'password' => Hash::make('password'),
                'role_id' => $hodRole->id,
                'phone' => '555-1000',
                'status' => 'active',
            ]);
        }

        // Check if HOD profile exists
        $hod = HOD::where('user_id', $hodUser->id)->first();

        if (!$hod) {
            HOD::create([
                'user_id' => $hodUser->id,
                'employee_id' => 'HOD001',
                'department' => 'Computer Science',
                'specialization' => 'Computer Science Education',
                'qualification' => 'PhD Computer Science',
                'experience_years' => 12,
            ]);
        }

        echo "HOD role and user seeded successfully!\n";
    }
}
