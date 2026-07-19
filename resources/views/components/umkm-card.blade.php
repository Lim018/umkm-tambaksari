@props(['umkm'])

<div data-reveal
     class="group flex flex-col overflow-hidden rounded-[24px] bg-white shadow-card transition duration-200 hover:-translate-y-2 hover:shadow-card-hover">
    {{-- foto --}}
    <div class="relative grid aspect-square place-items-center"
         @if ($umkm->photo_path) style="background:#f4f6ff;" @else style="background: {{ $umkm->pastel_bg }};" @endif>
        @if ($umkm->photo_path)
            <img src="{{ asset('storage/' . $umkm->photo_path) }}" alt="{{ $umkm->name }}"
                 class="absolute inset-0 h-full w-full object-cover">
        @else
            <span class="font-mono text-[11px] uppercase tracking-[.05em] text-navy/40">foto produk</span>
        @endif

        <button type="button" aria-label="Simpan"
                class="absolute left-3 top-3 grid h-[34px] w-[34px] place-items-center rounded-xl bg-white/85 shadow-[0_6px_16px_-8px_rgba(27,37,89,.4)] backdrop-blur">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M6 4h12v16l-6-4-6 4V4z" stroke="#1B2559" stroke-width="2" stroke-linejoin="round"/></svg>
        </button>
        <span class="absolute right-3 top-3 grid h-[34px] w-[34px] place-items-center rounded-xl bg-white/85 shadow-[0_6px_16px_-8px_rgba(27,37,89,.4)] backdrop-blur">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="18" height="14" rx="3" stroke="#1B2559" stroke-width="2"/><circle cx="12" cy="13" r="3.2" stroke="#1B2559" stroke-width="2"/><path d="M8 6l1.5-2h5L16 6" stroke="#1B2559" stroke-width="2" stroke-linejoin="round"/></svg>
        </span>
    </div>

    {{-- isi --}}
    <div class="flex flex-1 flex-col gap-1.5 p-4 pb-[18px]">
        <h3 class="m-0 truncate text-[16px] font-bold text-navy">{{ $umkm->name }}</h3>
        <p class="m-0 text-[12.5px] font-medium text-grey-soft">
            {{ $umkm->category?->name }} · {{ $umkm->kelurahan }}
        </p>
        <div class="mt-3 flex items-center justify-between">
            <span class="text-[15px] font-extrabold text-navy">{{ $umkm->price_range }}</span>
            <div class="flex gap-2">
                <a href="{{ $umkm->whatsapp_url }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"
                   class="grid h-[34px] w-[34px] place-items-center rounded-[11px] bg-[#25D366] shadow-[0_8px_18px_-8px_rgba(37,211,102,.7)]">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="#fff"><path d="M12 2a10 10 0 00-8.5 15.2L2 22l4.9-1.4A10 10 0 1012 2zm5.3 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .1-1.7-.1-.4-.1-.9-.3-1.6-.6-2.8-1.2-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.8 0-1.3.7-1.9 1-2.2.2-.2.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.7 1.8c.1.1.1.3 0 .5l-.3.5-.4.4c-.1.1-.3.3-.1.6.1.3.6 1 1.3 1.6.9.8 1.6 1 1.9 1.2.2.1.4.1.6-.1l.6-.7c.2-.3.4-.2.6-.1l1.7.8c.2.1.4.2.4.3.1.2.1.7-.1 1.3z"/></svg>
                </a>
                <a href="{{ $umkm->shopee_url ?: '#' }}" @if ($umkm->shopee_url) target="_blank" rel="noopener noreferrer" @endif aria-label="Shopee"
                   class="grid h-[34px] w-[34px] place-items-center rounded-[11px] bg-coral shadow-[0_8px_18px_-8px_rgba(255,107,74,.7)]">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M6 8h12l-1 12H7L6 8z" stroke="#fff" stroke-width="2" stroke-linejoin="round"/><path d="M9 8a3 3 0 016 0" stroke="#fff" stroke-width="2"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>
