@props(['umkm'])

@php
    $menuCount = $umkm->menus_count ?? null;
    $kontak = $umkm->kontak_populer ?? 0;
@endphp

<article data-reveal
         class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft transition duration-200 hover:-translate-y-0.5 hover:shadow-card">
    <a href="{{ route('catalog.show', $umkm) }}" class="absolute inset-0 z-[1]" aria-label="Lihat {{ $umkm->name }}"></a>

    <div class="relative aspect-[4/3] shrink-0 overflow-hidden bg-slate-100"
         @unless ($umkm->photo_path) style="background: {{ $umkm->pastel_bg }};" @endunless>
        @if ($umkm->photo_path)
            <img src="{{ asset('storage/' . $umkm->photo_path) }}" alt="{{ $umkm->name }}"
                 class="absolute inset-0 h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]">
        @else
            <span class="grid h-full place-items-center text-[11px] font-medium text-navy/30">Belum ada foto</span>
        @endif

        <div class="absolute bottom-2.5 left-2.5 z-[2] flex flex-wrap items-center gap-1.5">
            @if ($menuCount)
                <span class="rounded-md bg-white/95 px-2 py-0.5 text-[11px] font-semibold text-navy">
                    {{ $menuCount }} menu
                </span>
            @endif

            <x-popularity-badge :count="$kontak" />
            <x-status-buka :umkm="$umkm" />
        </div>
    </div>

    <div class="relative z-[2] flex flex-1 flex-col p-3.5 pointer-events-none">
        <p class="m-0 text-[11px] font-semibold uppercase tracking-wide text-grey-soft">
            {{ $umkm->category?->name }}
        </p>
        <h3 class="mt-1 m-0 line-clamp-2 min-h-[2.5rem] text-[15px] font-bold leading-snug text-navy">
            {{ $umkm->name }}
        </h3>
        @if ($umkm->description)
            <p class="mt-1.5 m-0 line-clamp-2 text-[12px] leading-relaxed text-grey-soft">{{ $umkm->description }}</p>
        @endif

        <div class="mt-auto flex items-center justify-between gap-2 pt-3">
            <span class="truncate text-[14px] font-extrabold text-navy">{{ $umkm->price_range }}</span>
            <div class="pointer-events-auto flex shrink-0 gap-1.5">
                <a href="{{ route('go.umkm', [$umkm, 'whatsapp']) }}" target="_blank" rel="noopener noreferrer nofollow" aria-label="WhatsApp"
                   class="grid h-8 w-8 place-items-center rounded-lg bg-[#25D366]">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="#fff"><path d="M12 2a10 10 0 00-8.5 15.2L2 22l4.9-1.4A10 10 0 1012 2zm5.3 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .1-1.7-.1-.4-.1-.9-.3-1.6-.6-2.8-1.2-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.8 0-1.3.7-1.9 1-2.2.2-.2.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.7 1.8c.1.1.1.3 0 .5l-.3.5-.4.4c-.1.1-.3.3-.1.6.1.3.6 1 1.3 1.6.9.8 1.6 1 1.9 1.2.2.1.4.1.6-.1l.6-.7c.2-.3.4-.2.6-.1l1.7.8c.2.1.4.2.4.3.1.2.1.7-.1 1.3z"/></svg>
                </a>
                @if ($umkm->shopee_url)
                    <a href="{{ route('go.umkm', [$umkm, 'shopee']) }}" target="_blank" rel="noopener noreferrer nofollow" aria-label="Shopee"
                       class="grid h-8 w-8 place-items-center rounded-lg bg-coral">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M6 8h12l-1 12H7L6 8z" stroke="#fff" stroke-width="2" stroke-linejoin="round"/><path d="M9 8a3 3 0 016 0" stroke="#fff" stroke-width="2"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</article>
