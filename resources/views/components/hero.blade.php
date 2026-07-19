<header id="beranda" class="relative z-[5] mx-auto max-w-[900px] px-6 pb-8 pt-[78px] text-center">
    <span data-reveal class="mb-[22px] inline-flex items-center gap-2 rounded-pill border border-white/90 bg-white/70 px-4 py-[7px] text-[13px] font-semibold text-primary shadow-[0_10px_24px_-12px_rgba(27,37,89,.25)]">
        <span class="inline-block h-2 w-2 rounded-full bg-teal"></span>
        Kecamatan Tambaksari · Surabaya
    </span>

    <h1 data-reveal class="m-0 font-extrabold leading-[.98] tracking-[-.035em] text-navy" style="font-size:clamp(44px,8vw,84px);">
        UMKM Tambaksari
    </h1>

    <p data-reveal class="mx-auto mt-[22px] max-w-[560px] font-medium leading-[1.6] text-grey-soft" style="font-size:clamp(15px,2.4vw,18px);">
        Temukan produk terbaik dari pelaku usaha lokal Tambaksari, Surabaya.<br>
        Belanja mudah, dukung ekonomi warga.
    </p>

    {{-- search bar --}}
    <form data-reveal action="{{ route('catalog.index') }}" method="GET"
          class="mx-auto mt-[34px] flex max-w-[620px] items-center gap-2.5 rounded-pill bg-white py-[9px] pl-[22px] pr-[9px] shadow-search">
        <svg width="21" height="21" viewBox="0 0 24 24" fill="none" class="flex-none">
            <circle cx="11" cy="11" r="7" stroke="#8F9BBA" stroke-width="2.2"/>
            <path d="M20 20l-3.2-3.2" stroke="#8F9BBA" stroke-width="2.2" stroke-linecap="round"/>
        </svg>
        <input name="q" value="{{ request('q') }}" placeholder="Cari UMKM atau produk..."
               class="min-w-0 flex-1 border-none bg-transparent p-0 text-[16px] font-medium text-navy placeholder:text-grey-soft focus:ring-0">
        <button type="submit" aria-label="Cari"
                class="grid h-12 w-12 flex-none place-items-center rounded-full bg-gradient-to-br from-[#FF8A5B] to-coral shadow-[0_12px_26px_-8px_rgba(255,107,74,.65)] transition hover:-translate-y-0.5">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <circle cx="11" cy="11" r="7" stroke="#fff" stroke-width="2.4"/>
                <path d="M20 20l-3.2-3.2" stroke="#fff" stroke-width="2.4" stroke-linecap="round"/>
            </svg>
        </button>
    </form>

    {{-- quick filters --}}
    <div data-reveal class="mt-5 flex flex-wrap justify-center gap-2.5">
        @foreach (['Terpopuler', 'Terdekat', 'Baru Buka'] as $chip)
            <a href="{{ route('catalog.index') }}"
               class="rounded-pill border border-white/90 bg-white/60 px-[18px] py-[9px] text-[13.5px] font-semibold text-navy shadow-[0_8px_20px_-14px_rgba(27,37,89,.35)] backdrop-blur transition hover:-translate-y-0.5">
                {{ $chip }}
            </a>
        @endforeach
    </div>
</header>
