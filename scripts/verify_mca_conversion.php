<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Verify all students are now MCA
$programs = \App\Models\Student::selectRaw('program, COUNT(*) as count')
    ->groupBy('program')
    ->get();

echo "=== Student Programs Distribution ===\n";
foreach($programs as $prog) {
    echo "{$prog->program}: {$prog->count} students\n";
}

echo "\nTotal Students: " . \App\Models\Student::count() . "\n";

// Show sample students
echo "\n=== Sample Students (First 5) ===\n";
$students = \App\Models\Student::with('user')->take(5)->get();
foreach($students as $student) {
    echo "- {$student->user->name} (ID: {$student->student_id}) → Program: {$student->program}\n";
}
