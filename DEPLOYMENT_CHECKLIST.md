# Deployment Checklist

Complete these steps to deploy the EduInsight extended features to production.

## Pre-Deployment

- [ ] All tests passing
- [ ] Code reviewed
- [ ] Database backup created
- [ ] SSL certificate valid
- [ ] Production mail service configured
- [ ] Environment variables updated

## Database

- [ ] Run all migrations:
  ```bash
  php artisan migrate --force
  ```

- [ ] Verify new tables created:
  ```bash
  php artisan migrate:status
  ```

- [ ] Backup critical data

## Configuration

- [ ] Update .env with production mail credentials
- [ ] Configure MAIL_MAILER (smtp/sendgrid/ses)
- [ ] Set MAIL_FROM_ADDRESS and MAIL_FROM_NAME
- [ ] Verify APP_URL is correct

## Code Deployment

- [ ] Push code to production
- [ ] Composer install: `composer install --optimize-autoloader`
- [ ] Cache config: `php artisan config:cache`
- [ ] Cache routes: `php artisan route:cache`
- [ ] Cache views: `php artisan view:cache`

## Test in Production

- [ ] Send test email:
  ```bash
  php artisan tinker
  >>> Mail::raw('Test', function($m) { $m->to('test@example.com'); })
  ```

- [ ] Verify email received

- [ ] Test all new features manually

## Scheduling

- [ ] Add cron job for alerts:
  ```bash
  * * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1
  ```

- [ ] Verify cron is running:
  ```bash
  sudo service cron status
  ```

## Monitoring

- [ ] Check application logs
- [ ] Monitor email delivery rates
- [ ] Track database performance
- [ ] Set up error alerts

## Rollback Plan

If issues occur:
```bash
php artisan migrate:rollback
# Or specific migration:
php artisan migrate:rollback --step=5
```

## Documentation

- [ ] Update team on new features
- [ ] Create user guide for admins
- [ ] Set up help desk tickets template
- [ ] Train support staff

---

## Post-Deployment

- [ ] Monitor for 24 hours
- [ ] Check email delivery
- [ ] Verify all features working
- [ ] Performance testing
- [ ] User feedback collection

✓ All steps complete - Ready for production!
