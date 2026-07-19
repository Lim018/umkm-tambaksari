@props(['category'])

<a data-reveal href="{{ route('catalog.index', ['kategori' => $category->slug]) }}"
   class="group flex flex-col items-center gap-3 rounded-[22px] border border-white/85 glass-card p-[22px] px-3 shadow-[0_14px_34px_-22px_rgba(27,37,89,.3)] transition duration-200 hover:-translate-y-2 hover:scale-[1.03] hover:shadow-cat-hover">
    <span class="grid h-[58px] w-[58px] place-items-center rounded-[18px] text-[27px]"
          style="background: {{ $category->tint }}; box-shadow:0 12px 24px -12px {{ $category->accent_color }}66;">
        {{ $category->icon }}
    </span>
    <span class="text-[14px] font-semibold text-navy">{{ $category->name }}</span>
</a>
