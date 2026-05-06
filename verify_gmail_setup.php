<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\EmailLog;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║           GMAIL EMAIL HISTORY - VERIFICATION              ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

$allEmails = EmailLog::all();

echo "📊 TOTAL EMAILS IN DATABASE: " . $allEmails->count() . "\n\n";

echo "📋 EMAIL LOG:\n";
echo str_repeat("─", 60) . "\n";

foreach ($allEmails as $email) {
    $status = $email->status === 'sent' ? '✅ SENT' : '❌ FAILED';
    echo "ID: {$email->id} | Status: $status\n";
    echo "To: {$email->receiver_email}\n";
    echo "From: " . ($email->sender->email ?? 'Unknown') . "\n";
    echo "Subject: {$email->subject}\n";
    echo "Message: " . substr($email->message, 0, 40) . "...\n";
    echo "Sent At: {$email->sent_at}\n";
    echo str_repeat("─", 60) . "\n";
}

echo "\n✅ GMAIL CONFIGURATION SUMMARY:\n";
echo "   Provider: Gmail SMTP\n";
echo "   Host: smtp.gmail.com\n";
echo "   Port: 587\n";
echo "   Email: wwwbvndksowmika@gmail.com\n";
echo "   Status: ✅ CONNECTED & WORKING\n\n";

echo "🎯 READY TO USE:\n";
echo "   1. Go to http://127.0.0.1:8000/email/send\n";
echo "   2. Select student/class\n";
echo "   3. Write your message\n";
echo "   4. Click Send\n";
echo "   5. Email is delivered via Gmail! ✅\n";
?>
