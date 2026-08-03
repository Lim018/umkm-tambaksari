@extends('layouts.public')

@section('title', $umkm->name . ' — UMKM Tambaksari')

@section('content')
    <section class="relative z-[5] mx-auto max-w-[1100px] px-6 pt-10 md:pt-12">
        <a href="{{ route('catalog.index') }}" class="mb-5 inline-flex text-[14px] font-semibold text-primary hover:underline">
            ← Kembali ke katalog
        </a>

        <div data-reveal class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
            <div class="grid md:grid-cols-[300px_1fr]">
                <div class="relative aspect-[4/3] bg-slate-100 md:aspect-auto md:min-h-[280px]"
                     style="background: {{ $umkm->pastel_bg }};">
                    @if ($umkm->photo_path)
                        <img src="{{ asset('storage/' . $umkm->photo_path) }}" alt="{{ $umkm->name }}"
                             class="absolute inset-0 h-full w-full object-cover">
                    @else
                        <div class="grid h-full min-h-[200px] place-items-center text-[12px] font-semibold uppercase tracking-wide text-navy/35">
                            Foto toko
                        </div>
                    @endif
                </div>

                <div class="flex flex-col justify-center p-6 md:p-8">
                    <p class="m-0 text-[13px] font-semibold text-grey-soft">
                        {{ $umkm->category?->name }} · Kecamatan Tambaksari
                    </p>
                    <h1 class="mt-2 m-0 text-[26px] font-extrabold leading-tight text-navy md:text-[32px]">{{ $umkm->name }}</h1>
                    <p class="mt-2 text-[18px] font-bold text-navy">{{ $umkm->price_range }}</p>
                    @if ($umkm->description)
                        <p class="mt-3 m-0 text-[15px] leading-relaxed text-grey-soft">{{ $umkm->description }}</p>
                    @endif

                    <div class="mt-6 flex flex-wrap gap-2.5">
                        <a href="{{ $umkm->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center rounded-lg bg-[#25D366] px-4 py-2.5 text-[14px] font-bold text-white hover:brightness-105">
                            Hubungi WhatsApp
                        </a>
                        @if ($umkm->shopee_url)
                            <a href="{{ $umkm->shopee_url }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center rounded-lg bg-coral px-4 py-2.5 text-[14px] font-bold text-white hover:brightness-105">
                                Beli di Shopee
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-[5] mx-auto max-w-[1100px] px-6 pb-16 pt-10" id="menu">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-2">
            <div>
                <h2 class="m-0 text-[22px] font-extrabold text-navy md:text-[26px]">Menu</h2>
                <p class="mt-1 text-[14px] text-grey-soft">Pesan langsung ke pemilik toko via WhatsApp</p>
            </div>
            @if ($umkm->menus->isNotEmpty())
                <p class="text-[13px] font-medium text-grey-soft">{{ $umkm->menus->count() }} item</p>
            @endif
        </div>

        @if ($umkm->menus->isEmpty())
            <div data-reveal class="rounded-2xl border border-dashed border-slate-200 bg-white px-6 py-12 text-center">
                <p class="font-bold text-navy">Menu belum tersedia</p>
                <p class="mt-1 text-[14px] text-grey-soft">Hubungi toko langsung untuk menanyakan produk.</p>
                <a href="{{ $umkm->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                   class="mt-5 inline-flex rounded-lg bg-[#25D366] px-4 py-2.5 text-[14px] font-bold text-white">
                    Tanya via WhatsApp
                </a>
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($umkm->menus as $menu)
                    <article data-reveal
                             @class([
                                 'flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft',
                                 'opacity-70' => ! $menu->is_available,
                             ])>
                        <div class="relative aspect-[4/3] overflow-hidden bg-slate-100"
                             style="background: {{ $umkm->pastel_bg }};">
                            @if ($menu->photo_path)
                                <img src="{{ asset('storage/' . $menu->photo_path) }}" alt="{{ $menu->name }}"
                                     class="absolute inset-0 h-full w-full object-cover">
                            @else
                                <div class="grid h-full place-items-center text-[11px] font-semibold uppercase tracking-wide text-navy/35">
                                    Foto menu
                                </div>
                            @endif
                            @unless ($menu->is_available)
                                <span class="absolute left-3 top-3 rounded-md bg-navy/80 px-2 py-1 text-[11px] font-bold text-white">Habis</span>
                            @endunless
                        </div>

                        <div class="flex flex-1 flex-col gap-1.5 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="m-0 text-[15px] font-bold leading-snug text-navy">{{ $menu->name }}</h3>
                                <span class="shrink-0 text-[14px] font-extrabold text-navy">{{ $menu->formatted_price }}</span>
                            </div>
                            @if ($menu->description)
                                <p class="m-0 line-clamp-2 text-[13px] leading-relaxed text-grey-soft">{{ $menu->description }}</p>
                            @endif
                            <div class="mt-auto pt-3">
                                @if ($menu->is_available)
                                    <a href="{{ $menu->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex w-full items-center justify-center rounded-lg bg-[#25D366] px-3 py-2.5 text-[13px] font-bold text-white hover:brightness-105">
                                        Pesan WhatsApp
                                    </a>
                                @else
                                    <span class="inline-flex w-full items-center justify-center rounded-lg bg-slate-100 px-3 py-2.5 text-[13px] font-semibold text-slate-500">
                                        Tidak tersedia
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
