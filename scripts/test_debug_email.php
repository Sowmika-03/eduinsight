<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;
use App\Mail\DebugStudentNotification;
use Illuminate\Support\Facades\Mail;

$student = Student::with('user')->find(1);

if (!$student) {
    echo "❌ Student not found\n";
    exit(1);
}

echo "Testing debug email with public properties...\n";
echo "To: {$student->user->email}\n\n";

try {
    Mail::to($student->user->email)->send(new DebugStudentNotification(
        'Test Email - Low Attendance Alert',
        'This is a test email to verify the email system is working correctly.',
        $student
    ));
    
    echo "✅ Debug email sent successfully!\n";
    
} catch (\Exception $e) {
    echo "❌ Error:\n";
    echo $e->getMessage() . "\n";
    exit(1);
}
?>
