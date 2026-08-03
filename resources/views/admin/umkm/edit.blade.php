<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <a href="{{ route('admin.umkm.index') }}" class="text-sm font-medium text-slate-500 hover:text-primary">← Toko UMKM</a>
                <h1 class="mt-1 text-xl font-semibold tracking-tight text-navy">Edit {{ $umkm->name }}</h1>
            </div>
            <a href="{{ route('admin.umkm.menu.index', $umkm) }}"
               class="rounded-md border border-slate-200 bg-white px-3.5 py-2 text-sm font-medium text-navy hover:bg-slate-50">
                Kelola menu
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl rounded-lg border border-slate-200 bg-white p-5 sm:p-6">
        <form action="{{ route('admin.umkm.update', $umkm) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.umkm._form')
        </form>
    </div>
</x-app-layout>
