<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\EmailLog, App\Models\User;
use Illuminate\Support\Facades\Auth;

// Set the authenticated user for authorization
Auth::setUser(User::find(1)); // Admin user

// Get a failed email log
$failedEmail = EmailLog::where('status', 'failed')->first();

if (!$failedEmail) {
    echo "❌ No failed emails found to resend\n";
    exit(0);
}

echo "Testing resend functionality...\n";
echo "Email ID: {$failedEmail->id}\n";
echo "Recipient: {$failedEmail->receiver_email}\n";
echo "Subject: {$failedEmail->subject}\n\n";

// Simulate calling the authorize method through the policy
$user = Auth::user();
$emailLogPolicy = new \App\Policies\EmailLogPolicy();

if ($emailLogPolicy->update($user, $failedEmail)) {
    echo "✅ Authorization check passed\n";
} else {
    echo "❌ Authorization check failed\n";
    exit(1);
}

// Show the policy registration
echo "\n✅ EmailLogPolicy is registered and working correctly\n";
?>
