<header id="beranda" class="relative z-[5] mx-auto max-w-[820px] px-6 pb-10 pt-[72px] text-center">
    <h1 data-reveal class="m-0 font-extrabold leading-[1.02] tracking-[-.035em] text-navy"
        style="font-size:clamp(40px,7.5vw,72px);">
        UMKM<span class="text-primary">Tambaksari</span>
    </h1>

    <p data-reveal class="mx-auto mt-5 max-w-[520px] text-[16px] font-medium leading-relaxed text-grey-soft md:text-[17px]">
        Temukan produk lokal dari pelaku usaha di Kecamatan Tambaksari, Surabaya.
    </p>

    <form data-reveal action="{{ route('catalog.index') }}" method="GET"
          class="mx-auto mt-8 flex max-w-[560px] items-center gap-2 rounded-pill bg-white py-2 pl-5 pr-2 shadow-search">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="flex-none" aria-hidden="true">
            <circle cx="11" cy="11" r="7" stroke="#8F9BBA" stroke-width="2.2"/>
            <path d="M20 20l-3.2-3.2" stroke="#8F9BBA" stroke-width="2.2" stroke-linecap="round"/>
        </svg>
        <input name="q" value="{{ request('q') }}" placeholder="Cari toko atau produk..."
               class="min-w-0 flex-1 border-none bg-transparent p-0 text-[15px] font-medium text-navy placeholder:text-grey-soft focus:ring-0">
        <button type="submit"
                class="rounded-pill bg-primary px-5 py-2.5 text-[14px] font-bold text-white transition hover:bg-primary/90">
            Cari
        </button>
    </form>
</header>
