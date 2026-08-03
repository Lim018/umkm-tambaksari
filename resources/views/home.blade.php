@extends('layouts.public')

@section('title', 'UMKM Tambaksari — Katalog Usaha Lokal Surabaya')

@section('content')
    <x-hero />

    {{-- KATEGORI --}}
    <x-katalog-banner />

    {{-- UMKM UNGGULAN --}}
    <section id="katalog" class="relative z-[5] mx-auto mt-[62px] max-w-[1180px] px-6">
        <div data-reveal class="mb-[26px] flex flex-wrap items-end justify-between gap-4">
            <div>
                <h2 class="m-0 font-extrabold tracking-[-.03em]" style="font-size:clamp(26px,4vw,36px);">UMKM Unggulan</h2>
                <p class="mt-2 font-medium text-grey-soft">Pilihan usaha terbaik dari warga Tambaksari</p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('catalog.index') }}"
                   class="rounded-pill bg-gradient-to-br from-primary to-ungu px-[18px] py-[9px] text-[13.5px] font-bold text-white">Semua</a>
                <a href="{{ route('catalog.index', ['sort' => 'terlaris']) }}"
                   class="rounded-pill border border-white/90 bg-white/60 px-[18px] py-[9px] text-[13.5px] font-bold text-navy">Terlaris</a>
                <a href="{{ route('catalog.index') }}" class="px-1.5 py-[9px] text-[14px] font-bold text-primary">Lihat Semua →</a>
            </div>
        </div>

        @if ($featured->isEmpty())
            <p class="rounded-2xl bg-white/60 p-8 text-center font-medium text-grey-soft">Belum ada UMKM unggulan.</p>
        @else
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($featured as $umkm)
                    <x-umkm-card :umkm="$umkm" />
                @endforeach
            </div>
        @endif

        <div data-reveal class="mt-10 flex justify-center">
            <a href="{{ route('catalog.index') }}"
               class="rounded-pill border-[1.6px] border-primary/40 bg-white/60 px-[34px] py-3.5 text-[15px] font-bold text-primary backdrop-blur transition hover:-translate-y-0.5 hover:bg-primary/10">
                Muat Lebih Banyak
            </a>
        </div>
    </section>
@endsection
