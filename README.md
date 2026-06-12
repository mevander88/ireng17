# ireng17

ireng17 adalah aplikasi web Laravel untuk lobby game online dengan frontend mobile-first, backoffice admin, integrasi katalog/provider GGR, deposit QRIS TopPayment, manajemen banner/popup/SEO, dan halaman AMP ringan untuk landing page.

Project ini memakai Laravel 10, MySQL/MariaDB, asset publik statis di `public`, dan data katalog game disimpan di database lokal supaya halaman user tidak perlu memanggil API provider setiap request.

## Fitur Utama

- Frontend responsive untuk home, slot, casino, sports, e-games, promotion, register, login, profile, deposit, withdraw, dan history.
- Backoffice admin untuk setting website, appearance/theme, SEO, logo, popup, banner, payment gateway, bank, member, deposit, withdraw, bonus, provider, game, dan history play.
- Integrasi GGR/Fiver style API untuk provider list, game list, launch game, saldo, deposit, withdraw, dan history play.
- Integrasi TopPayment/Jayapay alias untuk QRIS deposit, callback, query status pembayaran, dan anti double pending deposit.
- Cache gambar remote untuk provider/game agar mobile lebih ringan.
- AMP landing page di `/amp`.
- Route maintenance `/clear-cache` sudah dibatasi hanya untuk user admin level developer.

## Kebutuhan Server

- PHP 8.1 atau lebih baru.
- Composer 2.
- MySQL atau MariaDB.
- Apache/Nginx.
- PHP extension: `bcmath`, `ctype`, `curl`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `zip`, `gd`.
- Node.js 18+ hanya jika ingin build asset Vite. Sebagian besar asset aktif project ini sudah berada langsung di `public`.

## Struktur Penting

- `app/Http/Controllers`: controller user, backoffice, payment, GGR, AMP, cache gambar.
- `app/Http/Api/fiver.php`: client API provider game legacy.
- `app/Services/GgrCatalogService.php`: sinkron dan pembacaan katalog lokal.
- `app/Services/JayapayService.php`: integrasi TopPayment.
- `resources/views/ggr`: frontend utama dan AMP.
- `resources/views/backoffice`: halaman admin.
- `public/assets/css/ggr-site.css`: CSS frontend.
- `public/Admin`: asset backoffice AdminLTE yang sudah dibersihkan.
- `database/ireng17_schema.sql`: schema database.
- `database/ireng17_minimal_seed.sql`: seed minimal.
- `database/ireng17_full_dump.sql`: dump schema + data operasional non-secret untuk import shared hosting. Data user, transaksi, dan credential runtime tidak disimpan di repo.
- `storage/app/public/banner-home`: asset banner yang direferensikan oleh dump/seed banner backoffice.
- `.env.production.example`: template environment production.
- `docs/DEPLOYMENT.md`: catatan deploy lebih detail.

## Install Lokal

```bash
git clone https://github.com/mevander88/ireng17.git
cd ireng17
composer install
cp .env.example .env
php artisan key:generate
```

Edit `.env` lokal:

```env
APP_NAME=ireng17
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ireng17
DB_USERNAME=root
DB_PASSWORD=
```

Import database:

```bash
mysql -u root -p ireng17 < database/ireng17_schema.sql
php artisan migrate
mysql -u root -p ireng17 < database/ireng17_minimal_seed.sql
```

Jalankan server lokal:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Buka:

- Frontend: `http://127.0.0.1:8000`
- AMP: `http://127.0.0.1:8000/amp`
- Backoffice login: `http://127.0.0.1:8000/admins`

## Deploy ke VPS

```bash
git clone https://github.com/mevander88/ireng17.git
cd ireng17
composer install --no-dev --optimize-autoloader
cp .env.production.example .env
php artisan key:generate
```

Edit `.env` production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com
AMP_URL=https://domain-anda.com/amp

DB_DATABASE=ireng17
DB_USERNAME=isi_user_db
DB_PASSWORD=isi_password_db

