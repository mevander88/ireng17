# IRENG17 Deployment Guide

Dokumen ini menjelaskan konfigurasi minimum untuk deploy project Laravel ini ke server baru.

## 1. Kebutuhan Server

- PHP 8.1 atau lebih baru.
- Composer 2.
- MySQL/MariaDB.
- Node.js 18+ hanya jika perlu build asset Vite.
- Web server Apache/Nginx dengan document root mengarah ke folder `public`.
- PHP extension umum Laravel: `bcmath`, `ctype`, `curl`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `zip`, `gd`.

## 2. File Penting

- `.env.production.example`: template environment production.
- `database/miscqccc_jarot.sql`: full database dump lokal lama, termasuk data awal. File ini mengandung data runtime/credential, jadi jangan dipush ke repository publik.
- `database/ireng17_schema.sql`: schema-only dump, tanpa `INSERT`.
- `database/ireng17_minimal_seed.sql`: seed minimal non-secret untuk clean install.
- `database/migrations/*`: migration runtime tambahan, termasuk tabel GGR.
- `public/assets/images/logo.png`: logo utama.
- `public/favicon.ico`, `public/assets/images/favicon-*.png`, `public/apple-touch-icon.png`: favicon dari logo.

## 3. Setup Project

```bash
git clone https://github.com/mevander88/ireng17.git
cd ireng17
composer install --no-dev --optimize-autoloader
cp .env.production.example .env
php artisan key:generate
```

Edit `.env` sesuai server:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com
DB_DATABASE=ireng17
DB_USERNAME=...
DB_PASSWORD=...
SESSION_SECURE_COOKIE=true
```

Jika deploy belum HTTPS, set sementara `SESSION_SECURE_COOKIE=false`.

## 4. Database

Pilihan A, deploy dengan data awal dari dump lokal:

```bash
mysql -u USER -p ireng17 < database/miscqccc_jarot.sql
php artisan migrate --force
```

Pilihan B, deploy schema kosong:

```bash
mysql -u USER -p ireng17 < database/ireng17_schema.sql
php artisan migrate --force
mysql -u USER -p ireng17 < database/ireng17_minimal_seed.sql
```

Catatan:

- `database/ireng17_schema.sql` tidak membawa data admin, setting website, bank, game, atau transaksi.
- `database/ireng17_minimal_seed.sql` hanya membuat setting dasar dan row `api` kosong tanpa credential.
- Untuk production yang langsung jalan, gunakan full dump lokal secara manual lalu ubah kredensial admin dan setting dari backoffice.
- Jangan commit full dump berisi token, password hash, transaksi, atau data member.
- Migration tetap wajib dijalankan setelah import dump untuk memastikan tabel/kolom runtime terbaru seperti `ggr_providers` dan `ggr_games` tersedia.

## 5. Role User

Project memakai kolom `users.level`, bukan kolom `role`.

- User biasa: `level = NULL`
- Admin: `level = 1`
- Developer / super admin: `level = 2`

Contoh membuat akun jadi super admin:

```sql
UPDATE users SET level = 2 WHERE name = 'admin';
```

## 6. API Game

Ada dua sumber konfigurasi API:

1. `.env`
   - `GGR_API_URL`
   - `GGR_AGENT_CODE`
   - `GGR_AGENT_TOKEN`
   - `JAYAPAY_*`

2. Database table `api`
   - `nx_agent_code`
   - `nx_token`
   - `nx_endpoint`
   - dan field provider legacy lain.

Class legacy `App\Http\Api\fiver` membaca data dari table `api`, bukan dari `.env`.
Pastikan row pertama table `api` sudah berisi endpoint, agent code, dan token yang benar.

## 7. Payment Gateway

Jayapay membaca konfigurasi dari `.env` lewat `config/jayapay.php`.

Minimal:

```env
JAYAPAY_MERCHANT_CODE=
JAYAPAY_PRIVATE_KEY_PATH=storage/app/private_pkcs8.pem
JAYAPAY_PUBLIC_KEY_PATH=storage/app/jayapay_public.pem
JAYAPAY_API_URL=https://openapi.jayapayment.com/gateway/prepaidOrder
JAYAPAY_NOTIFY_URL=https://domain-anda.com/api/jayapay/callback
```

File key tidak ikut git. Upload manual ke:

- `storage/app/private_pkcs8.pem`
- `storage/app/jayapay_public.pem`

## 8. Storage dan Permission

```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

Sesuaikan user web server jika bukan `www-data`.

## 9. Optimize Production

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Jika asset Vite dipakai:

```bash
npm ci
npm run build
```

Saat ini banyak asset utama berada langsung di `public`, tetapi build Vite tetap aman dijalankan jika server membutuhkan asset bawaan Laravel.

## 10. Sync Katalog GGR

Setelah `.env` dan table `api` benar:

```bash
php artisan ggr:sync-catalog
```

Atau gunakan Backoffice:

- `/backoffice/ggr`
- Sync Provider
- Sync Game

Frontend membaca data katalog dari tabel lokal agar tidak berat.

## 11. Checklist Setelah Deploy

- `APP_URL` sudah domain production.
- `APP_KEY` sudah dibuat.
- `APP_DEBUG=false`.
- Database bisa connect.
- `php artisan migrate --force` sukses.
- `php artisan storage:link` sukses.
- Logo dan favicon muncul.
- Backoffice bisa login.
- `users.level` admin benar.
- Table `api` berisi credential game API.
- Jayapay callback mengarah ke domain production.
- Permission `storage` dan `bootstrap/cache` writable.
