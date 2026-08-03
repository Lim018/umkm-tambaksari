<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    /**
     * Kategori bersifat tetap (3 kategori, tanpa CRUD admin).
     * Warna diselaraskan dengan gradient kartu di <x-katalog-banner />.
     */
    private const CATEGORIES = [
        ['name' => 'Makanan', 'icon' => '🍜', 'accent_color' => '#FF6B4A', 'tint' => '#FFE4DA'],
        ['name' => 'Minuman', 'icon' => '🧋', 'accent_color' => '#14B8A6', 'tint' => '#CCFBF1'],
        ['name' => 'Fashion', 'icon' => '👗', 'accent_color' => '#6D3EF0', 'tint' => '#EDE9FE'],
    ];

    public function run(): void
    {
        $byName = [];
        $keptSlugs = [];
        foreach (self::CATEGORIES as $c) {
            $slug = Str::slug($c['name']);
            $keptSlugs[] = $slug;
            $byName[$c['name']] = Category::updateOrCreate(['slug' => $slug], $c);
        }

        $keptIds = collect($byName)->pluck('id')->all();
        $fallbackId = $keptIds[0];

        Umkm::whereNotIn('category_id', $keptIds)->update(['category_id' => $fallbackId]);
        Umkm::query()->update(['kelurahan' => 'Tambaksari']);
        Category::whereNotIn('slug', $keptSlugs)->delete();

        $umkms = [
            ['name' => 'Sambel Bu Yanti',      'cat' => 'Makanan', 'price' => 'Rp 15rb–40rb',  'bg' => 'linear-gradient(135deg,#FFE4DA,#FFF3EE)', 'feat' => true, 'best' => true, 'desc' => 'Sambel homemade khas Tambaksari dengan resep turun-temurun. Pedas, gurih, dan cocok untuk lauk harian.', 'buka' => '07:00', 'tutup' => '17:00', 'libur' => [7]],
            ['name' => 'Kopi Susu Rangkah',    'cat' => 'Minuman', 'price' => 'Rp 12rb–25rb',  'bg' => 'linear-gradient(135deg,#CCFBF1,#ECFEFB)', 'feat' => true, 'best' => true, 'desc' => 'Kedai kopi susu lokal dengan menu signature gula aren dan pastry ringan untuk teman ngopi.', 'buka' => '10:00', 'tutup' => '23:00', 'libur' => []],
            ['name' => 'Batik Ploso Ayu',      'cat' => 'Fashion', 'price' => 'Rp 85rb–350rb', 'bg' => 'linear-gradient(135deg,#EDE9FE,#F5F0FF)', 'feat' => true, 'best' => false, 'desc' => 'Batik tulis dan print motif khas Surabaya. Pakaian siap pakai untuk pria dan wanita.', 'buka' => '09:00', 'tutup' => '16:00', 'libur' => [7]],
            ['name' => 'Keripik Tempe Renyah', 'cat' => 'Makanan', 'price' => 'Rp 10rb–30rb',  'bg' => 'linear-gradient(135deg,#FEF3C7,#FFFBEB)', 'feat' => true, 'best' => true, 'desc' => 'Camilan keripik tempe tanpa pengawet, tersedia rasa original dan pedas dalam kemasan hemat.', 'buka' => '08:00', 'tutup' => '20:00', 'libur' => []],
            ['name' => 'Es Dawet Gading',      'cat' => 'Minuman', 'price' => 'Rp 8rb–18rb',   'bg' => 'linear-gradient(135deg,#D1FAE5,#ECFDF5)', 'feat' => true, 'best' => false, 'desc' => 'Es dawet segar dengan santan kental dan gula merah alami. Minuman favorit warga setempat.', 'buka' => '10:00', 'tutup' => '18:00', 'libur' => [1]],
            ['name' => 'Kaos Sablon Setro',    'cat' => 'Fashion', 'price' => 'Rp 55rb–150rb', 'bg' => 'linear-gradient(135deg,#DBEAFE,#EEF5FF)', 'feat' => true, 'best' => true, 'desc' => 'Kaos sablon custom dan ready stock dengan desain lokal. Bahan adem, cocok untuk daily wear.', 'buka' => '09:00', 'tutup' => '17:00', 'libur' => [6, 7]],
            ['name' => 'Rujak Cingur Keling',  'cat' => 'Makanan', 'price' => 'Rp 18rb–35rb',  'bg' => 'linear-gradient(135deg,#FCE7F3,#FFF0F6)', 'feat' => true, 'best' => false, 'desc' => 'Rujak cingur otentik dengan bumbu petis khas Surabaya. Segar, pedas, dan mengenyangkan.', 'buka' => '10:00', 'tutup' => '21:00', 'libur' => []],
            ['name' => 'Jus Buah Segar Kapas', 'cat' => 'Minuman', 'price' => 'Rp 10rb–22rb',  'bg' => 'linear-gradient(135deg,#FEF3C7,#FFFBEB)', 'feat' => true, 'best' => true, 'desc' => 'Jus buah segar tanpa pengawet, diperas setiap hari. Pilihan sehat untuk cuaca panas.', 'buka' => '18:00', 'tutup' => '02:00', 'libur' => []],
        ];

        $created = [];
        foreach ($umkms as $u) {
            $created[$u['name']] = Umkm::create([
                'name' => $u['name'],
                'category_id' => $byName[$u['cat']]->id,
                'kelurahan' => 'Tambaksari',
                'price_range' => $u['price'],
                'description' => $u['desc'],
                'pastel_bg' => $u['bg'],
                'whatsapp' => '6281234567890',
                'shopee_url' => null,
                'is_featured' => $u['feat'],
                'is_bestseller' => $u['best'],
                'opening_time' => $u['buka'],
                'closing_time' => $u['tutup'],
                'closed_days' => $u['libur'],
            ]);
        }

        $menus = [
            'Sambel Bu Yanti' => [
                ['name' => 'Sambel Terasi Special', 'price' => 18000, 'description' => 'Sambel terasi homemade dengan cabai rawit segar, cocok untuk lauk harian.', 'sort' => 1],
                ['name' => 'Sambel Ijo Pete', 'price' => 22000, 'description' => 'Pedas segar dengan potongan pete gurih. Porsi keluarga.', 'sort' => 2],
                ['name' => 'Paket Nasi + Sambel', 'price' => 28000, 'description' => 'Nasi hangat, telur dadar, dan pilihan sambel favorit.', 'sort' => 3],
            ],
            'Kopi Susu Rangkah' => [
                ['name' => 'Kopi Susu Gula Aren', 'price' => 18000, 'description' => 'Espresso, susu segar, dan gula aren lokal yang creamy.', 'sort' => 1],
                ['name' => 'Es Matcha Latte', 'price' => 22000, 'description' => 'Matcha premium dengan foam lembut, disajikan dingin.', 'sort' => 2],
                ['name' => 'Croissant Butter', 'price' => 15000, 'description' => 'Pastry renyah, cocok dampingan kopi pagi.', 'sort' => 3],
            ],
            'Batik Ploso Ayu' => [
                ['name' => 'Kemeja Batik Pria', 'price' => 185000, 'description' => 'Batik tulis motif klasik Ploso, kain katun nyaman.', 'sort' => 1],
                ['name' => 'Dress Batik Wanita', 'price' => 250000, 'description' => 'Potongan modern dengan motif flora khas Surabaya.', 'sort' => 2],
            ],
            'Keripik Tempe Renyah' => [
                ['name' => 'Keripik Tempe Original 250g', 'price' => 15000, 'description' => 'Gurih renyah tanpa pengawet, cocok untuk cemilan keluarga.', 'sort' => 1],
                ['name' => 'Keripik Tempe Pedas 250g', 'price' => 17000, 'description' => 'Balutan bumbu pedas manis yang bikin nagih.', 'sort' => 2],
                ['name' => 'Paket Mixed 500g', 'price' => 28000, 'description' => 'Campuran original dan pedas dalam satu paket hemat.', 'sort' => 3],
            ],
            'Sayur Hidroponik Setro' => [
                ['name' => 'Paket Selada Segar', 'price' => 12000, 'description' => 'Selada hidroponik dipanen pagi hari, siap salad.', 'sort' => 1],
                ['name' => 'Pakcoy & Kangkung Mix', 'price' => 10000, 'description' => 'Sayur hijau segar untuk tumisan harian.', 'sort' => 2],
            ],
        ];

        foreach ($menus as $umkmName => $items) {
            $umkm = $created[$umkmName] ?? null;
            if (! $umkm) {
                continue;
            }

            foreach ($items as $item) {
                Menu::create([
                    'umkm_id' => $umkm->id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'description' => $item['description'],
                    'is_available' => true,
                    'sort_order' => $item['sort'],
                ]);
            }
        }
    }
}
