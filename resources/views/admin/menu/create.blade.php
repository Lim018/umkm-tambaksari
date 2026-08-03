<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('admin.umkm.menu.index', $umkm) }}" class="text-sm font-medium text-slate-500 hover:text-primary">← Menu {{ $umkm->name }}</a>
            <h1 class="mt-1 text-xl font-semibold tracking-tight text-navy">Tambah menu</h1>
            <p class="mt-0.5 text-sm text-slate-500">Tambahkan produk yang ditawarkan toko ini</p>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('admin.umkm.menu.store', $umkm) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.menu._form')
        </form>
    </div>
</x-app-layout>
