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
- `database/ireng17_full_dump.sql`: full dump schema + data terbaru untuk import cepat, terutama shared hosting tanpa terminal.
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

Pilihan A, deploy dengan data terbaru dari full dump:

```bash
mysql -u USER -p ireng17 < database/ireng17_full_dump.sql
php artisan migrate --force
```

Pilihan B, deploy dengan data awal dari dump lokal lama:

```bash
mysql -u USER -p ireng17 < database/miscqccc_jarot.sql
php artisan migrate --force
```

Pilihan C, deploy schema kosong:

```bash
mysql -u USER -p ireng17 < database/ireng17_schema.sql
php artisan migrate --force
mysql -u USER -p ireng17 < database/ireng17_minimal_seed.sql
```

Catatan:

- `database/ireng17_schema.sql` tidak membawa data admin, setting website, bank, game, atau transaksi.
- `database/ireng17_minimal_seed.sql` hanya membuat setting dasar dan row `api` kosong tanpa credential.
- Untuk production yang langsung jalan, gunakan `database/ireng17_full_dump.sql` secara manual lalu ubah kredensial admin dan setting dari backoffice.
- Full dump bisa berisi password hash, transaksi, setting, dan data runtime. Jangan bagikan repository atau file dump ke publik jika data tersebut sensitif.
- Migration tetap wajib dijalankan setelah import dump untuk memastikan tabel/kolom runtime terbaru seperti `ggr_providers` dan `ggr_games` tersedia.

## 4A. Shared Hosting Tanpa Terminal

Jika cPanel/shared hosting tidak menyediakan terminal atau SSH:

1. Jalankan `composer install --no-dev --optimize-autoloader` di lokal.
2. Upload seluruh project ke hosting, termasuk folder `vendor`.
3. Idealnya arahkan document root domain ke folder `public`.
4. Jika document root tidak bisa diarahkan ke `public`, simpan folder Laravel di luar `public_html`, lalu pindahkan isi folder `public` ke `public_html`. Sesuaikan path `require` di `public_html/index.php` jika struktur folder berubah.
5. Buat database dan user MySQL dari cPanel.
6. Import `database/ireng17_full_dump.sql` lewat phpMyAdmin.
7. Copy `.env.production.example` menjadi `.env` lewat File Manager.
8. Isi `.env` sesuai hosting:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com
AMP_URL=https://domain-anda.com/amp
DB_DATABASE=nama_database
DB_USERNAME=user_database
DB_PASSWORD=password_database
SESSION_SECURE_COOKIE=true
```

9. Buat `APP_KEY` dari lokal:

```bash
php artisan key:generate --show
```

Paste hasilnya ke `APP_KEY` di `.env` hosting.

10. Upload file key TopPayment manual ke `storage/app` jika payment aktif:

- `storage/app/toppayment_private.pem`
- `storage/app/toppayment_public.pem`
- `storage/app/cacert.pem` jika hosting bermasalah dengan CA SSL.

11. Pastikan folder berikut writable dari File Manager atau fitur permission hosting:

- `storage`
- `storage/logs`
- `storage/framework/cache`
- `storage/framework/sessions`
- `storage/framework/views`
- `bootstrap/cache`
- `public/image-cache`
- `public/storage`

12. Jika `php artisan storage:link` tidak bisa dijalankan, gunakan fitur symlink hosting bila tersedia. Jika tidak tersedia, copy isi `storage/app/public` ke `public/storage` setiap kali ada upload logo, banner, atau asset backoffice.
13. Jika hosting menyediakan Cron Jobs, isi command ini untuk scheduler:

```text
* * * * * /usr/local/bin/php /home/USER/path-ireng17/artisan schedule:run >> /dev/null 2>&1
```

Jika cron tidak tersedia, fitur utama web tetap jalan. Sinkronisasi provider/game dan pengecekan tertentu perlu dijalankan dari backoffice atau dilakukan manual.

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
   - `TOPPAYMENT_*` / `JAYAPAY_*` alias
   - `LUCKY_SPIN_PRIZES` jika fitur lucky spin dipakai, contoh `1000,2000,5000`

2. Database table `api`
   - `nx_agent_code`
   - `nx_token`
   - `nx_endpoint`
   - dan field provider legacy lain.

Class legacy `App\Http\Api\fiver` membaca data dari table `api`, bukan dari `.env`.
Pastikan row pertama table `api` sudah berisi endpoint, agent code, dan token yang benar.
Sesuai dokumentasi GGR, `nx_endpoint` harus diisi dari halaman profile agent:
`https://{SERVER}/app/profile` bagian `API Endpoint`. Dokumentasi tidak menetapkan domain API publik statis.

## 7. Payment Gateway

TopPayment dibaca dari `.env` lewat `config/jayapay.php`. Prefix `JAYAPAY_*` masih dipertahankan sebagai alias kompatibilitas.

Minimal:

```env
TOPPAYMENT_MERCHANT_CODE=isi_merchant_code
TOPPAYMENT_PRIVATE_KEY_PATH=storage/app/toppayment_private.pem
TOPPAYMENT_PUBLIC_KEY_PATH=storage/app/toppayment_public.pem
TOPPAYMENT_API_URL=https://global-id-openapi.toppayment.com/id/pay/prePay
TOPPAYMENT_QUERY_URL=https://global-id-openapi.toppayment.com/id/pay/query
TOPPAYMENT_NOTIFY_URL=https://domain-anda.com/api/jayapay/callback
```

File key tidak ikut git. Upload manual ke:

- `storage/app/toppayment_private.pem`
- `storage/app/toppayment_public.pem`

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
- TopPayment callback mengarah ke domain production.
- Permission `storage` dan `bootstrap/cache` writable.
