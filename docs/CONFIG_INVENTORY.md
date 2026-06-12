# IRENG17 Config Inventory

## Environment Files

- `.env.example`: default local template.
- `.env.production.example`: production-safe template for new servers.
- `.env`: local/runtime only, ignored by git.

## Required Production ENV Keys

Core:

- `APP_NAME`
- `APP_ENV`
- `APP_KEY`
- `APP_DEBUG`
- `APP_URL`
- `AMP_URL`

Database:

- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

Runtime:

- `CACHE_DRIVER`
- `FILESYSTEM_DISK`
- `QUEUE_CONNECTION`
- `SESSION_DRIVER`
- `SESSION_LIFETIME`
- `SESSION_SECURE_COOKIE`

TopPayment:

- `TOPPAYMENT_MERCHANT_CODE`
- `TOPPAYMENT_PRIVATE_KEY_PATH`
- `TOPPAYMENT_PUBLIC_KEY_PATH`
- `TOPPAYMENT_API_URL`
- `TOPPAYMENT_QUERY_URL`
- `TOPPAYMENT_NOTIFY_URL`
- `JAYAPAY_MERCHANT_CODE`
- `JAYAPAY_PRIVATE_KEY_PATH`
- `JAYAPAY_PUBLIC_KEY_PATH`
- `JAYAPAY_API_URL`
- `JAYAPAY_QUERY_URL`
- `JAYAPAY_NOTIFY_URL`

GGR:

- `GGR_API_URL`
- `GGR_AGENT_CODE`
- `GGR_AGENT_TOKEN`

Catatan: class legacy `App\Http\Api\fiver` membaca konfigurasi aktif dari table `api`
(`nx_endpoint`, `nx_agent_code`, `nx_token`). Endpoint GGR harus diambil dari halaman
profile agent `https://{SERVER}/app/profile`.

Mail:

- `MAIL_MAILER`
- `MAIL_HOST`
- `MAIL_PORT`
- `MAIL_USERNAME`
- `MAIL_PASSWORD`
- `MAIL_ENCRYPTION`
- `MAIL_FROM_ADDRESS`
- `MAIL_FROM_NAME`

## Database Dumps

- `database/miscqccc_jarot.sql`
  - Full local dump.
  - Contains table structure and seed/runtime data.
  - May contain credential, member, transaction, and password-hash data.
  - Keep local or transfer manually over a private channel. Do not commit to a public repository.

- `database/ireng17_schema.sql`
  - Schema-only dump generated from `miscqccc_jarot.sql`.
  - No `INSERT` statements.
  - Use this only when you want a clean database.

- `database/ireng17_minimal_seed.sql`
  - Minimal non-secret seed for clean database deployments.
  - Creates base `genral_settings` and empty `api` row.
  - Does not contain user passwords, API tokens, or transaction data.

## Tables From `ireng17_schema.sql`

- `api`
- `banks`
- `banner`
- `banner_promosi`
- `bonuses`
- `bonus_lama`
- `failed_jobs`
- `fiver_games`
- `fiver_games2`
- `game_list`
- `game_lists`
- `game_users`
- `games`
- `game_transaction`
- `genral_settings`
- `history`
- `migrations`
- `networks`
- `password_resets`
- `password_reset_tokens`
- `personal_access_tokens`
- `promosi`
- `saldo`
- `saldo_log`
- `slot_game_histories`
- `spins`
- `tb_gamenew`
- `transaksi`
- `users`
- `user_logins`
- `vouchers`
- `w_gamelists`

## Tables Added/Guaranteed By Migration

- `ggr_providers`
- `ggr_games`

Run after importing SQL:

```bash
php artisan migrate --force
```

## Database Config Tables

These tables hold application settings after import:

- `genral_settings`: website name, logo, SEO, payment/deposit/withdraw settings, maintenance mode.
- `api`: legacy game API config used by `App\Http\Api\fiver`.
- `banks`: manual transfer bank/e-wallet config.
- `banner`, `banner_promosi`, `bonuses`: frontend promotion content.

## Role Mapping

The app uses `users.level`.

- `NULL`: normal user.
- `1`: admin.
- `2`: developer/super admin.

Backoffice middleware allows `1` and `2`.
Developer-only menu allows only `2`.

## Runtime Files Not Committed

Upload/generate these on the server:

- `.env`
- `storage/app/toppayment_private.pem`
- `storage/app/toppayment_public.pem`
- `public/storage` symlink from `php artisan storage:link`
- runtime uploads under `storage/app/public`
- cache files under `bootstrap/cache`

## Public Root

Point the web server document root to:

```text
/path/to/project/public
```

Do not expose the project root as the public web root.
