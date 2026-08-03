@props([
    'items' => [
        [
            'slug' => 'makanan',
            'name' => 'Makanan',
            'desc' => 'Kuliner khas & jajanan warga Tambaksari',
            'icon' => 'icon-makanan.svg',
            'image' => 'images/food.jpeg',
            'gradient' => 'linear-gradient(150deg,#FF8A5B,#FF6B4A)',
            'shadow' => '0 40px 70px -30px rgba(255,107,74,.6)',
        ],
        [
            'slug' => 'minuman',
            'name' => 'Minuman',
            'desc' => 'Kopi, boba, dan minuman segar buatan warga',
            'icon' => 'icon-minuman.svg',
            'image' => 'images/drink.jpeg',
            'gradient' => 'linear-gradient(150deg,#2DD4BF,#14B8A6)',
            'shadow' => '0 40px 70px -30px rgba(20,184,166,.6)',
        ],
        [
            'slug' => 'fashion',
            'name' => 'Fashion',
            'desc' => 'Batik, kaos, dan busana karya penjahit lokal',
            'icon' => 'icon-fashion.svg',
            'image' => 'images/fashion.jpeg',
            'gradient' => 'linear-gradient(150deg,#8B5CF6,#6D3EF0)',
            'shadow' => '0 40px 70px -30px rgba(109,62,240,.6)',
        ],
    ],
])

<section id="kategori" class="relative z-[5] mx-auto mt-[46px] max-w-[1180px] px-6">
    {{-- dekor mengambang --}}
    <img src="{{ asset('assets/katalog/decor-blob.svg') }}" alt="" aria-hidden="true"
         class="pointer-events-none absolute -left-16 -top-14 hidden w-[190px] animate-floaty opacity-60 blur-[2px] md:block">
    <img src="{{ asset('assets/katalog/decor-ball.svg') }}" alt="" aria-hidden="true"
         class="pointer-events-none absolute -right-10 bottom-[-38px] hidden w-[112px] animate-floaty2 opacity-70 blur-[1px] md:block">

    <div data-reveal class="mb-[30px] text-center">
        <h2 class="m-0 font-extrabold tracking-[-.03em]" style="font-size:clamp(26px,4vw,36px);">Jelajahi Kategori</h2>
        <p class="mt-2 font-medium text-grey-soft">Arahkan kursor pada kategori untuk melihat detailnya</p>
    </div>

    <div data-reveal
         x-data="{ active: null, touch: false }"
         x-init="touch = window.matchMedia('(hover: none)').matches"
         @mouseleave="if (!touch) active = null"
         class="kb-wrap">
        @foreach ($items as $i => $item)
            <div class="kb-card"
                 :class="active === {{ $i }} && 'is-active'"
                 @mouseenter="if (!touch) active = {{ $i }}"
                 @click="active = active === {{ $i }} ? null : {{ $i }}"
                 :style="active === {{ $i }}
                     ? 'background:{{ $item['gradient'] }};box-shadow:{{ $item['shadow'] }}'
                     : ''">
                {{-- foto kategori (default) --}}
                <span class="kb-photo"
                      style="background-image:url('{{ asset('assets/katalog/' . $item['image']) }}');"></span>
                <span class="kb-scrim"></span>

                {{-- pola diamond --}}
                <span class="kb-pattern"
                      style="background-image:url('{{ asset('assets/katalog/pattern-diamond.svg') }}');"></span>

                <img class="kb-icon" src="{{ asset('assets/katalog/' . $item['icon']) }}" alt="{{ $item['name'] }}">

                <h3 class="kb-title">{{ $item['name'] }}</h3>

                <div class="kb-reveal">
                    <p class="kb-desc">{{ $item['desc'] }}</p>
                    <a href="{{ route('catalog.index', ['kategori' => $item['slug']]) }}" class="kb-cta">
                        Lihat Katalog →
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>
