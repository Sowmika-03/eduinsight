# Email Notification System - Quick Start

## 1. Configuration

### Step 1: Set Up Mail Service in .env

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@eduinsight.com"
MAIL_FROM_NAME="EduInsight"
```

### Step 2: Run Migrations

```bash
php artisan migrate
```

### Step 3: Update Student Records

Ensure each student has a parent email:

```php
$student->update(['parent_email' => 'parent@example.com']);
```

---

## 2. Using the Email Interface

### Access Point
**Admin/Faculty → Email Menu → Send Notification**
or directly: `/email/send`

### Send to Single Student

1. Select "Single Student" as recipient type
2. Choose student from dropdown
3. Enter subject: e.g., "Performance Warning"
4. Enter message: e.g., "Your marks have dropped below passing"
5. Click "Send Email"

### Send to Parents

1. Select "Parent/Guardian" as recipient type
2. Choose student (system sends to parent email)
3. Enter subject and message
4. Click "Send Email"

### Send to Entire Class

1. Select "Entire Class" as recipient type
2. Choose course from dropdown
3. Enter mass message (e.g., class schedule change)
4. All enrolled students receive email

### Send to Low Attendance Students

1. Select "Students with Low Attendance"
2. Choose course (optional - all courses if not selected)
3. Set attendance threshold (default: 75%)
4. Enter message (e.g., "Attendance warning")
5. System automatically identifies eligible students and sends emails

---

## 3. View Email History

**Navigate to:** `/email/history`

### Features:
- **Search** by subject or email
- **Filter** by status (sent, failed, pending)
- **View** email details in modal
- **Resend** failed emails
- **Export** data for reporting

### Status Meanings:
- **Sent** ✓ Email delivered successfully
- **Failed** ✗ Email delivery failed (can resend)
- **Pending** ⏳ Queue pending (for async jobs)

---

## 4. Email Templates

### Student Notification Template

```
Subject: [Your Subject]

Hello [StudentName],

[Your Message]

[Dashboard Link Button]

Best regards,
EduInsight Team
```

### Parent Notification Template

```
Subject: [Your Subject]

Hello [ParentName],

Regarding Student: [StudentName]

[Your Message]

[View Details Link Button]

Regards,
EduInsight Team
```

### Alert Notification Template

```
Subject: [AlertType]

Hello [RecipientName],

Alert Type: [Type]

[Alert Message]

[Login Link Button]

Regards,
EduInsight Team
```

---

## 5. Troubleshooting

### Issue: Emails Not Sending

**Solution:**
1. Check mail configuration in .env is correct
2. Run test: `php artisan tinker` then test mail
3. Check Laravel logs: `storage/logs/laravel.log`
4. Verify email service credentials

### Issue: Parent Emails Not Found

**Solution:**
1. Ensure all students have parent_email field populated
2. Check email format is valid
3. Update missing records: 
   ```sql
   UPDATE students SET parent_email = 'parent@example.com' WHERE parent_email IS NULL;
   ```

### Issue: Emails Marked as Failed

**Solution:**
1. Check error message in email history
2. Verify recipient email is valid
3. Check if email service credentials still valid
4. Resend failed emails from history page

---

## 6. API Reference

### Get Email Statistics
```
GET /email/stats
Response:
{
  "total_sent": 245,
  "total_failed": 3,
  "this_month": 45
}
```

### Programmatic Email Sending

```php
use App\Services\EmailService;
use App\Models\Student;

// Send to single student
EmailService::sendToStudent(
    $student,
    'Subject',
    'Message body'
);

// Send to parents
EmailService::sendToParent(
    $student,
    'Subject',
    'Message body'
);

// Send to class
EmailService::sendToClass(
    $courseId,
    'Subject',
    'Message body',
    $senderId
);

// Send to low attendance students
EmailService::sendToLowAttendance(
    60,  // attendance threshold
    'Subject',
    'Message body',
    $senderId
);
```

---

## 7. Best Practices

✓ **Do:**
- Test email configuration before sending to large groups
- Personalize messages when possible
- Include actionable next steps in emails
- Monitor email delivery rates
- Keep parent email addresses current

✗ **Don't:**
- Send spam or irrelevant messages
- Use HTML without proper encoding
- Send bulk emails without approval
- Forward to external email lists
- Share sensitive student information in emails

---

## 8. Email Scheduling

### Auto-Send Based on Alerts

When low attendance or marks detected:
1. Alert created in database
2. Email automatically sent to student & parent
3. Email logged in email_logs table

### Trigger Daily Alert Check

```bash
# Add to cron
* * * * * cd /path/to/app && php artisan schedule:run
```

---

## 9. Batch Email Operations

### Send to Multiple Classes

1. Send email to Class A
2. Send email to Class B
3. History shows all separately tracked

### Send to Multiple Recipients

- For parents: Select each student individually
- For class: Select course once → emails all students
- For low attendance: System auto-determines recipients

---

## Sample Messages

### Attendance Warning
```
Subject: Attendance Alert - Action Required

Dear [StudentName],

Your current attendance is [X%], which is below the required 75%.

Required Actions:
1. Meet with your Course Instructor
2. Provide attendance documentation if applicable
3. Improve attendance in coming sessions

Regards,
EduInsight Academic Team
```

### Performance Improvement
```
Subject: Academic Support Available

Dear [StudentName],

Your recent marks indicate you might benefit from additional support.

Available Resources:
- Faculty office hours: Tuesday & Thursday, 2-4 PM
- Peer tutoring sessions: Wednesday evening
- Online study materials on portal

Please contact your instructor for assistance.

Best regards,
EduInsight Support
```

### Parent Update
```
Subject: [StudentName] - Academic Update

Dear [ParentName],

We wanted to update you on [StudentName]'s academic progress:

Attendance: [%]
Recent Marks: [Score]
Overall Status: [Status]

Please encourage [StudentName] to focus on studies and reach out if you need any clarification.

Regards,
EduInsight Administration
```

