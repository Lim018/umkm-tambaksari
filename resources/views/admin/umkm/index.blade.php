<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-navy">Toko UMKM</h1>
                <p class="mt-0.5 text-sm text-slate-500">Kelola data toko dan menu masing-masing</p>
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

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="border-b border-slate-100 bg-slate-50 text-xs font-medium uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3 sm:px-5">Toko</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Jam buka</th>
                        <th class="px-4 py-3">Menu</th>
                        <th class="px-4 py-3">Kontak 30h</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right sm:px-5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($umkms as $u)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 sm:px-5">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 shrink-0 overflow-hidden rounded-md bg-slate-100"
                                         @if (! $u->photo_path) style="background: {{ $u->pastel_bg }};" @endif>
                                        @if ($u->photo_path)
                                            <img src="{{ asset('storage/' . $u->photo_path) }}" alt="" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate font-medium text-navy">{{ $u->name }}</p>
                                        <p class="truncate text-xs text-slate-500">{{ $u->price_range }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $u->category?->name }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-600">
                                @if ($u->has_opening_hours)
                                    <span class="tabular-nums">{{ $u->opening_hours_label }}</span>
                                    <span class="block text-xs text-slate-400">{{ $u->open_days_label }}</span>
                                @else
                                    <span class="text-slate-300">Belum diisi</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 tabular-nums text-slate-600">{{ $u->menus_count }}</td>
                            <td class="px-4 py-3 tabular-nums">
                                @if ($u->kontak_30 > 0)
                                    <span class="font-semibold text-navy">{{ $u->kontak_30 }}</span>
                                @else
                                    <span class="text-slate-300">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @if ($u->is_featured)
                                        <span class="rounded bg-slate-100 px-1.5 py-0.5 text-[11px] font-medium text-slate-700">Unggulan</span>
                                    @endif
                                    @if ($u->is_bestseller)
                                        <span class="rounded bg-slate-100 px-1.5 py-0.5 text-[11px] font-medium text-slate-700">Terlaris</span>
                                    @endif
                                    @if (! $u->is_featured && ! $u->is_bestseller)
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right sm:px-5">
                                <a href="{{ route('admin.umkm.menu.index', $u) }}" class="font-medium text-slate-700 hover:text-navy">Menu</a>
                                <a href="{{ route('admin.umkm.edit', $u) }}" class="ml-3 font-medium text-primary hover:underline">Edit</a>
                                <form action="{{ route('admin.umkm.destroy', $u) }}" method="POST" class="ml-3 inline"
                                      onsubmit="return confirm('Hapus toko {{ $u->name }} beserta menunya?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-slate-500 sm:px-5">
                                Belum ada toko.
                                <a href="{{ route('admin.umkm.create') }}" class="font-medium text-primary hover:underline">Tambah toko</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($umkms->hasPages())
        <div class="mt-4">{{ $umkms->links() }}</div>
    @endif
</x-app-layout>
