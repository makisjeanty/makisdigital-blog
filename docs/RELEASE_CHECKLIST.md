# Release Checklist

## 1. Security

- Confirm `APP_ENV=production` and `APP_DEBUG=false`.
- Rotate and validate production secrets:
  - `MERCADOPAGO_ACCESS_TOKEN`
  - `MERCADOPAGO_WEBHOOK_TOKEN`
- Confirm webhook endpoints are reachable over HTTPS:
  - `POST /mercadopago/webhook?token=<MERCADOPAGO_WEBHOOK_TOKEN>`
- Ensure no diagnostic/admin maintenance routes are publicly exposed.

## 2. Build and Cache

- Install dependencies in production mode.
- Run migrations with backup/rollback plan.
- Build frontend assets.
- Clear and rebuild Laravel caches:
  - `php artisan optimize:clear`
  - `php artisan config:cache`
  - `php artisan route:cache`
  - `php artisan view:cache`

## 3. Validation

- Run smoke tests:
  - Home, Blog, Courses pages load.
  - Contact form and newsletter submission behave normally.
  - Admin login and dashboard access work.
- Payment smoke tests:
  - Mercado Pago checkout creation works.
  - Success URL without valid payment is rejected.
  - Valid webhook enrolls expected user/course only.
- Check logs for errors after deploy (`storage/logs/laravel.log`).

## 4. Operational

- Verify backups and restore procedure.
- Confirm queue worker status (if enabled).
- Monitor application health and error rate after release.
