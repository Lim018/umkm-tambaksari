<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\ContactEvent;
use App\Models\Menu;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTrackingTest extends TestCase
{
    use RefreshDatabase;

    private const BROWSER_UA = 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 Safari/604.1';

    private function umkm(array $overrides = []): Umkm
    {
        $category = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);

        return Umkm::create(array_merge([
            'name' => 'Sambel Bu Yanti',
            'category_id' => $category->id,
            'kelurahan' => 'Tambaksari',
            'price_range' => 'Rp 15rb–40rb',
            'whatsapp' => '6281234567890',
        ], $overrides));
    }

    private function visit(string $url)
    {
        return $this->withHeaders(['User-Agent' => self::BROWSER_UA])->get($url);
    }

    public function test_klik_whatsapp_toko_dicatat_lalu_diteruskan(): void
    {
        $umkm = $this->umkm();

        $this->visit(route('go.umkm', [$umkm, 'whatsapp']))
            ->assertRedirect($umkm->whatsapp_url);

        $this->assertDatabaseHas('contact_events', [
            'umkm_id' => $umkm->id,
            'menu_id' => null,
            'channel' => ContactEvent::CHANNEL_WHATSAPP,
            'source' => ContactEvent::SOURCE_TOKO,
        ]);
    }

    public function test_klik_shopee_dicatat_dengan_channel_shopee(): void
    {
        $umkm = $this->umkm(['shopee_url' => 'https://shopee.co.id/sambel-bu-yanti']);

        $this->visit(route('go.umkm', [$umkm, 'shopee']))
            ->assertRedirect('https://shopee.co.id/sambel-bu-yanti');

        $this->assertDatabaseHas('contact_events', [
            'umkm_id' => $umkm->id,
            'channel' => ContactEvent::CHANNEL_SHOPEE,
        ]);
    }

    public function test_klik_menu_dicatat_beserta_menu_id(): void
    {
        $umkm = $this->umkm();
        $menu = Menu::create(['umkm_id' => $umkm->id, 'name' => 'Sambel Bawang', 'price' => 15000]);

        $this->visit(route('go.menu', $menu))
            ->assertRedirect($menu->whatsapp_url);

        $this->assertDatabaseHas('contact_events', [
            'umkm_id' => $umkm->id,
            'menu_id' => $menu->id,
            'channel' => ContactEvent::CHANNEL_WHATSAPP,
            'source' => ContactEvent::SOURCE_MENU,
        ]);
    }

    public function test_klik_berulang_pengunjung_sama_hanya_dihitung_sekali(): void
    {
        $umkm = $this->umkm();
        $url = route('go.umkm', [$umkm, 'whatsapp']);

        $this->visit($url);
        $this->visit($url);
        $this->visit($url);

        $this->assertSame(1, ContactEvent::count());
    }

    public function test_klik_lama_dihitung_lagi_setelah_jendela_deduplikasi(): void
    {
        $umkm = $this->umkm();
        $url = route('go.umkm', [$umkm, 'whatsapp']);

        $this->visit($url);

        $this->travel(31)->minutes();
        $this->visit($url);

        $this->assertSame(2, ContactEvent::count());
    }

    public function test_crawler_tidak_menggelembungkan_angka_tetapi_tetap_diteruskan(): void
    {
        $umkm = $this->umkm();

        $this->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1)'])
            ->get(route('go.umkm', [$umkm, 'whatsapp']))
            ->assertRedirect($umkm->whatsapp_url);

        $this->assertSame(0, ContactEvent::count());
    }

    public function test_channel_tak_dikenal_menghasilkan_404(): void
    {
        $umkm = $this->umkm();

        $this->visit("/go/{$umkm->id}/tokopedia")->assertNotFound();
        $this->assertSame(0, ContactEvent::count());
    }

    public function test_shopee_tanpa_tautan_menghasilkan_404(): void
    {
        $umkm = $this->umkm();

        $this->visit(route('go.umkm', [$umkm, 'shopee']))->assertNotFound();
        $this->assertSame(0, ContactEvent::count());
    }

    public function test_halaman_perantara_tidak_boleh_diindeks(): void
    {
        $umkm = $this->umkm();

        $this->visit(route('go.umkm', [$umkm, 'whatsapp']))
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_dashboard_dan_laporan_menampilkan_angka_kontak(): void
    {
        $umkm = $this->umkm();
        $this->visit(route('go.umkm', [$umkm, 'whatsapp']));

        $this->actingAs(User::factory()->create());

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Kontak 30 hari')
            ->assertSee('Sambel Bu Yanti');

        $this->get(route('admin.laporan'))
            ->assertOk()
            ->assertSee('Kontak per toko')
            ->assertSee('Sambel Bu Yanti');
    }

    public function test_laporan_bisa_diunduh_sebagai_csv(): void
    {
        $umkm = $this->umkm();
        $this->visit(route('go.umkm', [$umkm, 'whatsapp']));

        $response = $this->actingAs(User::factory()->create())
            ->get(route('admin.laporan', ['periode' => 30, 'export' => 'csv']));

        $response->assertOk()->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Sambel Bu Yanti', $response->streamedContent());
    }

    public function test_laporan_menolak_periode_tak_dikenal_dan_kembali_ke_bawaan(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.laporan', ['periode' => 9999]))
            ->assertOk();
    }

    public function test_laporan_hanya_untuk_pengguna_terautentikasi(): void
    {
        $this->get(route('admin.laporan'))->assertRedirect(route('login'));
    }

    public function test_rekap_harian_mengisi_hari_kosong_dengan_nol(): void
    {
        $umkm = $this->umkm();
        ContactEvent::create([
            'umkm_id' => $umkm->id,
            'channel' => ContactEvent::CHANNEL_WHATSAPP,
            'source' => ContactEvent::SOURCE_TOKO,
            'visitor_hash' => str_repeat('a', 64),
        ]);

        $trend = ContactEvent::dailySeries(7);

        $this->assertCount(7, $trend['labels']);
        $this->assertCount(7, $trend['series'][ContactEvent::CHANNEL_WHATSAPP]);
        $this->assertSame(1, $trend['total']);
        $this->assertSame(1, $trend['series'][ContactEvent::CHANNEL_WHATSAPP][6]); // hari ini
        $this->assertSame(0, $trend['series'][ContactEvent::CHANNEL_SHOPEE][6]);
    }
}
