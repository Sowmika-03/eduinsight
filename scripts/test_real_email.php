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
echo "║       EMAIL SENDING SYSTEM - FULL TEST                     ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Check email configuration
echo "📋 CURRENT MAIL CONFIGURATION:\n";
echo "   MAIL_MAILER: " . env('MAIL_MAILER') . "\n";
echo "   MAIL_HOST: " . env('MAIL_HOST') . "\n";
echo "   MAIL_PORT: " . env('MAIL_PORT') . "\n";
echo "   MAIL_USERNAME: " . env('MAIL_USERNAME') . "\n";

// Check if using test credentials
if (strpos(env('MAIL_USERNAME'), 'add_your') !== false) {
    echo "   ⚠️  WARNING: Using placeholder credentials!\n";
    echo "   You need to add real SMTP credentials.\n\n";
    echo "   👉 SETUP INSTRUCTIONS:\n";
    echo "      1. Go to https://mailtrap.io (free account)\n";
    echo "      2. Copy SMTP credentials from their dashboard\n";
    echo "      3. Update .env file with your credentials\n";
    echo "      4. Run: php artisan config:clear\n";
    echo "      5. Run this script again\n\n";
    exit(1);
}

// Get test data
$admin = User::where('role_id', 1)->first();
$student = Student::with('user')->find(1);

if (!$student) {
    echo "❌ No student found!\n";
    exit(1);
}

echo "\n📧 TEST EMAIL DETAILS:\n";
echo "   From: {$admin->email} ({$admin->name})\n";
echo "   To: {$student->user->email} ({$student->user->name})\n";
echo "   Subject: Test Email - Email System Verification\n";
echo "   Message: This is a test email from EduInsight system\n\n";

echo "🚀 Sending email...\n";

try {
    // Send the email
    Mail::to($student->user->email)->send(new StudentNotification(
        'Test Email - Email System Verification',
        'This is a test email from EduInsight system. If you received this, the email system is working correctly!',
        $student
    ));
    
    echo "✅ Email sent successfully!\n\n";

    // Check database
    $emailLog = EmailLog::latest()->first();
    
    echo "📊 EMAIL LOG ENTRY:\n";
    echo "   ID: {$emailLog->id}\n";
    echo "   Status: " . ($emailLog->status === 'sent' ? '✅ SENT' : '❌ FAILED') . "\n";
    echo "   Recipient: {$emailLog->receiver_email}\n";
    echo "   Timestamp: {$emailLog->sent_at}\n\n";
    
    echo "👀 WHAT HAPPENS NEXT:\n";
    echo "   1. Check your email inbox\n";
    echo "   2. Or check Mailtrap inbox if using Mailtrap\n";
    echo "   3. View history at http://127.0.0.1:8000/email/history\n\n";
    
    echo "✨ EMAIL SYSTEM WORKING!\n";
    
} catch (\Exception $e) {
    echo "❌ EMAIL FAILED!\n\n";
    echo "Error Details:\n";
    echo $e->getMessage() . "\n\n";
    
    // Check if logged in database
    $failedLog = EmailLog::latest()->first();
    if ($failedLog && $failedLog->status === 'failed') {
        echo "📊 ERROR LOGGED IN DATABASE:\n";
        echo "   ID: {$failedLog->id}\n";
        echo "   Error: {$failedLog->error_message}\n\n";
    }
    
    echo "🔧 TROUBLESHOOTING:\n";
    echo "   1. Verify SMTP credentials in .env\n";
    echo "   2. Check internet connection\n";
    echo "   3. Run: php artisan config:clear\n";
    echo "   4. Check logs: tail -f storage/logs/laravel.log\n";
    
    exit(1);
}
?>
