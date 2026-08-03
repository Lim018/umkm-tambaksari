<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold leading-tight text-navy">Panel Admin</h2>
            <a href="{{ route('home') }}" class="text-sm font-semibold text-primary">Lihat Situs →</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-xl bg-teal/15 px-4 py-3 text-sm font-semibold text-teal">{{ session('status') }}</div>
            @endif

            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                @foreach ([
                    ['label' => 'Total UMKM', 'val' => $stats['umkm'], 'color' => 'text-primary'],
                    ['label' => 'Kelurahan', 'val' => $stats['kelurahan'], 'color' => 'text-ungu'],
                    ['label' => 'Unggulan', 'val' => $stats['featured'], 'color' => 'text-coral'],
                    ['label' => 'Terlaris', 'val' => $stats['bestseller'], 'color' => 'text-teal'],
                ] as $s)
                    <div class="rounded-2xl border border-white/80 bg-white/80 p-5 shadow-soft backdrop-blur">
                        <p class="text-sm font-medium text-grey-soft">{{ $s['label'] }}</p>
                        <p class="mt-1 text-3xl font-extrabold {{ $s['color'] }}">{{ $s['val'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('admin.umkm.index') }}" class="rounded-pill bg-gradient-to-br from-primary to-ungu px-5 py-2.5 text-sm font-bold text-white">Kelola UMKM</a>
                <a href="{{ route('admin.umkm.create') }}" class="rounded-pill border border-white/90 bg-white/70 px-5 py-2.5 text-sm font-bold text-navy">+ UMKM Baru</a>
            </div>

            <div class="mt-8 rounded-2xl border border-white/80 bg-white/80 p-6 shadow-soft backdrop-blur">
                <h3 class="mb-4 text-lg font-bold text-navy">UMKM Terbaru</h3>
                <ul class="divide-y divide-grey-soft/15">
                    @forelse ($recent as $u)
                        <li class="flex items-center justify-between py-3">
                            <div>
                                <p class="font-semibold text-navy">{{ $u->name }}</p>
                                <p class="text-sm text-grey-soft">{{ $u->category?->name }} · {{ $u->kelurahan }}</p>
                            </div>
                            <a href="{{ route('admin.umkm.edit', $u) }}" class="text-sm font-bold text-primary">Edit</a>
                        </li>
                    @empty
                        <li class="py-3 text-grey-soft">Belum ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
