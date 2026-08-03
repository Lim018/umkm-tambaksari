@props([
    'items' => [
        [
            'slug' => 'makanan',
            'name' => 'Makanan',
            'desc' => 'Kuliner khas & jajanan warga Tambaksari',
            'icon' => 'icon-makanan.svg',
            'image' => 'images/food.jpeg',
            'gradient' => 'linear-gradient(150deg,#FF8A5B,#FF6B4A)',
            'shadow' => '0 28px 50px -24px rgba(255,107,74,.45)',
        ],
        [
            'slug' => 'minuman',
            'name' => 'Minuman',
            'desc' => 'Kopi, boba, dan minuman segar buatan warga',
            'icon' => 'icon-minuman.svg',
            'image' => 'images/drink.jpeg',
            'gradient' => 'linear-gradient(150deg,#2DD4BF,#14B8A6)',
            'shadow' => '0 28px 50px -24px rgba(20,184,166,.45)',
        ],
        [
            'slug' => 'fashion',
            'name' => 'Fashion',
            'desc' => 'Batik, kaos, dan busana karya penjahit lokal',
            'icon' => 'icon-fashion.svg',
            'image' => 'images/fashion.jpeg',
            'gradient' => 'linear-gradient(150deg,#8B5CF6,#6D3EF0)',
            'shadow' => '0 28px 50px -24px rgba(109,62,240,.45)',
        ],
    ],
])

<section id="kategori" class="relative z-[5] mx-auto mt-12 max-w-[1180px] px-6">
    <div data-reveal class="mb-6 text-center">
        <h2 class="m-0 text-[28px] font-extrabold tracking-tight text-navy md:text-[32px]">Jelajahi Kategori</h2>
        <p class="mt-1.5 text-[15px] font-medium text-grey-soft">Pilih kategori untuk melihat daftar toko</p>
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
                 @click="if (touch) active = active === {{ $i }} ? null : {{ $i }}"
                 :style="active === {{ $i }}
                     ? 'background:{{ $item['gradient'] }};box-shadow:{{ $item['shadow'] }}'
                     : ''">
                <span class="kb-photo"
                      style="background-image:url('{{ asset('assets/katalog/' . $item['image']) }}');"></span>
                <span class="kb-scrim"></span>
                <span class="kb-pattern"
                      style="background-image:url('{{ asset('assets/katalog/pattern-diamond.svg') }}');"></span>

                <img class="kb-icon" src="{{ asset('assets/katalog/' . $item['icon']) }}" alt="" aria-hidden="true">
                <h3 class="kb-title">{{ $item['name'] }}</h3>

                <div class="kb-reveal">
                    <p class="kb-desc">{{ $item['desc'] }}</p>
                    <a href="{{ route('catalog.index', ['kategori' => $item['slug']]) }}" class="kb-cta">
                        Lihat katalog
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>
