<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan',    'icon' => '🍜', 'accent_color' => '#3B6FF5', 'tint' => '#DBEAFE'],
            ['name' => 'Minuman',    'icon' => '🧋', 'accent_color' => '#FF6B4A', 'tint' => '#FFE4DA'],
            ['name' => 'Fashion',    'icon' => '👗', 'accent_color' => '#8B5CF6', 'tint' => '#EDE9FE'],
            ['name' => 'Kerajinan',  'icon' => '🧺', 'accent_color' => '#FFB800', 'tint' => '#FEF3C7'],
            ['name' => 'Jasa',       'icon' => '🛠️', 'accent_color' => '#EF4444', 'tint' => '#FEE2E2'],
            ['name' => 'Kecantikan', 'icon' => '💄', 'accent_color' => '#2DD4BF', 'tint' => '#CCFBF1'],
            ['name' => 'Elektronik', 'icon' => '💡', 'accent_color' => '#EC4899', 'tint' => '#FCE7F3'],
            ['name' => 'Pertanian',  'icon' => '🌱', 'accent_color' => '#10B981', 'tint' => '#D1FAE5'],
            ['name' => 'Otomotif',   'icon' => '🛵', 'accent_color' => '#3B6FF5', 'tint' => '#DBEAFE'],
            ['name' => 'Lainnya',    'icon' => '✨', 'accent_color' => '#8B5CF6', 'tint' => '#EDE9FE'],
        ];

        $byName = [];
        foreach ($categories as $c) {
            $c['slug'] = Str::slug($c['name']);
            $byName[$c['name']] = Category::create($c);
        }

        $umkms = [
            ['name' => 'Sambel Bu Yanti',        'cat' => 'Makanan',    'kel' => 'Tambaksari',       'price' => 'Rp 15rb–40rb',  'bg' => 'linear-gradient(135deg,#EDE9FE,#F5F0FF)', 'feat' => true, 'best' => true],
            ['name' => 'Kopi Susu Rangkah',      'cat' => 'Minuman',    'kel' => 'Rangkah',          'price' => 'Rp 12rb–25rb',  'bg' => 'linear-gradient(135deg,#FCE7F3,#FFF0F6)', 'feat' => true, 'best' => true],
            ['name' => 'Batik Ploso Ayu',        'cat' => 'Fashion',    'kel' => 'Ploso',            'price' => 'Rp 85rb–350rb', 'bg' => 'linear-gradient(135deg,#DBEAFE,#EEF5FF)', 'feat' => true, 'best' => false],
            ['name' => 'Anyaman Rotan Gading',   'cat' => 'Kerajinan',  'kel' => 'Gading',           'price' => 'Rp 50rb–200rb', 'bg' => 'linear-gradient(135deg,#D1FAE5,#ECFDF5)', 'feat' => true, 'best' => false],
            ['name' => 'Keripik Tempe Renyah',   'cat' => 'Makanan',    'kel' => 'Pacar Kembang',    'price' => 'Rp 10rb–30rb',  'bg' => 'linear-gradient(135deg,#FEF3C7,#FFFBEB)', 'feat' => true, 'best' => true],
            ['name' => 'Skincare Ayu Beauty',    'cat' => 'Kecantikan', 'kel' => 'Pacar Keling',     'price' => 'Rp 25rb–120rb', 'bg' => 'linear-gradient(135deg,#EDE9FE,#F5F0FF)', 'feat' => true, 'best' => false],
            ['name' => 'Servis Elektronik Jaya', 'cat' => 'Elektronik', 'kel' => 'Kapas Madya Baru', 'price' => 'Rp 50rb–500rb', 'bg' => 'linear-gradient(135deg,#DBEAFE,#EEF5FF)', 'feat' => true, 'best' => false],
            ['name' => 'Sayur Hidroponik Setro', 'cat' => 'Pertanian',  'kel' => 'Dukuh Setro',      'price' => 'Rp 8rb–35rb',   'bg' => 'linear-gradient(135deg,#D1FAE5,#ECFDF5)', 'feat' => true, 'best' => true],
        ];

        $created = [];
        foreach ($umkms as $u) {
            $created[$u['name']] = Umkm::create([
                'name' => $u['name'],
                'category_id' => $byName[$u['cat']]->id,
                'kelurahan' => $u['kel'],
                'price_range' => $u['price'],
                'pastel_bg' => $u['bg'],
                'whatsapp' => '6281234567890',
                'shopee_url' => null,
                'is_featured' => $u['feat'],
                'is_bestseller' => $u['best'],
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
