<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Mail\SimpleTestMail;
use Illuminate\Support\Facades\Mail;

echo "Testing simple email...\n";

try {
    Mail::to('bvsaiganesh04@gmail.com')->send(new SimpleTestMail());
    echo "✅ Simple test email sent!\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
