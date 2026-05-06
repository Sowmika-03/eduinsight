<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #d9534f;">📬 Notification</h2>
        
        <p>Hello <strong>{{ $parentName }}</strong>,</p>
        
        <div style="background-color: #fff3cd; padding: 15px; border-left: 4px solid #d9534f; margin: 20px 0;">
            <p><strong>Regarding Student:</strong> {{ $studentName }}</p>
            <p style="margin-top: 10px;">{{ $emailMessage }}</p>
        </div>
        
        <p style="margin-top: 20px; text-align: center;">
            <a href="{{ config('app.url') }}/parent/dashboard" style="background-color: #d9534f; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
                View Student Details
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
