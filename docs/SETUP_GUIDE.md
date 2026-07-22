# EduInsight - Complete Setup Guide

## 📋 System Overview

EduInsight is a Natural Language Decision Support System for Educational Databases. It combines:
- Laravel backend with role-based access control
- Blade templating with Bootstrap UI
- Chart.js for data visualization
- Python Flask API for ML-based risk prediction
- Rule-based NLP query parser

---

## 🚀 Quick Start Guide

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL Server
- Python 3.8+
- XAMPP (for development)

### Installation Steps

#### 1. Clone/Setup Project
```bash
cd c:\xampp\htdocs\eduinsight-app
```

#### 2. Install Dependencies
```bash
composer install
```

#### 3. Configure Environment
The `.env` file is already configured for the eduinsight MySQL database.

#### 4. Generate Application Key
```bash
php artisan key:generate
```

#### 5. Run Database Migrations
```bash
php artisan migrate
```

#### 6. Seed Sample Data
```bash
php artisan db:seed
```

#### 7. Start Development Server
```bash
php artisan serve
```

Visit: `http://localhost:8000`

#### 8. Setup Python ML Service (in separate terminal)
```bash
cd ml_service
pip install -r requirements.txt
python train_model.py
python app.py
```

ML API will run on: `http://localhost:5000`

---

## 👥 User Roles & Credentials

### Admin
- **Email:** admin@eduinsight.com
- **Password:** password
- **Access:** View all students, courses, alerts, and system statistics

### Faculty
- **Email:** john.smith@eduinsight.com
- **Password:** password
- **Access:** Manage own courses, add marks, record attendance

### Student  
- **Email:** student1@eduinsight.com
- **Password:** password
- **Access:** View marks, attendance, alerts, risk predictions

### Parent
- Role created, but without specific dashboard (can be extended)

---

## 📊 Dashboard Features

### Admin Dashboard
- Total students count
- Average attendance percentage
- Overall pass percentage
- High-risk student count
- Risk distribution pie chart
- Student distribution by program
- Recent alerts feed

### Faculty Dashboard
- List of assigned courses
- Total enrolled students
- Average class attendance
- Students with low attendance alerts
- Ability to add marks and record attendance

### Student Dashboard
- Enrolled courses
- Average marks
- Overall performance status
- Academic risk analysis by course
- Recent alerts
- Quick access to marks, attendance, and risk details

---

## 🧠 Natural Language Query System

### Supported Query Patterns

1. **Low Attendance Queries**
   - "show students with attendance below 60%"
   - "find students having attendance less than 75%"

2. **Failing Student Queries**
   - "list students failing in database course"
   - "show students with grade F"

3. **Course-specific Queries**
   - "show students in CS201 course"
   - "find students of database systems"

4. **Top Performer Queries**
   - "show top performing students"
   - "list best students"

5. **Low Marks Queries**
   - "students with marks below 40"
   - "show students having less than 50 marks"

6. **Risk Analysis Queries**
   - "show high risk students"
   - "list students at academic risk"

### How It Works
1. User enters natural language query
2. NLP Parser matches regex patterns
3. SQL query is generated
4. Results are displayed in table format
5. Query history is saved in database

---

## 🤖 Machine Learning Risk Prediction

### Features Used
- **Attendance Percentage** (0-100)
- **Internal Marks** (0-50)
- **External Marks** (0-50)

### Prediction Output
- **Risk Level:** Low Risk, Medium Risk, or High Risk
- **Risk Score:** 0-1 (higher = more risk)
- **Recommendations:** Personalized suggestions for improvement

### ML Model Details
- **Algorithm:** Random Forest Classifier
- **Framework:** scikit-learn
- **Deployment:** Flask REST API

### Model Training
```bash
cd ml_service
python train_model.py
```

### API Endpoint
**POST** `/predict-risk`

Request:
```json
{
    "attendance_percentage": 85,
    "internal_marks": 40,
    "external_marks": 35
}
```

Response:
```json
{
    "risk_level": "Low Risk",
    "risk_score": 0.15,
    "recommendations": [
        "Continue maintaining good performance."
    ]
}
```

---

## 📁 Project Structure

