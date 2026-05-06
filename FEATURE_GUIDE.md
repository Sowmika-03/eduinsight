# EduInsight - Extended Features Implementation Guide

## Overview

This document covers the new features added to the EduInsight system:

1. **Email Notification System** - Send notifications to students/parents
2. **Enhanced NLP Query System** - Display data results instead of raw SQL
3. **Query Result Dashboard** - View results in tables and charts
4. **Automated Alerts & Email Integration** - Auto-send alerts for low attendance/marks

---

## FEATURE 1: Email Notification System

### Setup

#### 1. Add Environment Variables (.env)

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@eduinsight.com"
MAIL_FROM_NAME="EduInsight"
```

**Popular Mail Services:**
- **Mailtrap** (Development/Testing): https://mailtrap.io
- **Gmail**: SMTP host: smtp.gmail.com, Port: 587
- **AWS SES**: For production
- **SendGrid**: https://sendgrid.com

#### 2. Update Student Record with Parent Email

When creating/updating students, include the `parent_email` field:

```php
$student = Student::create([
    'user_id' => $userId,
    'student_id' => 'STU001',
    'parent_email' => 'parent@example.com',
    // ... other fields
]);
```

#### 3. Run Database Migration

```bash
php artisan migrate
```

This creates:
- `parent_email` column in `students` table
- `email_logs` table to track all emails
- Relationship between users and email logs

### Usage

#### Access Email Notification Page

**URL:** `/email/send`

**Required Permissions:** Admin or Faculty

**Features:**
- Send to single student
- Send to parent/guardian
- Send to entire class
- Send to students with low attendance

#### Example: Send Notification

1. Navigate to `/email/send`
2. Select recipient type: "Students with Low Attendance"
3. Set attendance threshold: 60%
4. Enter subject: "Attendance Warning"
5. Enter message: "Your attendance is below 60%. Please improve."
6. Click "Send Email"

#### View Email History

**URL:** `/email/history`

- Filter by status (sent, failed, pending)
- Search by subject or email
- Resend failed emails
- View email details in modal

### Database Schema

```sql
email_logs (
    id,
    sender_id,           -- User who sent the email
    receiver_email,      -- Recipient email
    subject,             -- Email subject
    message,             -- Email body
    status,              -- 'pending', 'sent', 'failed'
    error_message,       -- Error details if failed
    sent_at,             -- When email was sent
    created_at,
    updated_at
)
```

---

## FEATURE 2: Enhanced NLP Query System

### Previous vs New

**Before:**
```
User: "Show students with attendance below 60%"
System: Displays raw SQL query
Output: SELECT * FROM students WHERE attendance < 60;
```

**After:**
```
User: "Show students with attendance below 60%"
System: Executes query and displays formatted data
Output: Table with student names and attendance percentages
        Chart visualization (optional)
        SQL only visible to admin
```

### How It Works

1. **NLP Parser** converts natural language to SQL
2. **SQL Executes** against database
3. **Results Formatted** for display
4. **Chart Type Detected** automatically
5. **Results Displayed** to user (SQL hidden from non-admin)
6. **Data Stored** in `nl_queries` table

### Example Queries

```
"Show students with attendance below 60%"
"Display top 5 students by marks"
"List all courses with enrollment count"
"Show students in Computer Science batch with marks > 80"
"Display enrollment statistics by semester"
"Show students who failed in any course"
```

### Implementation Details

**File:** `app/Services/QueryResultsFormatter.php`

Key methods:
- `format()` - Format results for tables
- `detectChartType()` - Auto-detect visualization
- `prepareChartData()` - Prepare data for Chart.js

**File:** `app/Http/Controllers/NlQueryController.php`

Enhanced to:
- Format results automatically
- Detect chart compatibility
- Control SQL visibility per role
- Store formatted results

---

## FEATURE 3: Query Result Dashboard

### Result Visualization

#### Table Display
- Sortable columns
- Automatic formatting for:
  - Percentages (e.g., attendance_percentage → 85.50%)
  - Currency (e.g., fees → ₹5,000.00)
  - Dates (e.g., date_of_birth → 15 Jan 2005)

#### Chart Integration

**Automatic Chart Detection:**

| Scenario | Chart Type | Example |
|----------|-----------|---------|
| 1 string + 1 number | Bar Chart | Student names vs marks |
| Limited labels + values | Pie Chart | Program distribution |
| Time series | Line Chart | Attendance over time |

**Example:**
```
Query: "Show top 5 students by marks"
Results:
  - Name | Marks
  - Rahul | 95
  - Priya | 92
  - Amit | 88

