@props([
    'trend',
    'title' => 'Kontak masuk',
    'subtitle' => 'Klik tombol WhatsApp & Shopee dari pengunjung katalog',
])

@php
    // Pasangan warna ini lolos uji keterbacaan buta warna (ΔE 28,4 protan).
    // Hijau WhatsApp gagal uji itu berdampingan dengan coral, jadi identitas
    // channel dibawa oleh legenda dan label, bukan warna merek.
    $colors = ['whatsapp' => '#3B6FF5', 'shopee' => '#FF6B4A'];
    $names = ['whatsapp' => 'WhatsApp', 'shopee' => 'Shopee'];

    $jumlahHari = count($trend['labels']);
    // Dibulatkan ke atas ke bilangan genap supaya label garis tengah benar-benar
    // menunjukkan setengah dari puncak, bukan angka yang dipotong.
    $max = (int) ceil(max(1, $trend['max']) / 2) * 2;
    // Tampilkan sekitar 7 label saja supaya tidak saling tabrak.
    $stepLabel = (int) ceil($jumlahHari / 7);
@endphp

<section class="rounded-lg border border-slate-200 bg-white">
    <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-200 px-4 py-3 sm:px-5">
        <div>
            <h2 class="text-sm font-semibold text-navy">{{ $title }}</h2>
            <p class="mt-0.5 text-xs text-slate-500">{{ $subtitle }}</p>
        </div>

        <div class="flex items-center gap-4">
            @foreach ($names as $key => $label)
                <span class="flex items-center gap-1.5 text-xs font-medium text-slate-600">
                    <span class="h-2.5 w-2.5 rounded-sm" style="background: {{ $colors[$key] }};"></span>
                    {{ $label }}
                </span>
            @endforeach
        </div>
    </div>

    <div class="px-4 py-4 sm:px-5">
        @if ($trend['total'] === 0)
            <p class="py-10 text-center text-sm text-slate-500">
                Belum ada klik kontak yang tercatat pada periode ini.
            </p>
        @else
            <div class="flex gap-3">
                {{-- sumbu nilai, sengaja dibuat samar --}}
                <div class="flex h-[168px] w-8 shrink-0 flex-col justify-between text-right text-[11px] tabular-nums text-slate-400">
                    <span>{{ $max }}</span>
                    <span>{{ intdiv($max, 2) }}</span>
                    <span>0</span>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="relative h-[168px]">
                        {{-- garis bantu --}}
                        <div aria-hidden="true" class="absolute inset-0 flex flex-col justify-between">
                            <div class="border-t border-slate-100"></div>
                            <div class="border-t border-slate-100"></div>
                            <div class="border-t border-slate-200"></div>
                        </div>

                        <div class="relative flex h-full items-end gap-[2px]">
                            @foreach ($trend['labels'] as $i => $label)
                                @php
                                    $wa = $trend['series']['whatsapp'][$i];
                                    $shopee = $trend['series']['shopee'][$i];
                                    $harian = $wa + $shopee;
                                @endphp

                                <div class="group/day relative flex h-full flex-1 cursor-default items-end justify-center">
                                    {{-- area sasaran hover lebih besar daripada batangnya --}}
                                    <span aria-hidden="true" class="absolute inset-0 rounded-sm group-hover/day:bg-slate-50"></span>

                                    {{-- batang sengaja dibatasi lebarnya supaya tetap ramping --}}
                                    <div class="relative flex h-full w-full max-w-[22px] flex-col justify-end gap-[2px]">
                                        @if ($shopee > 0)
                                            <span class="rounded-t-[4px]"
                                                  style="height: {{ round($shopee / $max * 100, 2) }}%; min-height: 3px; background: {{ $colors['shopee'] }};"></span>
                                        @endif

                                        @if ($wa > 0)
                                            <span @class(['rounded-t-[4px]' => $shopee === 0])
                                                  style="height: {{ round($wa / $max * 100, 2) }}%; min-height: 3px; background: {{ $colors['whatsapp'] }};"></span>
                                        @endif
                                    </div>

                                    <div role="tooltip"
                                         class="pointer-events-none absolute bottom-full left-1/2 z-10 mb-1.5 hidden w-max -translate-x-1/2 rounded-md bg-navy px-2.5 py-1.5 text-left text-[11px] leading-tight text-white shadow-sm group-hover/day:block">
                                        <p class="font-semibold">{{ $label }}</p>
                                        <p class="mt-0.5 text-white/80">WhatsApp: <span class="tabular-nums">{{ $wa }}</span></p>
                                        <p class="text-white/80">Shopee: <span class="tabular-nums">{{ $shopee }}</span></p>
                                        <p class="mt-0.5 border-t border-white/20 pt-0.5">Total: <span class="tabular-nums font-semibold">{{ $harian }}</span></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-2 flex gap-[2px]">
                        @foreach ($trend['labels'] as $i => $label)
                            {{-- kolom sempit, jadi label dibiarkan meluber ke ruang tetangga yang kosong --}}
                            <span class="min-w-0 flex-1 overflow-visible whitespace-nowrap text-center text-[10px] leading-none text-slate-400">
                                {{ $i % $stepLabel === 0 ? $label : '' }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <p class="mt-4 border-t border-slate-100 pt-3 text-xs text-slate-500">
                Total {{ $jumlahHari }} hari terakhir:
                <span class="font-semibold tabular-nums text-navy">{{ $trend['total'] }}</span> klik kontak.
                Klik berulang dari pengunjung yang sama dalam 30 menit dihitung sekali.
            </p>
        @endif
    </div>
</section>
