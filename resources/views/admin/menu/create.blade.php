<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('admin.umkm.menu.index', $umkm) }}" class="text-sm font-medium text-slate-500 hover:text-primary">← Menu {{ $umkm->name }}</a>
            <h1 class="mt-1 text-xl font-semibold tracking-tight text-navy">Tambah menu</h1>
        </div>
    </x-slot>

    <div class="max-w-2xl rounded-lg border border-slate-200 bg-white p-5 sm:p-6">
        <form action="{{ route('admin.umkm.menu.store', $umkm) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.menu._form')
        </form>
    </div>
</x-app-layout>
