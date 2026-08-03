<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Umkm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetaKecamatanTest extends TestCase
{
    use RefreshDatabase;

    public function test_section_lokasi_muncul_sekali_di_tiap_halaman_publik(): void
    {
        $category = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);
        $umkm = Umkm::create([
            'name' => 'Sambel Bu Yanti',
            'category_id' => $category->id,
            'kelurahan' => 'Tambaksari',
            'price_range' => 'Rp 15rb–40rb',
            'whatsapp' => '6281234567890',
        ]);

        $halaman = [route('home'), route('catalog.index'), route('catalog.show', $umkm)];

        foreach ($halaman as $url) {
            $html = $this->get($url)->assertOk()->getContent();

            $this->assertSame(1, substr_count($html, 'id="lokasi"'), "Peta harus muncul tepat sekali di {$url}");
            $this->assertSame(1, substr_count($html, '<iframe'), "Peta harus tepat satu iframe di {$url}");
            $this->assertStringContainsString(config('kecamatan.alamat'), $html);
        }
    }

    public function test_peta_berada_sebelum_footer(): void
    {
        $html = $this->get(route('home'))->assertOk()->getContent();

        $this->assertLessThan(
            strpos($html, '<footer'),
            strpos($html, 'id="lokasi"'),
            'Section lokasi harus berada sebelum footer.'
        );
    }

    public function test_penanda_peta_memakai_koordinat_dari_config(): void
    {
        config(['kecamatan.lat' => -7.25, 'kecamatan.lng' => 112.76, 'kecamatan.peta_provider' => 'google']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('google.com/maps?q=-7.25%2C112.76', false);
    }

    public function test_penyedia_peta_dapat_diganti_ke_openstreetmap(): void
    {
        config(['kecamatan.lat' => -7.25, 'kecamatan.lng' => 112.76, 'kecamatan.peta_provider' => 'osm']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('openstreetmap.org/export/embed.html', false)
            ->assertSee('marker=-7.25%2C112.76', false);
    }
}
