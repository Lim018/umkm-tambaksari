@php
    $nav = [
        [
            'label' => 'Dashboard',
            'href' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/>',
        ],
        [
            'label' => 'Toko UMKM',
            'href' => route('admin.umkm.index'),
            'active' => request()->routeIs('admin.umkm.*'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
        ],
    ];
@endphp

<aside
    class="fixed inset-y-0 left-0 z-50 flex w-60 flex-col border-r border-slate-200 bg-white transition-transform duration-200 lg:static lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <div class="flex h-16 items-center gap-2 border-b border-slate-200 px-5">
        <span class="grid h-8 w-8 place-items-center rounded-md bg-primary text-xs font-bold text-white">UT</span>
        <div class="min-w-0 leading-tight">
            <p class="truncate text-sm font-semibold text-navy">UMKM Tambaksari</p>
            <p class="text-xs text-slate-500">Backoffice</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto p-3">
        <p class="px-3 pb-2 pt-1 text-[11px] font-semibold uppercase tracking-wide text-slate-400">Menu</p>
        @foreach ($nav as $item)
            <a href="{{ $item['href'] }}"
               @click="sidebarOpen = false"
               @class([
                   'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors',
                   'bg-slate-100 text-navy' => $item['active'],
                   'text-slate-600 hover:bg-slate-50 hover:text-navy' => ! $item['active'],
               ])>
                <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">{!! $item['icon'] !!}</svg>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="border-t border-slate-200 p-3">
        <a href="{{ route('home') }}"
           class="mb-2 flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-navy">
            <svg class="h-5 w-5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Lihat situs publik
        </a>

        <div x-data="{ open: false }" class="relative">
            <button type="button" @click="open = !open"
                    class="flex w-full items-center gap-3 rounded-md px-3 py-2 text-left hover:bg-slate-50">
                <span class="grid h-8 w-8 shrink-0 place-items-center rounded-md bg-slate-100 text-xs font-semibold text-navy">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                <span class="min-w-0 flex-1">
                    <span class="block truncate text-sm font-medium text-navy">{{ Auth::user()->name }}</span>
                    <span class="block truncate text-xs text-slate-500">{{ Auth::user()->email }}</span>
                </span>
            </button>

            <div x-show="open" x-cloak @click.outside="open = false"
                 class="absolute bottom-full left-0 right-0 mb-1 overflow-hidden rounded-md border border-slate-200 bg-white py-1 shadow-sm">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</aside>
