<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class OpeningHoursTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);
    }

    private function umkm(array $overrides = []): Umkm
    {
        return Umkm::create(array_merge([
            'name' => 'Sambel Bu Yanti',
            'category_id' => $this->category->id,
            'kelurahan' => 'Tambaksari',
            'price_range' => 'Rp 15rb–40rb',
            'whatsapp' => '6281234567890',
            'is_featured' => true,
        ], $overrides));
    }

    /** Pindahkan waktu memakai jam dinding Surabaya, bukan UTC. */
    private function saatWib(string $waktu): void
    {
        $this->travelTo(Carbon::parse($waktu, Umkm::TIMEZONE));
    }

    public function test_status_null_bila_jam_buka_belum_diisi(): void
    {
        $this->assertNull($this->umkm()->is_open_now);
        $this->assertNull($this->umkm()->opening_hours_label);
        $this->assertFalse($this->umkm()->has_opening_hours);
    }

    public function test_buka_di_dalam_jam_kerja(): void
    {
        $umkm = $this->umkm(['opening_time' => '08:00', 'closing_time' => '17:00']);

        $this->saatWib('2026-08-04 10:30');       // Selasa siang
        $this->assertTrue($umkm->is_open_now);
    }

    public function test_tutup_sebelum_jam_buka_dan_setelah_jam_tutup(): void
    {
        $umkm = $this->umkm(['opening_time' => '08:00', 'closing_time' => '17:00']);

        $this->saatWib('2026-08-04 07:59');
        $this->assertFalse($umkm->is_open_now);

        $this->saatWib('2026-08-04 17:00');       // jam tutup sudah tidak melayani
        $this->assertFalse($umkm->is_open_now);
    }

    public function test_tutup_pada_hari_libur_walau_di_jam_kerja(): void
    {
        $umkm = $this->umkm([
            'opening_time' => '08:00',
            'closing_time' => '17:00',
            'closed_days' => [7],                  // libur Minggu
        ]);

        $this->saatWib('2026-08-09 10:00');        // Minggu
        $this->assertFalse($umkm->is_open_now);

        $this->saatWib('2026-08-10 10:00');        // Senin
        $this->assertTrue($umkm->is_open_now);
    }

    public function test_jam_lewat_tengah_malam_tetap_terhitung_buka(): void
    {
        $umkm = $this->umkm(['opening_time' => '18:00', 'closing_time' => '02:00']);

        $this->saatWib('2026-08-04 20:00');
        $this->assertTrue($umkm->is_open_now);

        $this->saatWib('2026-08-05 01:30');        // masih sesi Selasa malam
        $this->assertTrue($umkm->is_open_now);

        $this->saatWib('2026-08-05 02:00');
        $this->assertFalse($umkm->is_open_now);
    }

    public function test_dini_hari_mengikuti_hari_libur_sesi_sebelumnya(): void
    {
        $umkm = $this->umkm([
            'opening_time' => '18:00',
            'closing_time' => '02:00',
            'closed_days' => [1],                  // libur Senin
        ]);

        // Selasa pukul 01.00 masih bagian dari sesi Senin, jadi tetap tutup.
        $this->saatWib('2026-08-11 01:00');
        $this->assertFalse($umkm->is_open_now);

        // Senin pukul 01.00 adalah sesi Minggu malam, toko buka.
        $this->saatWib('2026-08-10 01:00');
        $this->assertTrue($umkm->is_open_now);
    }

    public function test_label_hari_dan_jam(): void
    {
        $setiapHari = $this->umkm(['opening_time' => '08:00', 'closing_time' => '17:30']);
        $this->assertSame('08.00–17.30', $setiapHari->opening_hours_label);
        $this->assertSame('Setiap hari', $setiapHari->open_days_label);

        $rentang = $this->umkm(['opening_time' => '08:00', 'closing_time' => '17:00', 'closed_days' => [7]]);
        $this->assertSame('Senin–Sabtu', $rentang->open_days_label);

        $terpisah = $this->umkm(['opening_time' => '08:00', 'closing_time' => '17:00', 'closed_days' => [3, 5, 7]]);
        $this->assertSame('Senin, Selasa, Kamis, Sabtu', $terpisah->open_days_label);
    }

    public function test_katalog_menampilkan_status_buka(): void
    {
        $this->umkm(['opening_time' => '08:00', 'closing_time' => '17:00']);

        $this->saatWib('2026-08-04 10:00');

        $this->get(route('catalog.index'))->assertOk()->assertSee('Buka');
        $this->get(route('home'))->assertOk()->assertSee('Buka');
    }

    public function test_halaman_toko_menampilkan_jam_lengkap(): void
    {
        $umkm = $this->umkm(['opening_time' => '07:00', 'closing_time' => '17:00', 'closed_days' => [7]]);

        $this->saatWib('2026-08-04 10:00');

        $this->get(route('catalog.show', $umkm))
            ->assertOk()
            ->assertSee('Buka sekarang')
            ->assertSee('Senin–Sabtu · 07.00–17.00 WIB');
    }

    public function test_toko_tanpa_jam_buka_tidak_memasang_status_apa_pun(): void
    {
        $umkm = $this->umkm();

        $this->get(route('catalog.show', $umkm))
            ->assertOk()
            ->assertDontSee('Buka sekarang')
            ->assertDontSee('Sedang tutup');
    }

    public function test_admin_dapat_menyimpan_jam_buka_dan_hari_libur(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('admin.umkm.store'), [
                'name' => 'Toko Baru',
                'category_id' => $this->category->id,
                'price_range' => 'Rp 10rb–20rb',
                'whatsapp' => '6281234567890',
                'opening_time' => '09:00',
                'closing_time' => '21:00',
                'closed_days' => [7],
            ])
            ->assertRedirect(route('admin.umkm.index'));

        $umkm = Umkm::where('name', 'Toko Baru')->firstOrFail();

        $this->assertSame('09.00–21.00', $umkm->opening_hours_label);
        $this->assertSame([7], $umkm->closed_days);
    }

    public function test_jam_tutup_tanpa_jam_buka_ditolak(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('admin.umkm.store'), [
                'name' => 'Toko Baru',
                'category_id' => $this->category->id,
                'price_range' => 'Rp 10rb–20rb',
                'whatsapp' => '6281234567890',
                'closing_time' => '21:00',
            ])
            ->assertSessionHasErrors('opening_time');

        $this->assertDatabaseMissing('umkms', ['name' => 'Toko Baru']);
    }

    public function test_hari_libur_diabaikan_bila_jam_buka_dikosongkan(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('admin.umkm.store'), [
                'name' => 'Toko Baru',
                'category_id' => $this->category->id,
                'price_range' => 'Rp 10rb–20rb',
                'whatsapp' => '6281234567890',
                'closed_days' => [7],
            ])
            ->assertRedirect(route('admin.umkm.index'));

        $this->assertNull(Umkm::where('name', 'Toko Baru')->firstOrFail()->closed_days);
    }
}
