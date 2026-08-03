@extends('layouts.public')

@section('title', $umkm->name . ' — UMKM Tambaksari')

@section('content')
    {{-- Header toko --}}
    <section class="relative z-[5] mx-auto max-w-[1100px] px-6 pt-12 md:pt-16">
        <a href="{{ route('catalog.index') }}" class="mb-6 inline-flex items-center gap-1.5 text-[14px] font-bold text-primary transition hover:gap-2.5">
            <span aria-hidden="true">←</span> Kembali ke katalog
        </a>

        <div data-reveal class="overflow-hidden rounded-[28px] border border-white/85 bg-white/80 shadow-soft backdrop-blur">
            <div class="grid md:grid-cols-[280px_1fr]">
                <div class="relative aspect-[4/3] md:aspect-auto md:min-h-[260px]"
                     style="background: {{ $umkm->pastel_bg }};">
                    @if ($umkm->photo_path)
                        <img src="{{ asset('storage/' . $umkm->photo_path) }}" alt="{{ $umkm->name }}"
                             class="absolute inset-0 h-full w-full object-cover">
                    @else
                        <div class="grid h-full min-h-[200px] place-items-center">
                            <span class="font-mono text-[12px] uppercase tracking-[.05em] text-navy/40">foto toko</span>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col justify-center p-6 md:p-8">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center rounded-pill bg-pastel-ungu px-3 py-1 text-[12px] font-semibold text-ungu">
                            {{ $umkm->category?->icon }} {{ $umkm->category?->name }}
                        </span>
                        @if ($umkm->is_featured)
                            <span class="rounded-pill bg-primary/10 px-3 py-1 text-[12px] font-bold text-primary">Unggulan</span>
                        @endif
                        @if ($umkm->is_bestseller)
                            <span class="rounded-pill bg-coral/10 px-3 py-1 text-[12px] font-bold text-coral">Terlaris</span>
                        @endif
                    </div>

                    <h1 class="mt-3 m-0 text-[26px] font-extrabold leading-tight text-navy md:text-[32px]">{{ $umkm->name }}</h1>
                    <p class="mt-1.5 font-medium text-grey-soft">Kelurahan {{ $umkm->kelurahan }} · {{ $umkm->price_range }}</p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ $umkm->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 rounded-pill bg-[#25D366] px-5 py-2.5 text-[14px] font-bold text-white shadow-[0_12px_26px_-10px_rgba(37,211,102,.7)] transition hover:brightness-105">
                            Hubungi via WhatsApp
                        </a>
                        @if ($umkm->shopee_url)
                            <a href="{{ $umkm->shopee_url }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 rounded-pill bg-coral px-5 py-2.5 text-[14px] font-bold text-white shadow-[0_12px_26px_-10px_rgba(255,107,74,.7)] transition hover:brightness-105">
                                Beli di Shopee
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Menu / produk --}}
    <section class="relative z-[5] mx-auto max-w-[1100px] px-6 pb-20 pt-12" id="menu">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="m-0 text-[13px] font-bold uppercase tracking-[.08em] text-primary">Menu toko</p>
                <h2 class="mt-1 m-0 text-[24px] font-extrabold text-navy md:text-[28px]">Apa yang ditawarkan</h2>
                <p class="mt-1.5 max-w-lg text-[15px] text-grey-soft">
                    Pilih menu, lalu pesan langsung lewat WhatsApp ke pemilik toko.
                </p>
            </div>
            @if ($umkm->menus->isNotEmpty())
                <p class="text-[13px] font-semibold text-grey-soft">
                    {{ $umkm->menus->where('is_available', true)->count() }} tersedia
                    · {{ $umkm->menus->count() }} total
                </p>
            @endif
        </div>

        @if ($umkm->menus->isEmpty())
            <div data-reveal class="rounded-[24px] border border-dashed border-grey-soft/30 bg-white/60 px-6 py-16 text-center backdrop-blur">
                <p class="text-[17px] font-bold text-navy">Menu belum tersedia</p>
                <p class="mt-2 text-[14px] text-grey-soft">Pemilik toko belum menambahkan daftar menu. Hubungi langsung via WhatsApp.</p>
                <a href="{{ $umkm->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                   class="mt-6 inline-flex rounded-pill bg-[#25D366] px-5 py-2.5 text-[14px] font-bold text-white">
                    Tanya via WhatsApp
                </a>
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($umkm->menus as $menu)
                    <article data-reveal
                             class="group flex flex-col overflow-hidden rounded-[22px] bg-white shadow-card transition duration-200 hover:-translate-y-1.5 hover:shadow-card-hover
                                    {{ $menu->is_available ? '' : 'opacity-75' }}">
                        <div class="relative aspect-[4/3] overflow-hidden"
                             style="background: {{ $umkm->pastel_bg }};">
                            @if ($menu->photo_path)
                                <img src="{{ asset('storage/' . $menu->photo_path) }}" alt="{{ $menu->name }}"
                                     class="absolute inset-0 h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]">
                            @else
                                <div class="grid h-full place-items-center">
                                    <span class="font-mono text-[11px] uppercase tracking-[.05em] text-navy/35">foto menu</span>
                                </div>
                            @endif

                            @unless ($menu->is_available)
                                <span class="absolute left-3 top-3 rounded-pill bg-navy/80 px-3 py-1 text-[11px] font-bold text-white backdrop-blur">
                                    Habis
                                </span>
                            @endunless
                        </div>

                        <div class="flex flex-1 flex-col gap-2 p-4 pb-5">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="m-0 text-[16px] font-bold leading-snug text-navy">{{ $menu->name }}</h3>
                                <span class="shrink-0 text-[15px] font-extrabold text-navy">{{ $menu->formatted_price }}</span>
                            </div>

                            @if ($menu->description)
                                <p class="m-0 line-clamp-2 text-[13px] leading-relaxed text-grey-soft">{{ $menu->description }}</p>
                            @endif

                            <div class="mt-auto pt-3">
                                @if ($menu->is_available)
                                    <a href="{{ $menu->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex w-full items-center justify-center gap-2 rounded-pill bg-[#25D366] px-4 py-2.5 text-[13px] font-bold text-white shadow-[0_10px_22px_-10px_rgba(37,211,102,.65)] transition hover:brightness-105">
                                        Pesan via WhatsApp
                                    </a>
                                @else
                                    <span class="inline-flex w-full items-center justify-center rounded-pill bg-grey-soft/15 px-4 py-2.5 text-[13px] font-bold text-grey-soft">
                                        Sementara tidak tersedia
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
