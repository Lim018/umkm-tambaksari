@php($umkm = $umkm ?? null)

@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <p class="font-semibold">Periksa kembali isian berikut:</p>
        <ul class="mt-1 list-inside list-disc space-y-0.5">
            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="overflow-hidden rounded-xl border border-slate-200 bg-white"
     x-data="{
         preview: @js($umkm?->photo_path ? asset('storage/' . $umkm->photo_path) : null),
         pastel: @js(old('pastel_bg', $umkm?->pastel_bg ?? 'linear-gradient(135deg,#EDE9FE,#F5F0FF)')),
         presets: [
             'linear-gradient(135deg,#FFE4DA,#FFF3EE)',
             'linear-gradient(135deg,#CCFBF1,#ECFEFB)',
             'linear-gradient(135deg,#EDE9FE,#F5F0FF)',
             'linear-gradient(135deg,#DBEAFE,#EEF5FF)',
             'linear-gradient(135deg,#FEF3C7,#FFFBEB)',
             'linear-gradient(135deg,#FCE7F3,#FFF0F6)',
         ]
     }">

    {{-- Data toko --}}
    <div class="border-b border-slate-100 p-5 sm:p-6">
        <h2 class="text-sm font-semibold text-navy">Data toko</h2>
        <p class="mt-0.5 text-xs text-slate-500">Informasi dasar di katalog</p>

        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-navy">Nama toko</label>
                <input name="name" value="{{ old('name', $umkm?->name) }}" required placeholder="Contoh: Sambel Bu Yanti"
                       class="h-10 w-full rounded-lg border-slate-200 text-sm focus:border-primary focus:ring-primary">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-navy">Kategori</label>
                <select name="category_id" required class="h-10 w-full rounded-lg border-slate-200 text-sm focus:border-primary focus:ring-primary">
                    <option value="" disabled @selected(! old('category_id', $umkm?->category_id))>Pilih kategori</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" @selected(old('category_id', $umkm?->category_id) == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-navy">Rentang harga</label>
                <input name="price_range" value="{{ old('price_range', $umkm?->price_range) }}" placeholder="Rp 15rb–40rb" required
                       class="h-10 w-full rounded-lg border-slate-200 text-sm focus:border-primary focus:ring-primary">
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-navy">Deskripsi toko <span class="font-normal text-slate-400">(opsional)</span></label>
                <textarea name="description" rows="3" placeholder="Ceritakan singkat tentang toko, keunggulan, atau produk unggulan..."
                          class="w-full rounded-lg border-slate-200 text-sm focus:border-primary focus:ring-primary">{{ old('description', $umkm?->description) }}</textarea>
            </div>
        </div>
    </div>

    {{-- Kontak --}}
    <div class="border-b border-slate-100 p-5 sm:p-6">
        <h2 class="text-sm font-semibold text-navy">Kontak</h2>
        <p class="mt-0.5 text-xs text-slate-500">WhatsApp dan link belanja</p>

        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-navy">WhatsApp</label>
                <div class="flex h-10 overflow-hidden rounded-lg border border-slate-200 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary">
                    <span class="inline-flex items-center bg-slate-50 px-3 text-sm text-slate-500">+</span>
                    <input name="whatsapp" value="{{ old('whatsapp', $umkm?->whatsapp) }}" placeholder="6281234567890" required
                           class="min-w-0 flex-1 border-0 text-sm focus:ring-0">
                </div>
                <p class="mt-1 text-xs text-slate-500">Diawali 62 tanpa spasi</p>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-navy">Link Shopee <span class="font-normal text-slate-400">(opsional)</span></label>
                <input name="shopee_url" value="{{ old('shopee_url', $umkm?->shopee_url) }}" placeholder="https://shopee.co.id/..."
                       class="h-10 w-full rounded-lg border-slate-200 text-sm focus:border-primary focus:ring-primary">
            </div>
        </div>
    </div>

    {{-- Foto --}}
    <div class="border-b border-slate-100 p-5 sm:p-6">
        <h2 class="text-sm font-semibold text-navy">Foto & warna</h2>
        <p class="mt-0.5 text-xs text-slate-500">Gambar toko dan warna cadangan</p>

        <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-start">
            <div class="relative h-28 w-28 shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-slate-50"
                 :style="!preview ? `background:${pastel}` : ''">
                <template x-if="preview">
                    <img :src="preview" alt="Preview" class="absolute inset-0 h-full w-full object-cover">
                </template>
                <template x-if="!preview">
                    <span class="grid h-full place-items-center text-[11px] text-slate-400">Preview</span>
                </template>
            </div>

            <div class="min-w-0 flex-1 space-y-3">
                <div>
                    <input type="file" name="photo" accept="image/*"
                           @change="const f = $event.target.files[0]; preview = f ? URL.createObjectURL(f) : preview"
                           class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-navy hover:file:bg-slate-200">
                    <p class="mt-1 text-xs text-slate-500">JPG/PNG, max 4 MB</p>
                </div>
                <div>
                    <p class="mb-1.5 text-xs font-medium text-slate-500">Warna latar</p>
                    <input type="hidden" name="pastel_bg" :value="pastel">
                    <div class="flex flex-wrap gap-1.5">
                        <template x-for="(p, i) in presets" :key="i">
                            <button type="button" @click="pastel = p"
                                    class="h-7 w-7 rounded-md border transition"
                                    :class="pastel === p ? 'border-primary ring-2 ring-primary/20' : 'border-slate-200'"
                                    :style="`background:${p}`"></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Status --}}
    <div class="p-5 sm:p-6">
        <h2 class="text-sm font-semibold text-navy">Status</h2>
        <div class="mt-3 flex flex-wrap gap-x-6 gap-y-2">
            <label class="inline-flex items-center gap-2 text-sm text-navy">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $umkm?->is_featured))
                       class="rounded border-slate-300 text-primary focus:ring-primary">
                Tampil di unggulan
            </label>
            <label class="inline-flex items-center gap-2 text-sm text-navy">
                <input type="checkbox" name="is_bestseller" value="1" @checked(old('is_bestseller', $umkm?->is_bestseller))
                       class="rounded border-slate-300 text-primary focus:ring-primary">
                Tandai terlaris
            </label>
        </div>
    </div>

    <div class="flex items-center gap-3 border-t border-slate-100 bg-slate-50 px-5 py-4 sm:px-6">
        <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary/90">
            Simpan toko
        </button>
        <a href="{{ route('admin.umkm.index') }}" class="text-sm font-medium text-slate-500 hover:text-navy">Batal</a>
    </div>
</div>
