@php
    $lat = config('kecamatan.lat');
    $lng = config('kecamatan.lng');
    $spanLat = config('kecamatan.span_lat');
    $spanLng = config('kecamatan.span_lng');
    $nama = config('kecamatan.nama');
    $alamat = config('kecamatan.alamat');
    $telepon = config('kecamatan.telepon');

    // Keduanya tidak memerlukan kunci API. Lihat config/kecamatan.php soal
    // mengapa Google jadi bawaan.
    $petaUrl = config('kecamatan.peta_provider') === 'osm'
        ? 'https://www.openstreetmap.org/export/embed.html?' . http_build_query([
            'bbox' => implode(',', [$lng - $spanLng, $lat - $spanLat, $lng + $spanLng, $lat + $spanLat]),
            'layer' => 'mapnik',
            'marker' => "{$lat},{$lng}",
        ])
        : 'https://www.google.com/maps?' . http_build_query([
            'q' => "{$lat},{$lng}",
            'z' => config('kecamatan.zoom'),
            'output' => 'embed',
        ]);

    $mapsUrl = 'https://www.google.com/maps/search/?' . http_build_query([
        'api' => 1,
        'query' => "{$nama}, " . config('kecamatan.kota'),
    ]);
@endphp

<section id="lokasi" class="relative z-[5] mx-auto mt-16 max-w-[1180px] px-6 pb-16">
    <div data-reveal class="mb-6">
        <h2 class="m-0 text-[24px] font-extrabold tracking-tight text-navy md:text-[28px]">Lokasi</h2>
        <p class="mt-1.5 text-[15px] font-medium text-grey-soft">
            Seluruh UMKM dalam katalog ini berada di wilayah {{ $nama }}
        </p>
    </div>

    <div data-reveal class="grid overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft lg:grid-cols-[1fr_360px]">
        <div class="relative min-h-[280px] bg-slate-100 lg:min-h-[340px]">
            <iframe
                src="{{ $petaUrl }}"
                title="Peta wilayah {{ $nama }}"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                class="absolute inset-0 h-full w-full border-0"></iframe>
        </div>

        <div class="flex flex-col justify-center gap-5 p-6 md:p-7">
            <div>
                <p class="m-0 text-[11px] font-semibold uppercase tracking-wide text-grey-soft">Alamat</p>
                <p class="mt-1.5 m-0 text-[16px] font-bold leading-snug text-navy">{{ $nama }}</p>
                <p class="mt-1 m-0 text-[14px] leading-relaxed text-grey-soft">{{ $alamat }}</p>
            </div>

            @if ($telepon)
                <div>
                    <p class="m-0 text-[11px] font-semibold uppercase tracking-wide text-grey-soft">Telepon</p>
                    <a href="tel:{{ preg_replace('/\s+/', '', $telepon) }}"
                       class="mt-1 inline-block text-[14px] font-semibold text-primary hover:underline">{{ $telepon }}</a>
                </div>
            @endif

            <div>
                <p class="m-0 text-[11px] font-semibold uppercase tracking-wide text-grey-soft">Kelurahan</p>
                <p class="mt-1.5 m-0 text-[13px] leading-relaxed text-grey-soft">
                    {{ implode(' · ', config('kecamatan.kelurahan')) }}
                </p>
            </div>

            <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex w-fit items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-[14px] font-bold text-white hover:bg-primary/90">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 21s7-5.5 7-11a7 7 0 10-14 0c0 5.5 7 11 7 11z" stroke="#fff" stroke-width="2" stroke-linejoin="round"/>
                    <circle cx="12" cy="10" r="2.5" stroke="#fff" stroke-width="2"/>
                </svg>
                Buka di Google Maps
            </a>
        </div>
    </div>
</section>
