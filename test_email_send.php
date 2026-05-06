<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;
use App\Models\User;
use App\Mail\StudentNotification;
use Illuminate\Support\Facades\Mail;

// Get admin user and a student
$admin = User::where('role_id', 1)->first();
$student = Student::with('user')->find(1);

if (!$admin) {
    echo "❌ Admin user not found\n";
    exit(1);
}

if (!$student) {
    echo "❌ Student not found\n";
    exit(1);
}

echo "Testing email send...\n";
echo "From: {$admin->name} ({$admin->email})\n";
echo "To: {$student->user->email}\n";
echo "Student Name: {$student->user->name}\n\n";

try {
    // Send a test email
    Mail::to($student->user->email)->send(new StudentNotification(
        'Test Email - Low Attendance Alert',
        'This is a test email to verify the email system is working correctly. Your attendance has dropped below 75%.',
        $student
    ));
    
    echo "✅ Test email sent successfully!\n";
    echo "📬 Check your inbox or spam folder for the test email.\n";
    
} catch (\Exception $e) {
    echo "❌ Error sending email:\n";
    echo $e->getMessage() . "\n";
    exit(1);
}
?>
