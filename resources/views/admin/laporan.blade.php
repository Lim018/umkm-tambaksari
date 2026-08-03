<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-navy">Laporan kontak</h1>
                <p class="mt-0.5 text-sm text-slate-500">Berapa calon pembeli yang dikirim katalog ke tiap toko</p>
            </div>
            <a href="{{ route('admin.laporan', ['periode' => $days, 'export' => 'csv']) }}"
               class="inline-flex items-center rounded-md border border-slate-300 bg-white px-3.5 py-2 text-sm font-semibold text-slate-700 hover:border-slate-400">
                Unduh CSV
            </a>
        </div>
    </x-slot>

    {{-- filter periode, satu baris di atas grafik --}}
    <div class="mb-4 flex flex-wrap items-center gap-2">
        <span class="mr-1 text-xs font-medium uppercase tracking-wide text-slate-400">Periode</span>
        @foreach ($periods as $value => $label)
            <a href="{{ route('admin.laporan', ['periode' => $value]) }}"
               @class([
                   'rounded-md border px-3 py-1.5 text-sm font-medium transition-colors',
                   'border-primary bg-primary text-white' => $days === $value,
                   'border-slate-300 bg-white text-slate-600 hover:border-slate-400' => $days !== $value,
               ])>
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">
        @foreach ([
            ['label' => 'Total kontak', 'val' => $total['semua']],
            ['label' => 'Via WhatsApp', 'val' => $total['wa']],
            ['label' => 'Via Shopee', 'val' => $total['shopee']],
            ['label' => 'Toko dapat kontak', 'val' => $total['toko_aktif']],
        ] as $s)
            <div class="rounded-lg border border-slate-200 bg-white p-4">
                <p class="text-xs font-medium text-slate-500">{{ $s['label'] }}</p>
                <p class="mt-2 text-2xl font-semibold tabular-nums text-navy">{{ $s['val'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        <x-contact-trend-chart :trend="$trend" title="Tren kontak harian" />
    </div>

    <section class="mt-6 rounded-lg border border-slate-200 bg-white">
        <div class="border-b border-slate-200 px-4 py-3 sm:px-5">
            <h2 class="text-sm font-semibold text-navy">Kontak per toko</h2>
            <p class="mt-0.5 text-xs text-slate-500">Kolom "dari menu" berarti pengunjung menekan tombol pesan pada satu item menu</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="border-b border-slate-100 bg-slate-50 text-xs font-medium uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3 sm:px-5">Toko</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3 text-right">WhatsApp</th>
                        <th class="px-4 py-3 text-right">Shopee</th>
                        <th class="px-4 py-3 text-right">Dari menu</th>
                        <th class="px-4 py-3 text-right sm:px-5">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($umkms as $u)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 font-medium text-navy sm:px-5">
                                <a href="{{ route('admin.umkm.edit', $u) }}" class="hover:underline">{{ $u->name }}</a>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $u->category?->name }}</td>
                            <td class="px-4 py-3 text-right tabular-nums text-slate-600">{{ $u->kontak_wa }}</td>
                            <td class="px-4 py-3 text-right tabular-nums text-slate-600">{{ $u->kontak_shopee }}</td>
                            <td class="px-4 py-3 text-right tabular-nums text-slate-600">{{ $u->kontak_menu }}</td>
                            <td @class([
                                    'px-4 py-3 text-right font-semibold tabular-nums sm:px-5',
                                    'text-navy' => $u->kontak > 0,
                                    'text-slate-300' => $u->kontak === 0,
                                ])>{{ $u->kontak }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-500 sm:px-5">
                                Belum ada toko.
                                <a href="{{ route('admin.umkm.create') }}" class="font-medium text-primary hover:underline">Tambah toko</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="mt-6 rounded-lg border border-slate-200 bg-white">
        <div class="border-b border-slate-200 px-4 py-3 sm:px-5">
            <h2 class="text-sm font-semibold text-navy">Menu paling diminati</h2>
            <p class="mt-0.5 text-xs text-slate-500">Dipakai untuk menyarankan toko menonjolkan menu yang benar</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="border-b border-slate-100 bg-slate-50 text-xs font-medium uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3 sm:px-5">Menu</th>
                        <th class="px-4 py-3">Toko</th>
                        <th class="px-4 py-3 text-right">Harga</th>
                        <th class="px-4 py-3 text-right sm:px-5">Kontak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($topMenus as $m)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 font-medium text-navy sm:px-5">{{ $m->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $m->umkm?->name }}</td>
                            <td class="px-4 py-3 text-right tabular-nums text-slate-600">{{ $m->formatted_price }}</td>
                            <td class="px-4 py-3 text-right font-semibold tabular-nums text-navy sm:px-5">{{ $m->kontak }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-slate-500 sm:px-5">
                                Belum ada klik pada item menu di periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
