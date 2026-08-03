<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'umkm_id',
        'name',
        'price',
        'description',
        'photo_path',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'integer',
        'is_available' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    public function contactEvents(): HasMany
    {
        return $this->hasMany(ContactEvent::class);
    }

    /** Format harga Rupiah, mis. Rp 15.000 */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /** Link WhatsApp dengan pesan yang menyebut menu ini. */
    public function getWhatsappUrlAttribute(): string
    {
        $text = rawurlencode("Halo, saya tertarik dengan {$this->name} di {$this->umkm->name}");

        return "https://wa.me/{$this->umkm->whatsapp}?text={$text}";
    }
}
