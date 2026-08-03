<?php

namespace Database\Seeders;

use App\Models\ContactEvent;
use App\Models\Umkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Data kontak buatan untuk melihat badge popularitas tanpa menunggu trafik nyata.
 *
 *   php artisan db:seed --class=DemoContactEventSeeder
 *
 * Sengaja TIDAK dipanggil DatabaseSeeder supaya `migrate:fresh --seed` tidak
 * pernah menghasilkan angka palsu yang bisa terbawa ke laporan sungguhan.
 * Seeder ini mengosongkan tabel contact_events lebih dulu.
 */
class DemoContactEventSeeder extends Seeder
{
    /**
     * Total kontak per toko, dipilih supaya semua keadaan badge terlihat:
     * sangat ramai, ramai, sedang, pas di atas ambang, dan di bawah ambang.
     */
    private const TARGET_TOTALS = [34, 18, 9, 6, 2, 12];

    /** Porsi target yang jatuh ke menu ke-1, ke-2, dan ke-3 sebuah toko. */
    private const MENU_SHARE = [0.45, 0.20, 0.06];

    public function run(): void
    {
        if (app()->isProduction()) {
            $this->command->error('DemoContactEventSeeder tidak boleh jalan di production.');

            return;
        }

        $umkms = Umkm::with('menus')->orderBy('id')->get();

        if ($umkms->isEmpty()) {
            $this->command->warn('Belum ada UMKM. Jalankan CatalogSeeder dulu.');

            return;
        }

        $lama = ContactEvent::count();
        ContactEvent::query()->delete();
        $this->command->warn("Menghapus {$lama} baris contact_events yang lama.");

        // Angka acak yang dapat diulang, supaya tampilan sama tiap kali di-seed.
        mt_srand(20260804);

        $rows = [];

        foreach ($umkms->values() as $i => $umkm) {
            $target = self::TARGET_TOTALS[$i % count(self::TARGET_TOTALS)];
            $terpakai = 0;

            foreach ($umkm->menus->take(count(self::MENU_SHARE))->values() as $m => $menu) {
                $jumlah = (int) round($target * self::MENU_SHARE[$m]);
                $terpakai += $jumlah;

                for ($n = 0; $n < $jumlah; $n++) {
                    // Tombol menu hanya mengarah ke WhatsApp.
                    $rows[] = $this->row($umkm, $menu->id, ContactEvent::CHANNEL_WHATSAPP, ContactEvent::SOURCE_MENU, "m{$menu->id}-{$n}");
                }
            }

            for ($n = 0; $n < max(0, $target - $terpakai); $n++) {
                $pakaiShopee = $umkm->shopee_url && $n % 3 === 0;

                $rows[] = $this->row(
                    $umkm,
                    null,
                    $pakaiShopee ? ContactEvent::CHANNEL_SHOPEE : ContactEvent::CHANNEL_WHATSAPP,
                    ContactEvent::SOURCE_TOKO,
                    "t{$umkm->id}-{$n}",
                );
            }

            // Beberapa kontak kedaluwarsa pada toko teramai, untuk membuktikan
            // badge hanya menghitung jendela 30 hari.
            if ($i === 0) {
                for ($n = 0; $n < 15; $n++) {
                    $rows[] = $this->row($umkm, null, ContactEvent::CHANNEL_WHATSAPP, ContactEvent::SOURCE_TOKO, "old{$n}", mt_rand(31, 60));
                }
            }
        }

        foreach (array_chunk($rows, 200) as $chunk) {
            ContactEvent::insert($chunk);
        }

        $this->command->info(count($rows) . ' kontak demo dibuat.');
        $this->laporkan($umkms);
    }

    private function row(Umkm $umkm, ?int $menuId, string $channel, string $source, string $benih, ?int $umurHari = null): array
    {
        // Condongkan ke hari-hari terakhir supaya grafik tren tidak rata.
        $umurHari ??= min(mt_rand(0, ContactEvent::POPULARITY_DAYS - 1), mt_rand(0, ContactEvent::POPULARITY_DAYS - 1));

        $waktu = Carbon::now()->subDays($umurHari)->setTime(mt_rand(7, 21), mt_rand(0, 59));

        return [
            'umkm_id' => $umkm->id,
            'menu_id' => $menuId,
            'channel' => $channel,
            'source' => $source,
            'visitor_hash' => hash('sha256', "demo-{$umkm->id}-{$benih}"),
            'created_at' => $waktu,
            'updated_at' => $waktu,
        ];
    }

    private function laporkan($umkms): void
    {
        $baris = Umkm::withPopularity()->orderByDesc('kontak_populer')->get()
            ->map(fn (Umkm $u) => [
                $u->name,
                $u->kontak_populer,
                $u->kontak_populer >= ContactEvent::POPULARITY_MIN_UMKM ? 'ya' : 'tidak (di bawah ambang)',
            ])
            ->all();

        $this->command->table(['Toko', 'Kontak 30 hari', 'Badge tampil'], $baris);
    }
}
