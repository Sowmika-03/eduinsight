<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\EmailLog;

echo "=== EMAIL LOG ANALYSIS ===\n\n";

// Get all emails
$allEmails = EmailLog::all();

echo "Total emails: " . $allEmails->count() . "\n";
echo "Sent: " . EmailLog::where('status', 'sent')->count() . "\n";
echo "Failed: " . EmailLog::where('status', 'failed')->count() . "\n\n";

// Show all failed emails with errors
$failedEmails = EmailLog::where('status', 'failed')->get();

if ($failedEmails->count() > 0) {
    echo "=== FAILED EMAILS ===\n";
    foreach ($failedEmails as $email) {
        echo "\nID: {$email->id}\n";
        echo "To: {$email->receiver_email}\n";
        echo "Subject: {$email->subject}\n";
        echo "Error: " . substr($email->error_message, 0, 200) . "...\n";
    }
}

// Check mail config
echo "\n\n=== CURRENT MAIL CONFIG ===\n";
echo "MAIL_MAILER: " . env('MAIL_MAILER') . "\n";
echo "MAIL_HOST: " . env('MAIL_HOST') . "\n";
echo "MAIL_PORT: " . env('MAIL_PORT') . "\n";
echo "\nNote: MAIL_MAILER=log only LOGS emails, doesn't SEND them!\n";
?>
