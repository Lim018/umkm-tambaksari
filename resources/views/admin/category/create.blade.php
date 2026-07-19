<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-navy">Tambah Kategori</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-white/80 bg-white/85 p-6 shadow-soft backdrop-blur md:p-8">
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf
                    @include('admin.category._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
