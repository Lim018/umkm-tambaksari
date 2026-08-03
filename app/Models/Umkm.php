<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Umkm extends Model
{
    /**
     * Nama hari untuk nomor hari ISO (1 = Senin ... 7 = Minggu). Dipakai baik oleh
     * form admin maupun label jam buka di halaman publik.
     */
    public const DAY_NAMES = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];

    /**
     * Jam buka selalu dibaca dalam waktu Surabaya, terlepas dari APP_TIMEZONE.
     * Mengubah APP_TIMEZONE akan menggeser stempel waktu contact_events, jadi
     * zona waktu tampilan sengaja dipisahkan.
     */
    public const TIMEZONE = 'Asia/Jakarta';

    protected $fillable = [
        'name', 'category_id', 'kelurahan', 'price_range', 'description', 'photo_path',
        'pastel_bg', 'whatsapp', 'shopee_url', 'is_featured', 'is_bestseller',
        'opening_time', 'closing_time', 'closed_days',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
        'closed_days' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class)->orderBy('sort_order')->orderBy('name');
    }

    public function contactEvents(): HasMany
    {
        return $this->hasMany(ContactEvent::class);
    }

    /** Sertakan hitungan kontak yang dipakai badge popularitas publik. */
    public function scopeWithPopularity(Builder $query): Builder
    {
        return $query->withCount([
            'contactEvents as kontak_populer' => fn (Builder $q) => $q->lastDays(ContactEvent::POPULARITY_DAYS),
        ]);
    }

    /** Link WhatsApp siap-pakai. */
    public function getWhatsappUrlAttribute(): string
    {
        $text = rawurlencode('Halo saya tertarik dengan produk Anda');
        return "https://wa.me/{$this->whatsapp}?text={$text}";
    }

    public function getHasOpeningHoursAttribute(): bool
    {
        return filled($this->opening_time) && filled($this->closing_time);
    }

    /** Contoh: "08.00–17.00". Null bila jam buka belum diisi. */
    public function getOpeningHoursLabelAttribute(): ?string
    {
        if (! $this->has_opening_hours) {
            return null;
        }

        return $this->jam($this->opening_time) . '–' . $this->jam($this->closing_time);
    }

    /** Contoh: "Setiap hari" atau "Senin–Sabtu". Null bila jam buka belum diisi. */
    public function getOpenDaysLabelAttribute(): ?string
    {
        if (! $this->has_opening_hours) {
            return null;
        }

        $libur = $this->closedDayNumbers();

        if ($libur === []) {
            return 'Setiap hari';
        }

        $buka = array_values(array_diff(array_keys(self::DAY_NAMES), $libur));

        if ($buka === []) {
            return 'Tutup sementara';
        }

        // Rentang berurutan ditulis ringkas, sisanya dipisah koma.
        $berurutan = $buka === range($buka[0], $buka[0] + count($buka) - 1);

        if ($berurutan && count($buka) > 2) {
            return self::DAY_NAMES[$buka[0]] . '–' . self::DAY_NAMES[end($buka)];
        }

        return implode(', ', array_map(fn (int $d) => self::DAY_NAMES[$d], $buka));
    }

    /**
     * Apakah toko sedang buka menurut waktu Surabaya.
     * Null berarti jam buka belum diisi, jadi statusnya tidak diklaim apa pun.
     */
    public function getIsOpenNowAttribute(): ?bool
    {
        if (! $this->has_opening_hours) {
            return null;
        }

        $sekarang = now(self::TIMEZONE);
        $menitSekarang = (int) $sekarang->format('G') * 60 + (int) $sekarang->format('i');

        $buka = $this->menit($this->opening_time);
        $tutup = $this->menit($this->closing_time);

        // Jam tutup lebih kecil berarti melewati tengah malam, mis. 18.00–02.00.
        // Jam sesudah tengah malam masih milik hari kerja sebelumnya.
        $lewatTengahMalam = $tutup <= $buka;

        $hari = $sekarang->dayOfWeekIso;
        $hariKerja = $lewatTengahMalam && $menitSekarang < $tutup
            ? ($hari === 1 ? 7 : $hari - 1)
            : $hari;

        if (in_array($hariKerja, $this->closedDayNumbers(), true)) {
            return false;
        }

        return $lewatTengahMalam
            ? $menitSekarang >= $buka || $menitSekarang < $tutup
            : $menitSekarang >= $buka && $menitSekarang < $tutup;
    }

    /** @return list<int> */
    private function closedDayNumbers(): array
    {
        return array_values(array_filter(
            array_map('intval', $this->closed_days ?? []),
            fn (int $d) => isset(self::DAY_NAMES[$d]),
        ));
    }

    /** "17:30:00" → "17.30" */
    private function jam(string $time): string
    {
        return str_replace(':', '.', substr($time, 0, 5));
    }

    private function menit(string $time): int
    {
        [$j, $m] = array_pad(explode(':', $time), 2, '0');

        return (int) $j * 60 + (int) $m;
    }
}