SESSION_SECURE_COOKIE=true
```

Import database:

```bash
mysql -u USER -p ireng17 < database/ireng17_schema.sql
php artisan migrate --force
mysql -u USER -p ireng17 < database/ireng17_minimal_seed.sql
```

Permission:

```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache public/storage public/image-cache
chown -R www-data:www-data storage bootstrap/cache public/storage public/image-cache
```

Sesuaikan `www-data` dengan user web server yang dipakai.

Optimasi production:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Untuk Nginx/Apache, document root terbaik adalah:

```text
/path/ke/ireng17/public
```

## Deploy ke Shared Hosting atau cPanel

Cara paling aman adalah arahkan document root domain ke folder `public`.

Jika hosting tidak mengizinkan document root ke `public`, upload project ke root hosting dan pastikan file `.htaccess` root project ikut terupload. File `.htaccess` project sudah menolak akses langsung ke file/folder sensitif seperti `.env`, `vendor`, `storage`, `routes`, `config`, `database`, dan mengarahkan request ke `public`.

Langkah umum cPanel jika terminal tersedia:

1. Upload semua file project.
2. Buat database dan user MySQL.
3. Import `database/ireng17_schema.sql`.
4. Jalankan migration jika tersedia terminal:

```bash
php artisan migrate --force
```

5. Import `database/ireng17_minimal_seed.sql`.
6. Copy `.env.production.example` menjadi `.env`.
7. Isi `APP_URL`, database, TopPayment, dan GGR.
8. Jalankan:

```bash
php artisan key:generate
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Jika `storage:link` tidak bisa karena shared hosting membatasi symlink, buat folder `public/storage` manual dan pastikan upload backoffice mengarah ke folder publik yang writable.

### Shared Hosting Tanpa Terminal

Jika hosting tidak menyediakan terminal, gunakan workflow manual ini:

1. Di lokal, pastikan dependency sudah ada dengan `composer install --no-dev --optimize-autoloader`.
2. Upload seluruh project termasuk folder `vendor` ke hosting. Tanpa `vendor`, Laravel tidak akan jalan.
3. Arahkan document root domain ke folder `public`. Jika tidak bisa, upload project di luar `public_html` lalu isi `public_html` dengan isi folder `public`.
4. Buat database dan user MySQL dari cPanel.
5. Import `database/ireng17_full_dump.sql` lewat phpMyAdmin. File ini berisi schema dan data operasional non-secret, termasuk banner/default setting yang aman dipush.
6. Copy `.env.production.example` menjadi `.env` lewat File Manager.
7. Isi `.env`: `APP_URL`, `AMP_URL`, database, `APP_KEY`, GGR, dan TopPayment. Jangan menaruh private key/token asli di repository.
8. Jika belum punya `APP_KEY`, buat dari lokal dengan `php artisan key:generate --show`, lalu paste hasilnya ke `.env` hosting.
9. Pastikan folder `storage`, `storage/logs`, `storage/framework/cache`, `storage/framework/sessions`, `storage/framework/views`, `bootstrap/cache`, `public/image-cache`, dan `public/storage` writable.
10. Jika tidak bisa menjalankan `php artisan storage:link`, buat symlink dari fitur hosting jika ada. Jika tidak ada, copy isi `storage/app/public` ke `public/storage` setiap selesai upload asset backoffice.
11. Jika hosting punya fitur Cron Jobs, tambahkan schedule Laravel:

```text
* * * * * /usr/local/bin/php /home/USER/path-ireng17/artisan schedule:run >> /dev/null 2>&1
```

Sesuaikan path PHP dan path project dengan informasi dari cPanel. Jika tidak ada cron, fitur web tetap jalan, tetapi pekerjaan terjadwal harus dijalankan manual dari backoffice atau sinkronisasi yang tersedia di UI.

## Konfigurasi User Admin

Project memakai kolom `users.level`.

- User biasa: `NULL` atau selain `1/2`.
- Admin: `1`.
- Developer/super admin: `2`.

Contoh menjadikan user `yola` sebagai developer/admin level 2:

```sql
UPDATE users SET level = 2 WHERE name = 'yola';
```

Route yang sensitif seperti `/clear-cache`, setting gateway, banner, bonus, dan game setting berada di middleware admin/developer.

## Konfigurasi GGR Provider API

Ada dua sumber konfigurasi:

- `.env`: `GGR_API_URL`, `GGR_AGENT_CODE`, `GGR_AGENT_TOKEN`.
- Table `api`: `nx_endpoint`, `nx_agent_code`, `nx_token`, dan field provider legacy.

Client utama `App\Http\Api\fiver` membaca dari row pertama table `api`. Pastikan backoffice menu GGR/API sudah berisi endpoint, agent code, dan token yang benar.

Contoh `.env`:

```env
GGR_API_URL=https://api.nexusggr.com
GGR_AGENT_CODE=agent_anda
GGR_AGENT_TOKEN=token_anda
LUCKY_SPIN_PRIZES=1000,2000,5000
```

Setelah konfigurasi benar, sinkron katalog:

```bash
php artisan ggr:sync-catalog
```

Atau lewat Backoffice:

- `/backoffice/ggr`
- `Test Provider API`
- `Sync Provider`
- `Sync Game`

