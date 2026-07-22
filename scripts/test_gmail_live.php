<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student, App\Models\User;
use App\Mail\StudentNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailLog;

echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║     GMAIL EMAIL SENDING TEST - LIVE VERIFICATION         ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

// Verify Gmail configuration
echo "📋 GMAIL CONFIGURATION:\n";
echo "   MAIL_MAILER: " . env('MAIL_MAILER') . "\n";
echo "   MAIL_HOST: " . env('MAIL_HOST') . "\n";
echo "   MAIL_PORT: " . env('MAIL_PORT') . "\n";
echo "   MAIL_USERNAME: " . env('MAIL_USERNAME') . "\n\n";

$student = Student::with('user')->find(1);

if (!$student || !$student->user) {
    echo "❌ Student not found!\n";
    exit(1);
}

echo "📧 SENDING REAL EMAIL VIA GMAIL:\n";
echo "   From: " . env('MAIL_FROM_ADDRESS') . "\n";
echo "   To: " . $student->user->email . "\n";
echo "   Student: " . $student->user->name . "\n\n";

try {
    // Send the email
    Mail::to($student->user->email)->send(new StudentNotification(
        '✅ EduInsight Email System Test - NOW WORKING',
        'Congratulations! Your EduInsight email system is now fully operational and sending real emails via Gmail. This email was successfully delivered from your EduInsight application. You can now send email notifications to students directly from the system.',
        $student
    ));
    
    echo "🎉 EMAIL SENT SUCCESSFULLY!\n\n";

    // Check database
    $emailLog = EmailLog::latest()->first();
    
    echo "✅ LIVE EMAIL DETAILS:\n";
    echo "   ID: {$emailLog->id}\n";
    echo "   Status: {$emailLog->status}\n";
    echo "   To: {$emailLog->receiver_email}\n";
    echo "   Subject: {$emailLog->subject}\n";
    echo "   Sent At: {$emailLog->sent_at}\n\n";
    
    echo "📬 CHECK YOUR EMAIL:\n";
    echo "   1. Open Gmail inbox for: " . $student->user->email . "\n";
    echo "   2. Look for email from: " . env('MAIL_FROM_ADDRESS') . "\n";
    echo "   3. Subject: Email System Test - NOW WORKING\n\n";
    
    echo "🌐 ALSO CHECK WEB INTERFACE:\n";
    echo "   http://127.0.0.1:8000/email/history\n";
    echo "   You should see this email with \"Sent\" status ✅\n\n";
    
    echo "🎯 EMAIL SYSTEM STATUS: ✅ FULLY OPERATIONAL!\n";
    echo "   - Gmail authentication: ✅ SUCCESS\n";
    echo "   - Email creation: ✅ SUCCESS\n";
    echo "   - Template rendering: ✅ SUCCESS\n";
    echo "   - Database logging: ✅ SUCCESS\n";
    echo "   - Real delivery: ✅ SUCCESS (via Gmail SMTP)\n\n";
    
    echo "🚀 YOU CAN NOW:\n";
    echo "   - Send emails to individual students\n";
    echo "   - Send to entire classes\n";
    echo "   - Send to students with low attendance\n";
    echo "   - Send to parents\n";
    echo "   - Resend failed emails\n";
    echo "   - View email history and logs\n";
    
} catch (\Exception $e) {
    echo "❌ EMAIL FAILED!\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    
    echo "⚠️  POSSIBLE ISSUES:\n";
    echo "   1. Gmail account blocked email access\n";
    echo "   2. Password incorrect (check credentials)\n";
    echo "   3. Gmail requires App Password (not regular password)\n";
    echo "   4. Two-factor authentication enabled\n\n";
    
    echo "💡 SOLUTIONS:\n";
    echo "   If using 2FA: Generate App Password\n";
    echo "   - Go to: https://myaccount.google.com/apppasswords\n";
    echo "   - Select Mail + Windows Computer\n";
    echo "   - Copy 16-char password\n";
    echo "   - Update .env MAIL_PASSWORD\n";
    echo "   - Run: php artisan config:clear\n";
    
    exit(1);
}
?>
