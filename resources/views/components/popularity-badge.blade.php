@props([
    'count' => 0,
    'min' => \App\Models\ContactEvent::POPULARITY_MIN_UMKM,
    'noun' => 'dihubungi',
    'variant' => 'badge',
])

@php
    $count = (int) $count;
    $days = \App\Models\ContactEvent::POPULARITY_DAYS;
    $teks = "{$count} kali {$noun} dalam {$days} hari terakhir";
@endphp

@if ($count >= $min)
    @if ($variant === 'badge')
        <span class="inline-flex items-center gap-1 rounded-md bg-white/95 px-2 py-0.5 text-[11px] font-semibold text-navy shadow-sm"
              title="{{ $teks }}">
            <span aria-hidden="true">🔥</span>
            {{ $count }}× {{ $noun }}
        </span>
    @else
        <span class="inline-flex items-center gap-1.5 rounded-lg bg-coral/10 px-3 py-1.5 text-[13px] font-semibold text-navy">
            <span aria-hidden="true">🔥</span>
            {{ $teks }}
        </span>
    @endif
@endif