Frontend membaca `ggr_providers` dan `ggr_games` dari database lokal supaya halaman user lebih cepat.

## Konfigurasi TopPayment / QRIS

TopPayment dibaca dari `config/jayapay.php` melalui `.env`. Prefix `JAYAPAY_*` masih didukung sebagai alias lama. Merchant code, private key, platform public key, dan token provider harus dipasang langsung di server atau dari menu Backoffice, bukan di-commit ke GitHub.

Contoh:

```env
TOPPAYMENT_MERCHANT_CODE=isi_merchant_code
TOPPAYMENT_PRIVATE_KEY_PATH=storage/app/toppayment_private.pem
TOPPAYMENT_PUBLIC_KEY_PATH=storage/app/toppayment_public.pem
TOPPAYMENT_API_URL=https://global-id-openapi.toppayment.com/id/pay/prePay
TOPPAYMENT_QUERY_URL=https://global-id-openapi.toppayment.com/id/pay/query
TOPPAYMENT_NOTIFY_URL=https://domain-anda.com/api/jayapay/callback
```

Upload key RSA ke:

```text
storage/app/toppayment_private.pem
storage/app/toppayment_public.pem
```

Callback aktif di:

```text
POST /api/jayapay/callback
POST /jayapay/callback
```

Pastikan `TOPPAYMENT_NOTIFY_URL` memakai domain production yang bisa diakses publik.

Jika deploy dari GitHub, buat file key di server:

```bash
mkdir -p storage/app
nano storage/app/toppayment_private.pem
nano storage/app/toppayment_public.pem
chmod 600 storage/app/toppayment_private.pem
chmod 644 storage/app/toppayment_public.pem
```

Lalu clear cache config:

```bash
php artisan config:clear
php artisan config:cache
```

## Cache Gambar

Remote image provider/game akan diarahkan melalui sistem cache agar mobile tidak berat.

Folder terkait:

- `storage/app/image-cache`
- `public/image-cache`

Command cache manual:

```bash
php artisan images:cache-remote
```

Pastikan folder cache writable oleh web server.

## Keamanan Production

Wajib sebelum go-live:

- `APP_ENV=production`.
- `APP_DEBUG=false`.
- `APP_URL` sesuai domain production.
- Gunakan HTTPS dan `SESSION_SECURE_COOKIE=true`.
- Jangan commit atau publish `.env`, private key, token provider, full dump transaksi/member, atau credential API.
- `database/ireng17_full_dump.sql` di repository harus tetap sanitized. Data user/transaksi asli hanya boleh berada di database server/backup privat.
- Document root diarahkan ke `public` bila memungkinkan.
- Pastikan `/clear-cache` hanya bisa diakses user level `2`.
- Pastikan permission hanya writable untuk `storage`, `bootstrap/cache`, `public/storage`, dan `public/image-cache`.

## Checklist Setelah Deploy

- Homepage `/` HTTP 200.
- AMP `/amp` HTTP 200.
- Backoffice `/admins` bisa login.
- Logo, favicon, banner, popup tampil.
- Register dan login user berjalan.
- Deposit membuat transaksi pending dan tidak bisa double deposit saat masih pending.
- Callback TopPayment berhasil mengubah status deposit.
- Provider API test sukses di backoffice.
- Sync provider/game berhasil.
- Game launch membuka URL provider.
- History play membaca data API sesuai filter.
- `php artisan route:list` tidak error.
- `storage/logs/laravel.log` tidak berisi error baru setelah smoke test.

## Troubleshooting

Blank putih:

```bash
php artisan config:clear
php artisan view:clear
php artisan route:clear
tail -f storage/logs/laravel.log
```

Asset upload/logo tidak muncul:

```bash
php artisan storage:link
chmod -R 775 storage public/storage
```

Provider API gagal:

- Cek table `api`, terutama `nx_endpoint`, `nx_agent_code`, `nx_token`.
- Cek DNS server bisa resolve endpoint.
- Cek `storage/logs/laravel.log`.

Signature TopPayment gagal:

- Pastikan private key dan public key sesuai pasangan.
- Pastikan path key di `.env` benar.
- Pastikan callback menggunakan payload asli dari gateway.
- Clear config cache setelah update gateway:

```bash
php artisan config:clear
php artisan config:cache
```

## Perintah Verifikasi Cepat

```bash
php -l routes/web.php
php artisan route:list
php artisan config:clear
php artisan cache:clear
```

Untuk cek beberapa endpoint lokal:

```bash
curl -I http://127.0.0.1:8000/
curl -I http://127.0.0.1:8000/amp
curl -I http://127.0.0.1:8000/slots
curl -I http://127.0.0.1:8000/admins
```
