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
<div class="relative w-full overflow-hidden" style="min-height:100vh;">

    {{-- bentuk 3D glossy mengambang --}}
    <div aria-hidden="true" class="pointer-events-none absolute -left-16 top-24 h-52 w-52 rounded-full animate-floaty opacity-90"
         style="background:radial-gradient(circle at 32% 28%,#fff,#bcd3ff 34%,#3B6FF5 100%);box-shadow:0 40px 80px -20px rgba(59,111,245,.45);"></div>
    <div aria-hidden="true" class="pointer-events-none absolute left-10 top-[340px] h-24 w-24 rounded-full animate-floaty2"
         style="background:radial-gradient(circle at 30% 28%,#fff,#ffd9cd 36%,#FF6B4A 100%);box-shadow:0 24px 50px -14px rgba(255,107,74,.5);"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -right-12 top-36 h-56 w-56 rounded-full animate-floaty2 opacity-90"
         style="background:radial-gradient(circle at 34% 30%,#fff,#e7ddff 34%,#8B5CF6 100%);box-shadow:0 44px 90px -24px rgba(139,92,246,.5);"></div>
    <div aria-hidden="true" class="pointer-events-none absolute right-16 top-[420px] h-16 w-16 rounded-full animate-floaty"
         style="border:20px solid transparent;background:linear-gradient(#f6f8ff,#f6f8ff) padding-box,linear-gradient(135deg,#FFB800,#FF6B4A) border-box;box-shadow:0 20px 44px -14px rgba(255,184,0,.5);"></div>
    <div aria-hidden="true" class="pointer-events-none absolute right-64 top-64 h-11 w-11 rounded-full animate-floaty2"
         style="background:radial-gradient(circle at 32% 30%,#fff,#b9f5ec 40%,#2DD4BF 100%);box-shadow:0 16px 34px -12px rgba(45,212,191,.55);"></div>

    <x-navbar />

    @yield('content')

    <x-footer />
</div>

@stack('scripts')
</body>
</html>
