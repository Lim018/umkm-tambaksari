<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk Admin — UMKM Tambaksari</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell font-sans text-navy antialiased">
<div class="flex min-h-screen items-center justify-center px-4 py-12">
    <div class="w-full max-w-sm">
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                <span class="grid h-9 w-9 place-items-center rounded-md bg-primary text-xs font-bold text-white">UT</span>
                <span class="text-base font-semibold text-navy">UMKM Tambaksari</span>
            </a>
            <p class="mt-2 text-sm text-slate-500">Masuk ke backoffice</p>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-6">
            {{ $slot }}
        </div>

        <p class="mt-4 text-center text-sm">
            <a href="{{ route('home') }}" class="font-medium text-slate-500 hover:text-primary">Kembali ke situs</a>
        </p>
    </div>
</div>
</body>
</html>
