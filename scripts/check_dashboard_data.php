<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check AcademicRisk data
echo "=== ACADEMIC RISK DATA ===\n";
$risks = \App\Models\AcademicRisk::selectRaw('risk_level, COUNT(*) as count')
    ->groupBy('risk_level')
    ->get();
    
foreach($risks as $risk) {
    echo "{$risk->risk_level}: {$risk->count}\n";
}

if($risks->count() === 0) {
    echo "No academic risk data found!\n";
}

echo "\n=== STUDENT PROGRAM DATA ===\n";
$programs = \App\Models\Student::selectRaw('program, COUNT(*) as total')
    ->groupBy('program')
    ->get();
    
foreach($programs as $prog) {
    echo "{$prog->program}: {$prog->total}\n";
}

if($programs->count() === 0) {
    echo "No student program data found!\n";
}

echo "\n=== TOTAL STUDENTS ===\n";
echo "Total: " . \App\Models\Student::count() . "\n";

echo "\n=== SAMPLE STUDENTS ===\n";
$students = \App\Models\Student::take(5)->get();
foreach($students as $student) {
    echo "- {$student->user->name} (Program: {$student->program})\n";
}