```
eduinsight-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── AdminDashboardController.php
│   │   │   ├── FacultyDashboardController.php
│   │   │   ├── StudentDashboardController.php
│   │   │   ├── NlQueryController.php
│   │   │   └── MlRiskPredictionController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Student.php
│   │   ├── Faculty.php
│   │   ├── Course.php
│   │   ├── Enrollment.php
│   │   ├── Mark.php
│   │   ├── Attendance.php
│   │   ├── AcademicRisk.php
│   │   ├── Alert.php
│   │   └── NlQuery.php
│   └── Services/
│       └── NlpQueryParser.php
├── database/
│   ├── migrations/
│   │   ├── *_create_roles_table.php
│   │   ├── *_create_users_table.php
│   │   ├── *_create_faculty_table.php
│   │   ├── *_create_students_table.php
│   │   ├── *_create_courses_table.php
│   │   ├── *_create_enrollments_table.php
│   │   ├── *_create_marks_table.php
│   │   ├── *_create_attendance_table.php
│   │   ├── *_create_academic_risk_table.php
│   │   ├── *_create_alerts_table.php
│   │   └── *_create_nl_queries_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── auth/
│   │   └── login.blade.php
│   ├── admin/
│   │   ├── dashboard.blade.php
│   │   ├── students.blade.php
│   │   ├── courses.blade.php
│   │   └── alerts.blade.php
│   ├── faculty/
│   │   └── dashboard.blade.php
│   ├── student/
│   │   ├── dashboard.blade.php
│   │   ├── marks.blade.php
│   │   ├── attendance.blade.php
│   │   ├── risk-prediction.blade.php
│   │   └── alerts.blade.php
│   └── nlp/
│       ├── queries.blade.php
│       ├── create-query.blade.php
│       └── show-query.blade.php
├── routes/
│   └── web.php
├── ml_service/
│   ├── app.py
│   ├── train_model.py
│   ├── requirements.txt
│   ├── models/
│   │   ├── risk_prediction_model.pkl
│   │   └── scaler.pkl
│   └── README.md
└── .env
```

---

## 🔗 Database Schema

### Tables Overview

| Table | Purpose |
|-------|---------|
| roles | System roles (admin, faculty, student, parent) |
| users | User accounts with role association |
| faculty | Faculty member profiles |
| students | Student profiles with parent linkage |
| courses | Course definitions with faculty assignment |
| enrollments | Student-course enrollment records |
| marks | Student grades and assessment scores |
| attendance | Attendance records per student per course |
| academic_risk | ML risk predictions |
| alerts | System-generated alerts for students |
| nl_queries | Natural language query history |

---

## 🔐 Security Features

- Password hashing with bcrypt
- Role-based middleware protection
- Session management
- CSRF token protection
- SQL injection prevention (Eloquent ORM)

---

## 📝 API Endpoints

### Authentication
- `POST /login` - User login
- `POST /logout` - User logout

### Admin Routes
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/students` - Student list
- `GET /admin/courses` - Course list
- `GET /admin/alerts` - System alerts

### Faculty Routes
- `GET /faculty/dashboard` - Faculty dashboard
- `GET /faculty/course/{id}` - Course details
- `POST /faculty/marks` - Add student marks
- `POST /faculty/attendance` - Record attendance

### Student Routes
- `GET /student/dashboard` - Student dashboard
- `GET /student/marks` - View marks
- `GET /student/attendance` - View attendance
- `GET /student/risk-prediction` - Risk analysis
- `GET /student/alerts` - View alerts

### NLP Routes
- `GET /nlp/queries` - Query history
- `GET /nlp/create` - Create new query
- `POST /nlp/store` - Submit query
- `GET /nlp/query/{id}` - View query result

---

## 🛠️ Development & Debugging

### Clear Cache
```bash
php artisan cache:clear
```

### Check Model Relationships
```bash
php artisan tinker
> $student = App\Models\Student::first();
> $student->marks;
> $student->attendances;
```

### View Database Queries (enable in config/app.php)
```php
'debug' => true,
```

---

## 📊 Key Features Checklist

- [x] Multi-role authentication system
- [x] Admin dashboard with charts
- [x] Faculty course management
- [x] Student performance tracking
- [x] Natural language query parser
- [x] ML-based risk prediction
- [x] Automated alerts system
- [x] Attendance tracking
- [x] Mark management
- [x] Bootstrap responsive UI
- [x] Chart.js visualizations

---

## 🚀 Future Enhancements

1. Email notifications for alerts
2. Parent dashboard
3. Student-teacher messaging
4. Advanced ML models (Deep Learning)
5. Predictive analytics
6. Mobile app integration
7. API rate limiting
8. Admin audit logging
9. Data export features
10. Real-time notifications

---

## 📞 Support

For issues or questions:
1. Check the logs: `storage/logs/laravel.log`
2. Review migrations: `php artisan migrate:status`
3. Run seeders: `php artisan db:seed`

---

## 📄 License

This project is for educational purposes.

---

**Version:** 1.0.0  
**Last Updated:** March 2026
