@extends('layouts.public')

@section('title', $umkm->name . ' — UMKM Tambaksari')

@section('content')
    <section class="relative z-[5] mx-auto max-w-[960px] px-6 pt-16">
        <a href="{{ url()->previous() }}" class="mb-6 inline-block text-[14px] font-bold text-primary">← Kembali</a>

        <div data-reveal class="grid gap-8 rounded-[30px] border border-white/85 bg-white/80 p-6 shadow-soft backdrop-blur md:grid-cols-2 md:p-8">
            <div class="grid aspect-square place-items-center overflow-hidden rounded-[24px]"
                 style="background: {{ $umkm->pastel_bg }};">
                @if ($umkm->photo_path)
                    <img src="{{ asset('storage/' . $umkm->photo_path) }}" alt="{{ $umkm->name }}" class="h-full w-full object-cover">
                @else
                    <span class="font-mono text-[12px] uppercase tracking-[.05em] text-navy/40">foto produk</span>
                @endif
            </div>

            <div class="flex flex-col">
                <span class="mb-2 inline-flex w-fit items-center rounded-pill bg-pastel-ungu px-3 py-1 text-[12px] font-semibold text-ungu">
                    {{ $umkm->category?->name }}
                </span>
                <h1 class="m-0 text-[28px] font-extrabold text-navy">{{ $umkm->name }}</h1>
                <p class="mt-1 font-medium text-grey-soft">Kelurahan {{ $umkm->kelurahan }}</p>
                <p class="mt-6 text-[22px] font-extrabold text-navy">{{ $umkm->price_range }}</p>

                <div class="mt-auto flex flex-wrap gap-3 pt-8">
                    <a href="{{ $umkm->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 rounded-pill bg-[#25D366] px-6 py-3 text-[15px] font-bold text-white shadow-[0_12px_26px_-10px_rgba(37,211,102,.7)]">
                        Hubungi via WhatsApp
                    </a>
                    @if ($umkm->shopee_url)
                        <a href="{{ $umkm->shopee_url }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 rounded-pill bg-coral px-6 py-3 text-[15px] font-bold text-white shadow-[0_12px_26px_-10px_rgba(255,107,74,.7)]">
                            Beli di Shopee
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
