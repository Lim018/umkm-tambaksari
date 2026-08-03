# Prompt Implementasi — Katalog Banner (Laravel + Blade)

Fitur ini **menggantikan** section "Jelajahi Kategori" pada landing page Katalog UMKM
Tambaksari. Aset SVG sudah dibuat di folder `assets/katalog/` — pindahkan ke
`public/assets/katalog/` di proyek Laravel sebelum implementasi.

---

## ASET SVG YANG SUDAH DISEDIAKAN
Salin folder `assets/katalog/` → `public/assets/katalog/`:

| File | Fungsi |
|---|---|
| `icon-makanan.svg` | Ikon 2D flat — tudung saji (coral) |
| `icon-minuman.svg` | Ikon 2D flat — boba/gelas (teal) |
| `icon-fashion.svg` | Ikon 2D flat — kaos (ungu) |
| `pattern-diamond.svg` | Pola diamond/argyle tileable untuk background kartu aktif |
| `decor-blob.svg` | Blob gradient dekoratif (biru→ungu) |
| `decor-ball.svg` | Bola glossy 3D dekoratif |
| `btn-arrow.svg` | Tombol panah bulat (nav) |
| `btn-cta.svg` | Tombol pill "Lihat Katalog" (opsional, boleh pakai versi HTML) |

Akses di Blade: `{{ asset('assets/katalog/icon-makanan.svg') }}`

---

## PERILAKU (sesuai referensi)
- Banner berisi **3 kartu horizontal**: Makanan, Minuman, Fashion.
- Default: semua kartu netral (`#F4F5FA`), lebar sama, hanya ikon + judul.
- **Saat cursor hover salah satu kartu:**
  - Kartu itu **membesar** (flex-grow, mis. `flex: 2.2` vs `flex: 1`).
  - **Background berubah warna** (gradient sesuai kategori) + muncul pola `pattern-diamond.svg`.
  - Ikon **scale-up** ringan, judul jadi **putih**.
  - Muncul deskripsi singkat + tombol pill putih "Lihat Katalog →".
  - Transisi halus `.45s cubic-bezier(.4,0,.2,1)`.
- Warna gradient per kategori:
  - Makanan → `linear-gradient(150deg,#FF8A5B,#FF6B4A)`
  - Minuman → `linear-gradient(150deg,#2DD4BF,#14B8A6)`
  - Fashion → `linear-gradient(150deg,#8B5CF6,#6D3EF0)`
- Mobile (< 768px): tumpuk vertikal; expand aktif saat tap/hover, atau tampilkan
  semua kartu dalam keadaan ringkas.

---

## PROMPT SIAP-TEMPEL UNTUK CLAUDE CODE

