<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$students = \App\Models\Student::with('user')->limit(5)->get();

if ($students->count() > 0) {
    echo "✅ Found " . $students->count() . " students:\n";
    foreach ($students as $student) {
        echo "  ID: {$student->id} | Name: {$student->user->name} | Email: {$student->user->email}\n";
    }
} else {
    echo "❌ No students found in database. Run 'php artisan migrate --seed' first.\n";
}

// Also check if admin user exists
$admin = \App\Models\User::where('role_id', 1)->first();
if ($admin) {
    echo "\n✅ Admin user found: {$admin->name} ({$admin->email})\n";
} else {
    echo "\n❌ No admin user found\n";
}
?>
