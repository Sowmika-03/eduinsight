<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateFacultyUser extends Command
{
    protected $signature = 'user:create-faculty {email} {name?}';
    protected $description = 'Create a new faculty user';

    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->argument('name') ?? 'Faculty Member';

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("❌ User with email {$email} already exists!");
            return 1;
        }

        // Get faculty role
        $facultyRole = Role::where('slug', 'faculty')->first();
        if (!$facultyRole) {
            $this->error("❌ Faculty role not found!");
            return 1;
        }

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'role_id' => $facultyRole->id,
            'status' => 'active',
        ]);

        // Create faculty profile
        Faculty::create([
            'user_id' => $user->id,
            'employee_id' => 'FAC' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
            'department' => 'Computer Science',
            'specialization' => 'General',
            'qualification' => 'Master of Technology',
            'experience_years' => 5,
        ]);

        $this->info("✅ Faculty User Created Successfully!");
        $this->table(
            ['Field', 'Value'],
            [
                ['Email', $email],
                ['Password', 'password'],
                ['Name', $name],
                ['Employee ID', 'FAC' . str_pad($user->id, 3, '0', STR_PAD_LEFT)],
            ]
        );

        return 0;
    }
}
