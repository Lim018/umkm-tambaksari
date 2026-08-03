<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\ContactEvent;
use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PopularityBadgeTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);
    }

    private function umkm(string $name, array $overrides = []): Umkm
    {
        return Umkm::create(array_merge([
            'name' => $name,
            'category_id' => $this->category->id,
            'kelurahan' => 'Tambaksari',
            'price_range' => 'Rp 15rb–40rb',
            'whatsapp' => '6281234567890',
            'is_featured' => true,
        ], $overrides));
    }

    /** Buat sejumlah klik dengan pengunjung berbeda supaya lolos deduplikasi. */
    private function klik(Umkm $umkm, int $jumlah, ?Menu $menu = null, int $umurHari = 0): void
    {
        for ($i = 0; $i < $jumlah; $i++) {
            ContactEvent::create([
                'umkm_id' => $umkm->id,
                'menu_id' => $menu?->id,
                'channel' => ContactEvent::CHANNEL_WHATSAPP,
                'source' => $menu ? ContactEvent::SOURCE_MENU : ContactEvent::SOURCE_TOKO,
                'visitor_hash' => hash('sha256', "{$umkm->id}-{$menu?->id}-{$umurHari}-{$i}"),
            ])->forceFill(['created_at' => now()->subDays($umurHari)])->saveQuietly();
        }
    }

    public function test_kartu_menampilkan_jumlah_kontak_setelah_lewat_ambang(): void
    {
        $umkm = $this->umkm('Sambel Bu Yanti');
        $this->klik($umkm, ContactEvent::POPULARITY_MIN_UMKM);

        $this->get(route('catalog.index'))
            ->assertOk()
            ->assertSee(ContactEvent::POPULARITY_MIN_UMKM . '× dihubungi');
    }

    public function test_kartu_menyembunyikan_angka_di_bawah_ambang(): void
    {
        $umkm = $this->umkm('Toko Baru');
        $this->klik($umkm, ContactEvent::POPULARITY_MIN_UMKM - 1);

        $this->get(route('catalog.index'))
            ->assertOk()
            ->assertDontSee('× dihubungi');
    }

    public function test_klik_lebih_lama_dari_jendela_tidak_dihitung(): void
    {
        $umkm = $this->umkm('Toko Lama');
        $this->klik($umkm, 20, null, ContactEvent::POPULARITY_DAYS + 5);

        $this->get(route('catalog.index'))
            ->assertOk()
            ->assertDontSee('× dihubungi');
    }

    public function test_halaman_toko_menampilkan_ringkasan_dan_badge_menu(): void
    {
        $umkm = $this->umkm('Sambel Bu Yanti');
        $menu = Menu::create(['umkm_id' => $umkm->id, 'name' => 'Sambel Bawang', 'price' => 15000]);

        $this->klik($umkm, 6);
        $this->klik($umkm, ContactEvent::POPULARITY_MIN_MENU, $menu);

        $response = $this->get(route('catalog.show', $umkm))->assertOk();

        // 6 klik toko + klik lewat menu ikut terhitung sebagai kontak toko.
        $response->assertSee('9 kali dihubungi dalam ' . ContactEvent::POPULARITY_DAYS . ' hari terakhir');
        $response->assertSee(ContactEvent::POPULARITY_MIN_MENU . '× dipesan');
    }

    public function test_menu_sepi_tidak_memasang_badge(): void
    {
        $umkm = $this->umkm('Sambel Bu Yanti');
        $menu = Menu::create(['umkm_id' => $umkm->id, 'name' => 'Sambel Bawang', 'price' => 15000]);

        $this->klik($umkm, ContactEvent::POPULARITY_MIN_MENU - 1, $menu);

        $this->get(route('catalog.show', $umkm))
            ->assertOk()
            ->assertDontSee('× dipesan');
    }

    public function test_urutan_paling_ramai_menaruh_toko_terpopuler_di_depan(): void
    {
        $sepi = $this->umkm('Toko Sepi');
        $ramai = $this->umkm('Toko Ramai');

        $this->klik($sepi, 2);
        $this->klik($ramai, 9);

        $html = $this->get(route('catalog.index', ['sort' => 'populer']))->assertOk()->getContent();

        $this->assertLessThan(
            strpos($html, 'Toko Sepi'),
            strpos($html, 'Toko Ramai'),
            'Toko dengan kontak terbanyak harus tampil lebih dulu.'
        );
    }

    public function test_beranda_ikut_menampilkan_badge(): void
    {
        $umkm = $this->umkm('Sambel Bu Yanti');
        $this->klik($umkm, 7);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('7× dihubungi');
    }

    public function test_klik_lewat_rute_publik_menaikkan_angka_yang_dilihat_pengunjung(): void
    {
        $umkm = $this->umkm('Sambel Bu Yanti');
        $this->klik($umkm, ContactEvent::POPULARITY_MIN_UMKM - 1);

        $this->withHeaders(['User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15'])
            ->get(route('go.umkm', [$umkm, 'whatsapp']));

        $this->get(route('catalog.index'))
            ->assertOk()
            ->assertSee(ContactEvent::POPULARITY_MIN_UMKM . '× dihubungi');
    }
}
