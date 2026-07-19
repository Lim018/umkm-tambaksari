<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'accent_color', 'tint'];

    public function umkms(): HasMany
    {
        return $this->hasMany(Umkm::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
