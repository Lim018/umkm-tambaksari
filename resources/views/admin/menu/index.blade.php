<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <a href="{{ route('admin.umkm.index') }}" class="text-sm font-medium text-slate-500 hover:text-primary">← Toko UMKM</a>
                <h1 class="mt-1 text-xl font-semibold tracking-tight text-navy">Menu · {{ $umkm->name }}</h1>
                <p class="mt-0.5 text-sm text-slate-500">{{ $umkm->category?->name }} · {{ $umkm->kelurahan }}</p>
            </div>
            <a href="{{ route('admin.umkm.menu.create', $umkm) }}"
               class="inline-flex items-center rounded-md bg-primary px-3.5 py-2 text-sm font-semibold text-white hover:bg-primary/90">
                Tambah menu
            </a>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="border-b border-slate-100 bg-slate-50 text-xs font-medium uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3 sm:px-5">Produk</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right sm:px-5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($menus as $menu)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 sm:px-5">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 shrink-0 overflow-hidden rounded-md bg-slate-100"
                                         style="background: {{ $umkm->pastel_bg }};">
                                        @if ($menu->photo_path)
                                            <img src="{{ asset('storage/' . $menu->photo_path) }}" alt="" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-navy">{{ $menu->name }}</p>
                                        @if ($menu->description)
                                            <p class="mt-0.5 line-clamp-1 text-xs text-slate-500">{{ $menu->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-medium tabular-nums text-navy">{{ $menu->formatted_price }}</td>
                            <td class="px-4 py-3">
                                @if ($menu->is_available)
                                    <span class="inline-flex rounded bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Tersedia</span>
                                @else
                                    <span class="inline-flex rounded bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">Habis</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right sm:px-5">
                                <a href="{{ route('admin.umkm.menu.edit', [$umkm, $menu]) }}" class="font-medium text-primary hover:underline">Edit</a>
                                <form action="{{ route('admin.umkm.menu.destroy', [$umkm, $menu]) }}" method="POST" class="ml-3 inline"
                                      onsubmit="return confirm('Hapus menu {{ $menu->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-slate-500 sm:px-5">
                                Belum ada menu untuk toko ini.
                                <a href="{{ route('admin.umkm.menu.create', $umkm) }}" class="font-medium text-primary hover:underline">Tambah menu</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($menus->hasPages())
        <div class="mt-4">{{ $menus->links() }}</div>
    @endif
</x-app-layout>
