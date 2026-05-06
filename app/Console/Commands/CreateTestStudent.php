<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Student;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:create {email} {name=Test Student}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test student user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->argument('name');

        // Get student role
        $studentRole = Role::where('slug', 'student')->first();

        if (!$studentRole) {
            $this->error('Student role not found');
            return 1;
        }

        // Check if user exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists");
            return 1;
        }

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'role_id' => $studentRole->id,
            'status' => 'active',
        ]);

        // Create student profile
        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => 'STU' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
            'admission_year' => '2023',
            'semester' => '4',
            'program' => 'B.Tech CS',
            'batch' => '2023-2027',
            'parent_email' => 'parent@example.com',
        ]);

        $this->info('✅ Student Created Successfully!');
        $this->line('');
        $this->table(['Field', 'Value'], [
            ['Email', $email],
            ['Password', 'password'],
            ['Student ID', $student->student_id],
            ['Name', $name],
        ]);

        return 0;
    }
}
