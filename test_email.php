<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Mail\AlertNotification;
use Illuminate\Support\Facades\Mail;

try {
    echo "🚀 Testing Email Configuration...\n";
    echo "================================\n\n";
    
    // Test email details
    $testEmail = 'bvsaiganesh04@gmail.com';
    $alertMessage = "This is a test email from EduInsight. Your child's attendance is below the required threshold. Please take necessary action.";
    $recipientName = "Parent/Guardian";
    $alertType = "Attendance Alert";
    
    echo "📧 Sending test email...\n";
    echo "To: {$testEmail}\n";
    echo "Alert Type: {$alertType}\n";
    echo "Message: {$alertMessage}\n\n";
    
    // Send email
    Mail::to($testEmail)->send(new AlertNotification(
        $alertMessage,
        $recipientName,
        $alertType
    ));
    
    echo "✅ Email sent successfully!\n";
    echo "================================\n";
    echo "📬 You should receive the email in: {$testEmail}\n";
    echo "\n✨ Email Configuration is working correctly!\n";
    
} catch (\Exception $e) {
    echo "❌ Error sending email:\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "\n🔍 Troubleshooting Tips:\n";
    echo "1. Verify MAIL_HOST=smtp.gmail.com in .env\n";
    echo "2. Verify MAIL_PORT=587 in .env\n";
    echo "3. Verify MAIL_USERNAME in .env\n";
    echo "4. Check if 2-Step Verification is enabled on Gmail\n";
    echo "5. Verify App Password is correct in .env\n";
    exit(1);
}
