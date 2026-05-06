# 🚀 EduInsight - Quick Start Guide

## 1️⃣ Start the Server

Open **PowerShell** and run:

```powershell
& "C:\xampp1\php\php.exe" artisan serve
```

**The ampersand (&) is required in PowerShell!**

**The app will start at:** `http://127.0.0.1:8000`

---

## 2️⃣ Login with Demo Credentials

Go to `http://127.0.0.1:8000/login` and use any of these:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@eduinsight.com` | `password` |
| **Faculty** | `john.smith@eduinsight.com` | `password` |
| **HOD** | `hod@eduinsight.com` | `password` |
| **Student** | `student@eduinsight.com` | `password` |

---

## 3️⃣ What You Can Do

### **Admin Dashboard**
- View all student statistics (Total Students, Avg Attendance, Pass Rate)
- See risk distribution charts (Low/Medium/High Risk)
- View students by program (B.Tech CS, B.Tech IT, MCA)
- View all system alerts (26 dummy alerts available)
- Send email notifications to any user

### **Faculty Dashboard**
- View your courses and enrolled students
- See recent student alerts and risk levels
- Send email notifications to students
- View email analytics and history

### **HOD Dashboard**
- View department statistics and performance
- Check student alerts with smart recommendations
- Send departmental notifications
- View email analytics filtered by HOD

### **Student Dashboard**
- View your courses and enrollment
- Check your marks and attendance
- View course information

---

## 4️⃣ Features Available

✅ **Email System**
- Send emails with real Gmail SMTP
- 6 quick email templates
- Character counter validation
- Email history with resend capability

✅ **Alerts & Risk Tracking**
- Academic risk tracking (Low/Medium/High)
- 26 dummy alerts for testing
- Student alerts by course
- Smart recommendations for low performers

✅ **Analytics & Dashboards**
- Interactive charts (Chart.js)
- Email analytics (system-wide, faculty-filtered, HOD-filtered)
- Student performance metrics
- 7-day email trends

✅ **Time Format**
- All times display in IST (Asia/Kolkata timezone)
- 12-hour format with AM/PM (e.g., "12 Mar 2026, 5:40 PM IST")

✅ **Database**
- 22 students across 3 programs
- 6 MCA courses
- 62 total academic risk records
- Complete email history

---

## 5️⃣ Troubleshooting

**Q: Server won't start / Parser Error?**
- In PowerShell, use: `& "C:\xampp1\php\php.exe" artisan serve` (with the `&`)
- Without the `&`, you'll get a parser error
- The ampersand (&) tells PowerShell to execute the command

**Q: Page shows error?**
- Clear browser cache (Ctrl+Shift+Delete)
- Refresh the page (F5 or Ctrl+R)

**Q: Can't see chart data?**
- Refresh the dashboard page
- Charts load from database automatically

**Q: Login not working?**
- Use exact email: `admin@eduinsight.com`
- Password is: `password` (case-sensitive on some servers)

---

## 6️⃣ Demo Data Overview

**Students:** 22 total
- B.Tech CS: 6 students
- B.Tech IT: 10 students
- MCA: 6 students

**Courses:** 6 (MCA department)
- MCA101 - Data Structures
- MCA102 - Database Management
- MCA103 - Web Development
- MCA201 - Advanced Java
- MCA202 - Software Engineering
- MCA203 - Machine Learning

**Alerts:** 26 dummy alerts
- Low Attendance: 11
- High Risk: 5
- Low Marks: 5
- Missing Assignment: 5

---

## 🎉 That's It!

Just run `php artisan serve` and start exploring! Everything is ready to use.
