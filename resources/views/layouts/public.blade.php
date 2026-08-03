<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Katalog UMKM Kecamatan Tambaksari')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-navy antialiased">
<div class="relative min-h-screen w-full overflow-x-hidden">

    {{-- aksen lembut, dibatasi supaya tidak mengganggu konten --}}
    <div aria-hidden="true" class="pointer-events-none absolute -left-20 top-16 h-40 w-40 rounded-full opacity-70"
         style="background:radial-gradient(circle at 32% 28%,#fff,#bcd3ff 40%,#3B6FF5 100%);filter:blur(2px);"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -right-16 top-28 h-44 w-44 rounded-full opacity-60"
         style="background:radial-gradient(circle at 34% 30%,#fff,#e7ddff 40%,#8B5CF6 100%);filter:blur(2px);"></div>

    <x-navbar />

    <div class="relative z-[5]">
        @yield('content')
    </div>

    <x-footer />
</div>

@stack('scripts')
</body>
</html>
