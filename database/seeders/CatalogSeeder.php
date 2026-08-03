<?php

namespace Database\Seeders;

use App\Models\Category;
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
        foreach (self::CATEGORIES as $c) {
            $byName[$c['name']] = Category::updateOrCreate(
                ['slug' => Str::slug($c['name'])],
                $c
            );
        }

        $umkms = [
            ['name' => 'Sambel Bu Yanti',      'cat' => 'Makanan', 'kel' => 'Tambaksari',       'price' => 'Rp 15rb–40rb',  'bg' => 'linear-gradient(135deg,#FFE4DA,#FFF3EE)', 'feat' => true, 'best' => true],
            ['name' => 'Kopi Susu Rangkah',    'cat' => 'Minuman', 'kel' => 'Rangkah',          'price' => 'Rp 12rb–25rb',  'bg' => 'linear-gradient(135deg,#CCFBF1,#ECFEFB)', 'feat' => true, 'best' => true],
            ['name' => 'Batik Ploso Ayu',      'cat' => 'Fashion', 'kel' => 'Ploso',            'price' => 'Rp 85rb–350rb', 'bg' => 'linear-gradient(135deg,#EDE9FE,#F5F0FF)', 'feat' => true, 'best' => false],
            ['name' => 'Keripik Tempe Renyah', 'cat' => 'Makanan', 'kel' => 'Pacar Kembang',    'price' => 'Rp 10rb–30rb',  'bg' => 'linear-gradient(135deg,#FEF3C7,#FFFBEB)', 'feat' => true, 'best' => true],
            ['name' => 'Es Dawet Gading',      'cat' => 'Minuman', 'kel' => 'Gading',           'price' => 'Rp 8rb–18rb',   'bg' => 'linear-gradient(135deg,#D1FAE5,#ECFDF5)', 'feat' => true, 'best' => false],
            ['name' => 'Kaos Sablon Setro',    'cat' => 'Fashion', 'kel' => 'Dukuh Setro',      'price' => 'Rp 55rb–150rb', 'bg' => 'linear-gradient(135deg,#DBEAFE,#EEF5FF)', 'feat' => true, 'best' => true],
            ['name' => 'Rujak Cingur Keling',  'cat' => 'Makanan', 'kel' => 'Pacar Keling',     'price' => 'Rp 18rb–35rb',  'bg' => 'linear-gradient(135deg,#FCE7F3,#FFF0F6)', 'feat' => true, 'best' => false],
            ['name' => 'Jus Buah Segar Kapas', 'cat' => 'Minuman', 'kel' => 'Kapas Madya Baru', 'price' => 'Rp 10rb–22rb',  'bg' => 'linear-gradient(135deg,#FEF3C7,#FFFBEB)', 'feat' => true, 'best' => true],
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