```
Pada landing page Katalog UMKM Tambaksari (Laravel + Blade + Tailwind + Alpine.js),
HAPUS section "Jelajahi Kategori" dan GANTI dengan komponen "Katalog Banner".

ASET: sudah ada di public/assets/katalog/ (icon-makanan.svg, icon-minuman.svg,
icon-fashion.svg, pattern-diamond.svg, decor-blob.svg, decor-ball.svg,
btn-arrow.svg). Gunakan via asset() helper. Jangan buat ikon baru.

BUAT komponen Blade resources/views/components/katalog-banner.blade.php berisi
3 kartu horizontal dengan flexbox: Makanan, Minuman, Fashion. Data kartu (nama,
slug ikon, gradient, deskripsi, link) taruh sebagai array di komponen atau
lewatkan dari controller.

PERILAKU (replikasi referensi Starbucks yang saya lampirkan):
- Default: tiap kartu flex:1, background netral #F4F5FA, rounded-3xl, border tipis
  putih, isinya ikon 2D (dari SVG) + judul kategori. Tinggi ~360px.
- Hover kartu: kartu itu membesar (flex:2.2), background berubah jadi gradient
  kategori + overlay pola pattern-diamond.svg (opacity 0→1), ikon scale(1.15),
  judul jadi putih, muncul deskripsi (putih transparan) + tombol pill putih
  "Lihat Katalog →". Kartu lain menyusut kembali ke flex:1.
- Transisi flex/background/box-shadow .45s cubic-bezier(.4,0,.2,1). Hover state
  tambah box-shadow berwarna sesuai kategori.
- Gradient: Makanan #FF8A5B→#FF6B4A, Minuman #2DD4BF→#14B8A6, Fashion
  #8B5CF6→#6D3EF0.
- Tombol "Lihat Katalog" mengarah ke /katalog?kategori={slug}.

RESPONSIF:
- Desktop: 3 kartu sejajar, efek hover-expand seperti di atas.
- Tablet/Mobile (<768px): kartu ditumpuk vertikal (flex-col), tiap kartu tinggi
  wajar; pakai Alpine (x-data) agar tap pada kartu meng-expand & mewarnai kartu
  itu (accordion), karena hover tidak ada di sentuh.

STYLING: Tailwind utility + sedikit CSS kustom untuk transisi flex jika perlu.
Pola diamond pasang sebagai background-image absolute inset-0 dengan opacity yang
dianimasikan. Tambahkan 1-2 decor-ball.svg / decor-blob.svg mengambang di sudut
section (absolute, blur ringan, pointer-events-none) agar senada hero.

Font Plus Jakarta Sans, judul font-extrabold. Semua teks Bahasa Indonesia.
Pastikan tidak ada error, lalu tunjukkan hasilnya.
```

---

## CONTOH MARKUP REFERENSI (HTML/CSS — sudah diuji, tinggal port ke Blade+Tailwind)

```html
<section class="katalog-banner">
  <div class="card c-makanan">
    <div class="pat"></div>
    <img class="ico" src="/assets/katalog/icon-makanan.svg" alt="Makanan">
    <h3>Makanan</h3>
    <p>Kuliner khas & jajanan warga Tambaksari</p>
    <a class="cta" href="/katalog?kategori=makanan">Lihat Katalog →</a>
  </div>
  <!-- ulangi untuk .c-minuman & .c-fashion -->
</section>
```
```css
.katalog-banner{display:flex;gap:20px;height:360px}
.card{flex:1;border-radius:28px;background:#F4F5FA;display:flex;flex-direction:column;
  align-items:center;justify-content:center;gap:16px;cursor:pointer;position:relative;
  overflow:hidden;border:1px solid rgba(255,255,255,.8);
  transition:flex .45s cubic-bezier(.4,0,.2,1),background .45s,box-shadow .45s}
.card .ico{width:96px;height:96px;transition:transform .45s;z-index:2}
.card h3{font-weight:800;color:#1B2559;transition:color .45s;z-index:2}
.card p,.card .cta{display:none;z-index:2}
.card .pat{position:absolute;inset:0;background:url('/assets/katalog/pattern-diamond.svg');opacity:0;transition:opacity .45s}
.card:hover{flex:2.2;color:#fff;box-shadow:0 40px 70px -30px rgba(90,80,240,.6)}
.card:hover .pat{opacity:1}
.card:hover h3{color:#fff}
.card:hover .ico{transform:scale(1.15)}
.card:hover p{display:block;color:rgba(255,255,255,.85);max-width:280px;text-align:center;font-weight:500}
.card:hover .cta{display:inline-block;background:#fff;color:#1B2559;font-weight:700;padding:12px 28px;border-radius:999px;text-decoration:none}
.c-makanan:hover{background:linear-gradient(150deg,#FF8A5B,#FF6B4A)}
.c-minuman:hover{background:linear-gradient(150deg,#2DD4BF,#14B8A6)}
.c-fashion:hover{background:linear-gradient(150deg,#8B5CF6,#6D3EF0)}
```

> Catatan mobile: bungkus tiap kartu dengan Alpine `x-data="{open:false}"` dan
> toggle class saat `@click`/`@mouseenter` agar efek expand berjalan di layar sentuh.
