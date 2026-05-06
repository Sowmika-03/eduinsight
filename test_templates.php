<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;
use App\Mail\StudentNotification;
use App\Mail\ParentNotification;
use Illuminate\Support\Facades\Mail;

echo "\n╔════════════════════════════════════════════════╗\n";
echo "║    Testing Email Send (Fixed Templates)          ║\n";
echo "╚════════════════════════════════════════════════╝\n\n";

// Test 1: Send to Student
echo "📧 Test 1: Sending email to STUDENT\n";
echo "───────────────────────────────────────\n";

try {
    $student = Student::with('user')->first();
    
    if (!$student) {
        echo "❌ No students found\n";
        exit(1);
    }
    
    echo "Student: {$student->user->name}\n";
    echo "Email: {$student->user->email}\n";
    
    Mail::to($student->user->email)->send(new StudentNotification(
        "Test Student Notification",
        "This is a test email sent to verify student notification functionality.",
        $student
    ));
    
    echo "✅ Student email sent successfully!\n\n";
    
} catch (\Exception $e) {
    echo "❌ Error sending student email: " . $e->getMessage() . "\n\n";
}

// Test 2: Send to Parent
echo "📧 Test 2: Sending email to PARENT\n";
echo "───────────────────────────────────────\n";

try {
    $student = Student::with('user')->whereNotNull('parent_email')->first();
    
    if (!$student || !$student->parent_email) {
        echo "⚠️  No students with parent email found\n";
    } else {
        echo "Student: {$student->user->name}\n";
        echo "Parent Email: {$student->parent_email}\n";
        
        Mail::to($student->parent_email)->send(new ParentNotification(
            "Test Parent Notification",
            "This is a test email sent to verify parent notification functionality.",
            $student
        ));
        
        echo "✅ Parent email sent successfully!\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error sending parent email: " . $e->getMessage() . "\n";
}

echo "\n═════════════════════════════════════════════════\n";
echo "✨ Email template testing completed!\n";
echo "═════════════════════════════════════════════════\n\n";
?>
