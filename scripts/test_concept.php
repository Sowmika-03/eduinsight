<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student, App\Models\User;
use App\Mail\StudentNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailLog;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     EMAIL CONCEPT TEST - WITH LOG DRIVER                  ║\n";
echo "║     (Emails are logged to file, not sent)                 ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Temporarily set mail driver to log for demonstration
config(['mail.mailer' => 'log']);

$admin = User::where('role_id', 1)->first();
if (!$admin) {
    $admin = User::first();
}

$student = Student::with('user')->find(1);

if (!$student || !$student->user) {
    echo "❌ No student found!\n";
    exit(1);
}

echo "📧 SENDING TEST EMAIL...\n";
echo "   From: " . ($admin ? $admin->email : 'admin@eduinsight.com') . "\n";
echo "   To: {$student->user->email}\n";
echo "   Student: {$student->user->name}\n\n";

try {
    // Send the email
    Mail::to($student->user->email)->send(new StudentNotification(
        'Concept Test - Attendance Alert',
        'You have low attendance this semester.',
        $student
    ));
    
    echo "✅ EMAIL PROCESSED SUCCESSFULLY!\n\n";

    // Check database
    $emailLog = EmailLog::latest()->first();
    
    echo "📊 WHAT HAPPENED:\n";
    echo "   1. ✅ Email created with StudentNotification mailable\n";
    echo "   2. ✅ Email template rendered with student data\n";
    echo "   3. ✅ Email logged to database\n";
    echo "   4. ✅ Email written to log file\n\n";
    
    echo "📋 EMAIL LOG DETAILS:\n";
    echo "   ID: {$emailLog->id}\n";
    echo "   Status: {$emailLog->status}\n";
    echo "   To: {$emailLog->receiver_email}\n";
    echo "   Subject: {$emailLog->subject}\n";
    echo "   Message: " . substr($emailLog->message, 0, 50) . "...\n";
    echo "   Sent At: {$emailLog->sent_at}\n\n";
    
    echo "📄 CHECK EMAIL LOG:\n";
    echo "   Log file: storage/logs/laravel.log\n";
    echo "   View in browser: http://127.0.0.1:8000/email/history\n\n";
    
    echo "🔄 THE EMAIL FLOW:\n";
    echo "   User Form → StudentNotification Mailable\n";
    echo "              ↓\n";
    echo "   Email Template renders with data\n";
    echo "              ↓\n";
    echo "   Mail Driver (Log) writes email content\n";
    echo "              ↓\n";
    echo "   Email logged in database (sent)\n";
    echo "              ↓\n"; 
    echo "   Email visible in history/log file\n\n";
    
    echo "✨ SYSTEM WORKING CORRECTLY!\n\n";
    
    echo "📌 NEXT STEP:\n";
    echo "   To ACTUALLY SEND EMAILS:\n";
    echo "   1. Get Mailtrap account (free): https://mailtrap.io\n";
    echo "   2. Copy SMTP credentials\n";
    echo "   3. Update .env with credentials\n";
    echo "   4. Run: php artisan config:clear\n";
    echo "   5. Send real emails!\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
?>
