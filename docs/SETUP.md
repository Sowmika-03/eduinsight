# EduInsight - Setup Instructions

## Installation Guide for Your Friend

### Requirements
- PHP 8.2+
- MySQL/MariaDB
- Composer
- Node.js

### Installation Steps

1. **Extract the zip file**
   ```bash
   unzip eduinsight-app.zip
   cd eduinsight-app
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Node Dependencies**
   ```bash
   npm install
   ```

4. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database in .env**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=eduinsight
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed Database (Optional)**
   ```bash
   php artisan db:seed
   ```

8. **Build Assets**
   ```bash
   npm run build
   ```

9. **Start Development Server**
   ```bash
   php artisan serve
   ```

Visit: **http://localhost:8000**

### Login Credentials
- **Admin:** admin@example.com / password
- **HOD:** hod@example.com / password
- **Faculty:** faculty@example.com / password
- **Student:** student@example.com / password

### Troubleshooting
- If you get permission errors, run: `php artisan storage:link`
- For database errors, ensure MySQL is running
- Check `.env` file is properly configured
