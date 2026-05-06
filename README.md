# 🎓 EduInsight - Natural Language Decision Support System

A comprehensive full-stack educational management system combining Laravel, Python ML, and NLP.

**Version:** 1.0.0 | **Status:** ✅ Production Ready

---

## 🌟 Key Features

### 1. **Multi-Role Authentication**
- Admin, Faculty, Student, Parent roles
- Secure password encryption
- Role-based middleware protection

### 2. **Natural Language Query System**
Convert plain English to SQL queries:
- "Show students with attendance below 60%"
- "List students failing in courses"
- "Show top performing students"

### 3. **ML Risk Prediction**
- Scikit-learn Random Forest model
- Risk scoring: Low/Medium/High
- Personalized recommendations

### 4. **Comprehensive Dashboards**
- Admin: System analytics & management
- Faculty: Course & student monitoring
- Student: Personal progress tracking

### 5. **Beautiful Bootstrap UI**
- Chart.js visualizations
- Responsive design
- Modern gradient colors

---

## 🛠️ Tech Stack

| Component | Technology |
|-----------|------------|
| Backend | Laravel 10, PHP 8.1+ |
| Database | MySQL 5.7+ |
| Frontend | Blade, Bootstrap 5 |
| Analytics | Chart.js |
| ML/AI | Python, Scikit-learn, Flask |
| NLP | Rule-based pattern matching |

---

## 🚀 Quick Start

### 1. Setup
```bash
cd c:\xampp\htdocs\eduinsight-app
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 2. Run Applications
```bash
# Terminal 1: Laravel
php artisan serve
# http://localhost:8000

# Terminal 2: Flask ML API
cd ml_service
pip install -r requirements.txt
python train_model.py
python app.py
# http://localhost:5000
```

### 3. Login
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@eduinsight.com | password |
| Faculty | john.smith@eduinsight.com | password |
| Student | student1@eduinsight.com | password |

---

## 📊 Database Schema

11 Core Tables with relationships:
- `roles`, `users` - Authentication
- `faculty`, `students` - User profiles
- `courses`, `enrollments` - Academics
- `marks`, `attendance` - Performance
- `academic_risk`, `alerts` - Predictions
- `nl_queries` - Query history

---

## 📁 Project Structure

```
eduinsight-app/
├── app/Http/Controllers/         # 6 controllers
├── app/Models/                   # 11 models
├── app/Services/NlpQueryParser   # NLP engine
├── database/migrations/          # 13 migrations
├── database/seeders/             # Sample data
├── resources/views/              # 15+ Blade templates
├── routes/web.php                # All routes
├── ml_service/                   # Flask API
│   ├── app.py                    # ML service
│   ├── train_model.py           # Model training
│   └── requirements.txt
├── SETUP_GUIDE.md               # Detailed guide
└── README.md
```

---

## 🔑 Key Endpoints

**Admin:** `/admin/dashboard`, `/admin/students`, `/admin/courses`  
**Faculty:** `/faculty/dashboard`, `/faculty/course/:id`  
**Students:** `/student/dashboard`, `/student/marks`, `/student/attendance`  
**NLP:** `/nlp/queries`, `/nlp/create`  
**ML API:** `POST /predict-risk`, `GET /health`

---

## 🧠 Natural Language Examples

✅ "Show students with attendance below 60%"  
✅ "List students failing in CS201"  
✅ "Show top performing students"  
✅ "Students with high academic risk"  
✅ "Find students in web development course"

---

## 🤖 ML Model

**Algorithm:** Random Forest (100 trees)  
**Input Features:** Attendance %, Internal Marks, External Marks  
**Output:** Risk Level + Score (0-1) + Recommendations  

Risk Levels:
- 🟢 Low Risk (< 0.33)
- 🟡 Medium Risk (0.33-0.67)
- 🔴 High Risk (> 0.67)

---

## 📈 Dashboards

### Admin Dashboard
📊 System statistics • 📈 Risk charts • 👥 Student management • 🔔 Alert monitoring

### Faculty Dashboard
📚 My courses • 👥 Student list • ⚠️ Low attendance alerts • 📝 Mark management

### Student Dashboard
📖 My courses • 📝 My marks • ✅ Attendance • ⚠️ Risk analysis • 🔔 Alerts

---

## 🔐 Security

✅ bcrypt password hashing  
✅ CSRF protection  
✅ SQL injection prevention  
✅ Role-based access control  
✅ Session management  
✅ Secure credentials  

---

## 📚 Documentation

- **SETUP_GUIDE.md** - Complete setup instructions
- **ml_service/README.md** - ML API details
- **This file** - Quick reference

---

## ✨ Features Checklist

- [x] Multi-role authentication
- [x] 6 Controllers (Auth, Admin, Faculty, Student, NLP, ML)
- [x] 11 Database models
- [x] 11 Database tables with relationships
- [x] 15+ Blade views
- [x] Bootstrap 5 UI
- [x] Chart.js visualization
- [x] Natural language query parser
- [x] Machine learning API
- [x] Risk prediction system
- [x] Automated alerts
- [x] Complete seeder

---

## 🚀 Deployment Ready

All components are production-ready:
- ✅ Database migrations
- ✅ Model relationships
- ✅ Route protection
- ✅ Error handling
- ✅ Data validation
- ✅ Security best practices

---

## 📄 License

Educational project - 2026

---

**Last Updated:** March 9, 2026  
**Status:** Fully Functional ✅

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