⟹ Auto-generates Bar Chart
```

### Export Options

From results page, users can:
- **Export as CSV** - Import to Excel
- **Export as JSON** - For APIs
- **Print** - Browser print functionality

---

## FEATURE 4: Alerts + Email Integration

### Automatic Alert Triggers

The system automatically detects and notifies:

| Condition | Threshold | Recipients |
|-----------|-----------|------------|
| **Low Attendance** | < 60% | Student + Parent |
| **Low Marks** | Average < 40 | Student + Parent |
| **High Academic Risk** | Risk Level = High | Student + Parent |

### How It Works

1. **Scheduled Check** - Command runs periodically
2. **Alert Created** - Entry added to alerts table
3. **Notifications Sent** - Emails to student & parent
4. **Email Logged** - All emails tracked in email_logs

### Setup Scheduler

#### 1. Edit `app/Console/Kernel.php`

```php
protected function schedule(Schedule $schedule)
{
    // Run alert checks every hour
    $schedule->command('alerts:check')->hourly();
    
    // Or run daily at specific time
    $schedule->command('alerts:check')->dailyAt('02:00');
}
```

#### 2. Set Up Cron Job

```bash
* * * * * cd /path/to/eduinsight && php artisan schedule:run >> /dev/null 2>&1
```

#### 3. Manual Trigger (for testing)

```bash
php artisan alerts:check
```

### Alert Messages

**For Low Attendance:**
```
Subject: Attendance Alert
Message: Your attendance is critically low at 55%. 
         Please contact faculty to improve attendance.
```

**For Low Marks:**
```
Subject: Academic Performance Alert
Message: Your average marks (38.5) are below the passing threshold. 
         Please consult with faculty.
```

**For High Academic Risk:**
```
Subject: Critical Academic Risk Alert
Message: Your academic performance indicates a HIGH RISK status.
         Reason: [Description]. Please take immediate action.
```

---

## API Endpoints

### Email Endpoints

```
GET    /email/send                    - Show send form
POST   /email/send                    - Send notification
GET    /email/history                 - View email history
POST   /email/resend/{emailLog}       - Resend failed email
GET    /email/stats                   - Get email statistics
```

### NLP Query Endpoints

```
GET    /nlp/create                    - Show query form
POST   /nlp/store                     - Submit query
GET    /nlp/queries                   - List user's queries
GET    /nlp/query/{nlQuery}           - View query results
```

---

## Database Structure

### New Tables

#### email_logs
```sql
CREATE TABLE email_logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    sender_id BIGINT NOT NULL,
    receiver_email VARCHAR(255),
    subject VARCHAR(255),
    message LONGTEXT,
    status ENUM('pending', 'sent', 'failed'),
    error_message TEXT,
    sent_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    INDEX (sender_id),
    INDEX (receiver_email),
    INDEX (sent_at)
);
```

### Modified Tables

#### students
```sql
ALTER TABLE students ADD COLUMN parent_email VARCHAR(255);
```

#### nl_queries
```sql
ALTER TABLE nl_queries ADD COLUMN query_results_formatted LONGTEXT;
ALTER TABLE nl_queries ADD COLUMN result_columns JSON;
ALTER TABLE nl_queries ADD COLUMN result_count INT DEFAULT 0;
ALTER TABLE nl_queries ADD COLUMN show_sql_to_user BOOLEAN DEFAULT 0;
```

#### academic_risk
```sql
ALTER TABLE academic_risk ADD COLUMN risk_description VARCHAR(255);
ALTER TABLE academic_risk ADD COLUMN is_notified BOOLEAN DEFAULT 0;
```

---

## Mail Configuration Examples

### Option 1: Mailtrap (Development)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=xxxx
MAIL_PASSWORD=xxxx
MAIL_ENCRYPTION=tls
```

