<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check existing faculty
$faculty = \App\Models\Faculty::with('user')->get();
echo "=== Existing Faculty ===\n";
foreach($faculty as $fac) {
    echo "ID: {$fac->id}, Employee: {$fac->employee_id}, Name: {$fac->user->name}, Department: {$fac->department}\n";
}
echo "\nTotal Faculty: " . \App\Models\Faculty::count() . "\n";
