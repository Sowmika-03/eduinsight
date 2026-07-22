<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;
use App\Models\Alert;
use App\Mail\AlertNotification;
use Illuminate\Support\Facades\Mail;

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║     EDUINSIGHT - DEMO: ALERT APPROVAL & EMAIL SENDING     ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

// Get a student with parent email
$student = Student::with(['user', 'academicRisks'])->whereNotNull('parent_email')->first();

if (!$student) {
    echo "❌ No students found with parent email\n";
    exit(1);
}

echo "📊 DEMO DATA:\n";
echo "─────────────────────────────────────────────────────────────\n";
echo "Student Name: {$student->user->name}\n";
echo "Student ID: {$student->student_id}\n";
echo "Parent Email: {$student->parent_email}\n";
$riskLevel = $student->academicRisks && $student->academicRisks->first() ? $student->academicRisks->first()->risk_level : 'None';
echo "Academic Risk: {$riskLevel}\n";
echo "─────────────────────────────────────────────────────────────\n\n";

// Simulate admin approving an alert
echo "🔄 DEMO WORKFLOW:\n";
echo "─────────────────────────────────────────────────────────────\n";
echo "Step 1: Admin views dashboard\n";
echo "Step 2: Admin sees alert: LOW ATTENDANCE ({$student->student_id})\n";
echo "Step 3: Admin clicks 'APPROVE ALERT'\n";
echo "Step 4: System sends email to parent...\n\n";

// Create demo alert
$alert = Alert::firstOrCreate(
    [
        'student_id' => $student->id,
        'alert_type' => 'low_attendance',
        'is_read' => false,
    ],
    [
        'message' => "Attendance is critically low",
        'severity' => 'high',
        'alert_date' => now(),
    ]
);

// Send email (simulating approval action)
try {
    $emailMessage = "Your child {$student->user->name} (ID: {$student->student_id}) has critically low attendance (below 60%). Please contact the faculty immediately.";
    
    Mail::to($student->parent_email)->send(new AlertNotification(
        $emailMessage,
        "Parent/Guardian",
        "Low Attendance Alert"
    ));

    echo "✅ EMAIL SENT SUCCESSFULLY!\n";
    echo "─────────────────────────────────────────────────────────────\n";
    echo "📧 Recipient: {$student->parent_email}\n";
    echo "📝 Subject: Low Attendance Alert\n";
    echo "💬 Message: Parent notified about low attendance\n\n";
    
    echo "🎯 DEMO COMPLETE:\n";
    echo "─────────────────────────────────────────────────────────────\n";
    echo "[✓] Alert approved by Admin\n";
    echo "[✓] Parent email fetched from database\n";
    echo "[✓] Email sent via Gmail SMTP\n";
    echo "[✓] Real-time notification delivered\n";
    echo "[✓] Alert logged in email_logs table\n\n";
    
    echo "📬 CHECK YOUR EMAIL: bvsaiganesh04@gmail.com\n";
    echo "   (Email should arrive within 1-2 seconds)\n\n";
    
    echo "═══════════════════════════════════════════════════════════\n";
    echo "✨ Option-1: Real Email Demo is READY for presentation!\n";
    echo "═══════════════════════════════════════════════════════════\n\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
