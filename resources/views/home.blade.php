@extends('layouts.public')

@section('title', 'UMKM Tambaksari — Katalog Usaha Lokal Surabaya')

@section('content')
    <x-hero />

    <x-katalog-banner />

    <section id="katalog" class="relative z-[5] mx-auto mt-14 max-w-[1180px] px-6 pb-4">
        <div data-reveal class="mb-7 flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 class="m-0 text-[28px] font-extrabold tracking-tight text-navy md:text-[32px]">UMKM Unggulan</h2>
                <p class="mt-1.5 text-[15px] font-medium text-grey-soft">Pilihan usaha lokal dari warga Tambaksari</p>
            </div>
            <a href="{{ route('catalog.index') }}"
               class="text-[14px] font-bold text-primary transition hover:underline">
                Lihat semua →
            </a>
        </div>

        @if ($featured->isEmpty())
            <p class="rounded-2xl bg-white/70 p-8 text-center text-[15px] font-medium text-grey-soft">
                Belum ada UMKM unggulan.
            </p>
        @else
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($featured as $umkm)
                    <x-umkm-card :umkm="$umkm" />
                @endforeach
            </div>
        @endif
    </section>
@endsection
