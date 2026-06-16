# Laravel Esport Tournament Starter

Public-safe Laravel starter for small esports tournament communities. It includes local auth, teams, tournament registration, admin approval, and a simple demo bracket flow without private SaaS or monetization features.

This repository is intentionally shaped for public collaboration and learning. It is not a mirror of any private commercial product, and it stays inside a narrow starter scope.

## What It Includes

- Email/password registration and login
- Team creation and roster placeholders
- Tournament creation for admins
- Team registration requests for tournaments
- Admin approval and rejection of registrations
- Demo bracket generation from approved teams
- Simple match result entry
- SQLite-first local development setup
- Laravel Sail support for Docker-based local development

## Requirements

- PHP 8.3+
- Composer 2
- Node.js 22+ and npm
- SQLite 3

Optional:

- Docker Desktop or Docker Engine for Laravel Sail

## Local Setup

1. Install PHP and JavaScript dependencies.

```bash
composer install
npm ci
```

2. Create the local environment file.

```bash
cp .env.example .env
```

3. Create the SQLite database file used by `.env.example`.

```bash
touch database/database.sqlite
```

4. Generate the app key and prepare the database-backed session, cache, and queue tables.

```bash
php artisan key:generate
php artisan migrate --seed
```

5. Build frontend assets and start the local server.

```bash
npm run build
php artisan serve
```

The app will usually be available at [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Laravel Sail / Docker Setup

Use this path if you prefer Docker-managed PHP and Node tooling. The included `compose.yaml` starts the Laravel app container plus MySQL and Mailpit services, but the default `.env.example` still points the app itself at SQLite unless you change it.

1. Create the environment file and install PHP dependencies.

```bash
cp .env.example .env
composer install
```

2. Start Sail.

```bash
./vendor/bin/sail up -d
```

3. Generate the key, create the SQLite file, migrate, and build assets.

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan tinker --execute="if (! file_exists(database_path('database.sqlite'))) { touch(database_path('database.sqlite')); }"
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm ci
./vendor/bin/sail npm run build
```

4. Open the app at [http://localhost](http://localhost) or `http://localhost:${APP_PORT}` if you changed `APP_PORT`.

If you prefer Vite watch mode during development, use `npm run dev` locally or `./vendor/bin/sail npm run dev` with Sail.

## Tests and Local Checks

```bash
composer validate --no-check-lock
php artisan test
npm run build
```

`phpunit.xml` uses in-memory SQLite for tests, so the test suite does not depend on the local `database/database.sqlite` file.

## Demo Accounts

Seeder-created demo accounts:

- Admin: `admin@example.com` / `password`
- Player: `player@example.com` / `password`

These accounts are for local demos only.

## Screenshots

This repository does not ship production screenshots or private product images.

If you want visuals in a fork or a future documentation PR, use:

- Local development screenshots created from this public starter
- Clearly labeled placeholder image slots in docs or issues

Avoid fake UI images, private admin data, or screenshots from non-public systems.

## Troubleshooting

`database/database.sqlite` missing:

- Create it with `touch database/database.sqlite` before running `php artisan migrate --seed`.

`could not find driver` or SQLite connection errors:

- Make sure the PHP SQLite extensions are installed and enabled for your CLI PHP runtime.

Session, cache, or queue table errors after a fresh clone:

- Run `php artisan migrate --seed` so the database-backed tables from `.env.example` are created.

Frontend asset errors or missing `public/build` files:

- Run `npm ci` and then `npm run build`.

Sail command not found:

- Run `composer install` first so `./vendor/bin/sail` exists.

WSL or Linux permissions oddities:

- Confirm the current user can write to `.env`, `database/database.sqlite`, and `storage/`.

## Public-Safety Boundary

This starter deliberately excludes:

- Payment provider integrations
- Real-money wallet logic
- Payouts, prize finance, or billing flows
- Subscription logic
- Tenant monetization or private SaaS workflows
- Production credentials, customer data, SQL dumps, and private assets
- Private business copy, internal screenshots, and non-public branding

Contributions should stay within the public starter scope: tournaments, teams, registration, approval flow, demo brackets, match results, tests, accessibility, and documentation.

## License

AGPL-3.0-or-later. See `LICENSE`.
