@extends('layouts.public')

@section('title', 'Katalog UMKM — Tambaksari')

@section('content')
    <section class="relative z-[5] mx-auto max-w-[1180px] px-6 pt-16">
        <div data-reveal class="mb-6 text-center">
            <h1 class="m-0 font-extrabold tracking-[-.03em] text-navy" style="font-size:clamp(30px,5vw,48px);">Katalog UMKM</h1>
            <p class="mt-2 font-medium text-grey-soft">Cari & saring usaha lokal Tambaksari</p>
        </div>

        {{-- form pencarian & filter --}}
        <form data-reveal action="{{ route('catalog.index') }}" method="GET"
              class="mx-auto mb-8 flex max-w-[860px] flex-col gap-3 rounded-[24px] border border-white/80 bg-white/70 p-4 shadow-soft backdrop-blur sm:flex-row sm:items-center">
            <div class="flex flex-1 items-center gap-2.5 rounded-pill bg-white px-4 py-2.5 shadow-[0_10px_30px_-18px_rgba(27,37,89,.4)]">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" class="flex-none">
                    <circle cx="11" cy="11" r="7" stroke="#8F9BBA" stroke-width="2.2"/>
                    <path d="M20 20l-3.2-3.2" stroke="#8F9BBA" stroke-width="2.2" stroke-linecap="round"/>
                </svg>
                <input name="q" value="{{ $q }}" placeholder="Cari UMKM atau produk..."
                       class="min-w-0 flex-1 border-none bg-transparent p-0 text-[15px] font-medium text-navy placeholder:text-grey-soft focus:ring-0">
            </div>
            <select name="kategori" class="rounded-pill border-white/90 bg-white/90 px-4 py-2.5 text-[14px] font-medium text-navy focus:ring-primary">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->slug }}" @selected($kategori === $c->slug)>{{ $c->name }}</option>
                @endforeach
            </select>
            <select name="kelurahan" class="rounded-pill border-white/90 bg-white/90 px-4 py-2.5 text-[14px] font-medium text-navy focus:ring-primary">
                <option value="">Semua Kelurahan</option>
                @foreach ($kelurahans as $k)
                    <option value="{{ $k }}" @selected($kelurahan === $k)>{{ $k }}</option>
                @endforeach
            </select>
            <button type="submit"
                    class="rounded-pill bg-gradient-to-br from-primary to-ungu px-6 py-2.5 text-[14px] font-bold text-white shadow-[0_12px_26px_-8px_rgba(90,80,240,.6)] transition hover:-translate-y-0.5">
                Cari
            </button>
        </form>

        {{-- chip sort --}}
        <div data-reveal class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <p class="text-[14px] font-medium text-grey-soft">{{ $umkms->total() }} UMKM ditemukan</p>
            <div class="flex gap-2">
                <a href="{{ route('catalog.index', array_merge(request()->except('sort', 'page'), ['sort' => 'baru'])) }}"
                   class="rounded-pill px-[16px] py-2 text-[13px] font-bold {{ $sort !== 'terlaris' ? 'bg-gradient-to-br from-primary to-ungu text-white' : 'border border-white/90 bg-white/60 text-navy' }}">Semua</a>
                <a href="{{ route('catalog.index', array_merge(request()->except('sort', 'page'), ['sort' => 'terlaris'])) }}"
                   class="rounded-pill px-[16px] py-2 text-[13px] font-bold {{ $sort === 'terlaris' ? 'bg-gradient-to-br from-primary to-ungu text-white' : 'border border-white/90 bg-white/60 text-navy' }}">Terlaris</a>
            </div>
        </div>

        @if ($umkms->isEmpty())
            <div data-reveal class="rounded-[24px] bg-white/60 p-14 text-center">
                <p class="text-[18px] font-bold text-navy">Tidak ada hasil</p>
                <p class="mt-1 font-medium text-grey-soft">Coba kata kunci atau filter lain.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($umkms as $umkm)
                    <x-umkm-card :umkm="$umkm" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $umkms->links() }}
            </div>
        @endif
    </section>
@endsection
