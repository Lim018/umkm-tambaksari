@php($menu = $menu ?? null)

@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <p class="font-semibold">Periksa kembali isian berikut:</p>
        <ul class="mt-1 list-inside list-disc space-y-0.5">
            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="overflow-hidden rounded-xl border border-slate-200 bg-white"
     x-data="{ preview: @js($menu?->photo_path ? asset('storage/' . $menu->photo_path) : null) }">

    <div class="grid md:grid-cols-[200px_1fr]">
        {{-- Gambar --}}
        <div class="border-b border-slate-100 p-5 md:border-b-0 md:border-r">
            <h2 class="text-sm font-semibold text-navy">Gambar</h2>
            <div class="relative mt-3 aspect-square overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
                <template x-if="preview">
                    <img :src="preview" alt="Preview" class="absolute inset-0 h-full w-full object-cover">
                </template>
                <template x-if="!preview">
                    <span class="grid h-full place-items-center text-[11px] text-slate-400">Belum ada gambar</span>
                </template>
            </div>
            <input type="file" name="photo" accept="image/*"
                   @change="const f = $event.target.files[0]; preview = f ? URL.createObjectURL(f) : preview"
                   class="mt-3 block w-full text-xs text-slate-600 file:mr-2 file:rounded-md file:border-0 file:bg-slate-100 file:px-2.5 file:py-1.5 file:text-xs file:font-medium file:text-navy">
            <p class="mt-1 text-[11px] text-slate-500">JPG/PNG, max 4 MB</p>
        </div>

        {{-- Detail --}}
        <div class="p-5 sm:p-6">
            <h2 class="text-sm font-semibold text-navy">Detail menu</h2>
            <p class="mt-0.5 text-xs text-slate-500">Nama, harga, dan deskripsi</p>

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-navy">Nama menu</label>
                    <input name="name" value="{{ old('name', $menu?->name) }}" required placeholder="Contoh: Kopi Susu Gula Aren"
                           class="h-10 w-full rounded-lg border-slate-200 text-sm focus:border-primary focus:ring-primary">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-navy">Harga</label>
                    <div class="flex h-10 overflow-hidden rounded-lg border border-slate-200 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary">
                        <span class="inline-flex items-center bg-slate-50 px-3 text-sm text-slate-500">Rp</span>
                        <input type="number" name="price" value="{{ old('price', $menu?->price) }}" required min="0" step="500" placeholder="15000"
                               class="min-w-0 flex-1 border-0 text-sm focus:ring-0">
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-navy">Urutan tampil</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $menu?->sort_order ?? 0) }}" min="0" max="9999"
                           class="h-10 w-full rounded-lg border-slate-200 text-sm focus:border-primary focus:ring-primary">
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-navy">Deskripsi <span class="font-normal text-slate-400">(opsional)</span></label>
                    <textarea name="description" rows="3" placeholder="Ceritakan singkat produk..."
                              class="w-full rounded-lg border-slate-200 text-sm focus:border-primary focus:ring-primary">{{ old('description', $menu?->description) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="inline-flex items-center gap-2 text-sm text-navy">
                        <input type="checkbox" name="is_available" value="1"
                               @checked(old('is_available', $menu?->is_available ?? true))
                               class="rounded border-slate-300 text-primary focus:ring-primary">
                        Tersedia untuk dipesan
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 border-t border-slate-100 bg-slate-50 px-5 py-4 sm:px-6">
        <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary/90">
            Simpan menu
        </button>
        <a href="{{ route('admin.umkm.menu.index', $umkm) }}" class="text-sm font-medium text-slate-500 hover:text-navy">Batal</a>
    </div>
</div>
