@php($umkm = $umkm ?? null)

@if ($errors->any())
    <div class="mb-6 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-600">
        <ul class="list-inside list-disc">
            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-semibold text-navy">Nama Usaha</label>
        <input name="name" value="{{ old('name', $umkm?->name) }}" required
               class="w-full rounded-xl border-grey-soft/30 focus:border-primary focus:ring-primary">
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold text-navy">Kategori</label>
        <select name="category_id" required class="w-full rounded-xl border-grey-soft/30 focus:border-primary focus:ring-primary">
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $umkm?->category_id) == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold text-navy">Kelurahan</label>
        <input name="kelurahan" value="{{ old('kelurahan', $umkm?->kelurahan) }}" required
               class="w-full rounded-xl border-grey-soft/30 focus:border-primary focus:ring-primary">
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold text-navy">Rentang Harga</label>
        <input name="price_range" value="{{ old('price_range', $umkm?->price_range) }}" placeholder="Rp 15rb–40rb" required
               class="w-full rounded-xl border-grey-soft/30 focus:border-primary focus:ring-primary">
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold text-navy">Nomor WhatsApp (62...)</label>
        <input name="whatsapp" value="{{ old('whatsapp', $umkm?->whatsapp) }}" placeholder="6281234567890" required
               class="w-full rounded-xl border-grey-soft/30 focus:border-primary focus:ring-primary">
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-semibold text-navy">URL Shopee (opsional)</label>
        <input name="shopee_url" value="{{ old('shopee_url', $umkm?->shopee_url) }}" placeholder="https://shopee.co.id/..."
               class="w-full rounded-xl border-grey-soft/30 focus:border-primary focus:ring-primary">
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-semibold text-navy">Warna BG Kartu (CSS, opsional)</label>
        <input name="pastel_bg" value="{{ old('pastel_bg', $umkm?->pastel_bg) }}" placeholder="linear-gradient(135deg,#EDE9FE,#F5F0FF)"
               class="w-full rounded-xl border-grey-soft/30 focus:border-primary focus:ring-primary">
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-semibold text-navy">Foto (opsional)</label>
        @if ($umkm?->photo_path)
            <img src="{{ asset('storage/' . $umkm->photo_path) }}" class="mb-2 h-24 w-24 rounded-xl object-cover">
        @endif
        <input type="file" name="photo" accept="image/*" class="w-full text-sm text-grey-soft">
    </div>

    <div class="flex gap-6 md:col-span-2">
        <label class="inline-flex items-center gap-2 text-sm font-medium text-navy">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $umkm?->is_featured)) class="rounded border-grey-soft/40 text-primary focus:ring-primary">
            Tampilkan di Unggulan
        </label>
        <label class="inline-flex items-center gap-2 text-sm font-medium text-navy">
            <input type="checkbox" name="is_bestseller" value="1" @checked(old('is_bestseller', $umkm?->is_bestseller)) class="rounded border-grey-soft/40 text-primary focus:ring-primary">
            Terlaris
        </label>
    </div>
</div>

<div class="mt-8 flex items-center gap-3">
    <button class="rounded-pill bg-gradient-to-br from-primary to-ungu px-6 py-2.5 text-sm font-bold text-white">Simpan</button>
    <a href="{{ route('admin.umkm.index') }}" class="text-sm font-semibold text-grey-soft">Batal</a>
</div>
