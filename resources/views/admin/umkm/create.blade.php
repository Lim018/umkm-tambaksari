<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('admin.umkm.index') }}" class="text-sm font-medium text-slate-500 hover:text-primary">← Toko UMKM</a>
            <h1 class="mt-1 text-xl font-semibold tracking-tight text-navy">Tambah toko</h1>
            <p class="mt-0.5 text-sm text-slate-500">Isi data toko untuk ditampilkan di katalog publik</p>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <form action="{{ route('admin.umkm.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.umkm._form')
        </form>
    </div>
</x-app-layout>
