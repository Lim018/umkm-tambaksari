<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('admin.kategori.index') }}" class="text-sm font-medium text-slate-500 hover:text-primary">← Kategori</a>
            <h1 class="mt-1 text-xl font-semibold tracking-tight text-navy">Edit {{ $category->name }}</h1>
        </div>
    </x-slot>

    <div class="max-w-lg rounded-lg border border-slate-200 bg-white p-5 sm:p-6">
        <form action="{{ route('admin.kategori.update', $category) }}" method="POST">
            @csrf @method('PUT')
            @include('admin.category._form')
        </form>
    </div>
</x-app-layout>
