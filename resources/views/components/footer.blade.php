@php
    $footAbout = ['Tentang Kami', 'Cara Daftar', 'Kontak', 'FAQ'];
    $footKel = ['Tambaksari', 'Ploso', 'Rangkah', 'Pacar Kembang', 'Gading'];
    $footCat = ['Makanan', 'Minuman', 'Fashion'];
    $footPop = ['Terlaris', 'Terbaru', 'Promo', 'Unggulan'];
@endphp

<footer id="tentang" class="relative z-[5] mx-auto mt-20 max-w-[1180px] px-6 pb-10">
    <div class="rounded-[30px] border border-white/85 bg-white/[.72] p-11 px-10 pb-[30px] shadow-[0_24px_60px_-30px_rgba(27,37,89,.35)] backdrop-blur-md">
        <div class="grid grid-cols-2 gap-8 md:grid-cols-[1.4fr_1fr_1fr_1fr]">
            <div>
                <div class="mb-4 text-[19px] font-extrabold">UMKM<span class="text-primary">Tambaksari</span></div>
                <div class="flex flex-col gap-[11px]">
                    @foreach ($footAbout as $l)
                        <a href="{{ route('home') }}#tentang" class="inline-flex items-center gap-[9px] text-[14px] font-medium text-grey-soft hover:text-primary">
                            <span class="inline-block h-[7px] w-[7px] rounded-full bg-primary"></span>{{ $l }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="mb-4 text-[14px] font-bold text-navy">Kelurahan</div>
                <div class="flex flex-col gap-[11px]">
                    @foreach ($footKel as $l)
                        <a href="{{ route('catalog.index', ['kelurahan' => $l]) }}" class="text-[14px] font-medium text-grey-soft hover:text-primary">{{ $l }}</a>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="mb-4 text-[14px] font-bold text-navy">Kategori</div>
                <div class="flex flex-col gap-[11px]">
                    @foreach ($footCat as $l)
                        <a href="{{ route('catalog.index', ['kategori' => \Illuminate\Support\Str::slug($l)]) }}" class="text-[14px] font-medium text-grey-soft hover:text-primary">{{ $l }}</a>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="mb-4 text-[14px] font-bold text-navy">Populer</div>
                <div class="flex flex-col gap-[11px]">
                    @foreach ($footPop as $l)
                        <a href="{{ route('catalog.index') }}" class="text-[14px] font-medium text-grey-soft hover:text-primary">{{ $l }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="my-[25px] h-px bg-grey-soft/20"></div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <span class="text-[13px] font-medium text-grey-soft">© {{ date('Y') }} Katalog UMKM Kecamatan Tambaksari · Surabaya</span>
            <a href="{{ route('admin.login') }}" class="text-[13px] font-bold text-primary">Masuk Admin →</a>
        </div>
    </div>
</footer>
