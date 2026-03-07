# Quickstart: Family Restrictions MVP

## Prerequisites

- PHP 8+
- Composer
- MySQL
- Node.js (for frontend assets)

## Setup

1. Copy environment file:
   - `cp .env.example .env`
2. Configure database in `.env`:
   - `DB_CONNECTION=mysql`
   - `DB_HOST=127.0.0.1`
   - `DB_PORT=3306`
   - `DB_DATABASE=grounded_time`
   - `DB_USERNAME=...`
   - `DB_PASSWORD=...`
3. Install dependencies:
   - `composer install`
   - `npm install`
4. Generate app key:
   - `php artisan key:generate`
5. Run migrations:
   - `php artisan migrate`
6. Build frontend assets:
   - `npm run build`

## Run the App

- `php artisan serve`
- Visit `http://127.0.0.1:8000`

## Run Tests (TDD)

- `php artisan test`
- Example filtered run: `php artisan test --filter Restriction`

## Scheduler and Queues

- Start queue worker: `php artisan queue:work`
- Run scheduler locally: `php artisan schedule:work`

## Localization

- Supported locales: `pt_BR`, `en`, `es`
- Default locale: `pt_BR`
- Fallback locale: `en`

## Email

Configure email provider in `.env` (Mailgun, SendGrid, SMTP). For local dev, you can use Mailpit or log driver:

- `MAIL_MAILER=log`

## GDPR Exports

Export files are generated asynchronously and stored in private disk storage with temporary URLs.
