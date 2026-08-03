<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@isset($title){{ $title }} — @endisset Admin · UMKM Tambaksari</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell font-sans text-navy antialiased">
<div class="min-h-screen lg:grid lg:grid-cols-[240px_1fr]" x-data="{ sidebarOpen: false }">

    {{-- Mobile top bar --}}
    <div class="sticky top-0 z-40 flex items-center justify-between border-b border-slate-200 bg-white px-4 py-3 lg:hidden">
        <button type="button" @click="sidebarOpen = true" class="rounded-md p-2 text-navy hover:bg-slate-100" aria-label="Buka menu">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <span class="text-sm font-semibold">Admin Tambaksari</span>
        <a href="{{ route('home') }}" class="text-sm font-medium text-primary">Situs</a>
    </div>

    {{-- Overlay --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-navy/40 lg:hidden"></div>

    @include('layouts.navigation')

    <div class="min-w-0">
        <main class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
            @isset($header)
                <header class="mb-6">
                    {{ $header }}
                </header>
            @endisset

            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
