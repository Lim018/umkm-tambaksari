<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('admin.umkm.index') }}" class="text-sm font-medium text-slate-500 hover:text-primary">← Toko UMKM</a>
            <h1 class="mt-1 text-xl font-semibold tracking-tight text-navy">Tambah toko</h1>
        </div>
    </x-slot>

    <div class="max-w-2xl rounded-lg border border-slate-200 bg-white p-5 sm:p-6">
        <form action="{{ route('admin.umkm.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.umkm._form')
        </form>
    </div>
</x-app-layout>
