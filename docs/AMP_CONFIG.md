# Konfigurasi AMP ireng17

File AMP sudah dibuat di:

```text
public/amp.html
```

## Pasang di domain yang sama

1. Upload atau deploy project seperti biasa.
2. Buka:

```text
https://domain-utama.com/amp.html
```

3. Ubah canonical di `public/amp.html`:

```html
<link rel="canonical" href="https://domain-utama.com/">
```

4. Ubah semua link CTA `https://ireng17.com/...` menjadi domain utama.

5. Pastikan halaman utama punya tag ini:

```html
<link rel="amphtml" href="https://domain-utama.com/amp.html">
```

Layout GGR sudah menambahkan `rel="amphtml"` otomatis untuk halaman utama. Jika AMP dipasang di URL lain, isi `.env`:

```text
AMP_URL=https://domain-amp-anda.com/amp.html
```

## Pasang di web lain

1. Copy `public/amp.html` ke hosting lain.
2. Ganti canonical tetap mengarah ke halaman utama ireng17:

```html
<link rel="canonical" href="https://domain-utama-ireng17.com/">
```

3. Ganti semua URL tombol:

```text
https://ireng17.com/register
https://ireng17.com/slots
```

menjadi URL tujuan produksi.

4. Jika AMP dipasang di domain berbeda, jangan lupa tambahkan backlink dari isi halaman AMP ke domain utama.

5. Di project utama, isi `.env` supaya halaman utama mengarah ke AMP eksternal:

```text
AMP_URL=https://domain-lain.com/amp.html
```

## Robots dan sitemap

File `public/robots.txt` sudah dibuat. Saat production, ganti sitemap:

```text
Sitemap: https://domain-utama.com/sitemap.xml
```

Sitemap Laravel sudah ditambah URL:

```text
/
/slots
/casino
/sports
/e-games
/promotion
/register
/amp.html
```

## Validasi

Setelah production, cek AMP dengan:

```text
https://search.google.com/test/amp
```

atau buka:

```text
https://domain-utama.com/amp.html#development=1
```

lalu lihat console browser untuk error AMP.
