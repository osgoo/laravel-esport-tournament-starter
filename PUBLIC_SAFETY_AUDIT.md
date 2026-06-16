# Public-Safety Audit

Source inspected: `/home/jojo/msmart/Laravel/e_sport_demo` (`origin` points to `https://github.com/osgoo/esport-contest.git`).

Export target: `/home/jojo/msmart/Laravel/laravel-esport-tournament-starter`.

## Safe To Include

- Clean Laravel application skeleton without `.git` history.
- Basic email/password auth controllers and views.
- Users with simple `admin` / `user` role field.
- Teams, team membership pivot, tournaments, registration approval, and demo match result flow.
- Demo seed data only: `admin@example.com`, `player@example.com`, `Starter Cup`, `Demo Dragons`.
- SQLite-first `.env.example` with dummy values only.
- Docker/Sail-compatible `compose.yaml` with demo-local defaults.
- PHPUnit feature tests that cover starter flows only.
- OSS docs: README, AGPL license, contributing guide, security policy, roadmap.

## Must Remove / Excluded

- Private Git history and source `.git` directory.
- Real `.env`, `.env.testing`, API keys, production credentials, SQL/sqlite dumps, PEM/key/cert files, generated logs, caches.
- `vendor`, `node_modules`, build output, screenshots, Playwright MCP captures, coverage reports, generated IDE helpers.
- Wallets, transactions, deposits, payouts, finance admin workflows, platform earnings.
- Subscription billing, plans, tenant rent, tenant payment verification, tenant provisioning, QPay/payment provider code.
- Private commercial routes, Livewire admin SaaS screens, production release gates, private brand/copy/assets.

## Uncertain / Manual Review Needed

- `LICENSE`: AGPL-3.0-or-later was selected as requested; confirm this is acceptable for the intended public community and contributor model.
- `compose.yaml`: uses dummy MySQL password fallback `password`; acceptable for local Sail demos but should be changed for any hosted environment.
- Laravel config files still contain standard env placeholders such as `AWS_SECRET_ACCESS_KEY`, `MAIL_PASSWORD`, and `REDIS_PASSWORD`; no values are included.
- No browser visual QA was run because this task created a backend starter export and dependencies were intentionally not installed in the export folder.