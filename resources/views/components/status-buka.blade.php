@props(['umkm', 'variant' => 'badge'])

@php
    $buka = $umkm->is_open_now;
@endphp

{{-- Null berarti jam buka belum diisi, jadi tidak ada status yang diklaim. --}}
@if (! is_null($buka))
    @if ($variant === 'badge')
        <span @class([
                  'inline-flex items-center gap-1 rounded-md px-2 py-0.5 text-[11px] font-semibold shadow-sm',
                  'bg-white/95 text-emerald-700' => $buka,
                  'bg-white/95 text-slate-500' => ! $buka,
              ])
              title="{{ $umkm->open_days_label }} · {{ $umkm->opening_hours_label }} WIB">
            <span @class(['h-1.5 w-1.5 rounded-full', 'bg-emerald-500' => $buka, 'bg-slate-400' => ! $buka])></span>
            {{ $buka ? 'Buka' : 'Tutup' }}
        </span>
    @else
        <span @class([
                  'inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-[13px] font-semibold',
                  'bg-emerald-50 text-emerald-700' => $buka,
                  'bg-slate-100 text-slate-600' => ! $buka,
              ])>
            <span @class(['h-2 w-2 rounded-full', 'bg-emerald-500' => $buka, 'bg-slate-400' => ! $buka])></span>
            {{ $buka ? 'Buka sekarang' : 'Sedang tutup' }}
        </span>
    @endif
@endif
