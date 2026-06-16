# Laravel Esport Tournament Starter

Public-safe Laravel starter for small esports tournament communities. It includes basic email/password auth, teams, tournaments, registration approval, and a demo match result flow.

This repository is intentionally not a mirror of any private commercial SaaS project. It excludes wallet monetization, payment providers, subscription billing, tenant rent workflows, production data, private assets, and commit history.

## Features

- User registration and login
- Team creation and roster placeholders
- Tournament creation by admins
- Team registration requests for tournaments
- Admin approval for registrations
- Demo bracket generation from approved teams
- Simple match result entry
- SQLite-first local setup
- Laravel Sail compatible Docker Compose
- Demo seeder data only

## Quick Start

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Demo admin:

- Email: `admin@example.com`
- Password: `password`

Demo user:

- Email: `player@example.com`
- Password: `password`

## Sail

```bash
cp .env.example .env
composer install
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

## Public-Safety Boundary

The starter deliberately has no real-money wallet, payouts, subscriptions, tenant billing, payment webhooks, provider credentials, production mail credentials, SQL dumps, logs, private screenshots, or private brand assets.

## License

AGPL-3.0-or-later. See `LICENSE`.
