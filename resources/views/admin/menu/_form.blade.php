@php($menu = $menu ?? null)

@if ($errors->any())
    <div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <ul class="list-inside list-disc space-y-0.5">
            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-navy">Nama menu</label>
        <input name="name" value="{{ old('name', $menu?->name) }}" required
               class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-navy">Harga (Rp)</label>
        <input type="number" name="price" value="{{ old('price', $menu?->price) }}" required min="0" step="1000"
               class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
        <p class="mt-1 text-xs text-slate-500">Angka tanpa titik, contoh 15000</p>
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-navy">Urutan tampil</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $menu?->sort_order ?? 0) }}" min="0" max="9999"
               class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
    </div>

    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-navy">Deskripsi</label>
        <textarea name="description" rows="4"
                  class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">{{ old('description', $menu?->description) }}</textarea>
    </div>

    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-navy">Gambar produk</label>
        @if ($menu?->photo_path)
            <img src="{{ asset('storage/' . $menu->photo_path) }}" alt="" class="mb-2 h-20 w-20 rounded-md object-cover">
        @endif
        <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-navy hover:file:bg-slate-200">
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

<div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
    <button type="submit" class="rounded-md bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary/90">
        Simpan
    </button>
    <a href="{{ route('admin.umkm.menu.index', $umkm) }}" class="text-sm font-medium text-slate-500 hover:text-navy">Batal</a>
</div>
