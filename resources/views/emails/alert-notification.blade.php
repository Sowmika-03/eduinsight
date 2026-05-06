<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Academic Alert</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #d9534f;">🚨 Academic Alert</h2>
        
        <p>Hello <strong>{{ $recipientName }}</strong>,</p>
        
        <div style="background-color: #f5f5f5; padding: 15px; border-left: 4px solid #d9534f; margin: 20px 0;">
            <p><strong>Alert Type:</strong> {{ ucfirst($alertType) }}</p>
            <p style="margin-top: 10px;">{{ $alertMessage }}</p>
        </div>
        
        <p style="margin-top: 20px;">Please log into the EduInsight system to take necessary action.</p>
        
        <p style="text-align: center; margin-top: 30px;">
            <a href="{{ config('app.url') }}/login" style="background-color: #5cb85c; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Access EduInsight
            </a>
        </p>
        
        <hr style="margin: 30px 0; border: none; border-top: 1px solid #ddd;">
        
        <p style="font-size: 12px; color: #666;">
            Regards,<br>
            <strong>{{ config('app.name') }} Team</strong><br>
            <em>Automated Academic Support System</em>
        </p>
    </div>
</body>
</html>
