@php($category = $category ?? null)

@if ($errors->any())
    <div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <ul class="list-inside list-disc space-y-0.5">
            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="grid gap-5">
    <div>
        <label class="mb-1.5 block text-sm font-medium text-navy">Nama kategori</label>
        <input name="name" value="{{ old('name', $category?->name) }}" required
               class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
    </div>
    <div>
        <label class="mb-1.5 block text-sm font-medium text-navy">Ikon</label>
        <input name="icon" value="{{ old('icon', $category?->icon) }}" placeholder="🍜"
               class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-navy">Warna aksen</label>
            <input name="accent_color" value="{{ old('accent_color', $category?->accent_color ?? '#3B6FF5') }}"
                   class="w-full rounded-md border-slate-200 font-mono text-sm focus:border-primary focus:ring-primary">
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-medium text-navy">Warna latar ikon</label>
            <input name="tint" value="{{ old('tint', $category?->tint ?? '#DBEAFE') }}"
                   class="w-full rounded-md border-slate-200 font-mono text-sm focus:border-primary focus:ring-primary">
        </div>
    </div>
</div>

<div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
    <button type="submit" class="rounded-md bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary/90">
        Simpan
    </button>
    <a href="{{ route('admin.kategori.index') }}" class="text-sm font-medium text-slate-500 hover:text-navy">Batal</a>
</div>
