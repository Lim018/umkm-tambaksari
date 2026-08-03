@php($umkm = $umkm ?? null)

@if ($errors->any())
    <div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <ul class="list-inside list-disc space-y-0.5">
            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-navy">Nama toko</label>
        <input name="name" value="{{ old('name', $umkm?->name) }}" required
               class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-navy">Kategori</label>
        <select name="category_id" required class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $umkm?->category_id) == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-navy">Kelurahan</label>
        <input name="kelurahan" value="{{ old('kelurahan', $umkm?->kelurahan) }}" required
               class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-navy">Rentang harga</label>
        <input name="price_range" value="{{ old('price_range', $umkm?->price_range) }}" placeholder="Rp 15rb–40rb" required
               class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-navy">WhatsApp</label>
        <input name="whatsapp" value="{{ old('whatsapp', $umkm?->whatsapp) }}" placeholder="6281234567890" required
               class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
        <p class="mt-1 text-xs text-slate-500">Format 62… tanpa spasi</p>
    </div>

    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-navy">URL Shopee <span class="font-normal text-slate-400">(opsional)</span></label>
        <input name="shopee_url" value="{{ old('shopee_url', $umkm?->shopee_url) }}" placeholder="https://shopee.co.id/..."
               class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
    </div>

    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-navy">Warna latar kartu <span class="font-normal text-slate-400">(opsional)</span></label>
        <input name="pastel_bg" value="{{ old('pastel_bg', $umkm?->pastel_bg) }}" placeholder="linear-gradient(135deg,#EDE9FE,#F5F0FF)"
               class="w-full rounded-md border-slate-200 font-mono text-sm focus:border-primary focus:ring-primary">
    </div>

    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-navy">Foto toko</label>
        @if ($umkm?->photo_path)
            <img src="{{ asset('storage/' . $umkm->photo_path) }}" alt="" class="mb-2 h-20 w-20 rounded-md object-cover">
        @endif
        <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-navy hover:file:bg-slate-200">
        <p class="mt-1 text-xs text-slate-500">JPG/PNG, max 4 MB</p>
    </div>

    <div class="flex flex-wrap gap-4 sm:col-span-2">
        <label class="inline-flex items-center gap-2 text-sm text-navy">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $umkm?->is_featured))
                   class="rounded border-slate-300 text-primary focus:ring-primary">
            Tampil di unggulan
        </label>
        <label class="inline-flex items-center gap-2 text-sm text-navy">
            <input type="checkbox" name="is_bestseller" value="1" @checked(old('is_bestseller', $umkm?->is_bestseller))
                   class="rounded border-slate-300 text-primary focus:ring-primary">
            Terlaris
        </label>
    </div>
</div>

<div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
    <button type="submit" class="rounded-md bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary/90">
        Simpan
    </button>
    <a href="{{ route('admin.umkm.index') }}" class="text-sm font-medium text-slate-500 hover:text-navy">Batal</a>
</div>