### Option 2: Gmail

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

**Get Gmail App Password:**
1. Go to https://myaccount.google.com/apppasswords
2. Select Mail and Device
3. Generate password
4. Use generated password in .env

### Option 3: SendGrid

```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=your_api_key_here
```

### Option 4: AWS SES

```env
MAIL_MAILER=ses
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
```

---

## Testing

### Test Email Configuration

```bash
# Test email sending
php artisan tinker

>>> Mail::raw('Test email', function ($message) {
    $message->to('test@example.com')->subject('Test');
});
```

### Test Alerts Service

```bash
php artisan alerts:check
```

Expected output:
```
Checking for academic alerts...
Process completed successfully!

Total alerts triggered: 3
  - attendance: Your attendance is critically low at 55%...
  - marks: Your average marks (38) are below the threshold...
  - academic_risk: High academic risk detected: ...
```

---

## Authorization & Security

### Role-Based Access

| Feature | Admin | Faculty | Student |
|---------|-------|---------|---------|
| Send Email | ✓ | ✓ | ✗ |
| View All Emails | ✓ | Own only | ✗ |
| View SQL Query | ✓ | ✗ | ✗ |
| View Own Queries | ✓ | ✓ | ✓ |
| Access Alerts | ✓ | ✓ | Own only |

### Email Log Policy

```php
// Can resend own emails
// Admin can resend any email
// Controlled via app/Policies/EmailLogPolicy.php
```

---

## Troubleshooting

### Emails Not Sending

**Check mail configuration:**
```bash
php artisan config:list | grep MAIL
```

**Check email logs:**
```sql
SELECT * FROM email_logs WHERE status = 'failed' ORDER BY created_at DESC;
```

**Check Laravel logs:**
```bash
tail -f storage/logs/laravel.log
```

### Alerts Not Triggering

**Check if command is scheduled:**
```bash
# List scheduled commands
php artisan schedule:list
```

**Run manually:**
```bash
php artisan alerts:check --verbose
```

**Check academic_risk records:**
```sql
SELECT * FROM academic_risk WHERE risk_level = 'High' AND is_notified = 0;
```

### NLP Queries Not Returning Data

**Check if columns are populated:**
```sql
SELECT id, natural_language_query, result_count, query_status FROM nl_queries;
```

**Verify QueryResultsFormatter:**
- Check if `query_results_formatted` is populated
- Check if `result_columns` is populated

---

## Best Practices

1. **Email Testing:**
   - Use Mailtrap in development
   - Configure real SMTP in production
   - Test with sample recipients first

2. **Alert Scheduling:**
   - Run alerts during off-peak hours
   - Monitor email deliverability
   - Archive old alerts periodically

3. **NLP Queries:**
   - Validate user input
   - Cache common queries
   - Monitor query execution times

4. **Database:**
   - Archive old email logs (monthly/quarterly)
   - Regular backups of alerts table
   - Monitor email_logs table size

---

## Future Enhancements

- [ ] SMS notifications
- [ ] WhatsApp integration
- [ ] Custom email templates
- [ ] Batch email sending
- [ ] Query result recommendations
- [ ] Advanced alert scheduling
- [ ] Email signature customization
- [ ] Alert management dashboard

---

## Support & Documentation

For more information, refer to:
- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Chart.js Documentation](https://www.chartjs.org/)
- [Bootstrap Documentation](https://getbootstrap.com/)
