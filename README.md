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
- Laporan kontak (`/admin/laporan`) — rekap lead per toko, filter periode, unduh CSV.

Data contoh via `database/seeders/CatalogSeeder.php` (bukan hardcode di Blade).
Acuan visual: `design-reference.dc.html`.

## Pelacakan kontak

Semua tombol WhatsApp/Shopee tidak menunjuk langsung ke tujuan, melainkan lewat
`/go/{umkm}/{channel}` dan `/go/menu/{menu}`. Rute itu mencatat satu baris di
`contact_events` lalu meneruskan pengunjung. Tujuannya mengukur berapa calon
pembeli yang benar-benar dikirim katalog ke tiap toko — angka inilah bahan
laporan kelurahan.

Aturan pencatatan:
- Klik berulang dari pengunjung yang sama ke sasaran yang sama dihitung **sekali
  per 30 menit**.
- Identitas pengunjung disimpan sebagai hash SHA-256 dari IP + user agent + APP_KEY
  + tanggal. Dirotasi harian, jadi bukan alat pelacak lintas hari dan tidak ada IP mentah.
- Crawler dan pengambil pratinjau tautan diabaikan, tetapi tetap diteruskan.
- Menghapus toko ikut menghapus riwayat kontaknya (`cascadeOnDelete`). Unduh CSV
  dulu bila datanya masih dibutuhkan.

### Badge popularitas di halaman publik

Hitungan yang sama ditampilkan ke pengunjung sebagai bukti sosial, memakai jendela
`ContactEvent::POPULARITY_DAYS` (30 hari):

- Kartu toko (beranda & katalog): `🔥 12× dihubungi`
- Halaman toko: ringkasan kontak toko + badge `🔥 9× dipesan` pada tiap menu
- Katalog punya urutan **Paling ramai** (`?sort=populer`)

Badge baru muncul di atas ambang `POPULARITY_MIN_UMKM` (5) dan `POPULARITY_MIN_MENU`
(3). Di bawah itu badge disembunyikan — angka satu-dua digit kecil justru membuat
toko baru terlihat sepi. Kontak lewat tombol menu ikut dihitung sebagai kontak toko,
jadi angka toko selalu ≥ jumlah kontak menunya.

Untuk melihat badge tanpa menunggu trafik nyata:

```bash
php artisan db:seed --class=DemoContactEventSeeder
```

Seeder itu **mengosongkan `contact_events`** lalu mengisi ulang dengan kontak
buatan yang mencakup semua keadaan badge (sangat ramai, pas di atas ambang, dan
di bawah ambang). Sengaja tidak dipanggil `DatabaseSeeder` supaya
`migrate:fresh --seed` tidak pernah menghasilkan angka palsu yang terbawa ke
laporan sungguhan, dan menolak jalan bila `APP_ENV=production`.

Angka ini mengukur **klik menghubungi**, bukan penjualan. Deduplikasi 30 menit
menahan klik iseng, tetapi bukan pertahanan penuh terhadap orang yang sengaja
menggelembungkan angkanya sendiri.

## Ganti data placeholder
- Nomor WhatsApp seeder = `6281234567890`. Ganti lewat panel admin (format `62...`).
- Foto UMKM: upload lewat admin → tersimpan di `storage/app/public/umkm`.
