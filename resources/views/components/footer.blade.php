<footer id="tentang" class="relative z-[5] mx-auto mt-16 max-w-[1180px] px-6 pb-10">
    <div class="rounded-2xl border border-slate-200/80 bg-white p-8 shadow-soft md:p-10">
        <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3">
            <div class="sm:col-span-2 md:col-span-1">
                <div class="text-[18px] font-extrabold text-navy">UMKM<span class="text-primary">Tambaksari</span></div>
                <p class="mt-3 max-w-xs text-[14px] leading-relaxed text-grey-soft">
                    Katalog digital usaha lokal Kecamatan Tambaksari, Surabaya. Dukung ekonomi warga dengan belanja ke UMKM sekitar.
                </p>
            </div>

            <div>
                <p class="mb-3 text-[13px] font-bold uppercase tracking-wide text-navy">Jelajahi</p>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('home') }}" class="text-[14px] font-medium text-grey-soft hover:text-primary">Beranda</a>
                    <a href="{{ route('catalog.index') }}" class="text-[14px] font-medium text-grey-soft hover:text-primary">Katalog</a>
                    <a href="{{ route('home') }}#kategori" class="text-[14px] font-medium text-grey-soft hover:text-primary">Kategori</a>
                </div>
            </div>

            <div>
                <p class="mb-3 text-[13px] font-bold uppercase tracking-wide text-navy">Kategori populer</p>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('catalog.index', ['kategori' => 'makanan']) }}" class="text-[14px] font-medium text-grey-soft hover:text-primary">Makanan</a>
                    <a href="{{ route('catalog.index', ['kategori' => 'minuman']) }}" class="text-[14px] font-medium text-grey-soft hover:text-primary">Minuman</a>
                    <a href="{{ route('catalog.index', ['kategori' => 'fashion']) }}" class="text-[14px] font-medium text-grey-soft hover:text-primary">Fashion</a>
                </div>
            </div>
        </div>

        <div class="mt-8 border-t border-slate-100 pt-5">
            <p class="m-0 text-[13px] text-grey-soft">© {{ date('Y') }} Katalog UMKM Kecamatan Tambaksari · Surabaya</p>
        </div>
    </div>
</footer>
