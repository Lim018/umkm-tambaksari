<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-navy">Dashboard</h1>
                <p class="mt-0.5 text-sm text-slate-500">Ringkasan data katalog UMKM Tambaksari</p>
            </div>
            <a href="{{ route('admin.umkm.create') }}"
               class="inline-flex items-center rounded-md bg-primary px-3.5 py-2 text-sm font-semibold text-white hover:bg-primary/90">
                Tambah toko
            </a>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">
        @foreach ([
            ['label' => 'Toko UMKM', 'val' => $stats['umkm'], 'href' => route('admin.umkm.index')],
            ['label' => 'Menu', 'val' => $stats['menu'], 'href' => route('admin.umkm.index')],
            ['label' => 'Kelurahan', 'val' => $stats['kelurahan'], 'href' => route('admin.umkm.index')],
            ['label' => 'Unggulan', 'val' => $stats['featured'], 'href' => route('admin.umkm.index')],
        ] as $s)
            <a href="{{ $s['href'] }}" class="rounded-lg border border-slate-200 bg-white p-4 hover:border-slate-300">
                <p class="text-xs font-medium text-slate-500">{{ $s['label'] }}</p>
                <p class="mt-2 text-2xl font-semibold tabular-nums text-navy">{{ $s['val'] }}</p>
            </a>
        @endforeach
    </div>

    <section class="mt-6 rounded-lg border border-slate-200 bg-white">
        <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3 sm:px-5">
            <h2 class="text-sm font-semibold text-navy">Toko terbaru</h2>
            <a href="{{ route('admin.umkm.index') }}" class="text-sm font-medium text-primary hover:underline">Lihat semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="border-b border-slate-100 bg-slate-50 text-xs font-medium uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3 sm:px-5">Nama</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Kelurahan</th>
                        <th class="px-4 py-3 text-right sm:px-5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recent as $u)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 font-medium text-navy sm:px-5">{{ $u->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $u->category?->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $u->kelurahan }}</td>
                            <td class="px-4 py-3 text-right sm:px-5">
                                <a href="{{ route('admin.umkm.menu.index', $u) }}" class="font-medium text-slate-600 hover:text-navy">Menu</a>
                                <a href="{{ route('admin.umkm.edit', $u) }}" class="ml-3 font-medium text-primary hover:underline">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-slate-500 sm:px-5">
                                Belum ada toko.
                                <a href="{{ route('admin.umkm.create') }}" class="font-medium text-primary hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
