# Katalog UMKM Kecamatan Tambaksari

Katalog & pemasaran UMKM di Kecamatan Tambaksari, Surabaya. Warga menemukan produk
usaha lokal lalu menghubungi penjual via WhatsApp/Shopee. Admin kelurahan mengelola
data lewat panel CRUD.

## Stack
Laravel 11 · Blade · Tailwind CSS 3 · Alpine.js · Laravel Breeze (auth) · SQLite (dev).

## Menjalankan (dev)

```bash
composer install
cp .env.example .env && php artisan key:generate   # sudah ter-set jika hasil scaffold
php artisan migrate:fresh --seed
php artisan storage:link
npm install && npm run build      # atau: npm run dev (hot reload)
php artisan serve
```

Buka http://127.0.0.1:8000

## Akun admin (dari seeder)
- Email: `admin@tambaksari.test`
- Password: `password`
- Login: tombol **Masuk Admin** → `/admin/login` → `/login`. Panel di `/admin`.

## Struktur
- Landing (`/`) — 5 blok: navbar glass, hero+search, grid kategori (10), grid UMKM
  unggulan (8), footer 4 kolom.
- Katalog (`/katalog`) — pencarian `?q=`, filter `kategori`/`kelurahan`, `sort=terlaris`,
  paginasi 8/hal.
- Detail (`/umkm/{id}`).
- Admin (`/admin/*`, middleware `auth`) — dashboard + CRUD UMKM & Kategori, upload foto.

Data contoh via `database/seeders/CatalogSeeder.php` (bukan hardcode di Blade).
Acuan visual: `design-reference.dc.html`.

## Ganti data placeholder
- Nomor WhatsApp seeder = `6281234567890`. Ganti lewat panel admin (format `62...`).
- Foto UMKM: upload lewat admin → tersimpan di `storage/app/public/umkm`.
