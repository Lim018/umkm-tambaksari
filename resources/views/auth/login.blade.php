<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-navy">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-sm font-medium text-navy">Kata sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full rounded-md border-slate-200 text-sm focus:border-primary focus:ring-primary">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-primary focus:ring-primary">
            Ingat saya
        </label>

        <div class="flex items-center justify-between gap-3 pt-1">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-slate-500 hover:text-primary">Lupa sandi?</a>
            @else
                <span></span>
            @endif

            <button type="submit" class="rounded-md bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary/90">
                Masuk
            </button>
        </div>
    </form>
</x-guest-layout>
