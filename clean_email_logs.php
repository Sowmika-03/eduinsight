<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\EmailLog;

// Clear old failed emails from before the fix
$deleted = EmailLog::where('status', 'failed')->delete();

echo "✅ Cleared $deleted old failed email logs\n\n";

// Show current database state
$remaining = EmailLog::all();
echo "Remaining emails: " . $remaining->count() . "\n";

if ($remaining->count() > 0) {
    foreach ($remaining as $email) {
        echo "  - {$email->subject} ({$email->status}) to {$email->receiver_email}\n";
    }
}

echo "\n✅ Database cleaned. Ready for real email testing!\n";
?>
