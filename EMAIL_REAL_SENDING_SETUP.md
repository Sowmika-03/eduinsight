# Email Configuration Guide - REAL EMAIL SENDING

## THE PROBLEM
Your current setup uses `MAIL_MAILER=log` which only logs emails to files.
**Emails show as "Sent" but aren't actually delivered.**

## THE SOLUTION
Configure a real SMTP service. Choose one:

---

## OPTION 1: MAILTRAP (Recommended for Development) ⭐
### Why Mailtrap?
- ✅ Free account
- ✅ Catch all test emails
- ✅ View sent emails in web interface
- ✅ No real emails sent
- ✅ Perfect for development/testing

### Setup Steps:

1. **Go to** https://mailtrap.io (sign up free)

2. **Create an inbox** (they give you one by default)

3. **Get SMTP credentials** from dashboard:
   - SMTP Host: smtp.mailtrap.io
   - SMTP Port: 465 or 587
   - Username: (shown in credentials)
   - Password: (shown in credentials)

4. **Update `.env` file:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@eduinsight.com"
MAIL_FROM_NAME="EduInsight"
```

---

## OPTION 2: GMAIL (Production-Ready)

### Get Gmail App Password:

1. Go to: https://myaccount.google.com/apppasswords

2. Select "Mail" and "Windows Computer"

3. Copy the 16-character password

4. **Update `.env` file:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=xxxx-xxxx-xxxx-xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@eduinsight.com"
MAIL_FROM_NAME="EduInsight"
```

---

## OPTION 3: SENDGRID (Production)

1. Create free SendGrid account: https://sendgrid.com

2. Create API key

3. **Update `.env` file:**
```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=your_sendgrid_api_key
MAIL_FROM_ADDRESS="noreply@eduinsight.com"
MAIL_FROM_NAME="EduInsight"
```

---

## HOW IT WORKS

1. **User sends email** via web interface → POST /email/send
2. **Laravel processes** the request with StudentNotification mailable
3. **SMTP sends actual email** (via Mailtrap/Gmail/SendGrid)
4. **Email logged** in database (status: sent or failed)
5. **User can view history** and resend if needed

---

## TESTING EMAILS

### Via Web Interface:
1. Go to http://127.0.0.1:8000/email/send
2. Select student
3. Enter subject & message
4. Click "Send Email"
5. View at http://127.0.0.1:8000/email/history

### Via Command Line:
```bash
php artisan tinker
> $student = App\Models\Student::find(1);
> Mail::to($student->user->email)->send(new App\Mail\StudentNotification('Test', 'Testing email system', $student));
```

### Check Logs:
```bash
tail -f storage/logs/laravel.log
```

---

## AFTER UPDATING .env

1. **Clear cache:**
   ```bash
   php artisan config:clear
   ```

2. **Test immediately:**
   Go to http://127.0.0.1:8000/email/send and send a test email

3. **Check Mailtrap inbox** (if using Mailtrap) for received emails

---

## TROUBLESHOOTING

### Email shows as "Sent" but doesn't arrive?
- Check if using MAIL_MAILER=log (this only logs, doesn't send)
- Update to MAIL_MAILER=smtp with real credentials

### SMTP Authentication Failed?
- Check username/password are correct
- For Gmail: Ensure App Password (not regular password)
- For Mailtrap: Check you copied exact credentials

### Email shows as "Failed"?
- Check error message in email history details
- See storage/logs/laravel.log for full error
- Run: `php artisan config:clear` and try again