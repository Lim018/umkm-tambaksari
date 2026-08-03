<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-slate-500 hover:text-primary">← Dashboard</a>
            <h1 class="mt-1 text-xl font-semibold tracking-tight text-navy">Profil</h1>
        </div>
    </x-slot>

    <div class="max-w-xl space-y-4">
        <div class="rounded-lg border border-slate-200 bg-white p-5 sm:p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 sm:p-6">
            @include('profile.partials.update-password-form')
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 sm:p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
