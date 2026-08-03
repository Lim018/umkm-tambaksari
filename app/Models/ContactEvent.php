<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Satu baris = satu klik tombol kontak (WhatsApp / Shopee) dari pengunjung katalog.
 * Dipakai untuk mengukur dampak katalog: berapa lead yang benar-benar dikirim ke toko.
 */
class ContactEvent extends Model
{
    public const CHANNEL_WHATSAPP = 'whatsapp';
    public const CHANNEL_SHOPEE = 'shopee';

    public const CHANNELS = [self::CHANNEL_WHATSAPP, self::CHANNEL_SHOPEE];

    public const SOURCE_TOKO = 'toko';
    public const SOURCE_MENU = 'menu';

    /** Klik berulang pengunjung yang sama dihitung sekali dalam jendela ini. */
    private const DEDUPE_MINUTES = 30;

    protected $fillable = ['umkm_id', 'menu_id', 'channel', 'source', 'visitor_hash'];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /** Batasi ke rentang N hari terakhir (termasuk hari ini). */
    public function scopeLastDays(Builder $query, int $days): Builder
    {
        return $query->where('created_at', '>=', self::startOfWindow($days));
    }

    public function scopeChannel(Builder $query, string $channel): Builder
    {
        return $query->where('channel', $channel);
    }

    /**
     * Catat klik. Mengembalikan null bila diabaikan (bot atau klik duplikat),
     * supaya pemanggil tetap bisa melanjutkan redirect tanpa peduli hasilnya.
     */
    public static function record(Request $request, Umkm $umkm, ?Menu $menu, string $channel): ?self
    {
        if (! in_array($channel, self::CHANNELS, true) || self::looksLikeBot($request)) {
            return null;
        }

        $hash = self::visitorHash($request);

        $alreadyCounted = self::query()
            ->where('umkm_id', $umkm->id)
            ->where('menu_id', $menu?->id)
            ->where('channel', $channel)
            ->where('visitor_hash', $hash)
            ->where('created_at', '>=', now()->subMinutes(self::DEDUPE_MINUTES))
            ->exists();

        if ($alreadyCounted) {
            return null;
        }

        return self::create([
            'umkm_id' => $umkm->id,
            'menu_id' => $menu?->id,
            'channel' => $channel,
            'source' => $menu ? self::SOURCE_MENU : self::SOURCE_TOKO,
            'visitor_hash' => $hash,
        ]);
    }

    /**
     * Jumlah klik per hari per channel untuk N hari terakhir, sudah diisi nol
     * pada hari tanpa data supaya grafik tidak bolong.
     *
     * @return array{labels: list<string>, tanggal: list<string>, series: array<string, list<int>>, max: int, total: int}
     */
    public static function dailySeries(int $days, ?int $umkmId = null): array
    {
        $rows = self::query()
            ->when($umkmId, fn (Builder $q) => $q->where('umkm_id', $umkmId))
            ->lastDays($days)
            ->selectRaw('date(created_at) as hari, channel, count(*) as total')
            ->groupBy('hari', 'channel')
            ->get();

        $labels = [];
        $tanggal = [];
        $series = array_fill_keys(self::CHANNELS, []);
        $max = 0;
        $total = 0;

        $cursor = self::startOfWindow($days);

        for ($i = 0; $i < $days; $i++) {
            $key = $cursor->toDateString();
            $labels[] = $cursor->translatedFormat('j M');
            $tanggal[] = $key;

            $harian = 0;
            foreach (self::CHANNELS as $channel) {
                $n = (int) $rows->first(fn ($r) => $r->hari === $key && $r->channel === $channel)?->total;
                $series[$channel][] = $n;
                $harian += $n;
            }

            $max = max($max, $harian);
            $total += $harian;
            $cursor = $cursor->addDay();
        }

        return compact('labels', 'tanggal', 'series', 'max', 'total');
    }

    private static function startOfWindow(int $days): Carbon
    {
        return now()->subDays($days - 1)->startOfDay();
    }

    /**
     * Hash pengunjung untuk deduplikasi. Dirotasi harian dan digarami APP_KEY,
     * jadi tidak bisa dipakai melacak orang lintas hari dan tidak menyimpan IP mentah.
     */
    private static function visitorHash(Request $request): string
    {
        return hash('sha256', implode('|', [
            $request->ip(),
            (string) $request->userAgent(),
            config('app.key'),
            now()->toDateString(),
        ]));
    }

    /** Crawler dan pengambil pratinjau tautan tidak boleh menggelembungkan angka. */
    private static function looksLikeBot(Request $request): bool
    {
        $ua = strtolower((string) $request->userAgent());

        if ($ua === '') {
            return true;
        }

        foreach (['bot', 'crawl', 'spider', 'slurp', 'headless', 'preview', 'facebookexternalhit', 'whatsapp', 'telegram'] as $needle) {
            if (str_contains($ua, $needle)) {
                return true;
            }
        }

        return false;
    }
}
