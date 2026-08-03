<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEvent;
use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Laporan dampak katalog: berapa lead yang dikirim ke tiap toko, per periode.
 * Ini bahan yang dipakai kelurahan untuk mempertanggungjawabkan program.
 */
class ReportController extends Controller
{
    /** 0 berarti seluruh data, tanpa batas tanggal. */
    private const PERIODS = [7 => '7 hari', 30 => '30 hari', 90 => '90 hari', 0 => 'Semua'];

    public function index(Request $request)
    {
        $days = (int) $request->query('periode', 30);

        if (! array_key_exists($days, self::PERIODS)) {
            $days = 30;
        }

        $umkms = Umkm::query()
            ->with('category')
            ->withCount([
                'contactEvents as kontak' => fn (Builder $q) => $this->window($q, $days),
                'contactEvents as kontak_wa' => fn (Builder $q) => $this->window($q, $days)->channel(ContactEvent::CHANNEL_WHATSAPP),
                'contactEvents as kontak_shopee' => fn (Builder $q) => $this->window($q, $days)->channel(ContactEvent::CHANNEL_SHOPEE),
                'contactEvents as kontak_menu' => fn (Builder $q) => $this->window($q, $days)->where('source', ContactEvent::SOURCE_MENU),
            ])
            ->orderByDesc('kontak')
            ->orderBy('name')
            ->get();

        if ($request->query('export') === 'csv') {
            return $this->exportCsv($umkms, $days);
        }

        $topMenus = Menu::query()
            ->with('umkm:id,name')
            ->withCount(['contactEvents as kontak' => fn (Builder $q) => $this->window($q, $days)])
            ->orderByDesc('kontak')
            ->take(10)
            ->get()
            ->filter(fn (Menu $m) => $m->kontak > 0);

        $total = [
            'semua' => $umkms->sum('kontak'),
            'wa' => $umkms->sum('kontak_wa'),
            'shopee' => $umkms->sum('kontak_shopee'),
            'menu' => $umkms->sum('kontak_menu'),
            'toko_aktif' => $umkms->where('kontak', '>', 0)->count(),
        ];

        $trend = ContactEvent::dailySeries($days > 0 ? min($days, 30) : 30);

        return view('admin.laporan', [
            'umkms' => $umkms,
            'topMenus' => $topMenus,
            'total' => $total,
            'trend' => $trend,
            'days' => $days,
            'periods' => self::PERIODS,
        ]);
    }

    private function window(Builder $query, int $days): Builder
    {
        return $days > 0 ? $query->lastDays($days) : $query;
    }

    private function exportCsv($umkms, int $days): StreamedResponse
    {
        $label = $days > 0 ? "{$days}-hari" : 'semua';
        $filename = "laporan-kontak-umkm-{$label}-" . now()->format('Ymd') . '.csv';

        return response()->streamDownload(function () use ($umkms) {
            $out = fopen('php://output', 'w');

            fputcsv($out, ['Toko', 'Kategori', 'Kontak WhatsApp', 'Kontak Shopee', 'Dari halaman menu', 'Total kontak']);

            foreach ($umkms as $u) {
                fputcsv($out, [
                    $u->name,
                    $u->category?->name,
                    $u->kontak_wa,
                    $u->kontak_shopee,
                    $u->kontak_menu,
                    $u->kontak,
                ]);
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
