<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Umkm extends Model
{
    protected $fillable = [
        'name', 'category_id', 'kelurahan', 'price_range', 'description', 'photo_path',
        'pastel_bg', 'whatsapp', 'shopee_url', 'is_featured', 'is_bestseller',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
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
}
