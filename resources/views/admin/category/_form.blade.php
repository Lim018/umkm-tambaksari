@php($category = $category ?? null)

@if ($errors->any())
    <div class="mb-6 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-600">
        <ul class="list-inside list-disc">
            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="grid gap-5">
    <div>
        <label class="mb-1 block text-sm font-semibold text-navy">Nama Kategori</label>
        <input name="name" value="{{ old('name', $category?->name) }}" required
               class="w-full rounded-xl border-grey-soft/30 focus:border-primary focus:ring-primary">
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold text-navy">Ikon (emoji)</label>
        <input name="icon" value="{{ old('icon', $category?->icon) }}" placeholder="🍜"
               class="w-full rounded-xl border-grey-soft/30 focus:border-primary focus:ring-primary">
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="mb-1 block text-sm font-semibold text-navy">Warna Aksen</label>
            <input name="accent_color" value="{{ old('accent_color', $category?->accent_color ?? '#3B6FF5') }}"
                   class="w-full rounded-xl border-grey-soft/30 focus:border-primary focus:ring-primary">
        </div>
        <div>
            <label class="mb-1 block text-sm font-semibold text-navy">Warna Tint (bg ikon)</label>
            <input name="tint" value="{{ old('tint', $category?->tint ?? '#DBEAFE') }}"
                   class="w-full rounded-xl border-grey-soft/30 focus:border-primary focus:ring-primary">
        </div>
    </div>
</div>

<div class="mt-8 flex items-center gap-3">
    <button class="rounded-pill bg-gradient-to-br from-primary to-ungu px-6 py-2.5 text-sm font-bold text-white">Simpan</button>
    <a href="{{ route('admin.kategori.index') }}" class="text-sm font-semibold text-grey-soft">Batal</a>
</div>
