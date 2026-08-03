<?php

namespace App\Http\Controllers;

use App\Models\ContactEvent;
use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Http\Request;

/**
 * Pintu keluar untuk semua tombol kontak. Klik dicatat lebih dulu, lalu pengunjung
 * diteruskan ke WhatsApp/Shopee. Pencatatan tidak boleh menghalangi redirect.
 */
class ContactRedirectController extends Controller
{
    /** Tombol kontak di kartu katalog dan header halaman toko. */
    public function umkm(Request $request, Umkm $umkm, string $channel)
    {
        $target = $channel === ContactEvent::CHANNEL_SHOPEE
            ? $umkm->shopee_url
            : $umkm->whatsapp_url;

        abort_if(blank($target), 404);

        ContactEvent::record($request, $umkm, null, $channel);

        return $this->leave($target);
    }

    /** Tombol "Pesan WhatsApp" pada satu item menu. */
    public function menu(Request $request, Menu $menu)
    {
        $menu->load('umkm');

        abort_if($menu->umkm === null, 404);

        ContactEvent::record($request, $menu->umkm, $menu, ContactEvent::CHANNEL_WHATSAPP);

        return $this->leave($menu->whatsapp_url);
    }

    /** Halaman antara ini tidak boleh masuk indeks mesin pencari. */
    private function leave(string $target)
    {
        return redirect()->away($target)->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
