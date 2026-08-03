@php
    $links = [
        ['label' => 'Beranda', 'href' => route('home')],
        ['label' => 'Katalog', 'href' => route('catalog.index')],
        ['label' => 'Kategori', 'href' => route('home') . '#kategori'],
        ['label' => 'Tentang', 'href' => route('home') . '#tentang'],
    ];
@endphp

<nav x-data="{ open: false }"
     class="glass sticky top-[18px] z-50 mx-auto mt-[18px] flex max-w-[1180px] items-center justify-between gap-4 rounded-[24px] border border-white/75 px-4 py-3 pl-6 shadow-soft"
     style="width:calc(100% - 32px);">
    <a href="{{ route('home') }}" class="text-xl font-extrabold tracking-tight text-navy">
        UMKM<span class="text-primary">Tambaksari</span>
    </a>

    <div class="hidden items-center gap-1.5 md:flex">
        @foreach ($links as $link)
            <a href="{{ $link['href'] }}"
               class="rounded-xl px-[15px] py-[9px] text-[14.5px] font-medium text-grey-soft transition hover:bg-primary/10 hover:text-navy">
                {{ $link['label'] }}
            </a>
        @endforeach
    </div>

    <button @click="open = !open" class="grid h-11 w-11 place-items-center rounded-xl bg-white/70 md:hidden" aria-label="Menu">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" x-show="!open">
            <path d="M4 7h16M4 12h16M4 17h16" stroke="#1B2559" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" x-show="open" x-cloak>
            <path d="M6 6l12 12M18 6L6 18" stroke="#1B2559" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>

    <div x-show="open" x-cloak x-transition
         class="glass absolute left-0 right-0 top-[70px] flex flex-col gap-1 rounded-[24px] border border-white/75 p-3 shadow-soft md:hidden">
        @foreach ($links as $link)
            <a href="{{ $link['href'] }}"
               class="rounded-xl px-4 py-3 text-[15px] font-medium text-navy hover:bg-primary/10">
                {{ $link['label'] }}
            </a>
        @endforeach
    </div>
</nav>
