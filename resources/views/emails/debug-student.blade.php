<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #007bff;">📬 Notification</h2>
        
        <p>Hello <strong>{{ $studentName }}</strong>,</p>
        
        <div style="background-color: #f5f5f5; padding: 15px; border-left: 4px solid #007bff; margin: 20px 0;">
            <p>{{ $notificationMessage }}</p>
        </div>
        
        <p style="margin-top: 20px; text-align: center;">
            <a href="{{ config('app.url') }}/student/dashboard" style="background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
                View Your Dashboard
            </a>
        </p>
        
        <hr style="margin: 30px 0; border: none; border-top: 1px solid #ddd;">
        
        <p style="font-size: 12px; color: #666;">
            Best regards,<br>
            <strong>{{ config('app.name') }} Team</strong><br>
            <em>Academic Support System</em>
        </p>
    </div>
</body>
</html>
