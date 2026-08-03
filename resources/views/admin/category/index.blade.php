<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-navy">Kategori</h1>
                <p class="mt-0.5 text-sm text-slate-500">Kelompok usaha di katalog publik</p>
            </div>
            <a href="{{ route('admin.kategori.create') }}"
               class="inline-flex items-center rounded-md bg-primary px-3.5 py-2 text-sm font-semibold text-white hover:bg-primary/90">
                Tambah kategori
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
                        <th class="px-4 py-3 sm:px-5">Kategori</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Jumlah toko</th>
                        <th class="px-4 py-3 text-right sm:px-5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $c)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 sm:px-5">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-9 w-9 place-items-center rounded-md text-base" style="background: {{ $c->tint }};">
                                        {{ $c->icon }}
                                    </span>
                                    <span class="font-medium text-navy">{{ $c->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $c->slug }}</td>
                            <td class="px-4 py-3 tabular-nums text-slate-600">{{ $c->umkms_count }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right sm:px-5">
                                <a href="{{ route('admin.kategori.edit', $c) }}" class="font-medium text-primary hover:underline">Edit</a>
                                <form action="{{ route('admin.kategori.destroy', $c) }}" method="POST" class="ml-3 inline"
                                      onsubmit="return confirm('Hapus kategori {{ $c->name }}? Toko di dalamnya ikut terhapus.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-slate-500 sm:px-5">
                                Belum ada kategori.
                                <a href="{{ route('admin.kategori.create') }}" class="font-medium text-primary hover:underline">Tambah kategori</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($categories->hasPages())
        <div class="mt-4">{{ $categories->links() }}</div>
    @endif
</x-app-layout>
