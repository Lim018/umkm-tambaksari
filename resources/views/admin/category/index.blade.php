<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold leading-tight text-navy">Kelola Kategori</h2>
            <a href="{{ route('admin.kategori.create') }}" class="rounded-pill bg-gradient-to-br from-primary to-ungu px-5 py-2.5 text-sm font-bold text-white">+ Kategori Baru</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-xl bg-teal/15 px-4 py-3 text-sm font-semibold text-teal">{{ session('status') }}</div>
            @endif

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                @foreach ($categories as $c)
                    <div class="rounded-2xl border border-white/80 bg-white/85 p-5 text-center shadow-soft backdrop-blur">
                        <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl text-2xl" style="background: {{ $c->tint }};">{{ $c->icon }}</span>
                        <p class="mt-3 font-bold text-navy">{{ $c->name }}</p>
                        <p class="text-xs text-grey-soft">{{ $c->umkms_count }} UMKM</p>
                        <div class="mt-3 flex items-center justify-center gap-3 text-sm">
                            <a href="{{ route('admin.kategori.edit', $c) }}" class="font-bold text-primary">Edit</a>
                            <form action="{{ route('admin.kategori.destroy', $c) }}" method="POST"
                                  onsubmit="return confirm('Hapus kategori {{ $c->name }}? UMKM di dalamnya ikut terhapus.')">
                                @csrf @method('DELETE')
                                <button class="font-bold text-red-500">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $categories->links() }}</div>
        </div>
    </div>
</x-app-layout>
