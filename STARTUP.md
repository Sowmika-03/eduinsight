# EduInsight - Quick Start Guide

## Prerequisites

- PHP 8.1+
- MySQL 5.7+
- Composer
- Node.js (optional, for frontend assets)
- XAMPP or similar local server environment

---

## Installation & Setup

### 1. Clone/Extract Project

```bash
cd C:\xampp\htdocs\eduinsight-app
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Setup Environment File

Rename `.env.example` to `.env` (or copy it):

```bash
copy .env.example .env
```

**If `.env` already exists, verify these settings:**

```env
APP_NAME=EduInsight
APP_ENV=local
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eduinsight
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Start MySQL Server

**Option A: Using XAMPP Control Panel**
- Open `C:\xampp\xampp-control-panel.exe`
- Click "Start" for MySQL

**Option B: Command Line**
```bash
"C:\xampp\mysql\bin\mysqld.exe"
```

### 6. Run Database Migrations

```bash
php artisan migrate
```

This creates all required tables for the new features.

---

## Running the Project

### Start Laravel Development Server

```bash
php artisan serve
```

**Output will show:**
```
   INFO  Server running on http://127.0.0.1:8000
```

### Access Application

Open your browser and go to:

```
http://127.0.0.1:8000
```

---

## Quick Commands

| Command | Purpose |
|---------|---------|
| `php artisan serve` | Start Laravel server |
| `php artisan migrate` | Run database migrations |
| `php artisan alerts:check` | Run alert checks manually |
| `php artisan tinker` | Interactive console |
| `php artisan db:seed` | Seed test data (if seeders exist) |

---

## Features Available

✅ **Email Notification System** - Send emails to students/parents  
✅ **Enhanced NLP Queries** - Execute queries and view formatted results  
✅ **Query Result Dashboard** - Display results in tables & charts  
✅ **Automated Alerts** - Auto-detect low attendance/marks and send notifications  

---

## Troubleshooting

### MySQL Connection Error
```
Error: SQLSTATE[HY000] [2002] No connection could be made...
```

**Solution:** Start MySQL server before running the project.

### Port 8000 Already in Use
```bash
php artisan serve --port=8001
```

Then visit: `http://127.0.0.1:8001`

### Database Not Found
```bash
# Create database manually
mysql -u root -e "CREATE DATABASE IF NOT EXISTS eduinsight;"
php artisan migrate
```

### Permissions Error
```bash
# Clear cache and rebuild
php artisan cache:clear
php artisan config:clear
php artisan migrate:refresh
```

---

## Default Credentials

Check the database or use Laravel Tinker to create a test user:

```bash
php artisan tinker
>>> php shell code
```

---

## Project Structure

```
eduinsight-app/
├── app/
│   ├── Controllers/        # Application controllers
│   ├── Models/             # Database models
│   ├── Mail/               # Mailable classes for emails
│   ├── Services/           # Business logic services
│   └── Console/Commands/   # Artisan commands
├── database/
│   ├── migrations/         # Database schemas
│   └── seeders/           # Test data seeders
├── routes/
│   └── web.php            # Web routes
├── resources/
│   └── views/             # Blade templates
├── config/
│   └── mail.php           # Mail configuration
└── FEATURE_GUIDE.md       # Complete feature documentation
```

---

## Next Steps

1. **Explore Features**
   - Send notifications: `/email/send`
   - View history: `/email/history`
   - Try NLP queries: `/nlp/create`

2. **Read Documentation**
   - `FEATURE_GUIDE.md` - Complete feature guide
   - `NLP_QUERY_EXAMPLES.md` - Query examples
   - `EMAIL_QUICKSTART.md` - Email setup

3. **Configure Mail Service** (Optional)
   - Update `.env` with real SMTP credentials
   - See `FEATURE_GUIDE.md` for providers

---

## Support

For issues or questions, refer to:
- `FEATURE_GUIDE.md` - Detailed documentation
- `EMAIL_QUICKSTART.md` - Email configuration
- `NLP_QUERY_EXAMPLES.md` - Query reference
