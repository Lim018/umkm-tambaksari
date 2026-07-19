<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold leading-tight text-navy">Kelola UMKM</h2>
            <a href="{{ route('admin.umkm.create') }}" class="rounded-pill bg-gradient-to-br from-primary to-ungu px-5 py-2.5 text-sm font-bold text-white">+ UMKM Baru</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-xl bg-teal/15 px-4 py-3 text-sm font-semibold text-teal">{{ session('status') }}</div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-white/80 bg-white/85 shadow-soft backdrop-blur">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-grey-soft/15 text-left">
                        <thead class="text-xs uppercase tracking-wide text-grey-soft">
                            <tr>
                                <th class="px-5 py-3">Nama</th>
                                <th class="px-5 py-3">Kategori</th>
                                <th class="px-5 py-3">Kelurahan</th>
                                <th class="px-5 py-3">Harga</th>
                                <th class="px-5 py-3">Label</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-grey-soft/10">
                            @forelse ($umkms as $u)
                                <tr class="text-sm">
                                    <td class="px-5 py-3 font-semibold text-navy">{{ $u->name }}</td>
                                    <td class="px-5 py-3 text-grey-soft">{{ $u->category?->name }}</td>
                                    <td class="px-5 py-3 text-grey-soft">{{ $u->kelurahan }}</td>
                                    <td class="px-5 py-3 text-navy">{{ $u->price_range }}</td>
                                    <td class="px-5 py-3">
                                        @if ($u->is_featured)<span class="mr-1 rounded-pill bg-primary/10 px-2 py-0.5 text-xs font-bold text-primary">Unggulan</span>@endif
                                        @if ($u->is_bestseller)<span class="rounded-pill bg-coral/10 px-2 py-0.5 text-xs font-bold text-coral">Terlaris</span>@endif
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <a href="{{ route('admin.umkm.edit', $u) }}" class="font-bold text-primary">Edit</a>
                                        <form action="{{ route('admin.umkm.destroy', $u) }}" method="POST" class="ml-3 inline"
                                              onsubmit="return confirm('Hapus {{ $u->name }}?')">
                                            @csrf @method('DELETE')
                                            <button class="font-bold text-red-500">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-5 py-8 text-center text-grey-soft">Belum ada UMKM.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">{{ $umkms->links() }}</div>
        </div>
    </div>
</x-app-layout>
