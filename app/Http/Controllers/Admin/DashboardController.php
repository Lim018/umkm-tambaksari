<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEvent;
use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    /** Panjang jendela grafik tren di dashboard, dalam hari. */
    private const TREND_DAYS = 14;

    public function index()
    {
        $stats = [
            'umkm' => Umkm::count(),
            'menu' => Menu::count(),
            'kontak_30' => ContactEvent::lastDays(30)->count(),
            'kontak_hari_ini' => ContactEvent::whereDate('created_at', today())->count(),
            'featured' => Umkm::where('is_featured', true)->count(),
            'bestseller' => Umkm::where('is_bestseller', true)->count(),
        ];

        $trend = ContactEvent::dailySeries(self::TREND_DAYS);

        $topUmkms = Umkm::query()
            ->withCount([
                'contactEvents as kontak' => fn (Builder $q) => $q->lastDays(30),
                'contactEvents as kontak_wa' => fn (Builder $q) => $q->lastDays(30)->channel(ContactEvent::CHANNEL_WHATSAPP),
                'contactEvents as kontak_shopee' => fn (Builder $q) => $q->lastDays(30)->channel(ContactEvent::CHANNEL_SHOPEE),
            ])
            ->orderByDesc('kontak')
            ->take(5)
            ->get()
            ->filter(fn (Umkm $u) => $u->kontak > 0);

        $recent = Umkm::with('category')->latest('id')->take(6)->get();

        return view('admin.dashboard', compact('stats', 'trend', 'topUmkms', 'recent'));
    }
}
