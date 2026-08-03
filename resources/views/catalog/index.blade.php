@extends('layouts.public')

@section('title', 'Katalog UMKM — Tambaksari')

@section('content')
    <section class="relative z-[5] mx-auto max-w-[1180px] px-6 pb-8 pt-12 md:pt-14">
        <div data-reveal class="mb-6">
            <h1 class="m-0 text-[28px] font-extrabold tracking-tight text-navy md:text-[36px]">Katalog UMKM</h1>
            <p class="mt-1.5 text-[15px] font-medium text-grey-soft">Cari dan saring usaha lokal Tambaksari</p>
        </div>

        <form data-reveal
              action="{{ route('catalog.index') }}"
              method="GET"
              x-data="{
                  q: @js($q),
                  kategori: @js($kategori ?? ''),
                  get hasFilters() {
                      return Boolean((this.q || '').trim()) || Boolean(this.kategori);
                  }
              }"
              class="mb-5 overflow-x-auto rounded-xl border border-slate-200/80 bg-white p-2 shadow-soft">
            @if (filled($sort) && $sort !== 'baru')
                <input type="hidden" name="sort" value="{{ $sort }}">
            @endif

            <div class="flex min-w-[480px] items-center gap-2">
                <label class="flex min-w-0 flex-1 items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="flex-none" aria-hidden="true">
                        <circle cx="11" cy="11" r="7" stroke="#8F9BBA" stroke-width="2"/>
                        <path d="M20 20l-3.2-3.2" stroke="#8F9BBA" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input name="q" x-model="q" value="{{ $q }}" placeholder="Cari toko atau produk..."
                           class="min-w-0 flex-1 border-none bg-transparent p-0 text-[13px] font-medium text-navy placeholder:text-grey-soft focus:ring-0">
                </label>

                <select name="kategori" x-model="kategori"
                        class="w-[160px] shrink-0 rounded-lg border-slate-200 py-1.5 text-[13px] font-medium text-navy focus:border-primary focus:ring-primary">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->slug }}" @selected($kategori === $c->slug)>{{ $c->name }}</option>
                    @endforeach
                </select>

                <a href="{{ route('catalog.index', array_filter(['sort' => $sort !== 'baru' ? $sort : null])) }}"
                   x-show="hasFilters"
                   x-cloak
                   class="inline-flex shrink-0 items-center justify-center rounded-lg border border-slate-200 px-3 py-1.5 text-[13px] font-semibold text-slate-600 hover:bg-slate-50 hover:text-navy">
                    Clear
                </a>

                <button type="submit"
                        class="inline-flex shrink-0 items-center justify-center rounded-lg bg-primary px-4 py-1.5 text-[13px] font-bold text-white hover:bg-primary/90">
                    Cari
                </button>
            </div>
        </form>

        <div data-reveal class="mb-5 flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="m-0 text-[14px] font-medium text-grey-soft">{{ $umkms->total() }} toko ditemukan</p>
                @if ($sort === 'populer')
                    <p class="m-0 mt-0.5 text-[12px] text-grey-soft/80">
                        Diurutkan dari yang paling sering dihubungi pengunjung dalam
                        {{ \App\Models\ContactEvent::POPULARITY_DAYS }} hari terakhir
                    </p>
                @endif
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach ([
                    'baru' => 'Terbaru',
                    'populer' => 'Paling ramai',
                    'terlaris' => 'Terlaris',
                ] as $value => $label)
                    @php $aktif = $value === 'baru' ? ! in_array($sort, ['populer', 'terlaris'], true) : $sort === $value; @endphp
                    <a href="{{ route('catalog.index', array_merge(request()->except('sort', 'page'), ['sort' => $value])) }}"
                       @class([
                           'rounded-lg px-3.5 py-1.5 text-[13px] font-semibold',
                           'bg-navy text-white' => $aktif,
                           'bg-white text-navy ring-1 ring-slate-200' => ! $aktif,
                       ])>{{ $label }}</a>
                @endforeach
            </div>
        </div>

        @if ($umkms->isEmpty())
            <div data-reveal class="rounded-2xl border border-dashed border-slate-200 bg-white/70 px-6 py-14 text-center">
                <p class="text-[16px] font-bold text-navy">Tidak ada hasil</p>
                <p class="mt-1 text-[14px] text-grey-soft">Coba kata kunci atau filter lain.</p>
                <a href="{{ route('catalog.index') }}" class="mt-4 inline-block text-[14px] font-bold text-primary hover:underline">Reset filter</a>
            </div>
        @else
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($umkms as $umkm)
                    <x-umkm-card :umkm="$umkm" />
                @endforeach
            </div>

            <div class="mt-8">{{ $umkms->links() }}</div>
        @endif
    </section>
@endsection
