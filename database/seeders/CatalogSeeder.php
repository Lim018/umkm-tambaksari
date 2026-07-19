<?php

namespace Database\Seeders;

use App\Models\Category;
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

        foreach ($umkms as $u) {
            Umkm::create([
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
    }
}
